# Video Thumbnail Generator

## Basic Usage

```php
$generator = new Generator\Thumbnail();
$thumbnail = __DIR__ . '/stubs/thumbnail.jpg';
$video = __DIR__ . '/stubs/sample.mp4';

$generator->generate($video, __DIR__ . '/stubs/');
```

