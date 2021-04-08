<?php

/**
 * This file is part of Attributes package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Spiral\Attributes\Internal\Instantiator;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\NamedArgumentConstructorAnnotation as MarkerAnnotation;
use Doctrine\Common\Annotations\Annotation\NamedArgumentConstructor as MarkerInterface;

class Factory implements InstantiatorInterface
{
    /**
     * @var DoctrineInstantiator
     */
    private $doctrine;

    /**
     * @var NamedArgumentsInstantiator
     */
    private $named;

    /**
     * @var AnnotationReader
     */
    private $annotations;

    /**
     * Factory constructor.
     */
    public function __construct()
    {
        $this->doctrine = new DoctrineInstantiator();
        $this->named = new NamedArgumentsInstantiator();
        $this->annotations = new AnnotationReader();
    }

    /**
     * @param \ReflectionClass $attr
     * @param array $arguments
     * @param string $context
     * @return object
     * @throws \Throwable
     */
    public function instantiate(\ReflectionClass $attr, array $arguments, string $context): object
    {
        if ($this->isNamedArguments($attr)) {
            return $this->named->instantiate($attr, $arguments, $context);
        }

        return $this->doctrine->instantiate($attr, $arguments, $context);
    }

    /**
     * @param \ReflectionClass $class
     * @return bool
     */
    private function isNamedArguments(\ReflectionClass $class): bool
    {
        return $this->providesNamedArgumentsInterface($class) ||
            $this->providesNamedArgumentsAttribute($class)
        ;
    }

    /**
     * @param \ReflectionClass $class
     * @return bool
     */
    private function providesNamedArgumentsAttribute(\ReflectionClass $class): bool
    {
        if (\class_exists(MarkerAnnotation::class)) {
            return $this->annotations->getClassAnnotation($class, MarkerAnnotation::class) !== null;
        }

        return false;
    }

    /**
     * @param \ReflectionClass $class
     * @return bool
     */
    private function providesNamedArgumentsInterface(\ReflectionClass $class): bool
    {
        return \is_subclass_of($class->getName(), MarkerInterface::class);
    }
}
