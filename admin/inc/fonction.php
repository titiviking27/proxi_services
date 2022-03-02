<?php
$errors = [];

/// debug les tableaux

function debug($array) {

    echo '<pre style="width:50%; height:200px; overflow-y:scroll;
                    font-size:.7rem; padding:.6rem; margin:0 auto;
                    font-family: Consolas,Monospace;
                    background-color: #000; color: #fff;">';
    print_r($array);
    echo '</pre>';
}

function checkTxt($errors, $string, $key, $min = 3, $max = 70) {
    if (!empty($string)) {
        if (mb_strlen($string) < $min && $min != $max ) {
            $errors[$key] = 'erreur : '. $min .' caractères minimum';
        } elseif (mb_strlen($string) > $max && $min != $max ) {
            $errors[$key] = 'erreur : '. $max .' caractères maximum';       
        } elseif ($min == $max && (mb_strlen($string) < $min || mb_strlen($string) > $min)) {
            $errors[$key] = 'erreur : if faut entrer '. $min .' caractères';       
        }
    } else {
        $errors[$key] = 'erreur : veuillez renseignez ce champ';
    }
    return $errors;
}

function getInputValue($key) {
    if (!empty($_POST[$key])) {
        echo $_POST[$key];}    
}

function spanError($error, $key) {
    if(!empty($error[$key])) { echo $error[$key]; }
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

function isLoggedAdmin() {
    if(isLogged()) {
        if($_SESSION['user']['role'] === 'admin') {
            return true;
        }
    }
    return false;
}

function isLogged() {        
    if(!empty($_SESSION['user'])) {
        $S = $_SESSION['user'];
        if(!empty($S['id'] && is_numeric($S['id']))) {
            if(!empty($S['email'])) {
                if (!empty($S['role'] && is_string($S['role']))) {
                    if ($S['ip'] === $_SERVER['REMOTE_ADDR']) {
                        return true;                        
                    }
                }
            }
        }
    }

    return false;
}

// function ifSession($key) {
//     if(!empty($_SESSION[$key])) {
//        return $_SESSION['user']['email'] .'&token'. $_SESSION['user']['token'];
//     }
// }

function urlRemovelast($url) {
    $url = explode('/',$url);
    array_pop($url);
    return implode('/',$url);
}