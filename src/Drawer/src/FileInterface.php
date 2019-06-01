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
     * Get the content or a chunk of the file.
     *
     * @param int|null $offset
     * @param int|null $bytes
     * @return string
     */
    function getContent(int $offset = null, int $bytes = null) : string;

    /**
     * Get the content or a chunk of the file as a stream.
     *
     * @param int|null $offset
     * @param int|null $bytes
     * @return resource
     */
    function getContentStream(int $offset = null, int $bytes = null);

    /**
     * Get a hash of the file (if stored) or calculate it.
     * The actual hashing method is driver dependent.
     *
     * @return string
     */
    function getHash() : string;

    /**
     * Check whether the file as a stored hash value.
     *
     * @return bool
     */
    function hasHash() : bool;
}
