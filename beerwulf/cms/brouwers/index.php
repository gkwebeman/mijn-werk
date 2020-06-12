<?php 
session_start();

require "../../include/brouwer.php";

if(isset($_SESSION["message"])){
    $message = $_SESSION["message"];
    unset($_SESSION["message"]);
}

$brouwers = getBrouwers($pdo);

define('TITLE', 'Brouwers');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Beerwulf</title>
    <link rel="stylesheet" href="../../css/main.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
</head>
<body>
<?php
    include("../../include/cmsmenu.php");
?>

<h1 class="title"><?= TITLE ?></h1>

<p>
    <?= $message ?? "" ?>
</p>

<table class="table">
    <tr>
        <th>
            Naam
        </th>
        <th>
            in_etalage
        </th>
        <th>
            logo
        </th>
    </tr>

<?php 
    foreach ($brouwers as $brouwer) {
        $aantal = deleteCheckBrouwer($pdo, $brouwer['id'])['amount'];
?>
    <tr>
        <td>
            <?= $brouwer["naam"] ?>
        </td>
<?php
        if ($brouwer["in_etalage"]) {
?>
            <td class="in_etalage">
                <i class="fas fa-check checked"></i>
            </td>
<?php  
        } else {
?>
            <td></td>
<?php 
        }
        if ($brouwer["logo"]) {
?>
            <td>
                <i class="fas fa-check checked"></i>
            </td>
<?php 
        } else {
?>
            <td></td>
<?php 
        }
?>
        <td>
            <a href="edit.php?id=<?= $brouwer["id"] ?>" class="icon"><i class="far fa-edit"></i></a>
        </td>     
            
<?php
        if ($aantal > 0) {
?>
            <td>
                <a class="icon icon--disabled"><i class="far fa-trash-alt"></i></a>
            </td>
<?php
        } else {
?>    
            <td>
                <a href="remove.php?id=<?= $brouwer["id"] ?>" class="icon"><i class="far fa-trash-alt"></i></a>
            </td>
<?php
        }
?>
    </tr>
<?php
    }
?>
</table>
</body>
</html>