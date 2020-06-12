<?php 
session_start();

require "../../include/stijl.php";

$id = $_GET['id'] ?? 0;
 
$data = getStijl($pdo, $id);

if (isset($_SESSION["errors"])){
    $error = $_SESSION["errors"];
    unset($_SESSION["errors"]);
}

if (isset($_SESSION["post"])){
    $post = $_SESSION["post"];
    unset($_SESSION["post"]);
} 

if (!$data) {
    $_SESSION["message"] = "Deze stijl bestaat niet meer.";
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
    <h1>Stijl Wijzigen</h1>

        
    <form action="update.php?id=<?= $id ?>" method="POST">
        <p>
            Naam <br>
            <input type="text" name="naam" value="<?= $post["naam"] ?? $data["naam"] ?>"> <br>
            <b> <?= $error["naam"] ?? "" ?> </b>
        </p>
        <p>
            Beschrijving <br>
            <textarea name="tekst" cols="30" rows="10"><?= $post["tekst"] ?? $data["tekst"] ?></textarea>
        </p>
        <p>
            <input type="submit" name="save" value="Opslaan">
        </p>
    </form>
</div>
</body>
</html>