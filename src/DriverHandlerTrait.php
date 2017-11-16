<?php

namespace Iqb\Cabinet;

trait DriverHandlerTrait
{
    /**
     * @var callable[]
     * @see DriverInterface::setFileLoadedHandler()
     */
    private $fileLoadedHandlers = [];

    /**
     * @var callable[]
     * @see DriverInterface::setFolderLoadedHandler()
     */
    private $folderLoadedHandlers = [];

    /**
     * @var callable[]
     * @see DriverInterface::setFolderScannedHandler()
     */
    private $folderScannedHandlers = [];


    /** @see DriverInterface::notifyFileLoaded() */
    final public function notifyFileLoaded(FileInterface $file)
    {
        foreach ($this->fileLoadedHandlers as $name => $handler) {
            $handler($file, $this, $name);
        }
    }


    /** @see DriverInterface::registerFileLoadedHandler() */
    final public function registerFileLoadedHandler(callable $fileLoadedHandler, string $name = null) : string
    {
        $name || $name = \bin2hex(\random_bytes(8));

        if (\array_key_exists($name, $this->fileLoadedHandlers)) {
            throw new \InvalidArgumentException("Duplicate handler name '$name'");
        }

        $this->fileLoadedHandlers[$name] = $fileLoadedHandler;
        return $name;
    }


    /** @see DriverInterface::unregisterFileLoadedHandler() */
    final public function unregisterFileLoadedHandler(string $name)
    {
        if (!\array_key_exists($name, $this->fileLoadedHandlers)) {
            throw new \InvalidArgumentException("Handler with name '$name' not found!");
        }
        unset($this->fileLoadedHandlers[$name]);
    }


    /** @see DriverInterface::notifyFileLoaded() */
    final public function notifyFolderLoaded(FolderInterface $folder)
    {
        foreach ($this->folderLoadedHandlers as $name => $handler) {
            $handler($folder, $this, $name);
        }
    }


    /** @see DriverInterface::registerFolderLoadedHandler() */
    final public function registerFolderLoadedHandler(callable $folderLoadedHandler, string $name = null) : string
    {
        $name || $name = \bin2hex(\random_bytes(8));

        if (\array_key_exists($name, $this->folderLoadedHandlers)) {
            throw new \InvalidArgumentException("Duplicate handler name '$name'");
        }

        $this->folderLoadedHandlers[$name] = $folderLoadedHandler;
        return $name;
    }


    /** @see DriverInterface::unregisterFolderLoadedHandler() */
    final public function unregisterFolderLoadedHandler(string $name)
    {
        if (!\array_key_exists($name, $this->folderLoadedHandlers)) {
            throw new \InvalidArgumentException("Handler with name '$name' not found!");
        }
        unset($this->folderLoadedHandlers[$name]);
    }


    /** @see DriverInterface::notifyFolderScanned() */
    final public function notifyFolderScanned(FolderInterface $folder)
    {
        foreach ($this->folderScannedHandlers as $name => $handler) {
            $handler($folder, $this, $name);
        }
    }


    /** @see DriverInterface::registerFolderScannedHandler() */
    final public function registerFolderScannedHandler(callable $folderScannedHandler, string $name = null) : string
    {
        $name || $name = \bin2hex(\random_bytes(8));

        if (\array_key_exists($name, $this->folderScannedHandlers)) {
            throw new \InvalidArgumentException("Duplicate handler name '$name'");
        }

        $this->folderScannedHandlers[$name] = $folderScannedHandler;
        return $name;
    }


    /** @see DriverInterface::unregisterFolderScannedHandler() */
    final public function unregisterFolderScannedHandler(string $name)
    {
        if (!\array_key_exists($name, $this->folderScannedHandlers)) {
            throw new \InvalidArgumentException("Handler with name '$name' not found!");
        }
        unset($this->folderScannedHandlers[$name]);
    }
}