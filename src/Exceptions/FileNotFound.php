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

class FileNotFound extends \RuntimeException
{
    /**
     * Constructor.
     *
     * @param string $path The path to the file that was not found
     */
    public function __construct($path)
    {
        parent::__construct(sprintf('The file "%s" does not exist', $path));
    }
}