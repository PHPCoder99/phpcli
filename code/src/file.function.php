<?php

function validateDate($date, $format = 'd-m-Y') {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}

function readAllFunction(array $config) : string {
    $address = $config['storage']['address'];
    if (file_exists($address) && is_readable($address)) {
        $file = fopen($address, "rb");
        $contents = '';
        while (!feof($file)) {
            $contents .= fread($file, 100);
        }
        fclose($file);
        return $contents;
    }
    else {
        return handleError("Файл не существует");
    }
}

function addFunction(array $config) : string {
    $address = $config['storage']['address'];
    $name = readline("Введите имя: ");
    while (empty($name) || preg_match('/[^a-zA-Zа-яА-ЯёЁ\s-]/u', $name)) {
        $name = readline("Неверный формат, попробуйте еще раз: ");
    }

    $date = readline("Введите дату рождения в формате ДД-ММ-ГГГГ: ");
    while (!validateDate($date)) {
        $name = readline("Неверный формат, попробуйте еще раз: ");
    }

    $data = $name . ", " . $date . "\r\n";
    $fileHandler = fopen($address, 'a');
    if(fwrite($fileHandler, $data)){
        return "Запись $data добавлена в файл $address";
    }
    else {
        return handleError("Произошла ошибка записи. Данные не сохранены");
    }
    fclose($fileHandler);
}


function clearFunction(array $config) : string {
    $address = $config['storage']['address'];
    if (file_exists($address) && is_readable($address)) {
        $file = fopen($address, "w");
        fwrite($file, '');
        fclose($file);
        return "Файл очищен";
    }
    else {
        return handleError("Файл не существует");
    }
}

function readConfig(string $configAddress): array|false{
    return parse_ini_file($configAddress, true);
}

function readProfilesDirectory(array $config): string {
    $profilesDirectoryAddress = $config['profiles']['address'];
    if(!is_dir($profilesDirectoryAddress)){
        mkdir($profilesDirectoryAddress);
    }
    $files = scandir($profilesDirectoryAddress);
    $result = "";
    if(count($files) > 2){
        foreach($files as $file){
            if(in_array($file, ['.', '..']))
            continue;
            $result .= $file . "\r\n";
        }
    }
    else {
        $result .= "Директория пуста \r\n";
    }
    return $result;
}

function readProfile(array $config): string {
    $profilesDirectoryAddress = $config['profiles']['address'];

    if(!isset($_SERVER['argv'][2])){
        return handleError("Не указан файл профиля");
    }

    $profileFileName = $profilesDirectoryAddress . "/" . $_SERVER['argv'][2] . ".json";
    if(!file_exists($profileFileName)){
        return handleError("Файл $profileFileName не существует");
    }

    $contentJson = file_get_contents($profileFileName);
    $contentArray = json_decode($contentJson, true);

    $info = "Имя: " . $contentArray['name'] . "\r\n";
    $info .= "Фамилия: " . $contentArray['lastname'] . "\r\n";
    return $info;
}

function birthdaysToday(array $config) : string {
    $address = $config['storage']['address'];

    $birthdays = "";

    $currentDate = date('d-m');

    if (!file_exists($address)) {
        return handleError("Файл не существует");
    }

    $fileHandler = fopen($address, 'r');

    $contents = '';
    while (!feof($fileHandler)) {
        $contents .= fread($fileHandler, 100);
    }

    $contents = explode("\r\n", $contents);

    $found = false;

    foreach ($contents as $line) {
        $parts = explode(", ", $line);

        if (count($parts) != 2) {
            continue;
        }

        $name = $parts[0];
        $birthday = $parts[1];

        $birthdayDate = date('d-m', strtotime($birthday));

        if ($birthdayDate == $currentDate) {
            $birthdays .= "Сегодня день рождения у: $name (Дата: $birthday)\n";
            $found = true;
        }
    }

    fclose($fileHandler);

    if (!$found) {
        return "Сегодня ни у кого нет дня рождения.\n";
    } else {
        return $birthdays;
    }
}

function deleteBirthday(array $config) : string {
    $address = $config['storage']['address'];

    $deleted = "";

    $input = readline("Введите имя или дату (ДД-ММ-ГГГГ) для удаления: ");

    if (!file_exists($address)) {
        return handleError("Файл не существует");
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
            $deleted .= "Строка с \"$line\" удалена.\n";
        } else {
            fwrite($fileHandler, $line . "\r\n");
        }
    }

    if ($found == true) {
        return $deleted;
    } else {
        return "Ничего не найденно.";
    }

    fclose($fileHandler);
}