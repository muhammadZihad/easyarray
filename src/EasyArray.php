<?php

/*
* @package EasyArray
* This package helps user to interact with complex array more easily.
* 
* @author Muhammad AR Zihad <zihad.muhammadar@gmail.com>
* @created 21-03-2023
*/

namespace Zihad\Easyarray;

use IteratorAggregate;
use ArrayIterator;
use ArrayAccess;


class EasyArray implements ArrayAccess, IteratorAggregate
{
    /**
     * Stores data in array
     */
    private array $data = [];

    /**
     * Flag to check if it is a nested collection or not
     */
    private bool $hasNested = false;


    /**
     * Constructor of the class
     * @param array $hayStack Default []
     */
    public function __construct(array $hayStack = [], bool $hasNested = false)
    {
        $this->hasNested = $hasNested;
        $this->merge($hayStack);
    }


    /**
     * Merge data with the given array
     * @param array|null $hayStack
     * @return self
     */
    public function merge(array $hayStack = [], bool $hasNested = false): self
    {
        // check if the array is nested flagged
        $this->hasNested = $this->hasNested || $hasNested;
        if ($this->hasNested == true) {
            $hayStack = $this->prepareHaystack($hayStack);
        }
        // merge the new items to the exisitng array
        $this->data = array_merge($this->data, $hayStack);

        return $this;
    }

    /**
     * Prepare nested data to store in EasyArray
     *
     * @param array $hayStack
     * @return array
     */
    protected function prepareHaystack(array $hayStack): array
    {
        $preparedData = [];
        foreach ($hayStack as $index => $value) {
            $preparedData[$index] = $this->processData($value);
        }
        return $preparedData;
    }

    /**
     * Process data depending on if it is array or scaler
     *
     * @param mixed $data
     * @return mixed
     */
    private function processData(mixed $data): mixed
    {
        return is_array($data) ? new static($data, $this->hasNested) : $data;
    }


    /**
     * Set element to the data associated with the key
     * @param string $key Array key
     * @param mixed $value
     * @return void
     */
    public function __set(string $key, $value): void
    {
        $this->data[$key] = $value;
    }


    /**
     * Get element from the data by key
     * @param string $key Array key
     * @return mixed|self
     */
    public function __get(string $key): mixed
    {
        if (!array_key_exists($key, $this->data)) {
            return null;
        }
        return $this->data[$key];
    }

    /**
     * Prepare data to return
     * @param mixed $data
     * @return mixed
     */
    protected function prepareData(mixed $data): mixed
    {
        return $data instanceof EasyArray ? $data->toArray() : $data;
    }


    /**
     * Check if a key is available in the data
     * @param string $name key of the element
     * @return bool
     */
    public function __isset(string $name): bool
    {
        return isset($this->data[$name]);
    }


    /**
     * Unset element form array
     * @param string $name key of the element
     * @return void
     */
    public function __unset(string $name): void
    {
        if (isset($this->data[$name])) {
            unset($this->data[$name]);
        }
    }


    /**
     * Set element to the data associated with the key
     * @param string $key Array key
     * @param string $value Array value
     * @return void
     */
    public function offsetSet($key, $value): void
    {
        $this->__set($key, $value);
    }


    /**
     * Check if a key is available in the data
     * @param string $name key of the element
     * @return bool
     */
    public function offsetExists($name): bool
    {
        return $this->__isset($name);
    }


    /**
     * Unset element from data array
     * @param string $name key of the element
     * @return void
     */
    public function offsetUnset($name): void
    {
        $this->__unset($name);
    }


    /**
     * Get element from the data by key
     * @param string $key Array key
     * @return mixed|self
     */
    public function offsetGet($key): mixed
    {
        return $this->__get($key);
    }


    /**
     * Make the object iterable
     * @return array
     */
    public function toArray(): array
    {
        $preparedData = [];
        foreach ($this->data as $index => $value) {
            $preparedData[$index] = $this->prepareData($value);
        }
        return $preparedData;
    }


    /**
     * Let the data iterate through iterator functions
     * @return ArrayIterator
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->data);
    }

    /**
     * Push new values to the array
     *
     * @param array ...$values
     * @return int
     */
    public function push(...$values): int
    {
        return array_push($this->data, ...$values);
    }

    /**
     * Pop the last item of the array
     *
     * @return mixed
     */
    public function pop(): mixed
    {
        return array_pop($this->data);
    }
}
