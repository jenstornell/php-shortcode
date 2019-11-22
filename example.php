<?php
include __DIR__ . '/shortcode.php';
$content = file_get_contents(__DIR__ . '/content.html');
#echo $content;

$shortcode = new PHPShortcode();
$shortcode->add('button', function($args) {
  return addslashes(sprintf('<a href="%s">%s</a>', $args->title, $args->url));
});

$shortcode = new PHPShortcode();

$shortcode->add('block', function($args) {
  $args->content = (isset($args->content)) ? $args->content : '';
  $title = isset($args->title) ? $args->title : '';
  return sprintf('<div class="block">%s - %s</div>', $title, $args->content);
});

$shortcode = new PHPShortcode();

$shortcode->filter($content);

/*
    foreach($parts as $key => $part) {
      $group = explode('=', $part);
      $key = $group[0];
      $value = $group[1];

      $first = substr($value, 0, 1);
      $last = substr($value, -1);
      
      if(in_array('"', [$first, $last])) {
        $value = trim($group[1], '"');
      } elseif(in_array("'", [$first, $last])) {
        $value = trim($group[1], "'");
      }
*/

shortcode::add('button', function($args) {
  $title = htmlspecialchars($args->title, ENT_QUOTES);
  return sprintf('<a href="%s">%s</a>', $args->url, $title);
});

#echo shortcode::unset('button');

echo shortcode::filter($content);

