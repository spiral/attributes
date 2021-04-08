<?php

/**
 * This file is part of Spiral Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Spiral\Tests\Attributes\Reader\Complex;

use Spiral\Attributes\AnnotationReader;
use Spiral\Attributes\AttributeReader;
use Spiral\Attributes\Composite\SelectiveReader;
use Spiral\Attributes\ReaderInterface;

/**
 * @group unit
 * @group reader
 * @group complex
 */
class SelectiveReaderTest extends ComplexTestCase
{
    protected function getReader(): ReaderInterface
    {
        return new SelectiveReader([
            new AttributeReader(),
            new AnnotationReader()
        ]);
    }
}
