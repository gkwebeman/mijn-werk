<?php 
session_start();

require "../../include/brouwer.php";

define('UPLOADMAP', '../../logos/');

$id = $_GET["id"] ?? 0;

$data = getBrouwer($pdo, $id);

if (deleteCheckBrouwer($pdo, $id)['amount']) {
    $_SESSION['message'] = 'Ze hebben producten, sorry';
} elseif (!deleteBrouwer($pdo, $id)) {
    $_SESSION['message'] = 'Nee de database haat ons atm...';
} else {
    unlink(UPLOADMAP . $data['logo']);
    $_SESSION['message'] = 'Stijl succesvol verwijderd.';
}



header('location: index.php');