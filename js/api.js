$(document).ready(function () {
    // Obtener datos de la API al cargar la página
    $.ajax({
        url: 'api.php',
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            // Procesar y mostrar los datos en la página
            mostrarDatos(data);
        },
        error: function (error) {
            console.error('Error al obtener datos de la API:', error);
        }
    });

    // Función para mostrar los datos en la página
    function mostrarDatos(tareas) {
        // Limpiar contenedores existentes
        $('#pendientes').empty();
        $('#procesos').empty();
        $('#completados').empty();

        // Verificar si hay tareas en cada estado y mostrar mensaje apropiado
        if (tareas.length === 0) {
            $('#pendientes').html('<p>No hay tareas pendientes.</p>');
            $('#procesos').html('<p>No hay tareas en proceso.</p>');
            $('#completados').html('<p>No hay tareas completadas.</p>');
            return;
        }

        // Iterar sobre las tareas y mostrarlas en los contenedores correspondientes
        $.each(tareas, function (index, tarea) {
            var tareaHTML = '<div class="tarea" draggable="true" ondragstart="drag(event)" id="tarea-' + tarea.id + '" data-estado="' + tarea.estado + '">';
            tareaHTML += '<p>Nombre: ' + tarea.nombre + '</p>';
            tareaHTML += '<p>Descripción: ' + tarea.descripcion + '</p>';
            tareaHTML += '<p>Fecha de Compromiso: ' + tarea.fecha_compromiso + '</p>';
            tareaHTML += '<p>Hora de Culminación: ' + tarea.hora_culminacion + '</p>';
            tareaHTML += '<p>Prioridad: ' + tarea.prioridad + '</p>';
            tareaHTML += '<p>Responsable: ' + tarea.responsable + '</p>';
            if (tarea.edited == 1) {
                tareaHTML += '<p><strong>Edited</strong></p>';
            }
            tareaHTML += '<a href="./app/Edit.php?id=' + tarea.id + '" class="btn-editar">Editar</a>';
            tareaHTML += '<a href="./app/Delete.php?id=' + tarea.id + '" class="btn-eliminar">Eliminar</a>';
            tareaHTML += '</div>';

            // Agregar tarea al contenedor correspondiente según su estado
            if (tarea.estado === 'Pendiente') {
                $('#pendientes').append(tareaHTML);
            } else if (tarea.estado === 'En Proceso') {
                $('#procesos').append(tareaHTML);
            } else if (tarea.estado === 'Completado') {
                $('#completados').append(tareaHTML);
            }
        });
    }
});
