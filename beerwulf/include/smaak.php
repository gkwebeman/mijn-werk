<?php

require_once('../../include/database.php');

//smaken ophalen van de database.
function getSmaken(PDO $pdo){
    $query = "SELECT * FROM smaken";

    $statement = $pdo->prepare($query);
    $ok = $statement->execute();
    $smaken = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $smaken;
}

//functie om te zien of de naam (van smaken) al in de database bestaat.
function smaakExists(PDO $pdo, $naam) {
    return naamExists($pdo, $naam, "smaken");
}

//naam en tekst (van smaken) opslaan in de database.
function saveSmaak(PDO $pdo, $smaak) {
    $query = 'INSERT INTO smaken (naam, beschrijving) VALUES (:naam, :beschrijving)';
    $statement = $pdo->prepare($query);

    $statement->bindValue(':naam', $smaak["naam"], PDO::PARAM_STR);
    $statement->bindValue(':beschrijving', $smaak["beschrijving"], PDO::PARAM_STR);

    $ok = $statement->execute();
    $id = $pdo->lastInsertId();

    return $id;
}

//Smaak ophalen met een bepaalde id.
function getSmaak(PDO $pdo, $id) {
    $query = "SELECT * FROM smaken WHERE id=:id";
    $statement = $pdo->prepare($query);
    $statement->bindValue(":id", $id, PDO::PARAM_INT);
    $ok = $statement->execute();

    if ($ok) {
        return $statement->fetch(PDO::FETCH_ASSOC);
    } else {
        return false;
    }
}

//De smaak veranderen en opslaan in de database.
function updateSmaak(PDO $pdo, $newData, $id) {
    $query = "UPDATE smaken SET naam=:naam, beschrijving=:beschrijving WHERE id=:id";
    $statement = $pdo->prepare($query);
    
    $statement->bindValue(":id", $id, PDO::PARAM_INT);
    $statement->bindValue(":naam", $newData['naam'], PDO::PARAM_STR);
    $statement->bindValue(":beschrijving", $newData['beschrijving'], PDO::PARAM_STR);

    $ok = $statement->execute();

    if ($ok) {
        return $statement->rowCount();
    } 
    return false;
}   

//De smaak met een bepaalde id en koppeltabel verwijderen uit de database.
function deleteSmaak(PDO $pdo, $id) {
    $query1 = "DELETE FROM product_smaak WHERE id_smaak=:id";
    $statement1 = $pdo->prepare($query1);
    $statement1->bindValue(":id", $id, PDO::PARAM_INT);
    $ok = $statement1->execute();

    $query2 = "DELETE FROM smaken WHERE id=:id";
    $statement2 = $pdo->prepare($query2);
    $statement2->bindValue(":id", $id, PDO::PARAM_INT);
    $ok = $statement2->execute();

    $deleted = $statement2->rowCount() == 1;

    return $deleted;
}