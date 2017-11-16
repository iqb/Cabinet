<?php


namespace Iqb\Cabinet\FileSystem;


use Iqb\Cabinet\EntryInterface;
use Iqb\Cabinet\FolderInterface;

class Folder extends Entry implements FolderInterface
{
    /**
     * @var EntryInterface[]
     */
    private $children;


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
        $size = 0;
        foreach ($this->getChildren() as $child) {
            $size += $child->getSize();
        }
        return $size;
    }


    /** @inheritdoc */
    public function getChildren(): array
    {
        if (!\is_array($this->children)) {
            $this->children = [];
            $basedir = $this->getPath();

            foreach (\array_diff(\scandir($basedir), ['.', '..']) as $dirEntry) {
                $stat = new Stat($basedir . \DIRECTORY_SEPARATOR . $dirEntry);

                if ($stat->isRegularFile) {
                    $this->children[$dirEntry] = $file = $this->driver->fileFactory($dirEntry, $this, $stat);
                }

                elseif ($stat->isDirectory) {
                    $this->children[$dirEntry] = $folder = $this->driver->folderFactory($dirEntry, $this, $stat);
                }

                // Handle special case
            }

            $this->driver->notifyFolderScanned($this);
        }

        return $this->children;
    }


    /** @inheritdoc */
    public function hasChild(string $name): bool
    {
        return \array_key_exists($name, $this->getChildren());
    }


    /** @inheritdoc */
    public function getChild(string $name): EntryInterface
    {
        // Initialize children
        $children = $this->getChildren();

        if (!\array_key_exists($name, $children)) {
            throw new \InvalidArgumentException("No entry '$name' exists in directory '" . $this->getPath() . "'");
        }

        return $children[$name];
    }


    /** @inheritdoc */
    public function isParent(EntryInterface $child): bool
    {
        return \in_array($child, $this->getChildren(), true);
    }
}
