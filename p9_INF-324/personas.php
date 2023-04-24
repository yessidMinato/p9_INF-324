<?php
include 'conexion.php';

// Establecer conexión a la base de datos
$pdo = new conexion();

// Verificar el método HTTP utilizado
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Si se utiliza GET
    if (isset($_GET["ci"])) {
        $sql = $pdo->prepare("SELECT * FROM persona WHERE ci=:ci");
        $sql->bindValue(":ci", $_GET["ci"]);
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        header("HTTP/1.1 200 Tengo datos");
        echo json_encode($sql->fetchAll());
        exit;   
    }
  
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Si se utiliza POST
    // Verificar si se incluyen los datos necesarios en la petición
    if(isset($_POST["ci"]) && isset($_POST["nombreCompleto"]) && isset($_POST["fechaNaci"]) && isset($_POST["telefono"]) && isset($_POST["departamento"])) {
        $sql = $pdo->prepare("INSERT INTO persona(ci, nombreCompleto, fechaNaci,telefono,departamento) VALUES (:ci, :nombreCompleto, :fechaNaci, :telefono,:departamento)");
        $sql->bindValue(":ci", $_POST["ci"]);
        $sql->bindValue(":nombreCompleto", $_POST["nombreCompleto"]);
        $sql->bindValue(":fechaNaci", $_POST["fechaNaci"]);
        $sql->bindValue(":telefono", $_POST["telefono"]);
        $sql->bindValue(":departamento", $_POST["departamento"]);
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
  
} elseif ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    // Verificar si se proporcionaron los datos necesarios en la solicitud
    if (isset($_GET['ci']) && isset($_POST['nombreCompleto']) && isset($_POST['fechaNaci']) && isset($_POST['telefono']) && isset($_POST['departamento'])) {
      $CI = $_GET['ci'];
      $nombreCompleto = $_POST['nombreCompleto'];
      $fechaNaci = $_POST['fechaNaci'];
      $telefono = $_POST['telefono'];
      $departamento = $_POST['departamento'];
      $sql = $pdo->prepare("UPDATE Persona SET CI=:CI, nombreCompleto=:nombreCompleto, fechaNaci=:fechaNaci, telefono=:telefono, departamento=:departamento WHERE ci=:ci");
      $sql->bindParam(':CI', $CI);
      $sql->bindParam(':nombreCompleto', $nombreCompleto);
      $sql->bindParam(':fechaNaci', $fechaNaci);
      $sql->bindParam(':telefono', $telefono);
      $sql->bindParam(':departamento', $departamento);
      $sql->execute();
      header('HTTP/1.1 200 OK');
      echo json_encode(array('mensaje' => 'Datos de la persona actualizados correctamente.'));
      exit;
    } else {
      // Si faltan datos necesarios, responder con un error
      header('HTTP/1.1 400 Bad Request');
      echo json_encode(array('error' => 'Faltan datos necesarios en la solicitud.'));
      exit;
    }
  }
  if($_SERVER["REQUEST_METHOD"] == "DELETE") {
    $sql = $pdo->prepare("DELETE FROM persona WHERE ci=:ci");
    $sql->bindValue(":ci", $_GET["ci"]);
    $sql->execute();
    header("HTTP/1.1 200 OK");
    exit;
}

  
