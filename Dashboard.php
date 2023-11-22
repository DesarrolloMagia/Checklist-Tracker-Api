<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Checklist Tracker</title>
    <link rel="stylesheet" href="./css/estilos.css">
</head>

<body>

    <nav class="navbar">
        <ul class="navbar-list">
            <li class="navbar-item"><a class="button-link" href="Report.php">Reportes</a></li>
            <li class="navbar-item"><a class="button-link-cerrar" href="Logout.php"></a></li>
        </ul>
    </nav>

    <div class="container">
        <div class="kanban-head">
            <strong class="kanban-head-title">Mi lista de Control</strong>
        </div>

        <div class="kanban-table">
            <div class="kanban-form-container">
                <form id="kanban-form" action="app/Crear.php" method="POST">
                    <div class="kanban-form">
                        <strong class="kanban-form-title">Tarea</strong>
                        <div class="container-inputs">
                            <strong class="strong-input">Nombre Tarea: </strong>
                            <input type="text" name="tarea-nombre" class="input-text">
                            <strong class="strong-input">Descripción Tarea: </strong>
                            <textarea name="tarea-descripcion" class="textarea-text" rows="4"></textarea>
                            <strong class="strong-input">Fecha de Compromiso: </strong>
                            <input type="date" name="fecha-de-compromiso">
                            <strong class="strong-input">Hora de Culminación: </strong>
                            <input type="time" name="hora-culminacion">
                            <strong class="strong-input">Prioridad: </strong>
                            <select name="tarea-prioridad">
                                <option value="" disabled selected>Selecione una Prioridad</option>
                                <option value="Baja">Baja</option>
                                <option value="Media">Media</option>
                                <option value="Alta">Alta</option>
                            </select>
                            <strong class="strong-input">Responsable de Tarea: </strong>
                            <input type="text" name="tarea-responsable" class="input-text">
                        </div>
                        <?php if (isset($_GET['mess']) && $_GET['mess'] == 'error') { ?>
                            <p id="error-message" style="color: #ff6666;">Todos los campos son obligatorios.</p>
                        <?php } ?>
                        <input class="btn-crear" id="btn-crear-editar" type="submit" value="Crear Tarea" />
                    </div>
                </form>
            </div>
            <div class="kanban-block" id="pendientes" ondrop="drop(event)" ondragover="allowDrop(event)">
                <strong class="kanban-form-title">PENDIENTES</strong>
                <!-- Contenedor de tareas pendientes -->
            </div>
            <div class="kanban-block" id="procesos" ondrop="drop(event, 'En Proceso')" ondragover="allowDrop(event)">
                <strong class="kanban-form-title">EN PROCESO</strong>
                <!-- Contenedor de tareas en proceso -->
            </div>
            <div class="kanban-block" id="completados" ondrop="drop(event, 'Completado')" ondragover="allowDrop(event)">
                <strong class="kanban-form-title">COMPLETADOS</strong>
                <!-- Contenedor de tareas completadas -->
            </div>
        </div>
    </div>

    <script type="text/javascript" charset="utf-8" src="./js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" charset="utf-8" src="./js/jquery-ui.min.js"></script>
    <script src="./js/script.js"></script>
    <script src="./js/api.js"></script>
</body>

</html>