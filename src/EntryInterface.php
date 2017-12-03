<?php

/*
 * This file is part of Cabinet - file access abstraction library for PHP.
 * (c) 2017 by Dennis Birkholz
 * All rights reserved.
 * For the license to use this library, see the provided LICENSE file.
 */

namespace Iqb\Cabinet;

interface EntryInterface
{
    /**
     * Get the complete path of the file or directory
     *
     * @return string
     */
    function getPath() : string;

    /**
     * Get the name this file is known by.
     * A file name should be unique for the same parent but some file system may implement it otherwise
     *
     * @return string
     */
    function getName() : string;

    /**
     * Change the name of this entry.
     *
     * @param string $newName
     * @throws \Exception Rename failed
     */
    function rename(string $newName);

    /**
     * Move a file to another folder and optionally rename it.
     *
     * @param FolderInterface $newParent
     * @param string|null $newName
     * @throws \Exception Move failed
     */
    function move(FolderInterface $newParent, string $newName = null);

    /**
     * Check whether the file has at least one parent.
     * Most file systems will only allow a single parent but some allow more than one parent.
     *
     * @return bool
     */
    function hasParents() : bool;

    /**
     * Get the (first) folder this entry is contained in
     *
     * @return FolderInterface
     */
    function getParent() : FolderInterface;

    /**
     * Get all folders this entry is contained in
     *
     * @return FolderInterface[]
     */
    function getParents() : array;

    /**
     * Delete the entry from all its parents
     *
     * @return bool
     */
    function delete() : bool;

    /**
     * Get the size of the file or the total size of the directory in bytes
     *
     * @return int
     */
    function getSize() : int;
}
