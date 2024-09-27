<?php
include_once 'db.php';
include_once 'vehiculo.php';

$database = new Database();
$db = $database->getConnection();

$vehiculo = new Vehiculo($db);

$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'GET':
        // Verifica si existe un ID en los parámetros de la URL
        if (isset($_GET['id'])) {
            $vehiculo->idVehiculo = $_GET['id'];
            $stmt = $vehiculo->buscarPorId(); // Usamos la función buscarPorId
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                echo json_encode($row);
            } else {
                echo json_encode(array("message" => "Vehículo no encontrado."));
            }
        } else {
            // Obtener todos los vehículos si no se pasa el parámetro ID
            $stmt = $vehiculo->leer();
            $vehiculos_arr = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                array_push($vehiculos_arr, $row);
            }
            echo json_encode($vehiculos_arr);
        }
        break;

    case 'POST':
        // Crear un nuevo vehículo
        $data = json_decode(file_get_contents("php://input"));
        $vehiculo->idColor = $data->idColor;
        $vehiculo->idMarca = $data->idMarca;
        $vehiculo->modelo = $data->modelo;
        $vehiculo->chasis = $data->chasis;
        $vehiculo->motor = $data->motor;
        $vehiculo->nombre = $data->nombre;
        $vehiculo->carnet = $data->carnet;
        $vehiculo->activo = $data->activo;

        if ($vehiculo->crear()) {
            echo json_encode(array("message" => "Vehículo creado."));
        } else {
            echo json_encode(array("message" => "Error al crear vehículo."));
        }
        break;

    case 'PUT':
        // Actualizar un vehículo existente
        $data = json_decode(file_get_contents("php://input"));
        $vehiculo->idVehiculo = $data->idVehiculo;
        $vehiculo->idColor = $data->idColor;
        $vehiculo->idMarca = $data->idMarca;
        $vehiculo->modelo = $data->modelo;
        $vehiculo->chasis = $data->chasis;
        $vehiculo->motor = $data->motor;
        $vehiculo->nombre = $data->nombre;
        $vehiculo->carnet = $data->carnet;
        $vehiculo->activo = $data->activo;

        if ($vehiculo->actualizar()) {
            echo json_encode(array("message" => "Vehículo actualizado."));
        } else {
            echo json_encode(array("message" => "Error al actualizar el vehículo."));
        }
        break;

    case 'DELETE':
        // Eliminar un vehículo
        $data = json_decode(file_get_contents("php://input"));
        $vehiculo->idVehiculo = $data->idVehiculo;

        if ($vehiculo->eliminar()) {
            echo json_encode(array("message" => "Vehículo eliminado."));
        } else {
            echo json_encode(array("message" => "Error al eliminar el vehículo."));
        }
        break;

    default:
        // Método no soportado
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}
?>
