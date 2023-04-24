<?php
include "conexion.php";
$pdo = new conexion();


if($_SERVER["REQUEST_METHOD"]=="GET") {
    if (isset($_GET["ci"])) {
        $sql = $pdo->prepare("SELECT * FROM usuario WHERE ci=:ci");
        $sql->bindValue(":ci", $_GET["ci"]);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        header("HTTP/1.1 200 Tengo datos");
        echo json_encode($sql->fetchAll());
        exit;   
    }
    else {
        $sql = $pdo->prepare("SELECT * FROM usuario");
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        header("HTTP/1.1 200 Tengo datos");
        echo json_encode($sql->fetchAll());
        exit;   
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Comprobar si los datos necesarios existen en la petición
    if(isset($_POST["ci"]) && isset($_POST["usuario"]) && isset($_POST["password"])) {
        $sql = $pdo->prepare("INSERT INTO usuario(ci, usuario, password) VALUES (:ci, :usuario, :password)");
        $sql->bindValue(":ci", $_POST["ci"]);
        $sql->bindValue(":usuario", $_POST["usuario"]);
        $sql->bindValue(":password", $_POST["password"]);
        $sql->execute();
        $ci = $_POST["ci"];
        header("HTTP/1.1 201 Created");
        echo json_encode(array("ci"=>$ci));
        exit;
    } 
    else {
        // Si faltan datos necesarios, responder con un error
        header("HTTP/1.1 400 Bad Request");
        echo json_encode(array("error"=>"Faltan datos necesarios en la petición"));
        exit;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "PUT") {
    // Comprobar si los datos necesarios existen en la petición
    if(isset($_GET["ci"]) && isset($_POST["usuario"]) && isset($_POST["password"])) {
        $sql = $pdo->prepare("UPDATE usuario SET usuario=:usuario, password=:password WHERE ci=:ci");
        $sql->bindValue(":ci", $_GET["ci"]);
        $sql->bindValue(":usuario", $_POST["usuario"]);
        $sql->bindValue(":password", $_POST["password"]);
        $sql->execute();
        header("HTTP/1.1 200 OK");
        exit;
    } 
    else {
        // Si faltan datos necesarios, responder con un error
        header("HTTP/1.1 400 Bad Request");
        echo json_encode(array("error"=>"Faltan datos necesarios en la petición"));
        exit;
    }
}

if($_SERVER["REQUEST_METHOD"] == "DELETE") {
    $sql = $pdo->prepare("DELETE FROM usuario WHERE ci=:ci");
    $sql->bindValue(":ci", $_GET["ci"]);
    $sql->execute();
    header("HTTP/1.1 200 OK");
    exit;
}

// Si no se encontró una coincidencia con los métodos HTTP anteriores, responder con un error
header("HTTP/1.1 405 Method Not Allowed");
echo json_encode(array("error"=>"Método HTTP no permitido"));
exit;
?>
