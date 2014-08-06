<?php


namespace Estimate\Persistence\Implementation;

use \Estimate\Persistence\HandlerInterface as PersistenceHandler;
use \Estimate\Persistence\PersistentObject;
use SebastianBergmann\Exporter\Exception;

class Json implements PersistenceHandler
{

    const DEFAULT_FILE = 'data.json';

    protected $path;
    protected $defaultFilePath;

    /**
     * @param $savePath
     *
     * @throws \Exception
     */
    public function __construct($savePath)
    {
        if (true !== is_writable($savePath))
        {
            throw new \Exception(sprintf('Given path %s is not writable', $savePath));
        }
        $this->path            = $savePath;
        $this->defaultFilePath = $this->path . '/' . static::DEFAULT_FILE;
        if (!file_exists($this->defaultFilePath))
        {
            $fd = fopen($this->defaultFilePath, 'w');
            fclose($fd);
        }
    }


    /**
     * Saves an object and return its id when successful -1 on failure
     *
     * @param \Estimate\Persistence\PersistentObject $object
     *
     * @return int
     */
    public function put(PersistentObject $object)
    {
        $fd = fopen($this->defaultFilePath, 'a');
        fwrite($fd, json_encode($object->getPersistentVersion()));
        fclose($fd);
    }

    /**
     * Fetches a persistent object, return null if not found
     *
     * @param string $id
     *
     * @return \Estimate\Persistence\PersistentObject|null
     */
    public function get($id)
    {
        $content = json_encode(file_get_contents($this->defaultFilePath));
        return $content;
    }


} 