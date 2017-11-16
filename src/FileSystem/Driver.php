<?php

namespace Iqb\Cabinet\FileSystem;

use Iqb\Cabinet\DriverHandlerTrait;
use Iqb\Cabinet\DriverInterface;
use Iqb\Cabinet\FileInterface;
use Iqb\Cabinet\FolderInterface;

/**
 * Configuration container for a specific file system mapping
 */
class Driver implements DriverInterface
{
    use DriverHandlerTrait;

    /**
     * @var bool
     */
    private $autoScanFolders = false;

    /**
     * Factory callable to create a new File object
     * @var callable
     * @see DriverInterface::createFile()
     */
    private $fileFactory;

    /**
     * Factory callable to create a new Folder object
     * @var callable
     * @see DriverInterface::createFolder()
     */
    private $folderFactory;

    /**
     * @var callable
     * @see DriverInterface::setHashFunction()
     */
    private $hashFunction;


    /**
     * Change the value of the $autoScanFolder property.
     *
     * @param bool $autoScanFolder
     * @return bool Previous value
     */
    final public function setAutoScanFolders(bool $autoScanFolder) : bool
    {
        $oldAutoScanFolders = $this->autoScanFolders;
        $this->autoScanFolders = $autoScanFolder;
        return $oldAutoScanFolders;
    }


    /** @inheritdoc */
    final public function fileFactory(string $fileName, FolderInterface $parent = null, Stat $stat = null) : FileInterface
    {
        if ($this->fileFactory) {
            $file = ($this->fileFactory)($this, $fileName, $parent, $stat);
        } else {
            $file = new File($this, $fileName, $parent, $stat);
        }

        $this->notifyFileLoaded($file);
        return $file;
    }


    /** @inheritdoc */
    final public function setFileFactory(callable $fileFactory)
    {
        $this->fileFactory = $fileFactory;
    }


    /** @inheritdoc */
    final public function folderFactory(string $folderName, FolderInterface $parent = null, Stat $stat = null) : FolderInterface
    {
        if ($this->folderFactory) {
            $folder = ($this->folderFactory)($this, $folderName, $parent, $stat);
        } else {
            $folder = new Folder($this, $folderName, $parent, $stat);
        }

        $this->notifyFolderLoaded($folder);

        if ($this->autoScanFolders) {
            $folder->getChildren();
        }

        return $folder;
    }


    /** @inheritdoc */
    final public function setFolderFactory(callable $folderFactory)
    {
        $this->folderFactory = $folderFactory;
    }


    /** @inheritdoc */
    final public function hashFile(FileInterface $file): string
    {
        if ($this->hashFunction) {
            return ($this->hashFunction)($file);
        }

        else {
            return \md5_file($file->getPath());
        }
    }


    /** @inheritdoc */
    final public function setHashFunction(callable $hashFunction)
    {
        $this->hashFunction = $hashFunction;
    }
}
