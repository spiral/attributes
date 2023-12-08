<?php

declare(strict_types=1);

namespace Spiral\Attributes;

use Doctrine\Common\Annotations\Annotation\Target;
use Doctrine\Common\Annotations\Annotation\NamedArgumentConstructor as DoctrineNamedArgumentConstructor;

//
// In some cases, the polyfill may not load. For example, if this class is
// loaded from the composer plugin (plugins do not load the files defined in
// the "require.classmap" and "require.files" section of the "composer.json"
// file).
//
// In this case, it should be loaded explicitly.
//
if (!\class_exists(DoctrineNamedArgumentConstructor::class, false)) {
    require_once __DIR__ . '/polyfill.php';
}

/**
 * Metadata class that indicates that the annotated/attributed class should be
 * constructed with a named argument call.
 *
 * @Annotation
 * @Target({ "CLASS" })
 * @deprecated
 */
#[\Attribute(\Attribute::TARGET_CLASS)]
final class NamedArgumentConstructor extends DoctrineNamedArgumentConstructor
{
}
