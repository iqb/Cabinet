<?php

/*
 * This file is part of Cabinet - file access abstraction library for PHP.
 * (c) by Dennis Birkholz <cabinet@birkholz.org>
 * All rights reserved.
 * For the license to use this library, see the provided LICENSE file.
 */

namespace Iqb\Cabinet\Drawer;

interface FolderInterface extends EntryInterface
{
    /**
     * Create a new file in the current folder containing the supplied data
     *
     * @param string $fileName
     * @param string $data
     * @return FileInterface
     */
    function createFile(string $fileName, string $data) : FileInterface;

    /**
     * Create a new folder below the this folder.
     * The folder name must not contain the / character unless $recursive = true.
     *  In this case, a folder hierarchy will be created and already existing folders will not produce an error.
     *
     * @param string $folderName
     * @param bool $recursive
     * @return FolderInterface
     */
    function createFolder(string $folderName, bool $recursive = false) : FolderInterface;

    /**
     * Delete this folders if it is empty or use $recursive = true to recursively delete all children as well.
     *
     * @param bool $recursive
     * @return bool
     */
    function delete(bool $recursive = false) : bool;

    /**
     * Get a single child identified by the supplied name.
     *
     * @param string $name
     * @return EntryInterface|null
     */
    function getChild(string $name) : ?EntryInterface;

    /**
     * Get all entries contained in this folder
     *
     * @return EntryInterface[]
     */
    function getChildren() : array;

    /**
     * Check whether the folder contains a child with the supplied name
     *
     * @param string $name
     * @return bool
     */
    function hasChild(string $name) : bool;

    /**
     * Verify this folder is the parent of the supplied child
     *
     * @param EntryInterface $child
     * @return bool
     */
    function isParent(EntryInterface $child) : bool;
}
