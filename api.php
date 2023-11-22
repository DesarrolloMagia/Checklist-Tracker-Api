<?php
require 'Connect.php';

// Verificar el método de solicitud
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Obtener todas las tareas
    $sql = "SELECT * FROM tareas";
    $stmt = $conn->query($sql);
    $tareas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($tareas);

} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Crear una nueva tarea
    $data = json_decode(file_get_contents("php://input"), true);

    $nombre = $data['nombre'];
    $descripcion = $data['descripcion'];
    $fechaCompromiso = $data['fecha_compromiso'];
    $horaCulminacion = $data['hora_culminacion'];
    $prioridad = $data['prioridad'];
    $responsable = $data['responsable'];

    $sql = "INSERT INTO tareas (nombre, descripcion, fecha_compromiso, hora_culminacion, prioridad, responsable, estado)
            VALUES ('$nombre', '$descripcion', '$fechaCompromiso', '$horaCulminacion', '$prioridad', '$responsable', 'Pendiente')";
    
    try {
        $conn->exec($sql);
        echo json_encode(['message' => 'Tarea creada con éxito']);

    } catch (PDOException $e) {
        echo json_encode(['error' => 'Error al crear la tarea: ' . $e->getMessage()]);
    }

}  elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Actualizar una tarea existente
    $data = json_decode(file_get_contents("php://input"), true);

    $taskId = $data['id'];
    $estado = $data['estado'];

    $sql = "UPDATE tareas 
            SET estado=?
            WHERE id=?";

    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute([$estado, $taskId]);
        echo json_encode(['message' => 'Tarea actualizada con éxito']);

    } catch (PDOException $e) {
        echo json_encode(['error' => 'Error al actualizar la tarea: ' . $e->getMessage()]);
    }

} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Eliminar una tarea
    $data = json_decode(file_get_contents("php://input"), true);
    $taskId = $data['id'];

    $sql = "DELETE FROM tareas WHERE id=$taskId";

    try {
        $conn->exec($sql);
        echo json_encode(['message' => 'Tarea eliminada con éxito']);

    } catch (PDOException $e) {
        echo json_encode(['error' => 'Error al eliminar la tarea: ' . $e->getMessage()]);
    }
}
?>
