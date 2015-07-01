<?php

/**
 * AppserverIo\Server\Configuration\Extension\StringInjector
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
 * This class will get create a string from a single-column DB table called "virtualHost"
 *
 * @author    Bernhard Wick <bw@appserver.io>
 * @copyright 2015 TechDivision GmbH - <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://www.github.com/appserver-io/server
 * @link      http://www.appserver.io
 */
class StringInjector extends AbstractInjector
{
    /**
     * @var array $data The data collected from the DB
     */
    protected $data;

    /**
     * Delimiter for the extracted string
     *
     * @const string STRING_DELIMETER
     */
    const STRING_DELIMETER = ' ';

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
        $query = 'SELECT * FROM `virtualHost`';

        // Get the results and fill them into our data
        foreach ($dbConnection->query($query) as $row) {
            $this->data[] = $row[0];
        }
    }

    /**
     * We will return a string containing all data entries delimitered by the configured delimiter
     *
     * @return mixed
     */
    public function extract()
    {
        // Iterate over all entries and concatenate them
        $result = '';
        foreach ($this->data as $dataEntry) {
            $result .= $dataEntry . self::STRING_DELIMETER;
        }

        // Cut the last delimiter
        return substr($result, 0, strlen($result) - strlen(self::STRING_DELIMETER));
    }
}
