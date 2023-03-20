<?php

use Zihad\Easyarray\EasyArray;

if (!function_exists('easyArray')) {
    /**
     * Provides a new easy array instance 
     *
     * @param array $hayStack
     * @param boolean $hasNested
     * @return EasyArray
     */
    function easyArray(array $hayStack = [], bool $hasNested = false): EasyArray
    {
        return new EasyArray($hayStack, $hasNested);
    }
}
