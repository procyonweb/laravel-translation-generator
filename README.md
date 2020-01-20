# Translation Generator

[![Latest Version on Packagist](https://img.shields.io/packagist/v/procyonweb/laravel-translation-generator.svg?style=flat-square)](https://packagist.org/packages/procyonweb/subscription)
[![Build Status](https://img.shields.io/travis/procyonweb/laravel-translation-generator/master.svg?style=flat-square)](https://travis-ci.org/procyonweb/subscription)
[![Quality Score](https://img.shields.io/scrutinizer/g/procyonweb/laravel-translation-generator.svg?style=flat-square)](https://scrutinizer-ci.com/g/procyonweb/subscription)
[![Total Downloads](https://img.shields.io/packagist/dt/procyonweb/laravel-translation-generator.svg?style=flat-square)](https://packagist.org/packages/procyonweb/subscription)

Translation file generator for Laravel, Blade and Vue with upload and download from Lokalise.

## Installation

```bash
composer require procyonweb/laravel-translation-generator
```

```
php artisan vendor:publish --provider="ProcyonWeb\TranslationGenerator\ServiceProvider"
```

## Usage

```shell script
php artisan translation:show-missing {lang=en} # shows untranslated text in file
php artisan translation:show-files # shows all files found by configuration
php artisan translation:generate {lang=en} {--upload} # generates missing keys for translation file and upload to Lokalise
php artisan translation:download # download all translation from Lokalise
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email gabor@procyonweb.lu instead of using the issue tracker.

## Credits

- [Gabor Koszegi](https://github.com/procyonweb)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.