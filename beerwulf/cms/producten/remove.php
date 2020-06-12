<?php
require "../../include/producten.php";

$id = $_GET['id'];

$data = getProduct($pdo, $id);

function redirect() {
    header('location:index.php');
}

if (!$data) {
    redirect();
}

if (deleteProductCheck($pdo, $id)['aantal_bestellingen']) {
    $_SESSION['message'] = 'Dit product zit in een bestelling.';
    header("location:index.php");
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
        <h1>Weet je zeker dat je het product '<?= $data['naam'] ?>' wilt verwijderen?</h1>

        <div>
            <a href="delete.php?id=<?= $data['id'] ?>" class="button button--ja">Ja</button>
            <a href="index.php" class="button button--nee">Nee</a>
        </div>

    </div>
</body>
</html>