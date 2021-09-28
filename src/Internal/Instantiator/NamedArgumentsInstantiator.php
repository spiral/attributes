<?php

/**
 * This file is part of Spiral Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Spiral\Attributes\Internal\Instantiator;

use Spiral\Attributes\Internal\Exception;

/**
 * @internal NamedArgumentsInstantiator is an internal library class, please do not use it in your code.
 * @psalm-internal Spiral\Attributes
 */
final class NamedArgumentsInstantiator extends Instantiator
{
    /**
     * @var string
     */
    private const ERROR_ARGUMENT_NOT_PASSED = '%s::__construct(): Argument #%d ($%s) not passed';

    private const ERROR_OVERWRITE_ARGUMENT = 'Named parameter $%s overwrites previous argument';

    private const ERROR_NAMED_ARG_TO_VARIADIC = 'Cannot pass named argument $%s to variadic parameter ...$%s in PHP < 8.';

    /**
     * @var string
     */
    private const ERROR_UNKNOWN_ARGUMENT = 'Unknown named parameter $%s';

    /**
     * {@inheritDoc}
     */
    public function instantiate(\ReflectionClass $attr, array $arguments, \Reflector $context = null): object
    {
        if ($this->isNamedArgumentsSupported()) {
            try {
                return $attr->newInstanceArgs($arguments);
            } catch (\Throwable $e) {
                throw Exception::withLocation($e, $attr->getFileName(), $attr->getStartLine());
            }
        }

        $constructor = $this->getConstructor($attr);

        if ($constructor === null) {
            return $attr->newInstanceWithoutConstructor();
        }

        return $attr->newInstanceArgs(
            $this->resolveParameters($attr, $constructor, $arguments)
        );
    }

    /**
     * @return bool
     */
    private function isNamedArgumentsSupported(): bool
    {
        return \version_compare(\PHP_VERSION, '8.0') >= 0;
    }

    /**
     * @param \ReflectionClass $ctx
     * @param \ReflectionMethod $constructor
     * @param array $arguments
     * @return array
     * @throws \Throwable
     */
    private function resolveParameters(\ReflectionClass $ctx, \ReflectionMethod $constructor, array $arguments): array
    {
        // Normalize all numeric keys, but keep string keys.
        $arguments = array_merge($arguments);

        $i = 0;
        $namedArgsBegin = null;
        foreach ($arguments as $k => $v) {
            if ($k !== $i) {
                $namedArgsBegin = $i;
                break;
            }
            ++$i;
        }

        if ($namedArgsBegin === null) {
            // Only numeric / sequential keys exist.
            return $arguments;
        }

        // For any further numeric keys, one of them is now $namedArgsBegin.
        if (array_key_exists($namedArgsBegin, $arguments)) {
            throw new \BadMethodCallException(
                'Cannot use positional argument after named argument.');
        }

        if ($namedArgsBegin === 0) {
            // Only named keys exist.
            $passed = [];
            $named = $arguments;
        }
        else {
            // Sequential keys followed by named keys.
            // No need to preserve numeric keys.
            $passed = array_slice($arguments, 0, $namedArgsBegin);
            $named = array_slice($arguments, $namedArgsBegin);
        }

        $variadicParameter = null;
        $parameters = $constructor->getParameters();
        for ($i = $namedArgsBegin; $parameter = $parameters[$i] ?? null; ++$i) {
            if ($parameter->isVariadic()) {
                $variadicParameter = $parameter;
                break;
            }
            $k = $parameter->getName();
            if (array_key_exists($k, $named)) {
                $passed[] = $named[$k];
                unset($named[$k]);
            }
            elseif ($parameter->isDefaultValueAvailable()) {
                $passed[] = $parameter->getDefaultValue();
            }
            else {
                $message = \vsprintf(self::ERROR_ARGUMENT_NOT_PASSED, [
                    $ctx->getName(),
                    $parameter->getPosition() + 1,
                    $parameter->getName(),
                ]);

                throw new \ArgumentCountError($message);
            }
        }

        if ($named === []) {
            return $passed;
        }

        reset($named);
        $firstOrphanKey = key($named);

        foreach ($parameters as $i => $parameter) {
            if ($i >= $namedArgsBegin) {
                break;
            }
            if ($parameter->getName() === $firstOrphanKey) {
                $message = \sprintf(self::ERROR_OVERWRITE_ARGUMENT, $firstOrphanKey);
                throw new \BadMethodCallException($message);
            }
        }

        if ($variadicParameter !== null) {
            $message = \vsprintf(self::ERROR_NAMED_ARG_TO_VARIADIC, [
                $firstOrphanKey,
                $variadicParameter->getName(),
            ]);
            throw new \BadMethodCallException($message);
        }

        $message = \vsprintf(self::ERROR_UNKNOWN_ARGUMENT, [
            $firstOrphanKey,
        ]);
        throw new \BadMethodCallException($message);
    }
}
