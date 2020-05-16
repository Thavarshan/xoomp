<?php

namespace Generator\Tests;

use Generator\Thumbnail;
use PHPUnit\Framework\TestCase;

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
}
