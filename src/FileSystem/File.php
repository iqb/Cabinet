<?php

namespace Iqb\Cabinet\FileSystem;

use Iqb\Cabinet\FileInterface;
use Iqb\Cabinet\FolderInterface;

class File extends Entry implements FileInterface
{
    /** @inheritdoc */
    public function rename(string $newName)
    {

    }


    /** @inheritdoc */
    public function delete() : bool
    {

    }


    /** @inheritdoc */
    public function getSize(): int
    {
        return $this->stat->size;
    }
}
