<?php

$path         =    __DIR__;
$directory    =    new \RecursiveDirectoryIterator($path);
$iterator     =    new \RecursiveIteratorIterator($directory);
$files        =    array();

foreach ($iterator as $info) {
    if (substr($info->__toString(), -4) == '.php') {
        require_once($info->getPathname());
    }
}
