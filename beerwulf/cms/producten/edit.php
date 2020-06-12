<?php 
session_start();

require "../../include/producten.php";
require "../../include/stijl.php";
require "../../include/brouwer.php";
require "../../include/smaak.php";

$id = $_GET['id'] ?? 0;

$data = getProduct($pdo, $id);
$data["id_smaak"] = getProductSmaak($pdo, $data["id"]);
$stijlen = getStijlen($pdo);
$brouwers = getBrouwers($pdo);
$smaken = getSmaken($pdo);


if (isset($_SESSION["errors"])) {
    $error = $_SESSION["errors"];
    unset($_SESSION["errors"]);
}

if (isset($_SESSION["post"])) {
    $post = $_SESSION["post"];
    unset($_SESSION["post"]);
} 

if (!$data) {
    $_SESSION["message"] = "Dit product bestaat niet meer.";
    header('location:index.php');
}

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
        <h1>Product wijzigen</h1>

        <form action="update.php?id=<?= $id ?>" method="POST">
            <p>
                Naam <br>
                <input type="text" name="naam" value="<?= $post["naam"] ?? $data["naam"] ?>"> <br>
                <b> <?= $error["naam"] ?? "" ?> </b>
            </p>

            <p>
                Beschrijving <br>
                <textarea name="beschrijving" id="" cols="30" rows="10"><?= $post["beschrijving"] ?? $data["beschrijving"] ?></textarea>
            </p>

            <p>
                Inhoud (ml) <br>
                <input type="text" name="inhoud" value="<?= $post["inhoud"] ?? $data["inhoud"] ?>"> <br>
                <b> <?= $error["inhoud"] ?? "" ?> </b>
            </p>

            <p>
                Percentage (%) <br>
                <input type="text" name="percentage" value="<?= $post["percentage"] ?? $data["percentage"] ?>"> <br>
                <b> <?= $error["percentage"] ?? "" ?> </b>
            </p>

            <p>
                Prijs (&euro;) <br>
                <input type="text" name="prijs" value="<?= $post["prijs"] ?? $data["prijs"] ?>"> <br>
                <b> <?= $error["prijs"] ?? "" ?> </b>
            </p>

            <p>
                Stijl <br>
                <select name="id_stijl">
                    <option value="0">Maak een keuze..</option>
<?php 
                    foreach ($stijlen as $stijl) {
                        $selected = ($stijl['id'] == ($post["id_stijl"] ?? $data["id_stijl"]) ? 'selected' : '');
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
                        $selected = ($brouwer["id"] == ($post["id_brouwer"] ?? $data["id_brouwer"]) ? 'selected' : '');
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
                    $checked = (in_array($smaak["id"], $data["id_smaak"]) ? "checked" : '') ;
?>
                    <?= $smaak["naam"] ?>: <input type="checkbox" name="id_smaken[]" value="<?= $smaak["id"] ?>" <?= $checked ?>> <br>
<?php    
                }
?>
            </p>

            <p>
                <input type="submit" name="save" value="Opslaan">
            </p>
        </form>
    </div>
</body>
</html>