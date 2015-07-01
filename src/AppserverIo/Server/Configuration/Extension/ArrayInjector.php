<?php

/**
 * AppserverIo\Server\Configuration\Extension\ArrayInjector
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * PHP version 5
 *
 * @author    Bernhard Wick <bw@appserver.io>
 * @copyright 2015 TechDivision GmbH - <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://www.github.com/appserver-io/server
 * @link      http://www.appserver.io
 */

namespace AppserverIo\Server\Configuration\Extension;

/**
 * Will inject data in the form of an array of the structure "key" => "value" (DB must look accordingly)
 *
 * @author    Bernhard Wick <bw@appserver.io>
 * @copyright 2015 TechDivision GmbH - <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://www.github.com/appserver-io/server
 * @link      http://www.appserver.io
 */
class ArrayInjector extends AbstractInjector
{
    /**
     * @var array $data The data collected from the DB
     */
    protected $data;

    /**
     * Will init the injector's datasource
     *
     * @return void
     */
    public function init()
    {
        // Init data as an empty array
        $this->data = array();

        // Grab our DB resource
        $dbConnection = $this->getDbResource();

        // Build up the query
        $query = 'SELECT * FROM `rewrite`';

        // Get the results and fill them into our data
        foreach ($dbConnection->query($query, \PDO::FETCH_ASSOC) as $row) {
            $this->data[$row['key']] = $row['value'];
        }
    }

    /**
     * We will return a string containing all data entries delimetered by the configured delimeter
     *
     * @return mixed
     */
    public function extract()
    {
        return $this->data;
    }
}
