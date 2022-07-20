<?php

namespace App\Providers;

use App\Exceptions\MissingConfigException;
use League\Flysystem\Filesystem;
use League\Flysystem\FileAttributes;
use League\Flysystem\DirectoryAttributes;
use League\Flysystem\Local\LocalFilesystemAdapter;
use League\Flysystem\UnableToWriteFile;
use League\Flysystem\UnixVisibility\PortableVisibilityConverter;
use League\Flysystem\Visibility;

class Storage
{
    private $configs = [];

    private $default = 'local';

    public function __construct(string $default = 'local', array $configs = [])
    {
        $this->configs = !empty($configs) ? $configs : config('storage.filesystems');
        $this->default = $default;

        if ($this->configs == null || count($this->configs) == 0) {
            throw new MissingConfigException('Missing storage "filesystems" config.');
        }
    }

    /**
     * @throws MissingConfigException
     */
    public function disk(string $disk = null)
    {
        $disk = $disk ?? $this->default;

        switch ($disk) {
            case 'local':
                return $this->localAdapter();
                break;
            default:
                return $this->localAdapter();
                break;
        }
    }

    /**
     * Write a file from a string or a resource
     *
     * @param string $path
     * @param resource|string $contents
     * @param string $visibility `public` or `private`
     * @throws UnableToWriteFile
     * @throws FilesystemException
     * @throws MissingConfigException If method visibility param not set and config storage visibility is missing
     */
    public function write(string $path, $contents, string $visibility = null)
    {
        $config = $this->configs[$this->default];

        if ($visibility === null) {
            if (!isset($config['visibility'])) {
                throw new MissingConfigException('Missing storage "visibility" config.');
            }

            $visibility = $config['visibility'];
        }

        $config = ['visibility' => $visibility];
        $disk = $this->disk();

        if (gettype($contents) == 'string') {
            $disk->write($path, $contents, $config);
        } else if (gettype($contents) == 'resource') {
            $disk->writeStream($path, $contents, $config);
        }
    }

    /**
     * Read file contents
     *
     * @throws UnableToReadFile
     * @throws FilesystemException
     */
    public function read(string $path)
    {
        return $this->disk()->read($path);
    }

    /**
     * Read a file as a stream
     *
     * @throws UnableToReadFile
     * @throws FilesystemException
     */
    public function stream(string $path)
    {
        return $this->disk()->readStream($path);
    }

    /**
     * @throws UnableToDeleteFile
     * @throws FilesystemException
     */
    public function delete(string $path)
    {
        $this->disk()->delete($path);
    }

    /**
     * @throws UnableToCheckFileExistence
     * @throws FilesystemException
     */
    public function exists(string $path)
    {
        return $this->disk()->fileExists($path);
    }

    /**
     * @throws UnableToRetrieveMetadata
     * @throws FilesystemException
     */
    public function size(string $path)
    {
        return $this->disk()->fileSize($path);
    }

    /**
     * @throws MissingConfigException If config storage url is missing
     */
    public function fullPath(string $path)
    {
        $config = $this->configs[$this->default];

        if (!isset($config['root'])) {
            throw new MissingConfigException('Missing storage "root" config.');
        }

        return $config['root'] . '/' . $path;
    }

    /**
     * Get file url
     *
     * @throws MissingConfigException If config storage url is missing
     */
    public function url(string $path)
    {
        $config = $this->configs[$this->default];

        if (!isset($config['url'])) {
            throw new MissingConfigException('Missing storage "url" config.');
        }

        return $config['url'] . "/" . $path;
    }

    /**
     * @throws UnableToCopyFile
     * @throws FilesystemException
     */
    public function copy(string $source, string $destination)
    {
        $this->disk()->copy($source, $destination);
    }

    /**
     * @throws UnableToMoveFile
     * @throws FilesystemException
     */
    public function move(string $source, string $destination)
    {
        $this->disk()->move($source, $destination);
    }

    /**
     * @throws UnableToRetrieveMetadata
     * @throws FilesystemException
     */
    public function lastModified(string $path)
    {
        return $this->disk()->lastModified($path);
    }

    /**
     * @throws UnableToCreateDirectory
     * @throws FilesystemException
     */
    public function createDirectory(string $location)
    {
        return $this->disk()->createDirectory($location);
    }

    /**
     * @throws UnableToDeleteDirectory
     * @throws FilesystemException
     */
    public function deleteDirectory(string $location)
    {
        $this->disk()->deleteDirectory($location);
    }

    /**
     * @throws UnableToCheckExistence
     * @throws FilesystemException
     */
    public function has(string $path)
    {
        return $this->disk()->has($path);
    }

    /**
     * @throws UnableToCheckExistence
     * @throws FilesystemException
     */
    public function directoryExists(string $path)
    {
        return $this->disk()->directoryExists($path);
    }

    /**
     * Get All Files Within A Directory
     *
     * @throws FilesystemException
     * @return FileAttributes[]
     */
    public function files(string $location, bool $recursive = false)
    {
        $listing = $this->disk()->listContents($location, $recursive);
        $items = [];

        foreach ($listing as $item) {
            if ($item instanceof FileAttributes) {
                $items[] = $item;
            }
        }
    }

    /**
     * Get All Directories Within A Directory
     *
     * @throws FilesystemException
     * @return DirectoryAttributes[]
     */
    public function directories(string $location, bool $recursive = false)
    {
        $listing = $this->disk()->listContents($location, $recursive);
        $items = [];

        foreach ($listing as $item) {
            if ($item instanceof DirectoryAttributes) {
                $items[] = $item;
            }
        }
    }

    /**
     * @throws FilesystemException
     */
    public function all(string $location, bool $recursive = false)
    {
        $this->disk()->listContents($location, $recursive);
    }

    /**
     * Set or Get visibility of a file
     *
     * @throws UnableToSetVisibility
     * @throws UnableToRetrieveMetadata
     * @throws FilesystemException
     */
    public function visibility(string $path, string $visibility = null)
    {
        if ($visibility != null) {
            $this->disk()->setVisibility($path, $visibility);
        }

        return $this->disk()->visibility($path);
    }

    /**
     * @throws MissingConfigException
     */
    private function localAdapter(): Filesystem
    {
        if (!isset($this->configs['local'])) {
            throw new MissingConfigException('Missing storage "local" config.');
        }

        $local = $this->configs['local'];

        if (!isset($local['root']) || !isset($local['visibility'])) {
            throw new MissingConfigException('Missing storage "local.root" and "local.visibility" config.');
        }

        $permissions = [
            'file' => [
                'public' => 0644,
                'private' => 0604,
            ],
            'dir' => [
                'public' => 0755,
                'private' => 7604,
            ],
        ];

        if ($local['visibility'] == 'public') {
            $visibility = PortableVisibilityConverter::fromArray($permissions, Visibility::PUBLIC);
        } else if ($local['visibility'] == 'private') {
            $visibility = PortableVisibilityConverter::fromArray($permissions, Visibility::PRIVATE);
        } else {
            throw new MissingConfigException('Invalid storage "local.visibility" config.');
        }

        $adapter = new LocalFilesystemAdapter($local['root'], $visibility);

        return new Filesystem($adapter);
    }

    private static function awsS3Adapter()
    {
        // TODO: Implement awsS3() method.
    }

    private static function cloudStorageAdapter()
    {
        // TODO: Implement cloudStorage() method.
    }
}
