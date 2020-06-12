<?php
session_start();

require "../../include/smaak.php";

if(isset($_SESSION["message"])){
    $message = $_SESSION["message"];
    unset($_SESSION["message"]);
}

$smaken = getSmaken($pdo);

define('TITLE', 'Smaken');
?>

<!doctype html>
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
    </tr>
<?php 
    foreach ($smaken as $smaak) {
?>
    <tr>
        <td>
            <?= $smaak["naam"] ?>
        </td>
        
        <td>
            <a href="edit.php?id=<?= $smaak["id"] ?>" class="icon"><i class="far fa-edit"></i></a>
        </td>     
            
        <td>
            <a href="remove.php?id=<?= $smaak["id"] ?>" class="icon"><i class="far fa-trash-alt"></i></a>
        </td>
    </tr>
<?php
    }
?>
</table>
</body>
</html>