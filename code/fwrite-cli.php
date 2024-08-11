<?php 

$address = '/code/birthdays.txt';

function validateDate($date, $format = 'd-m-Y') {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}

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
    echo "Запись $data добавлена в файл $address";
}
else {
    echo "Произошла ошибка записи. Данные не сохранены";
}
fclose($fileHandler);
