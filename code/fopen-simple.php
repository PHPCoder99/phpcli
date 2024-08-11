<?php

$file = fopen(__DIR__ . "/file.txt", "rb");
$data = fread($file, 100);
fclose($file);
echo $data;