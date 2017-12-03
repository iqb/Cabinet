<?php

/*
 * This file is part of Cabinet - file access abstraction library for PHP.
 * (c) 2017 by Dennis Birkholz
 * All rights reserved.
 * For the license to use this library, see the provided LICENSE file.
 */

namespace Iqb\Cabinet;

interface FolderInterface extends EntryInterface
{
    /**
     * Get all entries contained in this folder
     *
     * @return EntryInterface[]
     */
    function getChildren() : array;

    /**
     * Verify this folder is the parent of the supplied child
     *
     * @param EntryInterface $child
     * @return bool
     */
    function isParent(EntryInterface $child) : bool;

    /**
     * Check whether the folder contains a child with the supplied name
     *
     * @param string $name
     * @return bool
     */
    function hasChild(string $name) : bool;

    /**
     * Get a single child identified by the supplied name.
     *
     * @FIXME
     * @param string $name
     * @return EntryInterface
     */
    function getChild(string $name) : EntryInterface;
}
