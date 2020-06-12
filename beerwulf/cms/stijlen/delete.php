<?php 
session_start();

require "../../include/stijl.php";

$id = $_GET["id"] ?? 0;

if (deleteCheckStijl($pdo, $id)['amount']) {
    $_SESSION['error'] = 'Ze hebben producten, sorry';
} else if (!deleteStijl($pdo, $id)) {
    $_SESSION['error'] = 'Nee de database haat ons atm...';
} else {
    $_SESSION['message'] = 'Stijl succesvol verwijderd.';
}

header('location: index.php');