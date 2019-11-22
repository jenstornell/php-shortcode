# PHP Shortcode

## Features

- Pure PHP shortcode library without dependencies
- Just a single file
- Very easy to use
- Shortcodes support both single and double quotes

## Summery

The code below is a fully working example.

```php
include __DIR__ . '/shortcode.php';

// Custom method - The shortcode will be replaced by the output of this code
shortcode::add('button', function($args) {
  return sprintf('<a href="%s">%s</a>', $args->url, $args->title);
});

// HTML content including the shortcode
$html = '<p>[button title="About" url="about"]</p>';

// Filter the HTML to replace the shortcode with the custom method output
echo shortcode::filter($html);
```

## Setup

Include the `shortcode.php` file. Just make sure the path is correct.

```php
include __DIR__ . '/shortcode.php';
```

## Shortcode

A shortcode starts with `[` and ends with `]`. The whole shortcode will then be replaced with the output from your custom method.

### Without arguments

```text
[button]
```

### Arguments and double quotes

```text
[button title="It's a button" url="about"]
```

### Arguments and single quotes

```text
[button title='My "button"' url='about']
```

### Arguments and no quotes, only for integers

```text
[button title="About" id=42]
```

## Custom method

With a custom method, you will replace the shortcode with your custom method output.

- `name` - The name of the shortcode [`button` title="button"]
- `method` - The output of the method will replace the shortcode.

### Static

The shortest way is to use a static class.

```php
shortcode::add('button', function($args) {
  return sprintf('<a href="%s">%s</a>', $args->url, $args->title);
});
```

### Instantiated

If you prefer working with an instance of a class, you can use this method instead.

```php
$shortcode = new PHPShortcode();
$shortcode->add('button', function($args) {
  return sprintf('<a href="%s">%s</a>', $args->url, $args->title);
});
```

## Filter html

### Static

The shortest way is to use a static class.

```php
$html = '<p>[button]</p>';
echo shortcode::filter($html);
```

### Instantiated

```php
$html = '<p>[button]</p>';
$shortcode = new PHPShortcode();
$shortcode->filter($html);
```

*If you already have an instance (when created the custom method), you don't need to create a new one.*

## Unset shortcode(s)

When using `shortcode::add()` or `$shortcode->add()`, your custom method will be added to a global variable for later usage.

With `unset()` and `unsetAll()`, you can remove one or remove all of them.

### `unset`

Remove a single custom method from memory by shortcode name.

```php
shortcode::unset('button');
```

or

```php
$shortcode = new PHPShortcode();
$shortcode->unset('button');
```

### `unsetAll`

Remove all custom methods from memory.

```php
shortcode::unsetAll();
```

or

```php
$shortcode = new PHPShortcode();
$shortcode->unsetAll();
```

### A note about quotes

Let's say you are using double quotes in your shortcode. Then if you are also using double quotes in the custom method output, it will break your HTML.

To solve this problem you can convert the quotes to HTML characters.

```php
shortcode::add('button', function($args) {
  $title = htmlspecialchars($args->title, ENT_QUOTES);
  return sprintf('<a href="%s">%s</a>', $args->url, $title);
});
```

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