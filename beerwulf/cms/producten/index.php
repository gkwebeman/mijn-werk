<?php 
session_start();

require "../../include/producten.php";

if(isset($_SESSION["message"])){
    $message = $_SESSION["message"];
    unset($_SESSION["message"]);
}

if(isset($_SESSION["error"])) {
    $error = $_SESSION["error"];
    unset($_SESSION["error"]);  
}

$producten = getProducten($pdo);

header('Content-Type: text/html; charset=ISO-8859-1');

define('TITLE', 'Producten');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Beerwulf</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../css/main.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
</head>
<body>
<?php
    include("../../include/cmsmenu.php");
?>

<div class="center">
    <h1><?= TITLE ?></h1>
        
    <p>
        <?= $message ?? "" ?>
    </p>
</div>

<table class="table">
    <tr>
        <th>
            Naam
        </th>
        <th>
            Inhoud
        </th>
        <th>
            Percentage
        </th>
        <th>
            Prijs
        </th>
        <th>
            Stijl
        </th>
        <th>
            Brouwer
        </th>
    </tr>

<?php 
    foreach ($producten as $product) {
        $aantal = deleteProductCheck($pdo, $product['id'])['aantal_bestellingen'];
?>
    <tr>
        <td>
            <?= $product["naam"] ?>
        </td>

        <td class="numbers">
            <?= $product["inhoud"] ?> ml
        </td>

        <td class="numbers">
            <?= $product["percentage"] ?> %
        </td>

        <td class="numbers">
            &euro; <?= $product["prijs"] ?> 
        </td> 

        <td>
            <?= $product["stijlen_naam"] ?>
        </td>

        <td>
            <?= $product["brouwers_naam"] ?>
        </td>

        <td>
            <a href="edit.php?id=<?= $product["id"] ?>" class="icon"><i class="far fa-edit"></i></a>
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
                <a href="remove.php?id=<?= $product["id"] ?>" class="icon"><i class="far fa-trash-alt"></i></a>
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