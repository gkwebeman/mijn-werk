<?php
session_start();

require "../../include/producten.php";

define('MAX_NAME_LENGTH', 255);
define('MAX_PRICE', 100000); //honderdduizend

function isValid($pdo, $product, &$errors){
    $length = strlen($product["naam"]);
    $regex = "/^\d{1,}$/";

    $errors = [];

    if ($product["naam"] == "") {
        $errors["naam"] = "De naam mag niet leeg zijn!";
    } elseif ($length > MAX_NAME_LENGTH) {
        $errors["naam"] = "De naam mag maximaal " + MAX_NAME_LENGTH + " tekens bevatten.";
    }
    
    if ($product["inhoud"] <= 0) {
        $errors["inhoud"] = "De inhoud moet groter dan 0 zijn.";
    } elseif (!preg_match($regex, $product["inhoud"])) {
        $errors["inhoud"] = "Het moet een geheel getal zijn.";
    }

    if ($product["percentage"] < 0 || $product["percentage"] >= 100) {
        $errors["percentage"] = "Het percentage moet tussen 0 - 100% zitten.";
    } elseif (!is_numeric($product["percentage"])) {
        $errors["percentage"] = "Het moet een getal zijn.";
    }

    if ($product["prijs"] < 0 || $product["prijs"] > MAX_PRICE) {
        $errors["prijs"] = "Het bedrag moet tussen de 0 & " + MAX_PRICE + " euro zitten.";
    } elseif (!is_numeric($product["prijs"])) {
        $errors["prijs"] = "Het moet een getal zijn.";
    }
  
    if (!isset($product["id_stijl"])) {
        $errors["id_stijl"] = "Je moet een stijl hebben gekozen.";
    } elseif (!id_stijlExists($pdo, $product)) {
        $errors["id_stijl"] = "Deze stijl bestaat niet meer.";
    }

    if(isset($product["id_brouwer"])) {
        if(!id_brouwerExists($pdo, $product)) {
            $errors["id_brouwer"] = "Deze brouwer bestaat niet meer.";
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

    $oldData = getProduct($pdo, $id);
    $oldData["id_smaak"] = getProductSmaak($pdo, $id);
 
    $newData["id_brouwer"] = $_POST["id_brouwer"] ? $_POST["id_brouwer"] : NULL;
    $newData["id_smaak"] = $_POST["id_smaken"] ? $_POST["id_smaken"] : [];  

    $delete = array_diff($oldData["id_smaak"], $newData["id_smaak"]);
    $add = array_diff($newData["id_smaak"], $oldData["id_smaak"]);

    if (!$oldData) {
        header('location:index.php');        
    } else {
        if (!isValid($pdo, $newData, $errors)) {
            $_SESSION["message"] = "Er is iets fout gegaan.";
            $_SESSION["post"] = $_POST; 
            $_SESSION["errors"] = $errors;
            header("location:edit.php?id=" . $id);
        } else {
            updateProduct($pdo, $newData, $id);
            updateIdSmaken($pdo, $id, $newData);

            // if ()

            $_SESSION["message"] = "Succesvol gewijzigd!";
            header("location:index.php");
        }
    }   
}