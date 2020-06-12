<?php
session_start();

require "../../include/stijl.php";

define("MAX_NAME_LENGTH", 50);

function isPostRequest() {
    return $_SERVER["REQUEST_METHOD"] == "POST";
}

function isValid($pdo, $stijl, &$errors){
    $length = strlen($stijl["naam"]);

    $errors = [];

    if ($stijl["naam"] == "") {
        $errors["naam"] = "De naam mag niet leeg zijn!";
    } elseif ($length > MAX_NAME_LENGTH) {
        $errors["naam"] = "De naam mag maximaal " + MAX_NAME_LENGTH + " tekens bevatten.";
    } elseif (stijlExists($pdo, $stijl["naam"])) {
        $errors["naam"] = "De naam bestaat al in de database.";
    } 

    $valid = count($errors) == 0;
    return $valid; 
}

if (!isPostRequest()) {
    $_SESSION["message"] = "test.";
    header("location:index.php");
} else {
    $stijl = [
        'naam'  => $_POST["naam"], 
        'tekst' => $_POST["tekst"]
    ];

    $_SESSION["save"] = $_POST["save"];
    $_SESSION["opslaan_nog_een_toevoegen"] = $_POST["opslaan_nog_een_toevoegen"];

    if (!isValid($pdo, $stijl, $errors)) {
        $_SESSION["message"] = "Er is iets fout gegaan.";
        $_SESSION["post"] = $_POST; 
        $_SESSION["errors"] = $errors;
        header("location:create.php");
    } else if (empty($errors)) {
        $_SESSION["message"] = "Stijl succesvol opgeslagen!";
        saveStijl($pdo, $stijl);

        if(isset($_SESSION["save"])){
            header("location:index.php");
        } elseif (isset($_SESSION["opslaan_nog_een_toevoegen"])) {
            header("location:create.php");
        }
    }
}