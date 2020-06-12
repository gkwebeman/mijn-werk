<?php
session_start();

require "../../include/stijl.php";

if(isset($_SESSION["message"])){
    $message = $_SESSION["message"];
    unset($_SESSION["message"]);
}

$stijlen = getStijlen($pdo);

define('TITLE', 'Stijlen');
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
    foreach ($stijlen as $stijl) {
        $aantal = deleteCheckStijl($pdo, $stijl['id'])['amount'];
?>
        <tr>
            <td>
                <?= $stijl["naam"] ?>
            </td>
            
            <td>
                <a href="edit.php?id=<?= $stijl["id"] ?>" class="icon"><i class="far fa-edit"></i></a>
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
                    <a href="remove.php?id=<?= $stijl["id"] ?>" class="icon"><i class="far fa-trash-alt"></i></a>
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