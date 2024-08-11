<?php 

$address = '/code/birthdays.txt';
$fileHandle = fopen($address, 'r');
while ($data = fgetcsv($fileHandle)) {
    print_r($data);
}