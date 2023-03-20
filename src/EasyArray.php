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
        // merge the new items to the exisitng array
        $this->data = array_merge($this->data, $hayStack);

        return $this;
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
     * @return mixed
     */
    public function __get(string $key): mixed
    {
        if (!array_key_exists($key, $this->data)) {
            return null;
        }
        return $this->prepareData($key);
    }

    /**
     * Prepare data to return
     * @param string $key
     * @return self|mixed
     */
    public function prepareData(string $key): mixed
    {
        if (is_array($this->data[$key]) && $this->hasNested == true) {
            return new static($this->data[$key], true);
        }
        return $this->data[$key];
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
     * @return mixed
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
        return $this->data;
    }


    /**
     * Let the data iterate through iterator functions
     * @return ArrayIterator
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->data);
    }
}
