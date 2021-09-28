<?php

/**
 * This file is part of Spiral Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Spiral\Tests\Attributes\Instantiator;

use Spiral\Attributes\Internal\Instantiator\InstantiatorInterface;
use Spiral\Attributes\Internal\Instantiator\NamedArgumentsInstantiator;
use Spiral\Tests\Attributes\Instantiator\Fixtures\NamedArgumentConstructorFixture;
use Spiral\Tests\Attributes\Instantiator\Fixtures\NamedRequiredArgumentConstructorFixture;

/**
 * @group unit
 * @group instantiator
 */
class NamedArgumentsInstantiatorTestCase extends InstantiatorTestCase
{
    /**
     * @return InstantiatorInterface
     */
    protected function getInstantiator(): InstantiatorInterface
    {
        return new NamedArgumentsInstantiator();
    }

    public function testNamedConstructorInstantiatable(): void
    {
        $object = $this->new(NamedArgumentConstructorFixture::class, [
            'a' => 23,
            'b' => 42,
        ]);

        $this->assertSame(23, $object->a);
        $this->assertSame(42, $object->b);
        $this->assertSame(null, $object->c);
    }

    public function testMixedArgs(): void
    {
        $object = $this->new(NamedArgumentConstructorFixture::class, [
            'A',
            'B',
            'c' => 'C',
        ]);

        $this->assertSame('A', $object->a);
        $this->assertSame('B', $object->b);
        $this->assertSame('C', $object->c);
    }

    public function testMessyIndices()
    {
        $object = $this->new(NamedArgumentConstructorFixture::class, [
            1 => 'one',
            0 => 'zero',
        ]);

        $this->assertSame('one', $object->a);
        $this->assertSame('zero', $object->b);
        $this->assertSame(null, $object->c);
    }

    public function testUnknownSequentialAfterNamed()
    {
        if (PHP_VERSION_ID < 80000) {
            $this->expectException(\BadMethodCallException::class);
        }
        else {
            $this->expectException(\Error::class);
        }
        $this->expectExceptionMessage('Cannot use positional argument after named argument');

        $this->new(NamedArgumentConstructorFixture::class, [
            'a' => 'A',
            5 => 'five',
        ]);
    }

    public function testKnownSequentialAfterNamed()
    {
        if (PHP_VERSION_ID < 80000) {
            $this->expectException(\BadMethodCallException::class);
        }
        else {
            $this->expectException(\Error::class);
        }
        $this->expectExceptionMessage('Cannot use positional argument after named argument');

        $object = $this->new(NamedArgumentConstructorFixture::class, [
            'a' => 'A',
            2 => 'five',
        ]);

        $this->assertSame('A', $object->a);
        $this->assertSame(null, $object->b);
        $this->assertSame('five', $object->c);
    }

    public function testMissingArg()
    {
        $this->expectException(\ArgumentCountError::class);
        $this->expectExceptionMessage('Argument #2 ($b) not passed');

        $this->new(NamedRequiredArgumentConstructorFixture::class, [
            'a',
            'c' => 'C',
        ]);
    }

    public function testUnknownArg()
    {
        if (PHP_VERSION_ID < 80000) {
            $this->expectException(\BadMethodCallException::class);
        }
        else {
            $this->expectException(\Error::class);
        }
        $this->expectExceptionMessage('Unknown named parameter $d');

        $this->new(NamedArgumentConstructorFixture::class, [
            'd' => 'D',
        ]);
    }

    public function testOverwriteArg()
    {
        if (PHP_VERSION_ID < 80000) {
            $this->expectException(\BadMethodCallException::class);
        }
        else {
            $this->expectException(\Error::class);
        }
        $this->expectExceptionMessage('Named parameter $a overwrites previous argument');

        $this->new(NamedArgumentConstructorFixture::class, [
            'zero',
            'a' => 'A',
        ]);
    }
}
