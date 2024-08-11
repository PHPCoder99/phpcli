<?php

function handleError(string $errorText) : string {
    return "\033[31m" . $errorText . " \r\n \033[97m";
}

function parseCommand() : string {
    $functionName = 'helpFunction';
    if(isset($_SERVER['argv'][1])) {
        $functionName = match($_SERVER['argv'][1]) {
            'read-all' => 'readAllFunction',
            'add' => 'addFunction',
            'clear' => 'clearFunction',
            'read-profiles' => 'readProfilesDirectory',
            'read-profile' => 'readProfile',
            'birthdays' => 'birthdaysToday',
            'delete' => 'deleteBirthday',
            'help' => 'helpFunction',
            default => 'helpFunction'
        };
    }
    return $functionName;
}
    

function main(string $configFileAddress) : string {
    $config = readConfig($configFileAddress);
    if(!$config){
        return handleError("Невозможно подключить файл настроек");
    }
    $functionName = parseCommand();
    if(function_exists($functionName)) {
        $result = $functionName($config);
    }
    else {
        $result = handleError("Вызываемая функция не существует");
    }
    return $result;
}
    