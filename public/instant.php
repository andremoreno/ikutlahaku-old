<?php

header('Content-Type: application/rss+xml; charset=utf-8');

$string = file_get_contents("instant.xml");

$string = preg_replace("~<cite>([\s\S]+?)</cite>~", "$1", $string);

print_r($string);

?>