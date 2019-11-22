<?php
include __DIR__ . '/shortcode.php';

// Custom method - The shortcode will be replaced by the output of this code
shortcode::add('button', function($args) {
  return '<a href="' . $args->url . '">' . $args->title . '</a>';
});

// HTML content including the shortcode
$html = '<p>[button title="About" url="about"]</p>';

// Filter the HTML to replace the shortcode with the custom method output
echo shortcode::filter($html);