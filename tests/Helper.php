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

trait Helper
{
    public function validStoresData()
    {
        return [
            'json_data' => '[ {
    "name": "' . $this->faker->name . '",
    "lat": "' . $this->faker->latitude . '",
    "lng": "' . $this->faker->longitude . '",
    "address": "' . $this->faker->streetAddress . '"
}]'
        ];
    }

    public function invalidStoresData()
    {
        return [
            'json_data' => '[ {
    "name": "' . $this->faker->name . '",
    "lat": "' . $this->faker->latitude . '",
    "lng": "' . $this->faker->longitude . '",
    "address": "' . $this->faker->streetAddress . '"
}]'
        ];
    }

    public function invalidOriginCoordsArgument()
    {
        return [];
    }

    public function validOriginCoordsArgument()
    {
        return [
            "lat" => $this->faker->latitude,
            "lng" => $this->faker->longitude
        ];
    }

    public function validAreaArgument()
    {
        return 'Berlin';
    }

    public function missingStoresDataFile()
    {
        return ['file_path' => 'stores.json'];
    }

    public function invalidStoresDataFile($filename)
    {
        return ['file_path' => $filename];
    }

    public function createInvalidStoresDataFile($filename)
    {
        fopen($filename, "w");
    }

    public function sortByKey($array, $key)
    {
        usort($array, function ($a, $b) use ($key) {
            $x = $a[$key];
            $y = $b[$key];
            return (($x < $y) ? -1 : (($x > $y) ? 1 : 0));
        });
        return $array;
    }
}
