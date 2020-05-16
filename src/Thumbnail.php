<?php

namespace Generator;

use FFMpeg\FFMpeg;
use FFMpeg\Coordinate\TimeCode;

class Thumbnail
{
    /**
     * Instance of media manager.
     *
     * @var \FFMpeg\FFMpeg
     */
    protected $manager;

    /**
     * Create a new project instance.
     *
     * @param string $manager
     */
    public function __construct($manager = null)
    {
        $this->manager = $manager;
    }

    /**
     * Generate thumbnail from video file.
     *
     * @param  media $video
     * @param  string $path
     * @return bool
     */
    public function generate($video, string $path)
    {
        $this->getMediaManager()
            ->open($video)
            ->frame($this->timeCode())
            ->save($path . 'thumbnail.jpg');
    }

    /**
     * Get media manager instance.
     *
     * @return \FFMpeg\FFMpeg
     */
    protected function getMediaManager()
    {
        if (is_null($this->manager)) {
            $this->createMediaManager();
        }

        return $this->manager;
    }

    /**
     * Create media manager instance.
     *
     * @return void
     */
    protected function createMediaManager()
    {
        $this->manager = FFMpeg::create([
            'ffmpeg.binaries' => __DIR__ . '/binaries/ffmpeg',
            'ffprobe.binaries' => __DIR__ . '/binaries/ffprobe',
            'timeout' => 3600, // The timeout for the underlying process
            'ffmpeg.threads' => 12,   // The number of threads that FFMpeg should use
        ]);
    }

    /**
     * Get time coder instance.
     *
     * @return \FFMpeg\Coordinate\TimeCode
     */
    protected function timeCode()
    {
        return TimeCode::fromSeconds(rand(5, 20));
    }
}
