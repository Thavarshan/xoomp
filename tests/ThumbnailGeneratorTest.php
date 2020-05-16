<?php

namespace Xoomp\Tests;

use FFMpeg\FFMpeg;
use ReflectionClass;
use Xoomp\Thumbnail;
use FFMpeg\Coordinate\TimeCode;
use PHPUnit\Framework\TestCase;
use Xoomp\Exceptions\InvalidOperatingSystemType;

class ThumbnailGeneratorTest extends TestCase
{
    public function testAThumbnailIsGenerated()
    {
        $generator = new Thumbnail();
        $thumbnail = __DIR__ . '/stubs/thumbnail.jpg';
        $video = __DIR__ . '/stubs/sample.mp4';

        if (file_exists($thumbnail)) {
            @unlink($thumbnail);
        }

        $generator->generate($video, __DIR__ . '/stubs/');

        $this->assertTrue(file_exists($thumbnail));
        @unlink($thumbnail);
    }

    public function testMediaManagerIsCreated()
    {
        $generator = new Thumbnail();
        $reflector = new ReflectionClass($generator);
        $method = $reflector->getMethod('getMediaManager');
        $method->setAccessible(true);
        $this->assertInstanceOf(FFMpeg::class, $method->invoke($generator));
    }

    public function testMediaManagerTimeCoderIsCreated()
    {
        $generator = new Thumbnail();
        $reflector = new ReflectionClass($generator);
        $method = $reflector->getMethod('timeCode');
        $method->setAccessible(true);
        $this->assertInstanceOf(TimeCode::class, $method->invoke($generator));
    }

    public function testThrowsExceptionIfUnSupportedOSDetected()
    {
        $this->expectException(InvalidOperatingSystemType::class);
        $this->expectExceptionMessage('This type of operating systems are not supported');

        $generator = new Thumbnail();
        $reflector = new ReflectionClass($generator);
        $method = $reflector->getMethod('operatingSystem');
        $method->setAccessible(true);
        $method->invokeArgs($generator, [true]);
        $thumbnail = __DIR__ . '/stubs/thumbnail.jpg';
        $video = __DIR__ . '/stubs/sample.mp4';

        if (file_exists($thumbnail)) {
            @unlink($thumbnail);
        }

        $generator->generate($video, __DIR__ . '/stubs/');
    }
}
