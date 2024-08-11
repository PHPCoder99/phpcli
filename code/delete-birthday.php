<?php 

$address = '/code/birthdays.txt';

$input = readline("Введите имя или дату (ДД-ММ-ГГГГ) для удаления: ");

if (!file_exists($address)) {
    echo "Файл $address не найден.\n";
    exit();
}

$fileHandler = fopen($address, 'r');

$contents = "";
while (!feof($fileHandler)) {
    $contents .= fread($fileHandler, 100);
}
fclose($fileHandler);

$fileHandler = fopen($address, 'w');

$found = false;

$contents = explode("\r\n", $contents);

foreach ($contents as $line) {
    $parts = explode(", ", $line);

    if (count($parts) != 2) {
        continue;
    }

    $name = $parts[0];
    $date = $parts[1];

    if ($name === $input || $date === $input) {
        $found = true;
        echo "Строка с \"$line\" удалена.\n";
    } else {
        fwrite($fileHandler, $line . "\r\n");
    }
}

fclose($fileHandler);
