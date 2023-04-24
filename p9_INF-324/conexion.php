<?php
class conexion extends PDO 
{
  private $servidor="localhost";
  private $usuario="yessid";
  private $clave="123456";
  private $basedatos="mibaseyessid";
    
  public function __construct()
  {

    try
    {
      parent::__construct("mysql:host=".$this->servidor.";dbname=".$this->basedatos.";charset=utf8",$this->usuario,$this->clave,array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
    }
    catch (PDOException $e)
    {
      echo "Error: ".$e->getMessage();
      exit;
    }
  }
}
?>