<?php 
session_start();

require "../../include/brouwer.php";

$id = $_GET['id'] ?? 0;
 
$data = getBrouwer($pdo, $id);

if (isset($_SESSION["errors"])){
    $error = $_SESSION["errors"];
    unset($_SESSION["errors"]);
}

if (isset($_SESSION["post"])){
    $post = $_SESSION["post"];
    unset($_SESSION["post"]);
} 

if (!$data) {
    $_SESSION["message"] = "Deze brouwer bestaat niet meer.";
    header('location:index.php');
}

$data["in_etalage"] = isset($post["in_etalage"]) || (!isset($post) && $data["in_etalage"]);
$logo_action = $post["logo_action"] ?? "no_changes_logo";

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

    <h1>Brouwer Wijzigen</h1>
        
    <form action="update.php?id=<?= $id ?>" method="POST" enctype="multipart/form-data">
        <p>
            Naam <br>
            <input type="text" name="naam" value="<?= $post["naam"] ?? $data["naam"] ?>"> <br>
            <b> <?= $error["naam"] ?? "" ?> </b>
        </p>
        <p>
            Beschrijving <br>
            <textarea name="beschrijving" cols="30" rows="10"><?= $post["beschrijving"] ?? $data["beschrijving"] ?></textarea>
        </p>
            <p>
                in etalage?
                <input type="checkbox" name="in_etalage" <?= $data["in_etalage"] ? "checked" : "" ?>>
            </p> 
<?php 
            if ($data["logo"]) {
?>
                <p>
                    <img src="../../logos/<?= $data['logo'] ?>" alt="logo" class="logo">
                </p>

                <p>
                    1. Geen verandering: <input type="radio" name="logo_action" value="no_changes_logo" <?= $logo_action == "no_changes_logo" ? "checked" : "" ?>> <br>
                    2. Verwijder logo: <input type="radio" name="logo_action" value="delete_logo" <?= $logo_action == "delete_logo" ? "checked" : "" ?>> <br>
                    3. Verander logo: <input type="radio" name="logo_action" value="change_logo" <?= $logo_action == "change_logo" ? "checked" : "" ?>> 
                </p>

                <p>
                    <input type="file" name="logo"> <br>
                    <b><?= $error["logo"] ?? "" ?></b>
                </p>
<?php
            } else {
?>
                <p>
                    <input type="file" name="logo"> <br>
                    <b><?= $error["logo"] ?? "" ?></b>
                </p>
<?php
            }
?>
        <p>
            <input type="submit" name="save" value="Opslaan">
        </p>
    </form>
</div>
</body>
</html>