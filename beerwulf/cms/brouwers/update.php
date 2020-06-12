<?php
session_start();

require "../../include/brouwer.php";

define('MAX_NAME_LENGTH', 255);
define('UPLOADMAP', '../../logos/');
define('MAX_FILE_SIZE', 200);// kb

function isValid($pdo, $brouwer, $oudenaam, $logo, $radioButtons, &$errors){
    $length = strlen($brouwer["naam"]);
    $accept_files = array(".jpg" => "image/jpeg", ".png" => "image/png");

    $errors = [];

    if ($brouwer["naam"] == "") {
        $errors["naam"] = "De naam mag niet leeg zijn!";
    } elseif ($length > MAX_NAME_LENGTH) {
        $errors["naam"] = "De naam mag maximaal " + MAX_NAME_LENGTH + " tekens bevatten.";
    } elseif ($brouwer["naam"] != $oudenaam && brouwerExists($pdo, $brouwer["naam"])) {
        $errors["naam"] = "De naam bestaat al in de database.";
    } 

    if ($radioButtons == "change_logo" || $radioButtons == "new_logo"){
        switch ($logo['error']) {
            case UPLOAD_ERR_OK:
                $size = $logo["size"];
                $type = $logo["type"];
                
                if ($size > MAX_FILE_SIZE * 1024) {
                    $errors["logo"] = "De file is te groot, de file moet maximaal " . MAX_FILE_SIZE . " kb zijn.";
                } elseif (!in_array($type, $accept_files)) { 
                    $errors["logo"] = "Deze file mag niet geüpload worden.";
                } 
            break;
            case UPLOAD_ERR_NO_FILE:
                if ($radioButtons == "change_logo") {
                    $errors["logo"] = "Kies een logo.";
                }
                break;
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                $errors["logo"] = "De file is te groot, de file moet maximaal " . MAX_FILE_SIZE . " kb zijn.";
                break;
            case UPLOAD_ERR_PARTIAL:
                $errors["logo"] = "Er is iets fout gegaan bij het uploaden van het bestand, probeer het nog eens.";
                break;                
            case UPLOAD_ERR_NO_TMP_DIR:
            case UPLOAD_ERR_CANT_WRITE:
            case UPLOAD_ERR_EXTENSION:
                $errors["logo"] = "Er is een storing, probeer het later nog een keer.";
                break;   
        }   
    }
    
    $valid = count($errors) == 0;
    return $valid; 
}

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    $_SESSION["message"] = "Het is geen post.";

    header("location:edit.php?id=" . $id);
} else {
    $newData = $_POST;
    $logo = $_FILES['logo'];
    $radioButtons = $_POST['logo_action'] ?? "new_logo";

    $newData["in_etalage"] = isset($newData["in_etalage"]);

    $oldData = getBrouwer($pdo, $id);

    $newData["logo"] = $oldData["logo"];

    if (!$oldData) {
        header('location:index.php');        
    } else {
        $oudenaam = $oldData["naam"];
        
        if (!isValid($pdo, $newData, $oudenaam, $logo, $radioButtons, $errors)) {
            $_SESSION["message"] = "Er is iets fout gegaan.";
            $_SESSION["post"] = $_POST; 
            $_SESSION["errors"] = $errors;
            header("location:edit.php?id=" . $id);
        } else {
            if ($radioButtons == "delete_logo" || $radioButtons == "change_logo") {
                unlink(UPLOADMAP . $oldData['logo']);
                $newData["logo"] = NULL;
            }

            if ($logo['error'] == UPLOAD_ERR_OK) {
                $newData['logo'] = $id . '.' . pathinfo($logo['name'], PATHINFO_EXTENSION);
                $destination = UPLOADMAP . $newData['logo'];
                $source = $logo['tmp_name'];
    
                move_uploaded_file($source, $destination);
            }
            updateBrouwer($pdo, $newData, $id);
    
            $_SESSION["message"] = "Succesvol gewijzigd!";
            header("location:index.php");
        }
    }
}