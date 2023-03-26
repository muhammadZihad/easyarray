# EasyArray

This package will allow developers to interact with complex and nested arrays easily. Any array can be converted into an EasyArray object and then access the array items like object properties.

# Installation:

`composer require zihad/easyarray`

# Usage

## Basics

```
use Zihad\Easyarray\EasyArray;

$testArray = [
    'name' => 'Zihad',
    'stack' => 'LAMP'
];
$easyArray = new EasyArray($testArray);

// Access array items
$easyArray->name // 'Zihad'
$easyArray['stack'] // 'LAMP'
$easyArray->language // null

// Check if the value is set
isset($easyArray->name) // true
isset($easyArray['stack']) // true
isset($easyArray['lang']) // false

// Unset value
unset($easyArray['name']);
unset($easyArray->name);
isset($easyArray->name) // false
$easyArray->name // null

// Iterating throught the array
foreach($easyArray as $key => $value) {
    echo "$key -> $value\n";
}
// Output
name -> Zihad
stack -> LAMP

// Working with nested array
$testArray = [
    'name' => 'Zihad',
    'stack' => [
        'lang' => 'PHP',
        'framework' => 'Laravel'
    ]
];
$easyArray = new EasyArray($testArray, true); // secord parameter is a flag to indicate if it is a nested array or not

$easyArray->stack->framework // 'Laravel'
isset($easyArray->stack->lang) // true


$easyArray->toArray()
//Output
[
    'name' => 'Zihad',
    'stack' => [
        'lang' => 'PHP',
        'framework' => 'Laravel'
    ]
]

$easyArray->stack->toArray()
// Output
[
    'lang' => 'PHP',
    'framework' => 'Laravel'
]


// You can also use helper function to create a new instance of EasyArray
$easyArray = easyArray([
    'name' => 'Zihad',
    'stack' => [
        'lang' => 'PHP',
        'framework' => 'Laravel'
    ]
]);
```

## Iterations

```
// You can use EasyArray in foreach and nested foreach loops
$easyArray = easyArray([
    'phones' => [
        'featured' => [
            'used' => [
                'Nokia 3310',
                'Oppo'
            ],
            'fresh' => [
                'Nokia 1110',
                'Huawei 11'
            ]
        ],
        'smartphone' => [
            'used' => [
                'iPhone 11',
                'Samsung s20'
            ],
            'fresh' => [
                'iPhone 13 pro',
                'One plus 9'
            ]
        ]
    ]
], true);

foreach ($easyArray as $category) {
    foreach ($category as $name => $subCategory) {
        foreach ($subCategory as $index => $phones) {
            var_dump(sprintf(
                "%s > %s phones: %s",
                ucfirst($name),
                ucfirst($index),
                implode(', ', $phones->toArray())
            ));
        }
    }
}
```

## Array operations

```
// Count the total number of elements
$easyArray = easyArray([
    'used' => [
        'iPhone 11',
        'Samsung s20'
    ],
    'fresh' => [
        'iPhone 13 pro',
        'One plus 9'
    ]
]);
count($easyArray) // 2
$easyArray->count() // 2


// Array push() method
$easyArray = easyArray([
    'used' => [
        'iPhone 11',
        'Samsung s20'
    ],
    'fresh' => [
        'iPhone 13 pro',
        'One plus 9'
    ]
], true);

$easyArray->used->push('Pixel 5');
$easyArray->used->count() // 3


// Array pop() method
$easyArray = easyArray([
    'used' => [
        'iPhone 11',
        'Samsung s20'
    ]
]);

$easyArray->merge([
    'fresh' => [
        'iPhone 13 pro',
        'One plus 9'
    ]
]);

$easyArray->fresh == null; // false
$easyArray->pop();
$easyArray->fresh == null; // true
```
