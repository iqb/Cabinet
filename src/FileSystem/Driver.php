<?php

namespace Iqb\Cabinet\FileSystem;

use Iqb\Cabinet\DriverInterface;
use Iqb\Cabinet\FileInterface;
use Iqb\Cabinet\FolderInterface;

/**
 * Configuration container for a specific file system mapping
 */
class Driver implements DriverInterface
{
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
     * @see DriverInterface::setFileLoadedHandler()
     */
    private $fileLoadedHandler;

    /**
     * @var callable
     * @see DriverInterface::setFolderLoadedHandler()
     */
    private $folderLoadedHandler;

    /**
     * @var callable
     * @see DriverInterface::setFolderScannedHandler()
     */
    private $folderScannedHandler;


    /**
     * Change the value of the $autoScanFolder property.
     * Returns the old value
     *
     * @param bool $autoScanFolder
     * @return bool
     */
    final public function setAutoScanFolders(bool $autoScanFolder) : bool
    {
        $oldAutoScanFolders = $this->autoScanFolders;
        $this->autoScanFolders = $autoScanFolder;
        return $oldAutoScanFolders;
    }


    /** @inheritdoc */
    final public function createFile(string $fileName, FolderInterface $parent = null, Stat $stat = null) : FileInterface
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
    final public function createFolder(string $folderName, FolderInterface $parent = null, Stat $stat = null) : FolderInterface
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
    final public function setFileFactory(callable $fileFactory)
    {
        $this->fileFactory = $fileFactory;
    }


    /** @inheritdoc */
    final public function setFolderFactory(callable $folderFactory)
    {
        $this->folderFactory = $folderFactory;
    }


    /** @inheritdoc */
    final public function notifyFileLoaded(FileInterface $file)
    {
        if ($this->fileLoadedHandler) {
            ($this->fileLoadedHandler)($this, $file);
        }
    }


    /** @inheritdoc */
    final public function setFileLoadedHandler(callable $fileLoadedHandler)
    {
        $this->fileLoadedHandler = $fileLoadedHandler;
    }


    /** @inheritdoc */
    final public function notifyFolderLoaded(FolderInterface $folder)
    {
        if ($this->folderLoadedHandler) {
            ($this->folderLoadedHandler)($this, $folder);
        }
    }


    /** @inheritdoc */
    final public function setFolderLoadedHandler(callable $folderLoadedHandler)
    {
        $this->folderLoadedHandler = $folderLoadedHandler;
    }


    /** @inheritdoc */
    final public function notifyFolderScannedHandler(FolderInterface $folder)
    {
        if ($this->folderScannedHandler) {
            ($this->folderScannedHandler)($this, $folder);
        }
    }


    /** @inheritdoc */
    final public function setFolderScannedHandler(callable $folderScannedHandler)
    {
        $this->folderScannedHandler = $folderScannedHandler;
    }
}
