# Video Thumbnail Generator

## Basic Usage

```php
$generator = new App\Thumbnail();
$thumbnailLocation = '/path/where/thumbnail/should/be/saved';
$video = '/path/where/video/file/is.mp4';

$generator->generate($video, $thumbnailLocation);
```

