<?php

/**
 * This file is part of Spiral Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Spiral\Attributes;

use Doctrine\Common\Annotations\Annotation\Target;
use Doctrine\Common\Annotations\Annotation\NamedArgumentConstructor as DoctrineNamedArgumentConstructor;

/**
 * Metadata class that indicates that the annotated/attributed class should be
 * constructed with a named argument call.
 *
 * @Annotation
 * @Target({ "CLASS" })
 */
#[\Attribute(\Attribute::TARGET_CLASS)]
final class NamedArgumentConstructor extends DoctrineNamedArgumentConstructor
{
}
