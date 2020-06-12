<?php 

require_once('../../include/database.php');

//ophalen van de brouwers uit de database.
function getBrouwers(PDO $pdo){
    $query = "SELECT * FROM brouwers";

    $statement = $pdo->prepare($query);
    $ok = $statement->execute();
    $brouwers = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $brouwers;
}

//functie om te zien of de naam (van brouwers) al in de database bestaat.
function brouwerExists(PDO $pdo, $naam) {
    return naamExists($pdo, $naam, "brouwers");
}

function saveBrouwer(PDO $pdo, $brouwer) {
    $query = 'INSERT INTO brouwers (naam, beschrijving, in_etalage) VALUES (:naam, :beschrijving, :in_etalage)';
    $statement = $pdo->prepare($query);

    $statement->bindValue(':naam', $brouwer["naam"], PDO::PARAM_STR);
    $statement->bindValue(':beschrijving', $brouwer["beschrijving"], PDO::PARAM_STR);
    $statement->bindValue(':in_etalage', $brouwer["in_etalage"], PDO::PARAM_INT);

    $ok = $statement->execute();

    $id = $pdo->lastInsertId();

    return $id;
}

function updateBrouwer(PDO $pdo, $newData, $id) {
    $query = "UPDATE brouwers SET naam=:naam, beschrijving=:beschrijving, logo=:logo, in_etalage=:in_etalage WHERE id=:id";
    $statement = $pdo->prepare($query);
    
    $statement->bindValue(":id", $id, PDO::PARAM_INT);
    $statement->bindValue(":naam", $newData['naam'], PDO::PARAM_STR);
    $statement->bindValue(":beschrijving", $newData['beschrijving'], PDO::PARAM_STR);
    $statement->bindValue(":logo", $newData['logo'], PDO::PARAM_STR);
    $statement->bindValue(":in_etalage", $newData['in_etalage'], PDO::PARAM_BOOL);


    $ok = $statement->execute();

    if ($ok) {
        return $statement->rowCount();
    } 
    return false;
}   

function updateLogoBrouwer ($pdo, $logo, $id) {
    $query = "UPDATE brouwers SET logo=:logo WHERE id=:id";
    $statement = $pdo->prepare($query);

    $statement->bindvalue(":id", $id, PDO::PARAM_INT);
    $statement->bindvalue(":logo", $logo, PDO::PARAM_STR);

    $ok = $statement->execute();

    $aantal = $statement->rowCount();

    return $aantal;
}

function getBrouwer(PDO $pdo, $id) {
    $query = "SELECT * FROM brouwers WHERE id=:id";
    $statement = $pdo->prepare($query);
    $statement->bindValue(":id", $id, PDO::PARAM_INT);
    $ok = $statement->execute();

    if ($ok) {
        return $statement->fetch(PDO::FETCH_ASSOC);
    } else {
        return false;
    }
}

function deleteBrouwer(PDO $pdo, $id) {
    $query = "DELETE FROM brouwers WHERE id=:id";

    $statement = $pdo->prepare($query);
    $statement->bindValue(":id", $id, PDO::PARAM_INT);

    $ok = $statement->execute();

    $aantal = $statement->rowCount();

    return $aantal;
}

function deleteCheckBrouwer(PDO $pdo, $id) {
    $query = 'SELECT count(brouwers.id) AS "amount" FROM producten JOIN brouwers ON producten.id_brouwer = brouwers.id WHERE brouwers.id=:id';
    $statement = $pdo->prepare($query);

    $statement->bindValue(":id", $id, PDO::PARAM_INT);
    $ok = $statement->execute();

    if (!$ok) {
        return ['amount' => 27];
    } else {
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}