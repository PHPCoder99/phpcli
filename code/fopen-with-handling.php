<?php

$file = fopen(__DIR__ . "/file.txt", "rb");

if ($file === false) {
    echo("File cannot be opened or does not exist.");
} else {
    $contents = "";
    while (!feof($file)) {
        $contents .= fread($file, 100);
    }
    fclose($file);
    echo $contents;
}