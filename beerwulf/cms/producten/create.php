<?php 
session_start();

require("../../include/stijl.php");
require("../../include/brouwer.php");
require("../../include/smaak.php");

$stijlen = getStijlen($pdo);
$brouwers = getBrouwers($pdo);
$smaken = getSmaken($pdo);

if(isset($_SESSION["message"])){
    $message = $_SESSION["message"];
    unset($_SESSION["message"]);
}

if (isset($_SESSION["errors"])){
    $error = $_SESSION["errors"];
    unset($_SESSION["errors"]);
}

if (isset($_SESSION["post"])){
    $post = $_SESSION["post"];
    unset($_SESSION["post"]);
} 

define('TITLE', 'Product toevoegen');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Beerwulf</title>
    <link rel="stylesheet" href="../../css/main.css">
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

    <form action="save.php" method="POST">

        <p>
            Naam <br>
            <input type="text" name="naam" value="<?= $post["naam"] ?? "" ?>"> <br>
            <b> <?= $error["naam"] ?? "" ?> </b>
        </p>

        <p>
            Beschrijving <br>
            <textarea name="beschrijving" cols="30" rows="10"><?= $post["beschrijving"] ?? "" ?></textarea>
        </p>

        <p>
            Inhoud (ml) <br>
            <input type="text" name="inhoud" value="<?= $post["inhoud"] ?? "" ?>"> <br>
            <b> <?= $error["inhoud"] ?? "" ?> </b>
        </p>

        <p>
            Percentage (%) <br>
            <input type="text" name="percentage" value="<?= $post["percentage"] ?? "" ?>"> <br>
            <b> <?= $error["percentage"] ?? "" ?> </b>
        </p>

        <p>
            Prijs (&euro;) <br>
            <input type="text" name="prijs" value="<?= $post["prijs"] ?? "" ?>"> <br>
            <b> <?= $error["prijs"] ?? "" ?> </b>
        </p>

        <p>
            Stijl <br>
            <select name="id_stijl">
                <option value="0">Maak een keuze..</option>
<?php 
                foreach ($stijlen as $stijl) {
                    $selected = ($stijl["id"] == $post["id_stijl"] ? 'selected' : '');
?>
                    <option value="<?= $stijl["id"] ?>" <?= $selected ?>><?= $stijl["naam"] ?></option>
<?php
                }
?>
            </select> <br>
            <b> <?= $error["id_stijl"] ?? "" ?> </b>
        </p>

        <p>
            Brouwer <br>
            <select name="id_brouwer">
                <option value="0">Maak een keuze..</option>
<?php 
                foreach ($brouwers as $brouwer) {
                    $selected = ($brouwer["id"] == $post["id_brouwer"] ? 'selected' : '');
?>
                    <option value="<?= $brouwer["id"] ?>" <?= $selected ?>><?= $brouwer["naam"] ?></option>
<?php
                }
?>
            </select> <br>
            <b> <?= $error["id_brouwer"] ?? "" ?> </b>
        </p>

        <p>
<?php 
            foreach ($smaken as $smaak) { 
                if (isset($post["id_smaken"])) {
                    $checked = (in_array($smaak["id"], $post["id_smaken"]) ? 'checked' : '');
                
?>
                    <?= $smaak["naam"] ?>: <input type="checkbox" name="id_smaken[]" value="<?= $smaak["id"] ?>" <?= $checked ?>> <br>
<?php
                } else {
?>
                    <?= $smaak["naam"] ?>: <input type="checkbox" name="id_smaken[]" value="<?= $smaak["id"] ?>"> <br>  
<?php
                }
            }
?>
        </p>

        <p>
            Opslaan en naar de index pagina gaan.
            <input type="submit" name="save" value="Klik hier..">
        </p>

        <p>
            Opslaan en nog een nieuwe stijl toevoegen.
            <input type="submit" name="opslaan_nog_een_toevoegen" value="Klik hier..">
        </p> 
        
    </form>
</div>
</body>
</html>