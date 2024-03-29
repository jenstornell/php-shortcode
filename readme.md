# PHP Shortcode

*Version 1.0*

## Features

- Just a single file
- No dependencies
- Very easy to use
- Shortcodes supports single, double and literal quotes

## Summary

The code below is a fully working example.

```php
include __DIR__ . '/shortcode.php';

shortcode::add('button', function($args) {
  return '<a href="' . $args->url . '">' . $args->title . '</a>';
});

echo shortcode::filter('<p>[button title="About" url="about"]</p>');
```

## Setup

Include the `shortcode.php` file. Just make sure the path is correct.

```php
include __DIR__ . '/shortcode.php';
```

## HTML

A shortcode starts with `[` and ends with `]`. The whole shortcode will then be replaced with the output from your custom method.

### Without arguments

```text
[button]
```

### Arguments and double quotes

Single quotes can be used inside the double quotes.

```text
[button title="It's a button" url="about"]
```

### Arguments and single quotes

Double quotes can be used inside single quotes.

```text
[button title='My "button"' url='about']
```

### Arguments and template literals

Both single and double quotes can be used inside template literals.

```text
[button title=`It's my "button"` url='about']
```

<!--

### Arguments and no quotes, only for integers

```text
[button title="About" id=42]
```

-->

## Custom method

With a custom method, you will replace the shortcode with your custom method output.

- `name` - The name of the shortcode [`button` title="button"]
- `method` - The output of the method will replace the shortcode.
- `args` (optional) - Arguments sent from the shortcode.
- `types` (optional) - The type of quotes that was used for each argument.

### Without arguments

```php
shortcode::add('button', function() {
  return 'Hello!';
});
```

### With arguments

```php
shortcode::add('button', function($args) {
  return '<a href="' . $args->url . '">' . $args->title . '</a>';
});
```

### With types

Your shortcode quotes may vary from time to time.

- `[quote content='"I am a quote"']`
- `[quote content="'I am a quote'"]`

If you are not always using the same type of quotes, you may need to use the second optional parameter `$quotes`.

```php
shortcode::add('quote', function($args, $quotes) {
  return sprintf('
    <div data-content=%s%s%s></div>',
    $quotes->content,
    $args->content,
    $quotes->content,
  );
});
```

## Filter html

All shortcodes will be replaced with the output from your custom method.

```php
$html = '<p>[button]</p>';
echo shortcode::filter($html);
```

## Unset shortcode(s)

When using `shortcode::add()` or `$shortcode->add()`, your custom method will be added to a global variable for later usage.

With `unset()` and `unsetAll()`, you can remove one or remove all of them.

### `unset`

Remove a single custom method from memory by shortcode name.

```php
shortcode::unset('button');
```

### `unsetAll`

Remove all custom methods from memory.

```php
shortcode::unsetAll();
```

### Alternative usage - Instantiated method

With all methods you can use an instantiated class instead if you prefer that approach.

```php
$shortcode = new PHPShortcode();
echo $shortcode->filter('[button]');
```

### A note about quotes

To prevent breaking HTML, it can sometimes be good to convert quotes to html characters.

```php
$some_argument = htmlspecialchars($args->some_argument, ENT_QUOTES);
```

## Todo

- Support for usage without quotes, mainly for integers.

## Limitations

- You can't place content within a start and closing shortcode like `[hello]world[/hello]`... yet.
- You can't use line breaks inside shortcodes. However, it's fine to print out line breaks from the custom shortcode methods.

## Bug report

Can you break it? If you break it in an unexpected way, please report it as a bug to us. Provide a code example.

## Inspiration

- [WordPress Shortcode API](https://codex.wordpress.org/Shortcode_API)
- [Thunderer Shortcode](https://github.com/thunderer/Shortcode)

## License

MIT