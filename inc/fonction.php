<?php

function debug($tableau)
{
    echo '<pre style="height:100px;overflow-y: scroll;font-size:.5rem;padding: .6rem; font-family: Consolas, Monospace;background-color: #000;color:#fff;">';
    print_r($tableau);
    echo '</pre>';
}
function getInputValue($key) {
    if(!empty($_POST[$key])) {
        echo $_POST[$key];
    }
}

function spanError($err,$key){
    if(!empty($err[$key])) {
        echo $err[$key];
    }
}


function validText($errors, $value,$key,$min = 3, $max = 70){
    if(!empty($value)) {
        if(mb_strlen($value) < $min) {
            $errors[$key] = 'Min '.$min.' caractères';
        } elseif(mb_strlen($value) > $max) {
            $errors[$key] = 'Max '.$max.' caractères';
        }
    } else {
        $errors[$key] = 'Veuillez renseigner ce champ';
    }
    return $errors;
}

function validEmail($errors, $value, $key ){
    if(!empty($value)) {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $errors[$key] = 'Veuillez renseigner un email valide';
        }
    } else {
        $errors[$key] = 'Veuillez renseigner un email';
    }
    return $errors;
}


function NotFoundRedirect()
{
    header('Location: 404.php');
}

function formatDate($date, $format = 'd/m/Y H:i') {
    return date($format, strtotime($date));
}


function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function isLoggedAdmin(){
    if(isLogged()) {
        if($_SESSION['user']['role'] === 'admin') {
            return true;
        }
    }
    return false;
}

function isLogged() {
    $allowedRoles = array('abonne', 'admin');
    if(!empty($_SESSION['user'])) {
        if(!empty($_SESSION['user']['id']) && is_numeric($_SESSION['user']['id'])) {
            if(!empty($_SESSION['user']['pseudo'])) {
                if(!empty($_SESSION['user']['email'])) {
                    if(!empty($_SESSION['user']['role'])  && in_array($_SESSION['user']['role'],$allowedRoles)) {
                        if(!empty($_SESSION['user']['ip'])) {
                            if($_SESSION['user']['ip'] === $_SERVER['REMOTE_ADDR']) {
                                return true;
                            }
                        }
                    }
                }
            }
        }
    }
    return false;
}

function urlRemovelast($url) {
    $url = explode('/', $url);
    array_pop($url);
    return implode('/', $url);
}