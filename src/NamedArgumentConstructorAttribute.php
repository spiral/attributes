<?php

declare(strict_types=1);

namespace Spiral\Attributes;

use Doctrine\Common\Annotations\NamedArgumentConstructorAnnotation;

//
// In some cases, the polyfill may not load. For example, if this class is
// loaded from the composer plugin (plugins do not load the files defined in
// the "require.classmap" and "require.files" section of the "composer.json"
// file).
//
// In this case, it should be loaded explicitly.
//
if (!\class_exists(NamedArgumentConstructorAnnotation::class, false)) {
    require_once __DIR__ . '/polyfill.php';
}

/**
 * Marker interface for PHP7/PHP8 compatible support for named arguments
 * (and constructor property promotion).
 * @deprecated
 */
interface NamedArgumentConstructorAttribute extends NamedArgumentConstructorAnnotation
{
}
