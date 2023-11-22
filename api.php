<?php
header("Content-Type: application/json");
 
require '../Connect.php';
 
// Función para manejar las respuestas
function sendResponse($status, $message, $data = null)
{
    $response = array(
        'status' => $status,
        'message' => $message,
        'data' => $data
    );
    echo json_encode($response);
    exit;
}
 
// Endpoint para crear una tarea
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'createTask') {
    $nombre = $_POST['tarea-nombre'];
    $descripcion = $_POST['tarea-descripcion'];
    $fecha_compromiso = $_POST['fecha-de-compromiso'];
    $hora_culminacion = $_POST['hora-culminacion'];
    $prioridad = $_POST['tarea-prioridad'];
    $responsable = $_POST['tarea-responsable'];
 
    // Validación de campos (puedes agregar más validaciones según sea necesario)
    if (empty($nombre) || empty($fecha_compromiso) || empty($prioridad) || empty($responsable)) {
        sendResponse('error', 'Todos los campos son obligatorios');
    }
 
    $stmt = $conn->prepare("INSERT INTO tareas (nombre, descripcion, fecha_compromiso, hora_culminacion, prioridad, responsable) VALUES (?, ?, ?, ?, ?, ?)");
    $res = $stmt->execute([$nombre, $descripcion, $fecha_compromiso, $hora_culminacion, $prioridad, $responsable]);
 
    if ($res) {
        sendResponse('success', 'Tarea creada con éxito');
    } else {
        sendResponse('error', 'Error al crear la tarea');
    }
}
 
// Endpoint para eliminar una tarea
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'deleteTask') {
    $id = $_POST['id'];
 
    // Validación de campos (puedes agregar más validaciones según sea necesario)
    if (!is_numeric($id)) {
        sendResponse('error', 'ID de tarea no válido');
    }
 
    $sql = "DELETE FROM tareas WHERE id = ?";
    $stmt = $conn->prepare($sql);
 
    if ($stmt->execute([$id])) {
        sendResponse('success', 'Tarea eliminada con éxito');
    } else {
        sendResponse('error', 'Error al eliminar la tarea');
    }
}
 
// Endpoint para actualizar una tarea
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'updateTask') {
    $id = $_POST['id'];
    $nombre = $_POST['tarea-nombre'];
    $descripcion = $_POST['tarea-descripcion'];
    $fecha_compromiso = $_POST['fecha-de-compromiso'];
    $prioridad = $_POST['tarea-prioridad'];
    $responsable = $_POST['tarea-responsable'];
 
    // Validación de campos (puedes agregar más validaciones según sea necesario)
    if (!is_numeric($id) || empty($nombre) || empty($fecha_compromiso) || empty($prioridad) || empty($responsable)) {
        sendResponse('error', 'Datos de tarea no válidos');
    }
 
    $sql = "UPDATE tareas SET nombre = ?, descripcion = ?, fecha_compromiso = ?, prioridad = ?, responsable = ?, edited = 1 WHERE id = ?";
    $stmt = $conn->prepare($sql);
 
    if ($stmt->execute([$nombre, $descripcion, $fecha_compromiso, $prioridad, $responsable, $id])) {
        sendResponse('success', 'Tarea actualizada con éxito');
    } else {
        sendResponse('error', 'Error al actualizar la tarea');
    }
}
 
// Endpoint para obtener todas las tareas
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['action']) && $_GET['action'] == 'getTasks') {
    $sql = "SELECT * FROM tareas";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $tareas = $stmt->fetchAll(PDO::FETCH_ASSOC);
 
    sendResponse('success', 'Tareas obtenidas con éxito', $tareas);
}
 
// Si no se encuentra ninguna acción válida
sendResponse('error', 'Acción no válida');
?>