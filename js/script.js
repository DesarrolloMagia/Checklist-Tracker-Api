function updateTaskStatus(taskId, newStatus) {
    $.ajax({
        url: 'api.php',
        method: 'PUT',
        contentType: 'application/json',
        data: JSON.stringify({
            id: taskId,
            estado: newStatus
        }),
        success: function(response) {
            console.log("Tarea actualizada con éxito.");
            // Aquí puedes actualizar solo la parte de la interfaz que ha cambiado en lugar de recargar toda la página
            // Por ejemplo, puedes mover el elemento en la interfaz según el nuevo estado
        },
        error: function(error) {
            console.error("Error al actualizar la tarea:", error);
        }
    });
}

$(document).ready(function() {
    $(".kanban-block").sortable({
        connectWith: ".kanban-block",
        update: function(event, ui) {
            var taskId = ui.item.attr("id").split("-")[1]; // Obtiene el ID de la tarea
            var targetKanbanBlock = ui.item.parent().attr("id");

            // Obtiene el estado actual de la tarea
            var currentState = ui.item.data("estado");
            var newStatus; // Inicializa newStatus

            if (targetKanbanBlock === "pendientes") {
                newStatus = 'Pendiente';
            } else if (targetKanbanBlock === "procesos" && currentState !== 'En Proceso') {
                newStatus = 'En Proceso';
            } else if (targetKanbanBlock === "completados" && currentState !== 'Completado') {
                newStatus = 'Completado';
            }

            if (newStatus) {
                updateTaskStatus(taskId, newStatus);
                console.log("taskId: " + taskId);
                console.log("targetKanbanBlock: " + targetKanbanBlock);
                console.log("currentState: " + currentState);
                console.log("newStatus: " + newStatus);
            }
        }
    });

    $(".kanban-block").disableSelection();
});
