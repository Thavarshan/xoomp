<?php

namespace Xoomp;

use FFMpeg\FFMpeg;
use FFMpeg\Coordinate\TimeCode;
use Xoomp\Exceptions\InvalidOperatingSystemType;

class Thumbnail
{
    /**
     * Instance of media manager.
     *
     * @var \FFMpeg\FFMpeg
     */
    protected $manager;

    /**
     * The video from which a thumbnail image should be generated.
     *
     * @var string
     */
    protected $video;

    /**
     * Location where the generated thumbnail image should be stored.
     *
     * @var string
     */
    protected $path;

    /**
     * Supported operating system types,
     *
     * @var array
     */
    protected $osversion = [
        'Darwin' => 'darwin',
        'WINNT' => 'winnt',
        'Linux' => 'linux',
    ];

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
     * Set video from which the thumnail should be generated.
     *
     * @param  string $video
     * @return $this
     */
    public function from($video)
    {
        $this->video = $video;

        return $this;
    }

    /**
     * Set the path/location where the thumbnail generated should be stored.
     *
     * @param  string $path
     * @return $this
     */
    public function saveTo(string $path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Generate thumbnail from video file.
     *
     * @return bool
     */
    public function generate()
    {
        $this->getMediaManager()
            ->open($this->video)
            ->frame($this->timeCode())
            ->save($this->path . 'thumbnail.jpg');
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
        $this->manager = FFMpeg::create(array_merge([
            'timeout' => 3600, // The timeout for the underlying process
            'ffmpeg.threads' => 12,   // The number of threads that FFMpeg should use
        ], $this->getBinaryfiles()));
    }

    /**
     * Get relevant path of bin files according to operating systems.
     *
     * @return string
     *
     * @throws \Xoomp\Exceptions\InvalidOperatingSystemType
     */
    protected function getBinaryfiles()
    {
        $binaries = dirname(__DIR__) . '/binaries/' . $this->operatingSystem();

        return [
            'ffmpeg.binaries' => "{$binaries}/ffmpeg",
            'ffprobe.binaries' => "{$binaries}/ffprobe",
        ];
    }

    /**
     * Determine PHP operating system and get relevant path of bin file.
     *
     * @param  bool $override
     * @return string
     *
     * @throws \Xoomp\Exceptions\InvalidOperatingSystemType
     */
    protected function operatingSystem(bool $override = false)
    {
        $operatingSystem = php_uname('s');

        if (array_key_exists($operatingSystem, $this->osversion) && ! $override) {
            return $this->osversion[$operatingSystem];
        }

        throw new InvalidOperatingSystemType('This type of operating systems are not supported');
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
