<?php


namespace Estimate\Persistence;

interface HandlerInterface
{

    /**
     * Saves an object and return its id when successful -1 on failure
     *
     * @param \Estimate\Persistence\PersistentObject $object
     *
     * @return int
     */
    public function put(PersistentObject $object);

    /**
     * Fetches a persistent object, return null if not found
     *
     * @param string $id
     *
     * @return \Estimate\Persistence\PersistentObject|null
     */
    public function get($id);

} 