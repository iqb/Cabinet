<?php

/*
 * This file is part of Cabinet - file access abstraction library for PHP.
 * (c) 2017 by Dennis Birkholz
 * All rights reserved.
 * For the license to use this library, see the provided LICENSE file.
 */

namespace Iqb\Cabinet\FileSystem\Tests;

use Iqb\Cabinet\FileSystem\Driver;
use Iqb\Cabinet\FileSystem\File;
use Iqb\Cabinet\FileSystem\Folder;
use PHPUnit\Framework\TestCase;

class DriverTest extends TestCase
{
    public function testAutoScan()
    {
        $fsDriver = new Driver();
        $fsDriver->setAutoScanFolders(true);
        $root = $fsDriver->folderFactory(__DIR__ . '/Sample');

        $fsDriver->setFileFactory(function() { throw new \RuntimeException("All files should have been created already!"); });
        $fsDriver->setFolderFactory(function() { throw new \RuntimeException("All folders should have been created already!"); });

        $dirs = [];

        foreach ($root->getChildren() as $child) {
            $dirs[] = $child->getName();
        }

        $this->assertTrue($root->hasChild('Subdir1'));
        /* @var $subdir1 Folder */
        $subdir1 = $root->getChild('Subdir1');
        $this->assertInstanceOf(Folder::class, $subdir1);
        $this->assertTrue($subdir1->hasChild("SubSubDir"));
        /* @var $subsubdir Folder */
        $subsubdir = $subdir1->getChild('SubSubDir');
        $this->assertInstanceOf(Folder::class, $subsubdir);
        $this->assertTrue($subsubdir->hasChild('lorem.txt'));
        /* @var $loremTxt File */
        $loremTxt = $subsubdir->getChild('lorem.txt');
        $this->assertEquals(451, $loremTxt->getSize());
        $this->assertFalse($loremTxt->hasHash());
        $this->assertEquals('afd2ef8aca8c4804da07577dd20b0e8a', $loremTxt->getHash());
        $this->assertTrue($loremTxt->hasHash());

        $this->assertTrue($root->hasChild('Subdir2'));
    }
}
