<?php 

require_once('../../include/database.php');

function getProducten(PDO $pdo){
    $query =    "SELECT producten.id AS id, 
                producten.naam AS naam, 
                producten.inhoud, producten.percentage, 
                producten.prijs, stijlen.naam AS stijlen_naam, 
                stijlen.id AS stijlen_id, brouwers.naam AS brouwers_naam 
                FROM producten 
                JOIN stijlen 
                ON producten.id_stijl = stijlen.id 
                LEFT JOIN brouwers 
                ON producten.id_brouwer = brouwers.id
                GROUP BY producten.id";

    $statement = $pdo->prepare($query);
    $ok = $statement->execute();
    $producten = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $producten;
}

function getProduct(PDO $pdo, $id) {
    $query = "SELECT * FROM producten WHERE id = :id";

    $statement = $pdo->prepare($query);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);

    statementExecute($statement);

    return $statement->fetch(PDO::FETCH_ASSOC);
}

function getProductSmaak(PDO $pdo, $id) {
    $query = "SELECT id_smaak FROM product_smaak WHERE id_product = :id";
    $statement = $pdo->prepare($query);

    $statement->bindValue(':id', $id, PDO::PARAM_INT);

    statementExecute($statement);

    return $statement->fetchAll(PDO::FETCH_COLUMN);
}

function id_stijlExists(PDO $pdo, $product) {
    return idExists($pdo, $product["id_stijl"], "stijlen");
}

function id_brouwerExists(PDO $pdo, $product) {
    return idExists($pdo, $product["id_brouwer"], "brouwers");
}

function saveProduct(PDO $pdo, $product) {
    $query =    "INSERT INTO producten (naam, beschrijving, inhoud, percentage, prijs, id_stijl, id_brouwer) 
                VALUES (:naam, :beschrijving, :inhoud, :percentage, :prijs, :id_stijl, :id_brouwer)";
    $statement = $pdo->prepare($query);

    $statement->bindValue(':naam', $product["naam"], PDO::PARAM_STR);
    $statement->bindValue(':beschrijving', $product["beschrijving"], PDO::PARAM_STR);
    $statement->bindValue(':inhoud', $product["inhoud"], PDO::PARAM_INT);
    $statement->bindValue(':percentage', $product["percentage"], PDO::PARAM_STR);
    $statement->bindValue(':prijs', $product["prijs"], PDO::PARAM_STR);
    $statement->bindValue(':id_stijl', $product["id_stijl"], PDO::PARAM_INT);
    $statement->bindValue(':id_brouwer', $product["id_brouwer"], PDO::PARAM_INT);

    $ok = $statement->execute();
    $id = $pdo->lastInsertId();

    if (!$ok) {
        $info = $statement->errorInfo();
        var_dump($product["id_brouwer"]);
        die($info[2]);
    }
    return $id;
}

function saveIdSmaken(PDO $pdo, $id, $product) {
    $query = "INSERT INTO product_smaak (id_product, id_smaak) VALUES (:id_product, :id_smaak)";
    $statement = $pdo->prepare($query);

    $statement->bindValue(':id_product', $id, PDO::PARAM_INT);
    $statement->bindParam(':id_smaak', $id_smaak, PDO::PARAM_INT);

    foreach ($product["id_smaken"] as $id_smaak) {
        statementExecute($statement);
    }
}

function updateProduct(PDO $pdo, $newData, $id) {
    $query =    "UPDATE producten SET naam=:naam, beschrijving=:beschrijving, inhoud=:inhoud, percentage=:percentage, 
                prijs=:prijs, id_stijl=:id_stijl, id_brouwer=:id_brouwer WHERE id=:id";
    $statement = $pdo->prepare($query);

    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->bindValue(':naam', $newData["naam"], PDO::PARAM_STR);
    $statement->bindValue(':beschrijving', $newData["beschrijving"], PDO::PARAM_STR);
    $statement->bindValue(':inhoud', $newData["inhoud"], PDO::PARAM_INT);
    $statement->bindValue(':percentage', $newData["percentage"], PDO::PARAM_STR);
    $statement->bindValue(':prijs', $newData["prijs"], PDO::PARAM_STR);
    $statement->bindValue(':id_stijl', $newData["id_stijl"], PDO::PARAM_INT);
    $statement->bindValue(':id_brouwer', $newData["id_brouwer"], PDO::PARAM_INT);

    statementExecute($statement);

    return $statement->rowCount();
}

function updateIdSmaken(PDO $pdo, $id, $newData) {
    $query = "UPDATE product_smaak SET id_smaak=:id_smaak WHERE id_product=:id_product";
    $statement = $pdo->prepare($query);

    $statement->bindValue(':id_smaak', $newData["id_smaak"], PDO::PARAM_INT);
    $statement->bindValue(':id_product', $id, PDO::PARAM_INT);

    statementExecute($statement);

    return $statement->rowCount();
}   

function deleteProduct(PDO $pdo, $id) {
    $query1 = "DELETE FROM product_smaak WHERE id_product=:id";
    $statement1 = $pdo->prepare($query1);
    $statement1->bindValue(':id', $id, PDO::PARAM_INT);

    statementExecute($statement1);

    $query2 = "DELETE FROM producten WHERE id=:id"; 

    $statement2 = $pdo->prepare($query2);
    $statement2->bindValue(':id', $id, PDO::PARAM_INT);

    statementExecute($statement2);

    $deleted = $statement2->rowCount() == 1;

    return $deleted;
}

function deleteProductCheck(PDO $pdo, $id) {
    $query =    "SELECT count(bestelling_product.id_product) AS aantal_bestellingen 
                FROM producten 
                LEFT JOIN bestelling_product 
                ON producten.id=bestelling_product.id_product
                WHERE producten.id = :id
                GROUP BY producten.id";

    $statement = $pdo->prepare($query);

    $statement->bindValue(":id", $id, PDO::PARAM_INT);
    $ok = $statement->execute();

    if (!$ok) {
        return ['aantal_bestellingen' => 27];
    } else {
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}