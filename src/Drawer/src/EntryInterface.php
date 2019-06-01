<?php

/*
 * This file is part of Cabinet - file access abstraction library for PHP.
 * (c) by Dennis Birkholz <cabinet@birkholz.org>
 * All rights reserved.
 * For the license to use this library, see the provided LICENSE file.
 */

namespace Iqb\Cabinet\Drawer;

interface EntryInterface
{
    /**
     * Delete the entry
     *
     * @return bool
     */
    function delete() : bool;

    /**
     * Get the creation date of this entry
     *
     * @return \DateTimeInterface
     */
    function getCreatedTime() : \DateTimeInterface;

    /**
     * Get the unique identifier for this entry
     *
     * @return string
     */
    function getId() : string;

    /**
     * Get the modification date of this entry
     *
     * @return \DateTimeInterface
     */
    function getModifiedTime() : \DateTimeInterface;

    /**
     * Get the name this file is known by.
     * A file name should be unique for the same parent but some file system may implement it otherwise
     *
     * @return string
     */
    function getName() : string;

    /**
     * Get the (first) folder this entry is contained in
     * Only root folders will have no parent and thus return null;
     *
     * @return FolderInterface|null
     */
    function getParent() : ?FolderInterface;

    /**
     * Get all folders this entry is contained in
     *
     * @return FolderInterface[]
     */
    function getParents() : array;

    /**
     * Get the complete path of the file or directory
     *
     * @return string
     */
    function getPath() : string;

    /**
     * Get custom properties of this entry.
     * Some drivers may not be able to store properties.
     *
     * @return array
     */
    function getProperties() : array;

    /**
     * Get the size of the file or the total size of the directory in bytes
     *
     * @return int
     */
    function getSize() : int;

    /**
     * Move this entry to another folder and optionally rename it.
     *
     * @param FolderInterface $newParent
     * @param string|null $newName
     * @param bool $overwrite
     * @return EntryInterface $this or a new entry, driver dependent.
     * @throws \Exception Move failed
     */
    function move(FolderInterface $newParent, string $newName = null, bool $overwrite = false) : EntryInterface;

    /**
     * Change the name of this entry.
     *
     * @param string $newName
     * @param bool $overwrite Whether to remove a file with the same name before renaming.
     * @return EntryInterface $this or a new entry, driver dependent.
     * @throws \Exception Rename failed
     */
    function rename(string $newName, bool $overwrite = false) : EntryInterface;

    /**
     * Update the created at timestamp
     *
     * @param \DateTimeInterface $createdTime
     * @return $this
     */
    function setCreatedTime(\DateTimeInterface $createdTime) : self;

    /**
     * Update the modified at timestamp
     *
     * @param \DateTimeInterface $modifiedTime
     * @return $this
     */
    function setModifiedTime(\DateTimeInterface $modifiedTime) : self;
}
