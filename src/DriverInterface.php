<?php

namespace Iqb\Cabinet;

interface DriverInterface
{
    /**
     * @param string $fileName
     * @param FolderInterface|null $parent
     * @return FileInterface
     */
    function createFile(string $fileName, FolderInterface $parent = null) : FileInterface;

    /**
     * @param string $folderName
     * @param FolderInterface|null $parent
     * @return FolderInterface
     */
    function createFolder(string $folderName, FolderInterface $parent = null) : FolderInterface;

    /**
     * Signature for the callback:
     * function(DriverInterface $driver, string $fileName, FolderInterface $parent = null) : FileInterface
     *
     * @param callable $fileFactory
     */
    function setFileFactory(callable $fileFactory);

    /**
     * Signature for the callback:
     * function(DriverInterface $driver, string $folderName, FolderInterface $parent = null) : FolderInterface
     *
     * @param callable $folderFactory
     */
    function setFolderFactory(callable $folderFactory);

    /**
     * Call file loaded handler for the supplied file
     *
     * @param FileInterface $file
     */
    function notifyFileLoaded(FileInterface $file);

    /**
     * Called after a file object is initialized
     *
     * Signature for the callback:
     * function(Driver $driver, fileInterface $file)
     *
     * @param callable $fileLoadedHandler
     */
    function setFileLoadedHandler(callable $fileLoadedHandler);

    /**
     * Call folder loaded handler for the supplied folder
     *
     * @param FolderInterface $folder
     */
    function notifyFolderLoaded(FolderInterface $folder);

    /**
     * Called after a folder is created but before all children are scanned
     *
     * Signature for the callback:
     * function(Driver $driver, FolderInterface $folder)
     *
     * @param callable $folderLoadedHandler
     */
    function setFolderLoadedHandler(callable $folderLoadedHandler);

    /**
     * Call folder scanned handler for the supplied folder
     *
     * @param FolderInterface $folder
     */
    function notifyFolderScannedHandler(FolderInterface $folder);

    /**
     * Called after a folder is created and all children are scanned
     *
     * Signature for the callback:
     * function(Driver $driver, FolderInterface $folder)
     *
     * @param callable $folderScannedHandler
     */
    function setFolderScannedHandler(callable $folderScannedHandler);
}
