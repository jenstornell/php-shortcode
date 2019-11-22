<?php
include __DIR__ . '/../shortcode.php';

$html = file_get_contents(__DIR__ . '/content/content.html');

shortcode::add('button', function($args, $quotes) {
  if(!isset($args->title)) return 'No title here!';

  $quote_url = isset($quotes->url) ? $quotes->url : '';
  $args->url = isset($args->url) ? $args->url : '';
  $args->title = isset($args->title) ? $args->title : '';

  return sprintf('
    <a href=%s%s%s>%s</a>',
    $quote_url,
    $args->url,
    $quote_url,
    $args->title
  );
});

echo shortcode::filter($html);

echo "\n\n<h2>RESET</h2>\n\n";

shortcode::unsetAll();

shortcode::add('button', function() {
  return 'hello';
});

echo shortcode::filter($html);