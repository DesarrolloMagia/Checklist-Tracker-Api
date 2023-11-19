$(document).ready(function () {
    // Función para manejar la creación de tareas
    $("#btn-crear-editar").click(function (e) {
        e.preventDefault();

        var formData = $("#tarea-form").serializeArray();
        formData.push({ name: 'action', value: 'createTask' });

        $.ajax({
            url: '../api.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function (response) {
                alert(response.message);
                // Actualizar la vista si es necesario
            },
            error: function (error) {
                console.error('Error en la solicitud AJAX:', error);
            }
        });
    });

    // Función para manejar la eliminación de tareas
    $(".btn-eliminar").click(function (e) {
        e.preventDefault();

        var taskId = $(this).data('task-id');
        var formData = { action: 'deleteTask', id: taskId };

        $.ajax({
            url: '../api.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function (response) {
                alert(response.message);
                // Actualizar la vista si es necesario
            },
            error: function (error) {
                console.error('Error en la solicitud AJAX:', error);
            }
        });
    });

    // Función para cargar todas las tareas
    $("#btn-cargar-tareas").click(function (e) {
        e.preventDefault();

        $.ajax({
            url: '../api.php?action=getTasks',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    // Procesar las tareas obtenidas y actualizar la vista
                    console.log(response.data);
                } else {
                    alert('Error al obtener las tareas');
                }
            },
            error: function (error) {
                console.error('Error en la solicitud AJAX:', error);
            }
        });
    });
});
