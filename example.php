<?php
include __DIR__ . '/shortcode.php';

// Custom method - The shortcode will be replaced by the output of this code
shortcode::add('button', function($args) {
  return sprintf('<a href="%s">%s</a>', $args->url, $args->title);
});

// HTML content including the shortcode
$html = '<p>[button title="About" url="about"]</p>';

// Filter the HTML to replace the shortcode with the custom method output
echo shortcode::filter($html);