# Xoomp PHP Video Thumbnail Generator

Xoomp is a simple PHP package that generates a thumbnail image of a given video file. This is done by scanning the video and capturing a single frame of it at a set or random time.

## Getting Started

### Installing

Xoomp is easy to install into your project. simply install xoomp by using composer to pull it in and it's dependencies.

```bash
composer require thavarshan/xoomp
```

### Basic Usage

```php
$thumbnail = new Xoomp\Thumbnail();

$thumbnailLocation = '/path/where/thumbnail/should/be/saved';
$video = '/path/where/video/file/is/saved.mp4';

$thumbnail->from($video)
          ->saveTo($thumbnailLocation)
          ->generate();
```

## Running the tests

Xoomp uses PHPUnit for testing. To clone xoomp into your local machine and run tests, simple open up your prefered terminal application, navigate into xoomp project root directory and run the following command..

```bash
git clone git@github.com:Thavarshan/xoomp.git
cd xoomp
composer install
vendor/bin/phpunit
```


## Contributing

Please read [CONTRIBUTING.md](https://github.com/Thavarshan/xoomp/blob/49964bea98f3b34ddb6ce59519b14e2885dc7413/CONTRIBUTING.md) for details on our code of conduct, and the process for submitting pull requests to us.

## Authors

* **Thavarshan Thayananthajothy** - *Initial work* - [Thavarshan](https://github.com/Thavarshan)

See also the list of [contributors](https://github.com/Thavarshan/xoomp/contributors) who participated in this project.

## License

This project is licensed under the MIT License - see the [LICENSE.md](https://github.com/Thavarshan/xoomp/blob/49964bea98f3b34ddb6ce59519b14e2885dc7413/LICENSE.md) file for details
