# Laravel Model Validation

With this package you can get stop writting the repetitive validation snippets once and for all.

## Installation

Update your `composer.json` file to require the `gerardog8\evident` package

```js
{
    "require": {
        "laravel/framework": "4.0.*",
        "gerardog8/evident": "dev-master"
    }
}
```

## Setting it up

When creating a new model, extend `\GerardoG8\Evident\Model` class instead of `Eloquent`:

```php
<?php

class Foo extends \GerardoG8\Evident\Model {
```

Next, declare some rules by owerwritting the `$rules` static variable:

```php
    protected $rules = array(
        'bar' => 'required'
    );
```

You may also set custom messages by owerwritting the `$messages` static variable:

```php
    protected $messages = array(
        'bar.required' => 'Don\'t forget to set a value for bar'
    );
```

## Validating your models

Just set the attributes of your models, and let Evident do the rest

```php
    $foo = new Foo;
    $foo->bar = 'value';
    $foo->save();

    if ($foo->hasErrors()) {
        // There where errors
    }
    else {
        // Model was saved
    }
```

You may also save while creating or on mass assignment

```php
    $foo = new Foo(array('bar' => 'value'));
    $foo->save();

    if ($foo->hasErrors()) {
        // There where errors
    }
    else {
        // Model was saved
    }
```

Or

```php
    $foo = new Foo::create(array('bar' => 'value'));

    if ($foo->hasErrors()) {
        // There where errors
    }
    else {
        // Model was saved
    }
```

## Disable auto validation

If you wouldn't like to run validation on save, simply overwrite the `$auto_validate` static variable and set its value to anything that evaluates to `false`. This is useful for models that have mutators or models that use `_confirmation` rules.

```php
    protected static $auto_validate = false;
```

Flow would change to this:

```php
    $foo = new Foo(array('bar' => 'value'));

    if ($foo->validate()) {
        $foo->save();
    }
    else {
        $errors = $foo->hasErrors();
    }
```