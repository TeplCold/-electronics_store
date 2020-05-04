<?php

function clear_string($cl_str)
{
    $cl_str = strip_tags($cl_str); //удаление html и php тегов
    // $cl_str = quotemeta($cl_str); //очистка спец символов (добавляет обратную косую черту к следующим символам)(Эта функция должна использоваться для того, чтобы обезопасить данные, вставляемые в запрос перед отправкой его в MySQL.)
    // $cl_str = stripcslashes($cl_str);
    $cl_str = trim($cl_str); //удаление пробелов в начале и конце(если есть)
    return $cl_str;      //возвращаем очищенную строку     
}


function fungenpass()
{
    $number = 10; //длина пароля 

    //массив символов которые должны быть в генерации пароля 
    $arr = array(
        'a', 'b', 'c', 'd', 'e', 'f',
        'g', 'h', 'i', 'j', 'k', 'l',
        'm', 'n', 'o', 'p', 'r', 's',
        't', 'u', 'v', 'x', 'y', 'z',
        '1', '2', '3', '4', '5', '6',
        '7', '8', '9', '0', '_', '-',
        'A', 'B', 'C', 'D', 'E', 'F',
        'G', 'H', 'I', 'G', 'K', 'L',
        'M', 'N', 'O', 'P', 'R', 'S',
        'T', 'U', 'V', 'X', 'Y', 'Z'
    );

    // Генерируем пароль

    $pass = "";

    for ($i = 0; $i < $number; $i++) {

        // Вычисляем случайный индекс массива

        $index = rand(0, count($arr) - 1);

        $pass .= $arr[$index];
    }
    return $pass;
}


function send_mail($from, $to, $subject, $body)
{
    $charset = 'utf-8';
    mb_language("ru");
    $headers  = "MIME-Version: 1.0 \n";
    $headers .= "From: <" . $from . "> \n";
    $headers .= "Reply-To: <" . $from . "> \n";
    $headers .= "Content-Type: text/html; charset=$charset \n";

    $subject = '=?' . $charset . '?B?' . base64_encode($subject) . '?=';

    mail($to, $subject, $body, $headers);
}
