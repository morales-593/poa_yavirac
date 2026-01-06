<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Ejes y Objetivos</title>
    <link rel="stylesheet" href="public/css/ejes.css">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
</head>
<body>
    <div class="container-fluid">

        <div class="page-header">
            <h4><i class="bi bi-bullseye me-2"></i>Gestión de Ejes y Objetivos</h4>
            <button class="btn btn-primary btn-modern" data-bs-toggle="modal" data-bs-target="#modalEje">
                <i class="bi bi-plus-circle"></i> Nuevo Eje
            </button>
        </div>

        <div class="table-container">
            <table class="table table-hover">
                <thead class="table-primary">
                    <tr>
                        <th width="80">ID</th>
                        <th>Eje</th>
                        <th>Objetivo</th>
                        <th width="200" class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ejes as $i => $e): ?>
                        <tr style="--i: <?= $i ?>;">
                            <td data-label="ID">
                                <span class="id-badge">#<?= $e['id_eje'] ?></span>
                            </td>
                            <td data-label="Eje" class="eje-name"><?= $e['nombre_eje'] ?></td>
                            <td data-label="Objetivo">
                                <div class="objetivo-desc"><?= $e['objetivo'] ?></div>
                            </td>

                            <td data-label="Acciones" class="actions-cell text-center">
                                <button class="btn btn-primary btn-sm btn-modern" data-bs-toggle="modal"
                                    data-bs-target="#modalEditar<?= $e['id_eje'] ?>">
                                    <i class="bi bi-pencil-square"></i> Editar
                                </button>
                                <a href="index.php?action=eliminarEje&id=<?= $e['id_eje'] ?>"
                                    class="btn btn-danger btn-sm btn-modern" 
                                    onclick="return confirmarEliminacion(event)">
                                    <i class="bi bi-trash"></i> Eliminar
                                </a>
                            </td>
                        </tr>
                        
                        <!-- Modal de edición (dentro del foreach) -->
                        <div class="modal fade modal-editar" id="modalEditar<?= $e['id_eje'] ?>" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">

                                    <form method="POST" action="index.php?action=editarEje&id=<?= $e['id_eje'] ?>" onsubmit="return confirmarEdicion(event)">

                                        <div class="modal-header">
                                            <h5><i class="bi bi-pencil-square me-2"></i>Editar Eje y Objetivo</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">
                                            <div class="mb-4">
                                                <label class="form-label">Nombre del Eje</label>
                                                <input type="text" name="nombre_eje" class="form-control"
                                                    value="<?= htmlspecialchars($e['nombre_eje']) ?>" required>
                                                <div class="form-text">Ingrese el nombre del eje estratégico.</div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Descripción del Objetivo</label>
                                                <textarea name="objetivo" class="form-control" rows="5"
                                                    required><?= htmlspecialchars($e['objetivo']) ?></textarea>
                                                <div class="form-text">Describa el objetivo asociado a este eje.</div>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary btn-modern" data-bs-dismiss="modal">
                                                <i class="bi bi-x-circle"></i> Cancelar
                                            </button>
                                            <button type="submit" class="btn btn-primary btn-modern">
                                                <i class="bi bi-check-circle"></i> Guardar Cambios
                                            </button>
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>
                    
                    <?php if (empty($ejes)): ?>
                        <tr>
                            <td colspan="4">
                                <div class="empty-state">
                                    <i class="bi bi-inbox"></i>
                                    <h5>No hay ejes registrados</h5>
                                    <p>Comience agregando un nuevo eje y objetivo</p>
                                    <button class="btn btn-primary btn-modern mt-3" data-bs-toggle="modal" data-bs-target="#modalEje">
                                        <i class="bi bi-plus-circle"></i> Crear primer eje
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>

    <!-- MODAL para nuevo eje -->
    <div class="modal fade" id="modalEje" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="index.php?action=guardarEje" onsubmit="return confirmarCreacion(event)">

                    <div class="modal-header">
                        <h5><i class="bi bi-plus-circle me-2"></i>Nuevo Eje y Objetivo</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-4">
                            <label class="form-label">Nombre del Eje</label>
                            <input type="text" name="nombre_eje" class="form-control" required placeholder="Ej: Innovación Tecnológica">
                            <div class="form-text">Ingrese un nombre descriptivo para el eje estratégico.</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Descripción del Objetivo</label>
                            <textarea name="objetivo" class="form-control" rows="5" required placeholder="Describa el objetivo a alcanzar..."></textarea>
                            <div class="form-text">Describa el objetivo asociado a este eje de manera clara y medible.</div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-modern" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle"></i> Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary btn-modern">
                            <i class="bi bi-save"></i> Guardar Eje
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle con Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- SweetAlert2 para alertas -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
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
                    window.location.href = url;
                }
            });
            
            return false;
        }

        // Función para confirmar edición
        function confirmarEdicion(event) {
            const nombre = event.target.querySelector('input[name="nombre_eje"]').value;
            const objetivo = event.target.querySelector('textarea[name="objetivo"]').value;
            
            Swal.fire({
                title: '¿Actualizar eje?',
                html: `<strong>Nombre:</strong> ${nombre}<br>
                       <strong>Objetivo:</strong> ${objetivo.substring(0, 100)}${objetivo.length > 100 ? '...' : ''}`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, actualizar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (!result.isConfirmed) {
                    event.preventDefault();
                }
            });
            
            return true;
        }

        // Función para confirmar creación
        function confirmarCreacion(event) {
            const nombre = event.target.querySelector('input[name="nombre_eje"]').value;
            const objetivo = event.target.querySelector('textarea[name="objetivo"]').value;
            
            Swal.fire({
                title: '¿Crear nuevo eje?',
                html: `<strong>Nombre:</strong> ${nombre}<br>
                       <strong>Objetivo:</strong> ${objetivo.substring(0, 100)}${objetivo.length > 100 ? '...' : ''}`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, crear',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (!result.isConfirmed) {
                    event.preventDefault();
                }
            });
            
            return true;
        }

        // Mostrar alertas de éxito/error desde la URL
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const mensaje = urlParams.get('mensaje');
            const error = urlParams.get('error');
            
            if (mensaje) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: decodeURIComponent(mensaje.replace(/\+/g, ' ')),
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
                
                // Limpiar URL
                const nuevaUrl = window.location.pathname + window.location.search.replace(/[?&](mensaje|error)=[^&]*/g, '').replace(/^&/, '?').replace(/\?$/, '');
                history.replaceState({}, document.title, nuevaUrl);
            }
            
            if (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: decodeURIComponent(error.replace(/\+/g, ' ')),
                    confirmButtonColor: '#d33'
                });
                
                // Limpiar URL
                const nuevaUrl = window.location.pathname + window.location.search.replace(/[?&](mensaje|error)=[^&]*/g, '').replace(/^&/, '?').replace(/\?$/, '');
                history.replaceState({}, document.title, nuevaUrl);
            }
            
            // Mantener las funciones existentes
            // Agregar etiquetas de datos para responsividad
            const tableCells = document.querySelectorAll('.table tbody td');
            const headers = Array.from(document.querySelectorAll('.table thead th')).map(th => th.textContent);
            
            tableCells.forEach((cell, index) => {
                const headerIndex = index % headers.length;
                cell.setAttribute('data-label', headers[headerIndex]);
            });
            
            // Animación para modales
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => {
                modal.addEventListener('show.bs.modal', function() {
                    this.querySelector('.modal-content').style.transform = 'scale(0.9)';
                    setTimeout(() => {
                        this.querySelector('.modal-content').style.transform = 'scale(1)';
                        this.querySelector('.modal-content').style.transition = 'transform 0.3s ease';
                    }, 10);
                });
            });
        });
    </script>
</body>
</html>