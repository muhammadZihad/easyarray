<?php

use Zihad\Easyarray\EasyArray;

test('create easy array using helper method', function () {
    $testArray = [];
    $easyArray = easyArray($testArray);
    expect($easyArray instanceof EasyArray)->toBeTrue();
});

test('checks if the easy array is iterable', function () {
    $testArray = ['php', 'laravel', 'frontend' => 'js'];
    $easyArray = easyArray($testArray);
    expect(is_iterable($easyArray))->toBeTrue();
});

test('validates that easy array is not arra', function () {
    $testArray = ['php', 'laravel', 'frontend' => 'js'];
    $easyArray = easyArray($testArray);
    expect(is_array($easyArray))->toBeFalse();
});

test('create easy array using EasyArray class', function () {
    $testArray = [];
    $easyArray = new EasyArray($testArray);
    expect($easyArray instanceof EasyArray)->toBeTrue();
});

test('access array element in object notation', function () {
    $testArray = [
        'name' => 'Zihad',
        'stacks' => [
            'php',
            'laravel'
        ]
    ];
    $easyArray = new EasyArray($testArray);
    expect($easyArray->name)->toBe('Zihad');
});

test('access array element in array notation', function () {
    $testArray = [
        'name' => 'Zihad',
        'stacks' => [
            'php',
            'laravel'
        ]
    ];
    $easyArray = new EasyArray($testArray);
    expect($easyArray['name'])->toBe('Zihad');
});

test('validate array and object isset', function () {
    $testArray = [
        'name' => 'Zihad',
        'stack' => [
            'php',
            'laravel'
        ]
    ];
    $easyArray = new EasyArray($testArray);
    expect(isset($easyArray['name']) && isset($easyArray->stack))->toBeTrue();
});

test('transform nested array into easy array and access the nested item in array notation', function () {
    $testArray = [
        'name' => 'Zihad',
        'stack' => [
            'php',
            'laravel'
        ]
    ];
    $easyArray = new EasyArray($testArray, true);
    expect($easyArray->stack->{'0'})->toBe('php');
});

test('unset() can remove item from easy array', function () {
    $testArray = [
        'name' => 'Zihad',
        'stack' => [
            'lang' => 'php',
            'framework' => 'laravel'
        ]
    ];
    $easyArray = new EasyArray($testArray, true);
    unset($easyArray['name']);
    unset($easyArray->stack);
    expect(!isset($easyArray->name) && !isset($easyArray['stack']))->toBeTrue();
});

test('isset() work on nested array item', function () {
    $testArray = [
        'name' => 'Zihad',
        'stack' => [
            'lang' => 'php',
            'framework' => 'laravel'
        ]
    ];
    $easyArray = new EasyArray($testArray, true);
    expect(isset($easyArray->stack->lang) && !isset($easyArray->stack->backend))->toBeTrue();
});
