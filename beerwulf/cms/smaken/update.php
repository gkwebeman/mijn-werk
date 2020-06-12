<?php
session_start();

require "../../include/smaak.php";

define('MAX_NAME_LENGTH', 50);

function isValid($pdo, $smaak, $oudenaam, &$errors){
    $length = strlen($smaak["naam"]);

    $errors = [];

    if ($smaak["naam"] == "") {
        $errors["naam"] = "De naam mag niet leeg zijn!";
    } elseif ($length > MAX_NAME_LENGTH) {
        $errors["naam"] = "De naam mag maximaal " + MAX_NAME_LENGTH + " tekens bevatten.";
    } elseif ($smaak["naam"] != $oudenaam && smaakExists($pdo, $smaak["naam"])) {
        $errors["naam"] = "De naam bestaat al in de database.";
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

    $oldData = getSmaak($pdo, $id);

    if (!$oldData) {
        header('location:index.php');        
    } else {
        $oudenaam = $oldData["naam"];
        
        if (!isValid($pdo, $newData, $oudenaam, $errors)) {
            $_SESSION["message"] = "Er is iets fout gegaan.";
            $_SESSION["post"] = $_POST; 
            $_SESSION["errors"] = $errors;
            header("location:edit.php?id=" . $id);
        } else {
            $_SESSION["message"] = "Succesvol gewijzigd!";
            updateSmaak($pdo, $newData, $id);
            header("location:index.php");
        }
    }
}
