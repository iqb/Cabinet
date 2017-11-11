<?php

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
     * Get a single child identified by the supplied name.
     *
     * @FIXME
     * @param string $name
     * @return EntryInterface
     */
    function getChild(string $name) : EntryInterface;
}
