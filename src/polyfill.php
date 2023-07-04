<?php

/**
 * This file is part of Spiral Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Doctrine\Common\Annotations {
    use Doctrine\Common\Annotations\Annotation\NamedArgumentConstructor;

    if (!\interface_exists(NamedArgumentConstructorAnnotation::class)) {
        /**
         * Marker interface for PHP7/PHP8 compatible support for named
         * arguments (and constructor property promotion).
         *
         * @deprecated Implementing this interface is deprecated.
         *             Use the Annotation @NamedArgumentConstructor instead.
         * @psalm-suppress UnrecognizedStatement
         */
        interface NamedArgumentConstructorAnnotation
        {
        }
    }
}

namespace Doctrine\Common\Annotations\Annotation {
    if (!\class_exists(NamedArgumentConstructor::class, false)) {
        /**
         * Annotation that indicates that the annotated class should be
         * constructed with a named argument call.
         *
         * @Annotation
         * @Target("CLASS")
         */
        #[\Attribute(\Attribute::TARGET_CLASS)]
        class NamedArgumentConstructor
        {
        }
    }
}
