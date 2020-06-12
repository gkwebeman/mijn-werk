<?php
session_start();

require "../../include/producten.php";

$id = $_GET["id"] ?? 0;

if (deleteProductCheck($pdo, $id)['aantal_bestellingen']) {
    $_SESSION['message'] = 'Dit product zit in een bestelling.';
} else if (!deleteProduct($pdo, $id)) {
    $_SESSION['message'] = 'De database haat ons atm..';
} else {
    $_SESSION['message'] = 'Product succesvol verwijderd.';
}

header('location:index.php');