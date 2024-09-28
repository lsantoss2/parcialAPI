<?php
include_once 'db.php';
include_once 'vehiculo.php';

$database = new Database();
$db = $database->getConnection();

$vehiculo = new vehiculo($db);

$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
    case 'GET':
        // Verifica si existe un ID en los parámetros de la URL
        if (isset($_GET['id'])) {
            $vehiculo->idvehiculo = $_GET['id'];
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
            // Obtener datos JSON
            $data = json_decode(file_get_contents("php://input"));
            
            // Agregar mensajes de depuración
            if ($data === null) {
                echo json_encode(array("message" => "No se recibieron datos o el formato es incorrecto."));
                exit;
            }
        
            // Mapear datos
            $vehiculo->idColor = $data->idcolor ?? null;
            $vehiculo->idMarca = $data->idmarca ?? null;
            $vehiculo->modelo = $data->modelo ?? null;
            $vehiculo->chasis = $data->chasis ?? null;
            $vehiculo->motor = $data->motor ?? null;
            $vehiculo->nombre = $data->nombre ?? null;
            $vehiculo->activo = $data->activo ?? null;
        
            // Verificar si los datos fueron mapeados correctamente
            if (!$vehiculo->idColor || !$vehiculo->idMarca || !$vehiculo->modelo || !$vehiculo->chasis || !$vehiculo->motor || !$vehiculo->nombre || !$vehiculo->activo) {
                echo json_encode(array("message" => "Datos incompletos."));
                exit;
            }
        
            // Intentar crear el vehículo
            if ($vehiculo->crear()) {
                echo json_encode(array("message" => "Vehículo creado."));
            } else {
                echo json_encode(array("message" => "Error al crear vehículo."));
            }
            break;
        
    case 'PUT':
        // Actualizar un vehículo existente
        $data = json_decode(file_get_contents("php://input"));
        $vehiculo->idvehiculo = $data->idvehiculo;
        $vehiculo->idcolor = $data->idcolor;
        $vehiculo->idmarca = $data->idmarca;
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
        $vehiculo->idvehiculo = $data->idvehiculo;

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
