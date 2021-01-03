<?php

namespace App\Repositories;

class BaseRepository
{
    protected $instance;

    protected function __construct(object $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Get all records
     *
     * @return object
     */
    public function all(): object
    {
        return $this->instance->all();
    }

    /**
     * Find by id
     *
     * @param int $id
     * @return object
     */
    public function find(int $id): object
    {
        return $this->instance->find($id);
    }

    /**
     * Find a by column name
     *
     * @param string $column Column to be searched
     * @param mixed $value Searched value
     *
     * @return object
     */
    public function findByColumnName(string $column, $value): object
    {
        return $this->instance->where($column, $value)->get();
    }

    /**
     * Insert the data
     *
     * @param array $attributes
     * @return bool
     */
    public function insert(array $attributes): bool
    {
        return $this->instance->insert($attributes);
    }

    /**
     * @param int $id
     * @param array $attributes
     * @return bool
     */
    public function update(int $id, array $attributes): bool
    {
        return $this->instance->find($id)->update($attributes);
    }
}
