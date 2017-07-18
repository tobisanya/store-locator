<?php
/*
 * This file is part of store-locator.
 *
 * (c) Tobi Sanya <tobisanya1@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tobisanya\StoreLocator;

use GuzzleHttp\Client;

class StoreLocator
{
    use Validator;

    /**
     * Google maps geocode url
     */
    const GEOCODE_BASE_URL = 'https://maps.googleapis.com/maps/api/geocode/json';

    /**
     * Earth radius in miles
     */
    const EARTH_RADIUS = 3956.0;

    /**
     * Configuration data
     * @var array
     */
    private $config;

    /**
     * Origin location coordinates
     * @var string | array
     */
    private $origin;

    /**
     * Stores data
     * @var string
     */
    private $stores;

    /**
     * StoreLocator constructor.
     * @param string|null $config. The config data for store-locator
     */
    public function __construct($config = null)
    {
        $this->validateConfig($config);
        $this->config = $config;
    }

    /**
     * Get stores closest to location based on config
     * @param string|array|null $origin
     * @return string
     */
    public function locateClosestStores($origin = null)
    {
        $this->validateLocationData($origin);
        $this->origin = $origin;
        if (is_string($origin)) {
            $this->origin = $this->googleGeocode($origin);
        }
        return $this->computeLocationDistance();
    }

    /**
     * Calculates the distance of each store to origin location
     * Returns the entire store data that was passed sorted by distance to origin
     * @return array
     */
    private function computeLocationDistance()
    {
        foreach ($this->stores as &$store) {
            $store['distance'] = $this->calcDistance(
                $this->origin['lat'],
                $this->origin['lng'],
                $store['lat'],
                $store['lng'],
                self::EARTH_RADIUS
            );
        }

        usort($this->stores, function ($a, $b) {
            $x = $a['distance'];
            $y = $b['distance'];
            return (($x < $y) ? -1 : (($x > $y) ? 1 : 0));
        });

        return $this->stores;
    }

    /**
     * Gets coordinates by geocoding location string
     * @param $location
     * @return mixed
     */
    private function googleGeocode($location)
    {
        $client = new Client();
        $response = $client->request(
            'GET',
            self::GEOCODE_BASE_URL,
            [
                'query' => ['address' => $location]
            ]
        );
        $body = json_decode((string) $response->getBody(), true);
        $coordinates = $body['results'][0]['geometry']['location'];
        return $coordinates;
    }

    /**
     * Calculates the distaance between two points
     * @param $lat1
     * @param $lng1
     * @param $lat2
     * @param $lng2
     * @param $radius
     * @return mixed
     */
    private function calcDistance($lat1, $lng1, $lat2, $lng2, $radius)
    {
        return $radius * 2 * asin(
            min(
                1,
                sqrt(
                    (
                        pow(
                            sin(($this->diffRadian($lat1, $lat2)) / 2.0),
                            2.0
                        ) + cos($this->toRadian($lat1)) * cos($this->toRadian($lat2))
                        * pow(sin(($this->DiffRadian($lng1, $lng2)) / 2.0), 2.0))
                )
            )
        );
    }

    /**
     * Calculates difference in radian of 2 values
     * @param $v1
     * @param $v2
     * @return mixed
     */
    private function diffRadian($v1, $v2)
    {
        return $this->toRadian($v2) - $this->toRadian($v1);
    }

    /**
     * Convert a to radian
     * @param $v
     * @return mixed
     */
    private function toRadian($v)
    {
        return $v * (pi() / 180);
    }
}
