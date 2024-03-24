<?php

namespace Hankz\LaravelPlus\Services;

abstract class BaseService
{
    /**
     * @var \Hankz\LaravelPlus\Repositories\BaseRepository
     */
    protected $repository;

    public function __call($method, $arguments)
    {
        if (method_exists($this->repository, $method)) {
            return call_user_func_array([$this->repository, $method], $arguments);
        }
    }
}
