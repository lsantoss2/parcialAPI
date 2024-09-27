<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'db.php';

class Vehiculo {
    private $conn;
    private $table_name = "Vehiculos";

    public $idVehiculo;
    public $idColor;
    public $idMarca;
    public $modelo;
    public $chasis;
    public $motor;
    public $nombre;
    public $carnet;
    public $activo;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Función para crear un nuevo vehículo
    public function crear() {
        $query = "INSERT INTO " . $this->table_name . " SET
            idColor=:idColor, idMarca=:idMarca, modelo=:modelo, chasis=:chasis, motor=:motor, nombre=:nombre, carnet=:carnet, activo=:activo";
        
        $stmt = $this->conn->prepare($query);

        // Sanitizar datos
        $this->idColor = htmlspecialchars(strip_tags($this->idColor));
        $this->idMarca = htmlspecialchars(strip_tags($this->idMarca));
        $this->modelo = htmlspecialchars(strip_tags($this->modelo));
        $this->chasis = htmlspecialchars(strip_tags($this->chasis));
        $this->motor = htmlspecialchars(strip_tags($this->motor));
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->carnet = htmlspecialchars(strip_tags($this->carnet));
        $this->activo = htmlspecialchars(strip_tags($this->activo));

        // Enlazar los valores
        $stmt->bindParam(":idColor", $this->idColor);
        $stmt->bindParam(":idMarca", $this->idMarca);
        $stmt->bindParam(":modelo", $this->modelo);
        $stmt->bindParam(":chasis", $this->chasis);
        $stmt->bindParam(":motor", $this->motor);
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":carnet", $this->carnet);
        $stmt->bindParam(":activo", $this->activo);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Función para obtener todos los vehículos
    public function leer() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Función para buscar un vehículo por ID
    public function buscarPorId() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE idVehiculo = :idVehiculo";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idVehiculo', $this->idVehiculo);
        $stmt->execute();
        return $stmt;
    }

    // Función para actualizar un vehículo
    public function actualizar() {
        $query = "UPDATE " . $this->table_name . " 
                  SET idColor = :idColor, idMarca = :idMarca, modelo = :modelo, chasis = :chasis, 
                      motor = :motor, nombre = :nombre, carnet = :carnet, activo = :activo
                  WHERE idVehiculo = :idVehiculo";
    
        $stmt = $this->conn->prepare($query);
    
        // Sanitizar los datos
        $this->idColor = htmlspecialchars(strip_tags($this->idColor));
        $this->idMarca = htmlspecialchars(strip_tags($this->idMarca));
        $this->modelo = htmlspecialchars(strip_tags($this->modelo));
        $this->chasis = htmlspecialchars(strip_tags($this->chasis));
        $this->motor = htmlspecialchars(strip_tags($this->motor));
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->carnet = htmlspecialchars(strip_tags($this->carnet));
        $this->activo = htmlspecialchars(strip_tags($this->activo));
        $this->idVehiculo = htmlspecialchars(strip_tags($this->idVehiculo));
    
        // Enlazar los valores
        $stmt->bindParam(":idColor", $this->idColor);
        $stmt->bindParam(":idMarca", $this->idMarca);
        $stmt->bindParam(":modelo", $this->modelo);
        $stmt->bindParam(":chasis", $this->chasis);
        $stmt->bindParam(":motor", $this->motor);
        $stmt->bindParam(":nombre", $this->nombre);
        $stmt->bindParam(":carnet", $this->carnet);
        $stmt->bindParam(":activo", $this->activo);
        $stmt->bindParam(":idVehiculo", $this->idVehiculo);
    
        // Ejecutar la consulta
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Función para eliminar un vehículo
    public function eliminar() {
        $query = "DELETE FROM " . $this->table_name . " WHERE idVehiculo = :idVehiculo";
    
        $stmt = $this->conn->prepare($query);
    
        // Sanitizar el dato
        $this->idVehiculo = htmlspecialchars(strip_tags($this->idVehiculo));
    
        // Enlazar el valor
        $stmt->bindParam(":idVehiculo", $this->idVehiculo);
    
        // Ejecutar la consulta
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
