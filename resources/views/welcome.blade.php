<!DOCTYPE html>
<html>
<head>
    <title>Gestión de Turnos - Hospital La Misericordia</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- Agrega el token CSRF -->
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Gestión de Turnos</h1>

        <div class="mt-4">
            <h2>Solicitar Turno</h2>
            <form id="solicitar-turno-form">
                <div class="form-group">
                    <label for="patient_id">ID del Paciente</label>
                    <select class="form-control" id="patient_id" required>
                        <option value="">Seleccione un paciente</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="service_id">Servicio</label>
                    <select class="form-control" id="service_id" required>
                        <option value="">Seleccione un servicio</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="scheduled_at">Fecha y Hora</label>
                    <input type="datetime-local" class="form-control" id="scheduled_at" required>
                </div>
                <button type="submit" class="btn btn-primary">Solicitar Turno</button>
            </form>
        </div>

        <div class="mt-5">
            <h2>Turnos Pendientes</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Paciente</th>
                        <th>Servicio</th>
                        <th>Fecha y Hora</th>
                        <th>Estado</th>
                        <th>Acciones</th> <!-- Nueva columna para acciones -->
                    </tr>
                </thead>
                <tbody id="turnos-lista">
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        // Función para cargar los turnos pendientes
        function cargarTurnos() {
            $.get('/turnos', function (data) {
                $('#turnos-lista').empty();
                data.forEach(function (turno) {
                    if (turno.estado === 'Pendiente') {
                        $('#turnos-lista').append(`
                            <tr>
                                <td>${turno.id}</td>
                                <td>${turno.paciente ? turno.paciente.nombre : 'No disponible'}</td>
                                <td>${turno.servicio ? turno.servicio.nombre : 'No disponible'}</td>
                                <td>${turno.hora_asignacion}</td>
                                <td>${turno.estado}</td>
                                <td>
                                    <button class="btn btn-success" onclick="cambiarEstado(${turno.id}, 'Completado')">Completar</button>
                                    <button class="btn btn-danger" onclick="cambiarEstado(${turno.id}, 'Cancelado')">Cancelar</button>
                                </td>
                            </tr>
                        `);
                    }
                });
            });
        }

        $(document).ready(function () {
            // Función para cargar los pacientes
            $.get('/pacientes', function (data) {
                data.forEach(function (paciente) {
                    $('#patient_id').append(`<option value="${paciente.id}">${paciente.nombre}</option>`);
                });
            });

            // Función para cargar los servicios
            $.get('/servicios', function (data) {
                data.forEach(function (servicio) {
                    $('#service_id').append(`<option value="${servicio.id}">${servicio.nombre}</option>`);
                });
            });

            // Cargar los turnos pendientes al cargar la página
            cargarTurnos();

            // Manejador de eventos para el envío del formulario de solicitud de turno
            $('#solicitar-turno-form').on('submit', function (e) {
                e.preventDefault();
                const token = $('meta[name="csrf-token"]').attr('content');
                const turnoData = {
                    id_paciente: $('#patient_id').val(),
                    id_servicio: $('#service_id').val(),
                    hora_asignacion: $('#scheduled_at').val(),
                    estado: 'Pendiente'
                };
                $.ajax({
                    url: '/turnos',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    data: turnoData,
                    success: function (data) {
                        cargarTurnos();
                        $('#solicitar-turno-form')[0].reset(); 
                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                    }
                });
            });
        });

        function cambiarEstado(turnoId, nuevoEstado) {
            const token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: '/turnos/' + turnoId,
                type: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': token
                },
                data: {
                    estado: nuevoEstado
                },
                success: function (data) {
                    cargarTurnos(); 
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        }
    </script>
</body>
</html>






