<?php

/*
 * This file is part of Cabinet - file access abstraction library for PHP.
 * (c) by Dennis Birkholz <cabinet@birkholz.org>
 * All rights reserved.
 * For the license to use this library, see the provided LICENSE file.
 */

namespace Iqb\Cabinet\Drawer;

interface DriverInterface
{
    /**
     * @param string $fileName
     * @param FolderInterface|null $parent
     * @return FileInterface
     * @internal Used by FolderInterface::getChildren()
     */
    function fileFactory(string $fileName, FolderInterface $parent = null) : FileInterface;

    /**
     * Set the factory method for creating new File objects.
     *
     * @param callable $fileFactory function(DriverInterface $driver, string $fileName, FolderInterface $parent = null) : FileInterface
     */
    function setFileFactory(callable $fileFactory);

    /**
     * @param string $folderName
     * @param FolderInterface|null $parent
     * @return FolderInterface
     * @internal Used by FolderInterface::getChildren()
     */
    function folderFactory(string $folderName, FolderInterface $parent = null) : FolderInterface;

    /**
     * Set the factory method for creating new Folder objects.
     *
     * @param callable $folderFactory function(DriverInterface $driver, string $folderName, FolderInterface $parent = null) : FolderInterface
     */
    function setFolderFactory(callable $folderFactory);

    /**
     * Hash the supplied file.
     * You should not use this method directly, use FileInterface::getHash().
     *
     * @param FileInterface $file
     * @return string
     * @internal Used by FileInterface::getHash()
     */
    function hashFile(FileInterface $file) : string;

    /**
     * Set the method for calculating file hashes.
     * Some drivers will never use the hash function and instead rely on hashes provided by the underlying storage.
     *
     * @param callable $hashFunction function(File $file) : string
     */
    function setHashFunction(callable $hashFunction);

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
