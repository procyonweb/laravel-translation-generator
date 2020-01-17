# Translation Generator

Translation file generator for Laravel, Blade and Vue.

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
php artisan translation:generate {lang=en} # generates missing keys for translation file
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