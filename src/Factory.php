<?php

/**
 * This file is part of Spiral Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Spiral\Attributes;

use Doctrine\Common\Annotations\AnnotationReader as DoctrineAnnotationReader;
use Doctrine\Common\Annotations\Reader as DoctrineReaderInterface;
use Psr\SimpleCache\CacheInterface;
use Spiral\Attributes\Composite\SelectiveReader;

class Factory implements FactoryInterface
{
    /**
     * @var CacheInterface|null
     */
    private $cache;

    /**
     * @param CacheInterface|null $cache
     * @return $this
     */
    public function withCache(?CacheInterface $cache): self
    {
        $self = clone $this;
        $self->cache = $cache;

        return $self;
    }

    /**
     * {@inheritDoc}
     */
    public function create(): ReaderInterface
    {
        $reader = new AttributeReader();

        if (\interface_exists(DoctrineReaderInterface::class)) {
            $reader = new SelectiveReader([$reader, new DoctrineAnnotationReader()]);
        }

        if ($this->cache !== null) {
            $reader = new Psr16CachedReader($reader, $this->cache);
        }

        return $reader;
    }
}
