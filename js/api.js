// Función para crear una nueva tarea
function createTask() {
    // Obtener los valores del formulario
    var nombre = $('#tarea-nombre').val();
    var descripcion = $('#tarea-descripcion').val();
    var fechaCompromiso = $('#fecha-de-compromiso').val();
    var horaCulminacion = $('#hora-culminacion').val();
    var prioridad = $('#tarea-prioridad').val();
    var responsable = $('#tarea-responsable').val();

    // Validar campos (puedes agregar más validaciones según sea necesario)
    if (!nombre || !fechaCompromiso || !prioridad || !responsable) {
        alert('Todos los campos son obligatorios');
        return;
    }

    // Enviar solicitud al servidor
    $.ajax({
        type: 'POST',
        url: './app/api.php',
        data: {
            action: 'createTask',
            'tarea-nombre': nombre,
            'tarea-descripcion': descripcion,
            'fecha-de-compromiso': fechaCompromiso,
            'hora-culminacion': horaCulminacion,
            'tarea-prioridad': prioridad,
            'tarea-responsable': responsable
        },
        success: function (response) {
            if (response.status === 'success') {
                alert('Tarea creada con éxito');
                // Puedes realizar otras acciones después de crear la tarea, si es necesario
            } else {
                alert('Error al crear la tarea');
            }
        },
        error: function () {
            alert('Error de conexión');
        }
    });
}

// Función para eliminar una tarea
function deleteTask(id) {
    // Confirmar la eliminación
    var confirmDelete = confirm('¿Estás seguro de que quieres eliminar esta tarea?');

    if (!confirmDelete) {
        return;
    }

    // Enviar solicitud al servidor
    $.ajax({
        type: 'POST',
        url: './app/api.php',
        data: {
            action: 'deleteTask',
            id: id
        },
        success: function (response) {
            if (response.status === 'success') {
                alert('Tarea eliminada con éxito');
                // Puedes realizar otras acciones después de eliminar la tarea, si es necesario
            } else {
                alert('Error al eliminar la tarea');
            }
        },
        error: function () {
            alert('Error de conexión');
        }
    });
}

// Función para actualizar una tarea
function updateTask(id) {
    // Obtener los valores del formulario
    var nombre = $('#tarea-nombre').val();
    var descripcion = $('#tarea-descripcion').val();
    var fechaCompromiso = $('#fecha-de-compromiso').val();
    var prioridad = $('#tarea-prioridad').val();
    var responsable = $('#tarea-responsable').val();

    // Validar campos (puedes agregar más validaciones según sea necesario)
    if (!nombre || !fechaCompromiso || !prioridad || !responsable) {
        alert('Datos de tarea no válidos');
        return;
    }

    // Enviar solicitud al servidor
    $.ajax({
        type: 'POST',
        url: './app/api.php',
        data: {
            action: 'updateTask',
            id: id,
            'tarea-nombre': nombre,
            'tarea-descripcion': descripcion,
            'fecha-de-compromiso': fechaCompromiso,
            'tarea-prioridad': prioridad,
            'tarea-responsable': responsable
        },
        success: function (response) {
            if (response.status === 'success') {
                alert('Tarea actualizada con éxito');
                // Puedes realizar otras acciones después de actualizar la tarea, si es necesario
            } else {
                alert('Error al actualizar la tarea');
            }
        },
        error: function () {
            alert('Error de conexión');
        }
    });
}

// Función para obtener todas las tareas
function getTasks() {
    // Enviar solicitud al servidor
    $.ajax({
        type: 'GET',
        url: './app/api.php?action=getTasks',
        success: function (response) {
            if (response.status === 'success') {
                // Manejar la respuesta y mostrar las tareas en el front-end
                displayTasks(response.data);
            } else {
                alert('Error al obtener las tareas');
            }
        },
    });
}

// Función para mostrar las tareas en el front-end
function displayTasks(tasks) {
    // Limpiar el contenedor de tareas antes de agregar las nuevas
    $('#pendientes').empty();
    $('#procesos').empty();
    $('#completados').empty();

    // Iterar sobre las tareas y agregarlas a los bloques correspondientes
    tasks.forEach(function (task) {
        var taskHtml =
            '<div class="tarea" draggable="true" ondragstart="drag(event)" id="tarea-' +
            task.id +
            '">' +
            '<p>Nombre: ' +
            task.nombre +
            '</p>' +
            '<p>Descripción: ' +
            task.descripcion +
            '</p>' +
            '<p>Fecha de Compromiso: ' +
            task.fecha_compromiso +
            '</p>' +
            '<p>Prioridad: ' +
            task.prioridad +
            '</p>' +
            '<p>Responsable: ' +
            task.responsable +
            '</p>' +
            '<a href="./app/Edit.php?id=' +
            task.id +
            '" class="btn-editar">Editar</a>' +
            '<a href="#" onclick="deleteTask(' +
            task.id +
            ')" class="btn-eliminar">Eliminar</a>' +
            '</div>';

        // Agregar la tarea al bloque correspondiente según el estado
        if (task.estado === 'Pendiente') {
            $('#pendientes').append(taskHtml);
        } else if (task.estado === 'En Proceso') {
            $('#procesos').append(taskHtml);
        } else if (task.estado === 'Completado') {
            $('#completados').append(taskHtml);
        }
    });
}

// Llamada inicial para obtener tareas al cargar la página
getTasks();
