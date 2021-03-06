<?php

/**
 * \AppserverIo\Server\Dictionaries\MimeTypesTest
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * PHP version 5
 *
 * @author    Johann Zelger <jz@appserver.io>
 * @author    Bernhard Wick <bw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/TechDivision_Http
 * @link      http://www.appserver.io
 */

namespace AppserverIo\Server\Dictionaries;

/**
 * Test implementation for the MimeTypes class.
 *
 * @author    Johann Zelger <jz@appserver.io>
 * @author    Bernhard Wick <bw@appserver.io>
 * @copyright 2015 TechDivision GmbH <info@appserver.io>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/TechDivision_Http
 * @link      http://www.appserver.io
 */
class MimeTypesTest extends \PHPUnit_Framework_TestCase
{

    /**
     * If the returned mime type is returned for the passed file extension.
     *
     * @return void
     */
    public function testGetMimeTypeByExtension()
    {
        foreach (MimeTypes::$types as $extension => $mimeType) {
            $this->assertEquals($mimeType, MimeTypes::getMimeTypeByExtension($extension));
        }
    }

    /**
     * If the returned mime type is returned for the passed unknown file extension.
     *
     * @return void
     */
    public function testGetMimeTypeByUnknownExtension()
    {
        $this->assertEquals(MimeTypes::MIMETYPE_DEFAULT, MimeTypes::getMimeTypeByExtension('a_unknown_file_extension'));
    }

    /**
     * If the returned mime type is returned for the passed filename.
     *
     * @return void
     */
    public function testGetMimeTypeByFilename()
    {
        foreach (MimeTypes::$types as $extension => $mimeType) {
            $this->assertEquals($mimeType, MimeTypes::getMimeTypeByFilename('some_filename.' . $extension));
        }
    }

    /**
     * If the returned mime type is returned for the passed filename with unknown extension.
     *
     * @return void
     */
    public function testGetMimeTypeByFilenameWithUnknownExtension()
    {
        $this->assertEquals(MimeTypes::MIMETYPE_DEFAULT, MimeTypes::getMimeTypeByFilename('a_unknown_filename.unknown_extension'));
    }

    /**
     * If the returned mime type is returned for the passed filename without extension.
     *
     * @return void
     */
    public function testGetMimeTypeByFilenameWithoutExtension()
    {
        $this->assertEquals(MimeTypes::MIMETYPE_DEFAULT, MimeTypes::getMimeTypeByFilename('filename_without_extension'));
    }
}
