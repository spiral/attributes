<?php

/**
 * This file is part of Spiral Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Spiral\Attributes\Internal;

use Spiral\Attributes\Internal\Instantiator\InstantiatorInterface;
use Spiral\Attributes\Reader;

/**
 * @internal AttributeReader is an internal library class, please do not use it in your code.
 * @psalm-internal Spiral\Attributes
 */
abstract class AttributeReader extends Reader
{
    /**
     * @var InstantiatorInterface
     */
    private $instantiator;

    /**
     * @param InstantiatorInterface $instantiator
     */
    public function __construct(InstantiatorInterface $instantiator)
    {
        $this->instantiator = $instantiator;
    }

    /**
     * {@inheritDoc}
     * @throws \Throwable
     */
    public function getClassMetadata(\ReflectionClass $class, string $name = null): iterable
    {
        $attributes = $this->getClassAttributes($class, $name);

        foreach ($attributes as $attribute => $arguments) {
            yield $this->instantiator->instantiate($attribute, $arguments, $class);
        }
    }

    /**
     * {@inheritDoc}
     * @throws \Throwable
     */
    public function getFunctionMetadata(\ReflectionFunctionAbstract $function, string $name = null): iterable
    {
        $attributes = $this->getFunctionAttributes($function, $name);

        foreach ($attributes as $attribute => $arguments) {
            yield $this->instantiator->instantiate($attribute, $arguments, $function);
        }
    }

    /**
     * {@inheritDoc}
     * @throws \Throwable
     */
    public function getPropertyMetadata(\ReflectionProperty $property, string $name = null): iterable
    {
        $attributes = $this->getPropertyAttributes($property, $name);

        foreach ($attributes as $attribute => $arguments) {
            yield $this->instantiator->instantiate($attribute, $arguments, $property);
        }
    }

    /**
     * {@inheritDoc}
     * @throws \Throwable
     */
    public function getConstantMetadata(\ReflectionClassConstant $constant, string $name = null): iterable
    {
        $attributes = $this->getConstantAttributes($constant, $name);

        foreach ($attributes as $attribute => $arguments) {
            yield $this->instantiator->instantiate($attribute, $arguments, $constant);
        }
    }

    /**
     * {@inheritDoc}
     * @throws \Throwable
     */
    public function getParameterMetadata(\ReflectionParameter $parameter, string $name = null): iterable
    {
        $attributes = $this->getParameterAttributes($parameter, $name);

        foreach ($attributes as $attribute => $arguments) {
            yield $this->instantiator->instantiate($attribute, $arguments, $parameter);
        }
    }

    /**
     * @param \ReflectionClass $class
     * @param string|null $name
     * @return iterable<\ReflectionClass, array>
     */
    abstract protected function getClassAttributes(\ReflectionClass $class, ?string $name): iterable;

    /**
     * @param \ReflectionFunctionAbstract $function
     * @param string|null $name
     * @return iterable<\ReflectionClass, array>
     */
    abstract protected function getFunctionAttributes(\ReflectionFunctionAbstract $function, ?string $name): iterable;

    /**
     * @param \ReflectionProperty $property
     * @param string|null $name
     * @return iterable<\ReflectionClass, array>
     */
    abstract protected function getPropertyAttributes(\ReflectionProperty $property, ?string $name): iterable;

    /**
     * @param \ReflectionClassConstant $const
     * @param string|null $name
     * @return iterable<\ReflectionClass, array>
     */
    abstract protected function getConstantAttributes(\ReflectionClassConstant $const, ?string $name): iterable;

    /**
     * @param \ReflectionParameter $param
     * @param string|null $name
     * @return iterable<\ReflectionClass, array>
     */
    abstract protected function getParameterAttributes(\ReflectionParameter $param, ?string $name): iterable;
}
