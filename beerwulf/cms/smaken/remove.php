<?php
require "../../include/smaak.php";

$id = $_GET['id'];

$data = getSmaak($pdo, $id);

function redirect() {
    header('index.php');
}

if (!$data) {
    redirect();
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
        <h1>Weet je zeker dat je de smaak '<?= $data['naam'] ?>' wilt verwijderen?</h1>

        <div>
            <a href="delete.php?id=<?= $data['id'] ?>" class="button button--ja">Ja</button>
            <a href="index.php" class="button button--nee">Nee</a>
        </div>
    </div>
</body>
</html>