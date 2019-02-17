<?php

function showInfoBlock($message, $type = 'success', $errors = [])
{
    switch ($type) {
        case 'success':
            $classname = 'alert-success';
            $strong = 'Дія успішна!';
            break;
        case 'error':
            $classname = 'alert-danger';
            $strong = 'Помилка!';
            break;
    }

    $infoblock = "<div class=\"alert {$classname} alert-dismissible fade show\" role=\"alert\">";
    $infoblock .= "<strong>$strong</strong> $message";

    if([] != $errors){
        $infoblock .= "<ul>";

        foreach($errors as $error){
            $infoblock .= "<li>$error</li>";
        }

        $infoblock .= "</ul>";
    }

    $infoblock .= "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">";
    $infoblock .= "<span aria-hidden=\"true\">&times;</span>";
    $infoblock .= "</button></div>";

    return $infoblock;
}