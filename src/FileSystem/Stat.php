<?php

namespace Iqb\Cabinet\FileSystem;

// from man stat(2):

/** bit mask for the file type bit field */
const S_IFMT =   0170000;
/** socket */
const S_IFSOCK = 0140000;
/** symbolic link */
const S_IFLNK =  0120000;
/** regular file */
const S_IFREG =  0100000;
/** block device */
const S_IFBLK =  0060000;
/** directory */
const S_IFDIR =  0040000;
/** character device */
const S_IFCHR =  0020000;
/** FIFO */
const S_IFIFO =  0010000;

/** set-user-ID bit */
const S_ISUID =   04000;
/** set-group-ID bit */
const S_ISGID =   02000;
/** sticky bit */
const S_ISVTX =   01000;
/** owner has read, write, and execute permission */
const S_IRWXU =   00700;
/** owner has read permission */
const S_IRUSR =   00400;
/** owner has write permission */
const S_IWUSR =   00200;
/** owner has execute permission */
const S_IXUSR =   00100;
/** group has read, write, and execute permission */
const S_IRWXG =   00070;
/** group has read permission */
const S_IRGRP =   00040;
/** group has write permission */
const S_IWGRP =   00020;
/** group has execute permission */
const S_IXGRP =   00010;
/** others (not in group) have read, write, and execute permission */
const S_IRWXO =   00007;
/** others have read permission */
const S_IROTH =   00004;
/** others have write permission */
const S_IWOTH =   00002;
/** others have execute permission */
const S_IXOTH =   00001;

final class Stat
{
    /** @var int */
    public $deviceNumber;

    /** @var int */
    public $inodeNumber;

    /** @var int */
    public $mode;

    /** @var int */
    public $numberOfLinks;

    /** @var int */
    public $userId;

    /** @var int */
    public $groupId;

    /** @var int */
    public $deviceType;

    /** @var int */
    public $size;

    /** @var int */
    public $accessTime;

    /** @var int */
    public $modificationTime;

    /** @var int */
    public $inodeChangeTime;

    /** @var int */
    public $blockSize;

    /** @var int */
    public $blocks;

    /** @var bool */
    public $isDirectory;

    /** @var bool */
    public $isRegularFile;

    /** @var bool */
    public $isSocket;

    /** @var bool */
    public $isSymlink;

    /** @var bool */
    public $isBlockDevice;

    /** @var bool */
    public $isCharacterDevice;

    /** @var bool */
    public $isFifo;

    /** @var bool */
    public $ownerCanRead;

    /** @var bool */
    public $ownerCanWrite;

    /** @var bool */
    public $ownerCanExecute;

    /** @var bool */
    public $groupCanRead;

    /** @var bool */
    public $groupCanWrite;

    /** @var bool */
    public $groupCanExecute;

    /** @var bool */
    public $otherCanRead;

    /** @var bool */
    public $otherCanWrite;

    /** @var bool */
    public $otherCanExecute;

    /** @var bool */
    public $setUserId;

    /** @var bool */
    public $setGroupId;

    /** @var bool */
    public $sticky;


    public function __construct(string $filename)
    {
        if (!$stat = \lstat($filename)) {
            throw new \InvalidArgumentException("Can not stat file '$filename'");
        }

        list(
            $this->deviceNumber,
            $this->inodeNumber,
            $this->mode,
            $this->numberOfLinks,
            $this->userId,
            $this->groupId,
            $this->deviceType,
            $this->size,
            $this->accessTime,
            $this->modificationTime,
            $this->inodeChangeTime,
            $this->blockSize,
            $this->blocks
        ) = $stat;

        $type = ($this->mode & S_IFMT);
        $this->isDirectory = ($type === S_IFDIR);
        $this->isRegularFile = ($type === S_IFREG);
        $this->isSocket = ($type === S_IFSOCK);
        $this->isSymlink = ($type === S_IFLNK);
        $this->isBlockDevice = ($type === S_IFBLK);
        $this->isCharacterDevice = ($type === S_IFCHR);
        $this->isFifo = ($type === S_IFIFO);

        $this->ownerCanRead    = ($this->mode & S_IRUSR !== 0);
        $this->ownerCanWrite   = ($this->mode & S_IWUSR !== 0);
        $this->ownerCanExecute = ($this->mode & S_IXUSR !== 0);
        $this->groupCanRead    = ($this->mode & S_IRGRP !== 0);
        $this->groupCanWrite   = ($this->mode & S_IWGRP !== 0);
        $this->groupCanExecute = ($this->mode & S_IXGRP !== 0);
        $this->otherCanRead    = ($this->mode & S_IROTH !== 0);
        $this->otherCanWrite   = ($this->mode & S_IWOTH !== 0);
        $this->otherCanExecute = ($this->mode & S_IXOTH !== 0);
        $this->setUserId       = ($this->mode & S_ISUID !== 0);
        $this->setGroupId      = ($this->mode & S_ISGID !== 0);
        $this->sticky          = ($this->mode & S_ISVTX !== 0);
    }
}