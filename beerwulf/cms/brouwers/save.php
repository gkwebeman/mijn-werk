<?php
session_start();

require "../../include/brouwer.php";

define("MAX_NAME_LENGTH", 255);
define('UPLOADMAP', '../../logos/');
define('MAX_FILE_SIZE', 200);// kb


function isPostRequest() {
    return $_SERVER["REQUEST_METHOD"] == "POST";
}

function isValid($pdo, $brouwer, $logo, &$errors){
    $length = strlen($brouwer["naam"]);
    $accept_files = array(".jpg" => "image/jpeg", ".png" => "image/png");

    $errors = [];

    if ($brouwer["naam"] == "") {
        $errors["naam"] = "De naam mag niet leeg zijn!";
    } elseif ($length > MAX_NAME_LENGTH) {
        $errors["naam"] = "De naam mag maximaal " + MAX_NAME_LENGTH + " tekens bevatten.";
    } elseif (brouwerExists($pdo, $brouwer["naam"])) {
        $errors["naam"] = "De naam bestaat al in de database.";
    } 

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
    
    $valid = count($errors) == 0;
    return $valid;
}

if (!isPostRequest()) {
    $_SESSION["message"] = "test.";
    header("location:index.php");
} else {
    $brouwer = [
        'naam'  => $_POST["naam"], 
        'beschrijving' => $_POST["beschrijving"],
        'in_etalage' => isset($_POST["in_etalage"])
    ];
    
    $logo = $_FILES["logo"];

    if (!isValid($pdo, $brouwer, $logo, $errors)) {
        $_SESSION["message"] = "Er is iets fout gegaan.";
        $_SESSION["post"] = $_POST; 
        $_SESSION["errors"] = $errors;
        header("location:create.php");
    } else {
        $id = saveBrouwer($pdo, $brouwer);

        if ($logo['error'] == UPLOAD_ERR_OK) {
            $fileName = $id . '.' . pathinfo($logo['name'], PATHINFO_EXTENSION) ;
            $destination = UPLOADMAP . $fileName;
            $source = $logo['tmp_name'];

            move_uploaded_file($source, $destination);

            $update = updateLogoBrouwer($pdo, $fileName, $id);
        }
       
        $_SESSION["message"] = "Brouwer succesvol opgeslagen!";

        if (isset($_POST["save"])){
            header("location:index.php");
        } elseif (isset($_POST["opslaan_nog_een_toevoegen"])) {
            header("location:create.php");
        }
    }
}