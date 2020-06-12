<?php
session_start();

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

define('TITLE', 'Stijl toevoegen');
?>

<!doctype html>
<html lang="en">
<head>
    <title>Beerwulf</title>
    <link rel="stylesheet" href="../../css/main.css" type="text/css">
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
            <textarea name="tekst" cols="30" rows="10"><?= $post["tekst"] ?? "" ?></textarea>
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