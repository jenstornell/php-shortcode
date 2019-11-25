<?php
class PHPShortcode {
  // Add
  function add($name, $method) {
    global $shortcodes;
    $shortcodes[$name] = $method;
  }

  // Filter
  function filter($html) {
    $collection = $this->beforeAfterCollection($html);
    return $this->replaceHtml($collection, $html);
  }

  // Replace html
  function replaceHtml($collection, $html) {
    foreach($collection as $item) {
      $html = str_replace($item['before'], $item['after'], $html);
    }

    return $html;
  }

  // Before after collection
  function beforeAfterCollection($html) {
    global $shortcodes;
    $i = 0;

    foreach ($shortcodes as $name => $value) {
      $matches = $this->getShortcodesFromHtml($name, $html);

      $codes = $matches[0];
      $args = $matches[1];

      foreach($codes as $j => $code) {
        $args_array = $this->argsToArray($args[$j]);
        $data = (object)$args_array['data'];
        $types = (object)$args_array['quotes'];

        $collection[$i] = [
          'before' => $code,
          'after' => $shortcodes[$name]($data, $types)
        ];
        $i++;
      }
    }

    return $collection;
  }

  // Get stortcodes from html
  function getShortcodesFromHtml($name, $html) {
    preg_match_all("~\[" . $name . "(.*?)\]~", $html, $matches);
    return $matches;    
  }

  // Args to array
  function argsToArray($incode) {
    $incode = trim($incode);

    $single = '\'([^\']*)\'';
    $double = '"([^"]*)"';
    $literals = '`([^`]*)`';

    preg_match_all('~(?|' . $double . '|' . $single . '|' . $literals . ')~', $incode, $matches);

    if(count($matches[0]) == 0) {
      return [
        'data' => null,
        'quotes' => null
      ];
    }

    $mashed_incode = $this->mashedIncode($incode, $matches);
    $keys = $this->getKeys($mashed_incode);

    foreach($matches[1] as $i => $match) {
      $args['data'][$keys[$i]] = $match;
      $args['quotes'][$keys[$i]] = $this->type($matches[0][$i]);
    }

    return $args;
  }

  // Type
  function type($value) {
    switch(substr($value, 0, 1)) {
      case "'":
        return "'";
        break;
      case '"':
        return '"';
        break;
      case '`':
        return '`';
      default:
        return null;
    }
  }

  // Mashed incode
  function mashedIncode($incode, $matches) {
    foreach($matches[0] as $match) {
      $mashed[] = str_replace(' ', '%s', $match);
    }

    return str_replace($matches[0], $mashed, $incode);
  }

  // Get keys
  function getKeys($mashed_incode) {
    $parts = explode(' ', $mashed_incode);

    foreach($parts as $part) {
      $keys[] = strtok($part, '=');
    }

    return $keys;
  }

  // Unset shortcode
  function unset($name) {
    if(!isset($GLOBALS['shortcodes'][$name])) return;
    unset($GLOBALS['shortcodes'][$name]);
  }

  // Unset shortcode
  function unsetAll() {
    if(!isset($GLOBALS['shortcodes'])) return;
    unset($GLOBALS['shortcodes']);
  }
}

class shortcode {
  public static function add($name, $method) {
    $shortcode = new PHPShortcode();
    $shortcode->add($name, $method);
  }

  public static function filter($html) {
    $shortcode = new PHPShortcode();
    return $shortcode->filter($html);
  }

  public static function unset($name) {
    $shortcode = new PHPShortcode();
    $shortcode->unset($name);
  }

  public static function unsetAll() {
    $shortcode = new PHPShortcode();
    $shortcode->unsetAll();
  }
}