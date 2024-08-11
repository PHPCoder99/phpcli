<?php 

$address = '/code/birthdays.txt';

$currentDate = date('d-m');

if (!file_exists($address)) {
    echo "Файл $address не найден.\n";
    exit();
}

$fileHandler = fopen($address, 'r');

$found = false;

while (($line = fgets($fileHandler)) !== false) {
    $parts = explode(", ", $line);

    $name = $parts[0];
    $birthday = $parts[1];

    $birthdayDate = date('d-m', strtotime($birthday));

    if ($birthdayDate == $currentDate) {
        echo "Сегодня день рождения у: $name (Дата: $birthday)\n";
        $found = true;
    }
}

fclose($fileHandler);

if (!$found) {
    echo "Сегодня ни у кого нет дня рождения.\n";
}
