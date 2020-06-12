<?php
define('DB_USER', 'noorderpoort');
define('DB_PASS', 'toets');
define('DB_HOST', '127.0.0.1');
define('DB_PORT', '3306');
define('DB_NAME', 'db_oefen_3_bier');
define('DB_DRIVER', 'mysql');

$dsn = DB_DRIVER . ':host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME;
$pdo = new PDO($dsn, DB_USER, DB_PASS);

function naamExists($pdo, $naam, $tabel) {
    $query = "SELECT COUNT(*) FROM $tabel WHERE naam=:naam";
    $statement = $pdo->prepare($query);

    $statement->bindValue(":naam", $naam, PDO::PARAM_STR);
    $ok = $statement->execute();

    $aantal = $statement->fetch(PDO::FETCH_COLUMN);
    $exists = $aantal > 0;

    return $exists;
}

function idExists($pdo, $id, $tabel) {
    $query = "SELECT COUNT(*) FROM $tabel WHERE id=:id";
    $statement = $pdo->prepare($query);

    $statement->bindValue(":id", $id, PDO::PARAM_INT);
    $ok = $statement->execute();

    $aantal = $statement->fetch(PDO::FETCH_COLUMN);
    $exists = $aantal > 0;

    return $exists;
}

function statementExecute($statement) {
    $ok = $statement->execute();
    
    if (!$ok) {
        $info = $statement->errorInfo();
        die($info[2]);
    }
}