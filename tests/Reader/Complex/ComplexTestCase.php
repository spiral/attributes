<?php

/**
 * This file is part of Spiral Framework package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Spiral\Tests\Attributes\Reader\Complex;

use Spiral\Tests\Attributes\Reader\Fixture\AnnotatedClass;
use Spiral\Tests\Attributes\Reader\Fixture\Annotation\ClassAnnotation;
use Spiral\Tests\Attributes\Reader\Fixture\Annotation\ConstantAnnotation;
use Spiral\Tests\Attributes\Reader\Fixture\Annotation\FunctionAnnotation;
use Spiral\Tests\Attributes\Reader\Fixture\Annotation\FunctionParameterAnnotation;
use Spiral\Tests\Attributes\Reader\Fixture\Annotation\MethodAnnotation;
use Spiral\Tests\Attributes\Reader\Fixture\Annotation\MethodParameterAnnotation;
use Spiral\Tests\Attributes\Reader\Fixture\Annotation\PropertyAnnotation;
use Spiral\Tests\Attributes\Reader\ReaderTestCase;

/**
 * @group unit
 * @group reader
 * @group complex
 */
abstract class ComplexTestCase extends ReaderTestCase
{
    /**
     * @var string
     */
    private const FIXTURE_FUNCTION_FQN = '\\Spiral\\Tests\\Attributes\\Reader\\Fixture\\annotated_function';

    /**
     * @var int
     */
    protected $classMetadataCount = 1;

    /**
     * @var int
     */
    protected $constantMetadataCount = 1;

    /**
     * @var int
     */
    protected $propertyMetadataCount = 1;

    /**
     * @var int
     */
    protected $methodMetadataCount = 1;

    /**
     * @var int
     */
    protected $methodParameterMetadataCount = 1;

    /**
     * @var int
     */
    protected $functionMetadataCount = 1;

    /**
     * @var int
     */
    protected $functionParameterMetadataCount = 1;

    public function testClassMetadataCount(): void
    {
        $this->assertCount($this->classMetadataCount,
            $this->getClassMetadata(AnnotatedClass::class)
        );
    }

    public function testClassMetadataObjects(): void
    {
        $expected = $this->newAnnotation(ClassAnnotation::class, [
            'field' => 'value'
        ]);

        if ($this->classMetadataCount === 0) {
            $this->expectNotToPerformAssertions();
        }

        foreach ($this->getClassMetadata(AnnotatedClass::class) as $actual) {
            $this->assertEquals($expected, $actual);
        }
    }

    public function testConstantMetadataCount(): void
    {
        $this->assertCount($this->constantMetadataCount,
            $this->getConstantMetadata(AnnotatedClass::class, 'CONSTANT')
        );
    }

    public function testConstantMetadataObjects(): void
    {
        $expected = $this->newAnnotation(ConstantAnnotation::class, [
            'field' => 'value'
        ]);

        if ($this->constantMetadataCount === 0) {
            $this->expectNotToPerformAssertions();
        }

        foreach ($this->getConstantMetadata(AnnotatedClass::class, 'CONSTANT') as $actual) {
            $this->assertEquals($expected, $actual);
        }
    }

    public function testPropertyMetadataCount(): void
    {
        $this->assertCount($this->propertyMetadataCount,
            $this->getPropertyMetadata(AnnotatedClass::class, 'property')
        );
    }

    public function testPropertyMetadataObjects(): void
    {
        $expected = $this->newAnnotation(PropertyAnnotation::class, [
            'field' => 'value'
        ]);

        if ($this->propertyMetadataCount === 0) {
            $this->expectNotToPerformAssertions();
        }

        foreach ($this->getPropertyMetadata(AnnotatedClass::class, 'property') as $actual) {
            $this->assertEquals($expected, $actual);
        }
    }

    public function testMethodMetadataCount(): void
    {
        $this->assertCount($this->methodMetadataCount,
            $this->getMethodMetadata(AnnotatedClass::class, 'method')
        );
    }

    public function testMethodMetadataObjects(): void
    {
        $expected = $this->newAnnotation(MethodAnnotation::class, [
            'field' => 'value'
        ]);

        if ($this->methodMetadataCount === 0) {
            $this->expectNotToPerformAssertions();
        }

        foreach ($this->getMethodMetadata(AnnotatedClass::class, 'method') as $actual) {
            $this->assertEquals($expected, $actual);
        }
    }

    public function testMethodParameterMetadataCount(): void
    {
        $this->assertCount($this->methodParameterMetadataCount,
            $this->getMethodParameterMetadata(AnnotatedClass::class, 'method', 'parameter')
        );
    }

    public function testMethodParameterMetadataObjects(): void
    {
        $expected = $this->newAnnotation(MethodParameterAnnotation::class, [
            'field' => 'value'
        ]);

        if ($this->methodParameterMetadataCount === 0) {
            $this->expectNotToPerformAssertions();
        }

        foreach ($this->getMethodParameterMetadata(AnnotatedClass::class, 'method', 'parameter') as $actual) {
            $this->assertEquals($expected, $actual);
        }
    }

    public function testFunctionMetadataCount(): void
    {
        $this->assertCount($this->functionMetadataCount,
            $this->getFunctionMetadata(self::FIXTURE_FUNCTION_FQN)
        );
    }

    public function testFunctionMetadataObjects(): void
    {
        $expected = $this->newAnnotation(FunctionAnnotation::class, [
            'field' => 'value'
        ]);

        if ($this->functionMetadataCount === 0) {
            $this->expectNotToPerformAssertions();
        }

        foreach ($this->getFunctionMetadata(self::FIXTURE_FUNCTION_FQN) as $actual) {
            $this->assertEquals($expected, $actual);
        }
    }

    public function testFunctionParameterMetadataCount(): void
    {
        $this->assertCount($this->functionParameterMetadataCount,
            $this->getFunctionParameterMetadata(self::FIXTURE_FUNCTION_FQN, 'parameter')
        );
    }

    public function testFunctionParameterMetadataObjects(): void
    {
        $expected = $this->newAnnotation(FunctionParameterAnnotation::class, [
            'field' => 'value'
        ]);

        if ($this->functionParameterMetadataCount === 0) {
            $this->expectNotToPerformAssertions();
        }

        foreach ($this->getFunctionParameterMetadata(self::FIXTURE_FUNCTION_FQN, 'parameter') as $actual) {
            $this->assertEquals($expected, $actual);
        }
    }
}
