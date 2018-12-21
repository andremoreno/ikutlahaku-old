<?php

header('Content-Type: application/rss+xml; charset=utf-8');

$string = file_get_contents("telegram.xml");

$string = preg_replace("~<blockquote>([\s\S]+?)</blockquote>~", "", $string);

print_r($string);

?>