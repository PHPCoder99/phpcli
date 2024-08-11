<?php 

function handleHelp() : string {
    $help = "Программа работы с файловым хранилищем \r\n";
    $help .= "Порядок вызова\r\n\r\n";
    $help .= "php /code/app.php [COMMAND] \r\n\r\n";
    $help .= "Доступные команды: \r\n";
    $help .= "read–all - чтение всего файла \r\n";
    $help .= "add - добавление записи \r\n";
    $help .= "clear - очистка файла \r\n";
    $help .= "read-profiles - вывод всех профилей \r\n";
    $help .= "read-profile [FILENAME] - вывод профиля с названием файла [FILENAME] \r\n";
    $help .= "birthdays - вывод всех дней рождания сегодня \r\n";
    $help .= "delete - удоляет запись \r\n";
    $help .= "help - помощь \r\n";
    return $help;
}    

function helpFunction() : string {
    return handleHelp();
}
