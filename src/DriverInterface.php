<?php

namespace Iqb\Cabinet;

interface DriverInterface
{
    /**
     * @param string $fileName
     * @param FolderInterface|null $parent
     * @return FileInterface
     */
    function fileFactory(string $fileName, FolderInterface $parent = null) : FileInterface;

    /**
     * @param string $folderName
     * @param FolderInterface|null $parent
     * @return FolderInterface
     */
    function folderFactory(string $folderName, FolderInterface $parent = null) : FolderInterface;

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
     * Register a handler that is called after a File object was initialized
     *
     * Signature for the callback:
     * function(fileInterface $file, Driver $driver, string $handlerName)
     *
     * @param callable $fileLoadedHandler
     * @param string|null $name Name to register handler as, auto generate name if null
     * @return string Name this handler is registered under
     */
    function registerFileLoadedHandler(callable $fileLoadedHandler, string $name = null) : string;

    /**
     * Remove a previously registered handler
     *
     * @param string $name Name returned by registerFileLoadedHandler()
     */
    function unregisterFileLoadedHandler(string $name);

    /**
     * Call folder loaded handler for the supplied folder
     *
     * @param FolderInterface $folder
     */
    function notifyFolderLoaded(FolderInterface $folder);

    /**
     * Register a handler that is called after a folder is initialized but before all children are scanned
     *
     * @param callable $folderLoadedHandler Signature: function(FolderInterface $folder, Driver $driver, string $handlerName)
     * @param string|null $name Name to register handler as, auto generate name if null
     * @return string Name this handler is registered under
     */
    function registerFolderLoadedHandler(callable $folderLoadedHandler, string $name = null) : string;

    /**
     * Remove a previously registered handler
     *
     * @param string $name Name returned by registerFolderLoadedHandler()
     */
    function unregisterFolderLoadedHandler(string $name);

    /**
     * Call folder scanned handler for the supplied folder
     *
     * @param FolderInterface $folder
     */
    function notifyFolderScanned(FolderInterface $folder);

    /**
     * Register a handler that is called after a folder is created and all children are scanned
     *
     * @param callable $folderScannedHandler Signature: function(FolderInterface $folder, Driver $driver, string $handlerName)
     * @param string|null $name Name to register handler as, auto generate name if null
     * @return string Name this handler is registered under
     */
    function registerFolderScannedHandler(callable $folderScannedHandler, string $name = null) : string;

    /**
     * Remove a previously registered handler
     *
     * @param string $name Name returned by registerFolderScannedHandler()
     */
    function unregisterFolderScannedHandler(string $name);
}
