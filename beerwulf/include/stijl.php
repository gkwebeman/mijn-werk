<?php

require_once('../../include/database.php');

//stijlen ophalen van de database.
function getStijlen(PDO $pdo){
    $query = "SELECT * FROM stijlen";

    $statement = $pdo->prepare($query);
    $ok = $statement->execute();
    $stijlen = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $stijlen;
}

//naam en tekst (van stijlen) opslaan in de database.
function saveStijl(PDO $pdo, $stijl) {
    $query = 'INSERT INTO stijlen (naam, tekst) VALUES (:naam, :tekst)';
    $statement = $pdo->prepare($query);

    $statement->bindValue(':naam', $stijl["naam"], PDO::PARAM_STR);
    $statement->bindValue(':tekst', $stijl["tekst"], PDO::PARAM_STR);

    $ok = $statement->execute();
    $id = $pdo->lastInsertId();

    return $id;
}

//functie om te zien of de naam (van stijlen) al in de database bestaat.
function stijlExists(PDO $pdo, $naam) {
    return naamExists($pdo, $naam, "stijlen");
}

//stijl ophalen met een bepaalde id.
function getStijl(PDO $pdo, $id) {
    $query = "SELECT * FROM stijlen WHERE id=:id";
    $statement = $pdo->prepare($query);
    $statement->bindValue(":id", $id, PDO::PARAM_INT);
    $ok = $statement->execute();

    if ($ok) {
        return $statement->fetch(PDO::FETCH_ASSOC);
    } else {
        return false;
    }
}

//De stijl veranderen en opslaan in de database.
function updateStijl(PDO $pdo, $newData, $id) {
    $query = "UPDATE stijlen SET naam=:naam, tekst=:tekst WHERE id=:id";
    $statement = $pdo->prepare($query);
    
    $statement->bindValue(":id", $id, PDO::PARAM_INT);
    $statement->bindValue(":naam", $newData['naam'], PDO::PARAM_STR);
    $statement->bindValue(":tekst", $newData['tekst'], PDO::PARAM_STR);

    $ok = $statement->execute();

    if ($ok) {
        return $statement->rowCount();
    } 
    return false;
}

//De stijl met een bepaalde id verwijderen uit de database.
function deleteStijl(PDO $pdo, $id) {
    $query = "DELETE FROM stijlen WHERE id=:id";

    $statement = $pdo->prepare($query);
    $statement->bindValue(":id", $id, PDO::PARAM_INT);

    $ok = $statement->execute();

    $aantal = $statement->rowCount();

    return $aantal;
}

//Controleren of er producten gekoppeld zijn aan de stijl.
function deleteCheckStijl(PDO $pdo, $id) {
    $query = 'SELECT count(stijlen.id) AS "amount" FROM producten JOIN stijlen ON producten.id_stijl = stijlen.id WHERE stijlen.id=:id';
    $statement = $pdo->prepare($query);

    $statement->bindValue(":id", $id, PDO::PARAM_INT);
    $ok = $statement->execute();

    if (!$ok) {
        return ['amount' => 27];
    } else {
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}