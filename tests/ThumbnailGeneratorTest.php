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
        $thumbnail = new Thumbnail();
        $thumbnailFile = __DIR__ . '/stubs/thumbnail.jpg';
        $video = __DIR__ . '/stubs/sample.mp4';

        if (file_exists($thumbnailFile)) {
            @unlink($thumbnailFile);
        }

        $thumbnail->from($video)
            ->saveTo(__DIR__ . '/stubs/')
            ->generate();

        $this->assertTrue(file_exists($thumbnailFile));
        @unlink($thumbnailFile);
    }

    public function testMediaManagerIsCreated()
    {
        $thumbnail = new Thumbnail();
        $reflector = new ReflectionClass($thumbnail);
        $method = $reflector->getMethod('getMediaManager');
        $method->setAccessible(true);
        $this->assertInstanceOf(FFMpeg::class, $method->invoke($thumbnail));
    }

    public function testMediaManagerTimeCoderIsCreated()
    {
        $thumbnail = new Thumbnail();
        $reflector = new ReflectionClass($thumbnail);
        $method = $reflector->getMethod('timeCode');
        $method->setAccessible(true);
        $this->assertInstanceOf(TimeCode::class, $method->invoke($thumbnail));
    }

    public function testThrowsExceptionIfUnSupportedOSDetected()
    {
        $this->expectException(InvalidOperatingSystemType::class);
        $this->expectExceptionMessage('This type of operating systems are not supported');

        $thumbnail = new Thumbnail();
        $reflector = new ReflectionClass($thumbnail);
        $method = $reflector->getMethod('operatingSystem');
        $method->setAccessible(true);
        $method->invokeArgs($thumbnail, [true]);
        $thumbnailFile = __DIR__ . '/stubs/thumbnail.jpg';
        $video = __DIR__ . '/stubs/sample.mp4';

        if (file_exists($thumbnailFile)) {
            @unlink($thumbnailFile);
        }

        $thumbnail->from($video)
            ->saveTo(__DIR__ . '/stubs/')
            ->generate();
    }
}
