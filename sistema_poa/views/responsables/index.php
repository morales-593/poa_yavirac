<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Responsables de Área</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="public/css/responsables.css">
</head>

<body>
    <div class="container-fluid">

        <div class="page-header">
            <h4><i class="bi bi-person-badge me-2"></i>Responsables de Área</h4>
            <button class="btn btn-primary btn-modern" data-bs-toggle="modal" data-bs-target="#modalResponsable">
                <i class="bi bi-plus-circle"></i> Nuevo Responsable
            </button>
        </div>

        <div class="table-container">
            <table class="table table-hover">
                <thead class="table-primary">
                    <tr>
                        <th width="80">ID</th>
                        <th>Nombre</th>
                        <th width="120">Estado</th>
                        <th width="350" class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($responsables as $i => $r): ?>
                        <tr style="--i: <?= $i ?>;">
                            <td data-label="ID">
                                <span class="id-badge">#<?= $r['id_responsable'] ?></span>
                            </td>
                            <td data-label="Nombre" class="nombre-cell">
                                <?= $r['nombre_responsable'] ?>
                            </td>
                            <td data-label="Estado">
                                <span class="status-badge status-<?= strtolower($r['estado']) ?>">
                                    <i class="bi bi-<?= $r['estado'] == 'ACTIVO' ? 'check-circle' : 'x-circle' ?>"></i>
                                    <?= $r['estado'] ?>
                                </span>
                            </td>
                            <td data-label="Acciones" class="actions-cell">
                                <div class="action-buttons">
                                    <button class="btn btn-warning btn-sm btn-modern" data-bs-toggle="modal"
                                        data-bs-target="#editar<?= $r['id_responsable'] ?>">
                                        <i class="bi bi-pencil-square"></i> Editar
                                    </button>

                                    <a href="index.php?action=toggleResponsable&id=<?= $r['id_responsable'] ?>"
                                        class="btn btn-info btn-sm btn-modern" onclick="confirmarCambioEstado(event)">

                                        
                                        <i class="bi bi-toggle-<?= $r['estado'] == 'ACTIVO' ? 'on' : 'off' ?>"></i>
                                        <?= $r['estado'] == 'ACTIVO' ? 'Desactivar' : 'Activar' ?>
                                    </a>

                                    <a href="index.php?action=eliminarResponsable&id=<?= $r['id_responsable'] ?>"
                                        class="btn btn-danger btn-sm btn-modern"  onclick="confirmarEliminacion(event)">

                                        <i class="bi bi-trash"></i> Eliminar
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach ?>

                    <?php if (empty($responsables)): ?>
                        <tr>
                            <td colspan="4">
                                <div class="empty-state">
                                    <i class="bi bi-people"></i>
                                    <h5>No hay responsables registrados</h5>
                                    <p>Comience agregando un nuevo responsable de área</p>
                                    <button class="btn btn-primary btn-modern mt-3" data-bs-toggle="modal"
                                        data-bs-target="#modalResponsable">
                                        <i class="bi bi-plus-circle"></i> Crear primer responsable
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>

    <!-- MODALES DE EDICIÓN (FUERA de la tabla) -->
    <?php foreach ($responsables as $r): ?>
        <div class="modal fade" id="editar<?= $r['id_responsable'] ?>" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form method="POST" action="index.php?action=actualizarResponsable&id=<?= $r['id_responsable'] ?>">
                        <div class="modal-header warning-header">
                            <h5><i class="bi bi-pencil-square me-2"></i>Editar Responsable</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-4">
                                <label class="form-label">Nombre del Responsable</label>
                                <input type="text" name="nombre_responsable" class="form-control"
                                    value="<?= $r['nombre_responsable'] ?>" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-modern" data-bs-dismiss="modal">
                                <i class="bi bi-x-circle"></i> Cancelar
                            </button>
                            <button type="submit" class="btn btn-warning btn-modern">
                                <i class="bi bi-check-circle"></i> Actualizar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach ?>

    <!-- Modal para nuevo responsable -->
    <div class="modal fade" id="modalResponsable" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="index.php?action=guardarResponsable">
                    <div class="modal-header">
                        <h5><i class="bi bi-person-plus me-2"></i>Nuevo Responsable</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-4">
                            <label class="form-label">Nombre del Responsable</label>
                            <input type="text" name="nombre_responsable" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-modern" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle"></i> Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary btn-modern">
                            <i class="bi bi-save"></i> Guardar Responsable
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- SweetAlert2 para alertas bonitas -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Script para las alertas -->
    <script>
        // Función para mostrar alerta de éxito
        function mostrarAlertaExito(mensaje) {
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: mensaje,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        }

        // Función para confirmar eliminación
        function confirmarEliminacion(event) {
            event.preventDefault();
            const url = event.currentTarget.getAttribute('href');
            
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡Esta acción no se puede deshacer!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Mostrar alerta de eliminando
                    Swal.fire({
                        title: 'Eliminando...',
                        text: 'Por favor espera',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    // Redirigir a la URL de eliminación
                    window.location.href = url;
                }
            });
        }

        // Función para confirmar cambio de estado
        function confirmarCambioEstado(event) {
            event.preventDefault();
            const url = event.currentTarget.getAttribute('href');
            const textoBoton = event.currentTarget.textContent.trim();
            const accion = textoBoton.includes('Desactivar') ? 'desactivar' : 'activar';
            
            Swal.fire({
                title: `¿${accion.charAt(0).toUpperCase() + accion.slice(1)} responsable?`,
                text: `Estás a punto de ${accion} este responsable`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#0ea5e9',
                cancelButtonColor: '#6b7280',
                confirmButtonText: `Sí, ${accion}`,
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        }

        // Detectar mensajes de éxito en la URL
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const mensaje = urlParams.get('mensaje');
            
            if (mensaje) {
                mostrarAlertaExito(mensaje);
                
                // Limpiar parámetro de la URL
                const nuevaUrl = window.location.pathname + window.location.search.replace(/&?mensaje=[^&]*/, '').replace(/^\?/, '');
                history.replaceState({}, document.title, nuevaUrl);
            }
        });
    </script>


    <!-- Bootstrap JS Bundle con Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>