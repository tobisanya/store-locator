<?php
/*
 * This file is part of store-locator.
 *
 * (c) Tobi Sanya <tobisanya1@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tobisanya\StoreLocator\Exceptions;

class Constants
{
    const LOCATION_DATA_FORMAT_MESSAGE = 'Location should either be an array or a string';
    const INVALID_JSON_DATA_MESSAGE = 'file_path or json_data must point to valid json';
    const BAD_CONFIG_FORMAT_MESSAGE = 'Config is not an array';
    const EMPTY_LOCATION_DATA_MESSAGE = 'Location data should not be empty';
}