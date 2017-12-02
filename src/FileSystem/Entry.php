<?php

namespace Iqb\Cabinet\FileSystem;

use Iqb\Cabinet\EntryInterface;
use Iqb\Cabinet\FolderInterface;

abstract class Entry implements EntryInterface
{
    /**
     * Full path of the directory this file belongs to
     * @var
     */
    private $path;

    /**
     * Name of the file inside the directory
     * @var string
     */
    private $name;

    /**
     * Folder object of the folder containing the file
     * @var FolderInterface
     */
    private $parent;

    /** @var Driver */
    protected $driver;

    /** @var Stat */
    protected $stat;


    public function __construct(Driver $driver, string $name, FolderInterface $parent = null, Stat $stat = null)
    {
        $this->driver = $driver;
        $this->stat = $stat;

        if ($name === '/') {
            $this->path = '';
            $this->name = '';
        }

        elseif (\strpos($name, \DIRECTORY_SEPARATOR) !== false) {
            if ($parent !== null) {
                throw new \InvalidArgumentException("Can not use a qualified file name and provide a parent!");
            }

            $this->name = \basename($name);
            $dir = \dirname($name);

            $oldAutoScanFolders = $this->driver->setAutoScanFolders(false);
            $this->parent = $this->driver->folderFactory($dir);
            $this->driver->setAutoScanFolders($oldAutoScanFolders);
        }

        else {
            $this->name = $name;
            $this->parent = $parent;
        }
    }


    /** @inheritdoc */
    public function getPath(): string
    {
        if ($this->path === null) {
            $this->path = $this->getParent()->getPath();
        }

        return $this->path . \DIRECTORY_SEPARATOR . $this->name;
    }


    /** @inheritdoc */
    final public function getName(): string
    {
        return $this->name;
    }


    /**
     * Change the name of the Entry
     *
     * @param string $newName
     */
    final protected function setName(string $newName)
    {
        $this->name = $newName;
    }


    /** @inheritdoc */
    final public function hasParents(): bool
    {
        return ($this->parent !== null);
    }


    /** @inheritdoc */
    final public function getParent(): FolderInterface
    {
        return $this->parent;
    }


    /** @inheritdoc */
    final public function getParents(): array
    {
        return [ $this->parent ];
    }


    /**
     * Change the parent of the Entry
     *
     * @param FolderInterface $newParent
     */
    final protected function setParent(FolderInterface $newParent)
    {
        $this->parent = $newParent;
    }


    /**
     * Get stat info about the Entry
     *
     * @return Stat
     */
    final public function getStat() : Stat
    {
        if (!$this->stat) {
            $this->stat = new Stat($this->getPath());
        }

        return $this->stat;
    }


    /**
     * @param Stat $stat
     */
    final protected function setStat(Stat $stat)
    {
        $this->stat = $stat;
    }


    final public function rename(string $newName)
    {
        // TODO: Implement rename() method.
    }


    final public function move(FolderInterface $newParent, string $newName = null)
    {
        // TODO: Implement move() method.
    }
}
