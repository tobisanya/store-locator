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

use Tobisanya\StoreLocator\Exceptions\Constants;
use Tobisanya\StoreLocator\Exceptions\FileNotFound;

trait Validator
{
    /**
     * Validates the config data passed in
     * @param $config
     * @throws \InvalidArgumentException when wrong config type is passed
     */
    private function validateConfig($config)
    {
        if (!is_array($config)) {
            throw new \InvalidArgumentException(Constants::BAD_CONFIG_FORMAT_MESSAGE);
        }
        if (!array_key_exists('file_path', $config) && !array_key_exists('json_data', $config)) {
            throw new \InvalidArgumentException('Config should either contain a `file_path` or `json_data`');
        }
        if (array_key_exists('file_path', $config)) {
            if (!file_exists($config['file_path'])) {
                throw new FileNotFound($config['file_path']);
            }
            $stores_data = file_get_contents($config['file_path']);
        }
        if (array_key_exists('json_data', $config)) {
            $stores_data = $config['json_data'];
        }

        $stores = json_decode(
            $stores_data,
            true
        );
        if (!$stores) {
            throw new \InvalidArgumentException(Constants::INVALID_JSON_DATA_MESSAGE);
        }
        $this->stores = $stores;
    }

    /**
     * Validate location data
     * @param $location
     * @throws StoreLocatorException when wrong location data is passed
     * @throws \InvalidArgumentException when wrong location is passed
     */
    private function validateLocationData($location = null)
    {
        if (!is_array($location) && !is_string($location)) {
            throw new \InvalidArgumentException(Constants::LOCATION_DATA_FORMAT_MESSAGE);
        }
        if (empty($location)) {
            throw new \InvalidArgumentException(Constants::EMPTY_LOCATION_DATA_MESSAGE);
        }
        if (is_array($location)) {
            if ((!array_key_exists('lng', $location) || !array_key_exists('lat', $location))) {
                throw new \InvalidArgumentException('Location array should contain values for key `lng` and `lat');
            }
            if (!is_double($location['lng']) || !is_double($location['lat'])) {
                throw new \InvalidArgumentException(
                    'Location array should contain valid values for key `lng` and `lat'
                );
            }
        }
    }
}