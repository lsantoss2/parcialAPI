<?php
// Archivo index.php

// Mostrar errores (solo para desarrollo, en producción es recomendable desactivarlo)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Puedes redirigir a la página principal o manejar la solicitud directamente desde aquí.
// Si todo tu API está manejado por api.php, puedes incluirlo directamente aquí.

require 'api.php';

// O si prefieres redirigir la solicitud:
header("Location: /api.php");
exit;
?>
