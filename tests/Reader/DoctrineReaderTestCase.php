<?php

/**
 * This file is part of Spiral Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Spiral\Tests\Attributes\Reader;

use Spiral\Attributes\AnnotationReader;
use Spiral\Attributes\ReaderInterface;
use Spiral\Tests\Attributes\Reader\Fixture\Annotation\ClassAnnotation;
use Spiral\Tests\Attributes\Reader\Fixture\ClassWithIgnoredAnnotations;

/**
 * Doctrine reader does not support:
 *  - function annotations
 *  - function parameter annotations
 *  - constant annotations
 *  - method parameter annotations
 *
 * @group unit
 * @group reader
 */
class DoctrineReaderTestCase extends ReaderTestCase
{
    protected $functionMetadataCount = 0;
    protected $functionParameterMetadataCount = 0;
    protected $constantMetadataCount = 0;
    protected $methodParameterMetadataCount = 0;

    protected function getReader(): ReaderInterface
    {
        return new AnnotationReader();
    }

    public function testIgnoredAnnotations(): void
    {
        $reader = $this->getReader();

        $this->assertEquals(
            [new ClassAnnotation()],
            $this->iterableToArray($reader->getClassMetadata(
                $this->getReflectionClass(ClassWithIgnoredAnnotations::class)
            ))
        );
    }
}
