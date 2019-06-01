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
    ######################################################################
    # Manage entries                                                     #
    ######################################################################

    /**
     * Get the root element
     *
     * @return FolderInterface|null
     */
    function getRoot() : ?FolderInterface;

    /**
     * Access a file or directory by identifier.
     * The ID is implementation dependent and may be the inode for a local file system or
     *  some arbitrary file identifier provided by the storage backend.
     *
     * @param string $entryId
     * @return EntryInterface|null
     */
    function getEntryById(string $entryId) : ?EntryInterface;

    /**
     * Get an entry from the supplied folder
     *
     * @param FolderInterface $folder
     * @param string $entryName
     * @return EntryInterface|null
     */
    function getEntryFromFolder(FolderInterface $folder, string $entryName) : ?EntryInterface;

    /**
     * Get all entries that are direct children of the supplied folder
     *
     * @param FolderInterface $folder
     * @return EntryInterface[]|null
     */
    function getEntries(FolderInterface $folder) : ?\Traversable;

    /**
     * Create a new folder below the provided parent folder
     *
     * @param FolderInterface $parent
     * @param string $name
     * @return FolderInterface
     */
    function createFolder(FolderInterface $parent, string $name) : FolderInterface;

    /**
     * Delete the supplied entry.
     *
     * @param EntryInterface $entry
     * @param bool $recursive
     * @return bool
     */
    function deleteEntry(EntryInterface $entry, bool $recursive = false) : bool;

//    /**
//     * Get a file by specifying the the path name relative to the file system root or the supplied folder
//     *
//     * @param string $filePath
//     * @param FolderInterface|null $rootFolder
//     * @return FileInterface|null
//     */
//    function getFileByPath(string $filePath, FolderInterface $rootFolder = null) : ?FileInterface;
//
//    /**
//     * Get all files that are direct children of the supplied folder
//     *
//     * @param FolderInterface $folder
//     * @return FileInterface[]|null
//     */
//    function getFiles(FolderInterface $folder) : ?\Traversable;
//
//    /**
//     * Recursively get all files in the supplied folder
//     *
//     * @param FolderInterface $folder
//     * @return FileInterface[]|null
//     */
//    function getFilesRecursive(FolderInterface $folder) : ?\Traversable;

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
}
