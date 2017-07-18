# Store Locator

[![Latest Version](https://img.shields.io/github/release/thephpleague/skeleton.svg?style=flat-square)](https://github.com/thephpleague/skeleton/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/thephpleague/skeleton/master.svg?style=flat-square)](https://travis-ci.org/thephpleague/skeleton)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/thephpleague/skeleton.svg?style=flat-square)](https://scrutinizer-ci.com/g/thephpleague/skeleton/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/thephpleague/skeleton.svg?style=flat-square)](https://scrutinizer-ci.com/g/thephpleague/skeleton)
[![Total Downloads](https://img.shields.io/packagist/dt/league/skeleton.svg?style=flat-square)](https://packagist.org/packages/league/skeleton)

Simple and easy to use PHP Store Locator Package.

Show users your closest store/office to their location

## Install

Via Composer

``` bash
$ composer require tobisanya/store-locator
```

## Usage

``` php
$storeLocator = new StoreLocator($config);
$closestLocations = $storeLocator->locateClosestStores($origin);
```
The complete json data is returned ordered by increasing distance to the origin. A distance (to the origin) field is also added to each store data.

`$config` should be an array pointing to a json file or json string;

``` php
//with json file
$config = ['file_path' => 'stores.json']
```

```php
//with json string
$config = [
           'json_data' => '[ {
              "name": "Acme Office",
              "lat": "3.456783",
              "lng": "-1.393922",
              "address": "Acme Road, Acme Town"
            }]'
          ]
```
`$origin` should be an array of `lng` and `lat` values or a string of an area name. If a string representing an area is passed, it geocoded and `lng` and `lat` values are automatically retrieved.
```php
//with array
$origin = ['lng' => 2.454343, 'lat' => 3.453535]
```

```php
//with string
$origin = 'Berlin'
```

## Testing

``` bash
$ phpunit
```

## Contributing

Please see [CONTRIBUTING](https://github.com/tobisanya/store-locator/blob/master/CONTRIBUTING.md) for details.

## Credits

- [:Tobi Sanya](https://github.com/tobisanya)
- [All Contributors](https://github.com/tobisanya/store-locator/contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
