<?php
/*
 * This file is part of store-locator.
 *
 * (c) Tobi Sanya <tobisanya1@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tobisanya\StoreLocator\Test;

use Faker\Factory;
use PHPUnit\Framework\TestCase;
use Tobisanya\StoreLocator\Exceptions\Constants;
use Tobisanya\StoreLocator\Exceptions\FileNotFound;
use Tobisanya\StoreLocator\StoreLocator;

class StoreLocatorTest extends TestCase
{
    use Helper;

    /**
     * Faker object
     * @var object
     */
    private $faker;

    public function setUp()
    {
        $this->faker = Factory::create();
        register_shutdown_function(function() {
            if(file_exists('testfile.txt')) {
                unlink('testfile.txt');
            }
        });
    }

    public function testItShouldThrowExceptionWhenInitializedWithBadConfig()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(Constants::BAD_CONFIG_FORMAT_MESSAGE);
        new StoreLocator();
    }

    public function testItShouldThrowExceptionWhenInitializedWithNoConfig()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(Constants::BAD_CONFIG_FORMAT_MESSAGE);
        new StoreLocator();
    }

    public function testItShouldThrowExceptionWhenFileDoesNotExist()
    {
        $this->expectException(FileNotFound::class);
        new StoreLocator($this->missingStoresDataFile());
    }

    public function testItShouldThrowExceptionWhenFileIsNotJson()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(Constants::INVALID_JSON_DATA_MESSAGE);
        $filename = 'testfile.txt';
        $this->createInvalidStoresDataFile($filename);
        new StoreLocator($this->invalidStoresDataFile($filename));
    }

    public function testItShouldThrowExceptionWhenPassedBadOriginLocationData()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(Constants::EMPTY_LOCATION_DATA_MESSAGE);
        $store_locator = new StoreLocator($this->validStoresData());
        $store_locator->locateClosestStores($this->invalidOriginCoordsArgument());
    }

    public function testItShouldReturnStoresWithSortedDistanceWhenPassedValidOriginArea()
    {
        $store_locator = new StoreLocator($this->validStoresData());
        $stores = $store_locator->locateClosestStores($this->validAreaArgument());
        $this->assertArrayHasKey('distance', $stores[0]);
        $this->assertTrue($stores === $this->sortByKey($stores, 'distance'));
    }

    public function testItShouldReturnStoresWithSortedDistanceWhenPassedValidOriginCoordinates()
    {
        $store_locator = new StoreLocator($this->validStoresData());
        $stores = $store_locator->locateClosestStores($this->validOriginCoordsArgument());
        $this->assertArrayHasKey('distance', $stores[0]);
        $this->assertTrue($stores === $this->sortByKey($stores, 'distance'));
    }
}
