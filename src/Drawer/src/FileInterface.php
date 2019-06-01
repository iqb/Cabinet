<?php

/*
 * This file is part of Cabinet - file access abstraction library for PHP.
 * (c) by Dennis Birkholz <cabinet@birkholz.org>
 * All rights reserved.
 * For the license to use this library, see the provided LICENSE file.
 */

namespace Iqb\Cabinet\Drawer;

interface FileInterface extends EntryInterface
{
    /**
     * Check whether the file as a stored hash value.
     *
     * @return bool
     */
    function hasHash() : bool;

    /**
     * Get a hash of the file (if stored) or calculate it.
     * The actual hashing method is driver dependent.
     *
     * @return string
     */
    function getHash() : string;
}
