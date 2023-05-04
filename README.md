# Open AI API Integration with Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/developerssavyour/openai.svg?style=flat-square)](https://packagist.org/packages/developerssavyour/openai)
[![Total Downloads](https://img.shields.io/packagist/dt/developerssavyour/openai.svg?style=flat-square)](https://packagist.org/packages/developerssavyour/openai)
![GitHub Actions](https://github.com/developerssavyour/openai/actions/workflows/main.yml/badge.svg)

It is the package to integrate OpenAI api with laravel.

## Installation

You can install the package via composer:

```bash
composer require developerssavyour/open-ai
```

Next, publish the configuration file:

```bash
php artisan vendor:publish --provider="DevelopersSavyour\OpenAI\OpenAIServiceProvider"
```
Or for Lumen Project manually add service provider: "DevelopersSavyour\OpenAI\OpenAIServiceProvider" to bootstrap/app.php and run

```bash
composer dump-autoload
```
## Usage

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email muhammad.hammad@savyour.com instead of using the issue tracker.

## Credits

-   [Hammad](https://github.com/developerssavyour)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
