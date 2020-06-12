<?php 
session_start();

require "../../include/smaak.php";

$id = $_GET["id"] ?? 0;

if (!deleteSmaak($pdo, $id)) {
    $_SESSION['error'] = 'Nee de database haat ons atm...';
} else {
    $_SESSION['message'] = 'Smaak succesvol verwijderd.';
}

header('location: index.php');