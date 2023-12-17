<?php

/**
 * This file is part of Spiral Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Spiral\Tests\Attributes\Reader;

use Spiral\Attributes\AttributeReader;
use Spiral\Attributes\Exception\SemanticAttributeException;
use Spiral\Attributes\ReaderInterface;
use Spiral\Tests\Attributes\Reader\Fixture\AnnotatedClass;
use Spiral\Tests\Attributes\Reader\Fixture\ClassWithAnnotatedInterface;
use Spiral\Tests\Attributes\Reader\Fixture\ClassWithAnnotatedTrait;
use Spiral\Tests\Attributes\Reader\Fixture\UndefinedMeta;

/**
 * @group unit
 * @group reader
 */
class AttributeReaderTestCase extends ReaderTestCase
{
    protected function getReader(): ReaderInterface
    {
        return new AttributeReader();
    }

    public function testClassMetadataCount(): void
    {
        parent::testClassMetadataCount();

        $this->assertCount($this->classMetadataCount,
            $this->getClassMetadata(ClassWithAnnotatedInterface::class)
        );
    }

    public function testUndefinedClassMeta(): void
    {
        $this->expectException(SemanticAttributeException::class);

        $reader = $this->getReader();

        $this->iterableToArray(
            $reader->getClassMetadata(
                $this->getReflectionClass(UndefinedMeta::class)
            )
        );
    }

    public function testUndefinedConstantMeta(): void
    {
        $this->expectException(SemanticAttributeException::class);
        $reader = $this->getReader();

        $this->iterableToArray(
            $reader->getConstantMetadata(
                $this->getReflectionConstant(UndefinedMeta::class, 'CONSTANT')
            )
        );
    }

    public function testUndefinedPropertyMeta(): void
    {
        $this->expectException(SemanticAttributeException::class);

        $reader = $this->getReader();

        $this->iterableToArray(
            $reader->getPropertyMetadata(
                $this->getReflectionProperty(UndefinedMeta::class, 'property')
            )
        );
    }

    public function testUndefinedMethodMeta(): void
    {
        $this->expectException(SemanticAttributeException::class);

        $reader = $this->getReader();

        $this->iterableToArray(
            $reader->getFunctionMetadata(
                $this->getReflectionMethod(UndefinedMeta::class, 'method')
            )
        );
    }

    public function testUndefinedParameterMeta(): void
    {
        $this->expectException(SemanticAttributeException::class);

        $reader = $this->getReader();

        $this->iterableToArray(
            $reader->getParameterMetadata(
                $this->getReflectionMethodParameter(UndefinedMeta::class, 'method', 'parameter')
            )
        );
    }

    public function testUndefinedFunctionMeta(): void
    {
        $this->expectException(SemanticAttributeException::class);

        $reader = $this->getReader();

        $this->iterableToArray(
            $reader->getFunctionMetadata(
                $this->getReflectionFunction($this->fixture('undefined_meta'))
            )
        );
    }
}
