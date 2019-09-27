# Translation Generator

Translation file generator for Laravel, Blade and Vue

## Installation

```bash
composer require kg4b0r/laravel-translation-generator
```

```
php artisan vendor:publish --provider="Kg4b0r\TranslationGenerator\ServiceProvider"
```

## Usage

```shell script
php artisan translation:show-missing {lang=hu} # shows untranslated text in file
php artisan translation:show-files # shows all files found by configuration
php artisan translation:generate {lang=hu} # generates missing keys for translation file
```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)