<?php

/**
 * This file is part of Spiral Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Spiral\Tests\Attributes\Reader;

use Spiral\Tests\Attributes\Concerns\InteractWithMetadata;
use Spiral\Tests\Attributes\TestCase;

/**
 * @group unit
 * @group reader
 */
abstract class ReaderTestCase extends TestCase
{
    use InteractWithMetadata;

    /**
     * @return void
     */
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        require_once __DIR__ . '/Fixture/function.php';
    }
}
