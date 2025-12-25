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
                                <div class="objetivo-desc"><?= $e['descripcion_objetivo'] ?></div>
                            </td>

                            <td data-label="Acciones" class="actions-cell text-center">
                                <button class="btn btn-primary btn-sm btn-modern" data-bs-toggle="modal"
                                    data-bs-target="#modalEditar<?= $e['id_eje'] ?>">
                                    <i class="bi bi-pencil-square"></i> Editar
                                </button>
                                <a href="index.php?action=eliminarEje&id=<?= $e['id_eje'] ?>"
                                    class="btn btn-danger btn-sm btn-modern" 
                                    onclick="return confirm('¿Estás seguro de eliminar este eje?')">
                                    <i class="bi bi-trash"></i> Eliminar
                                </a>
                            </td>
                        </tr>
                        
                        <!-- Modal de edición (dentro del foreach) -->
                        <div class="modal fade modal-editar" id="modalEditar<?= $e['id_eje'] ?>" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">

                                    <form method="POST" action="index.php?action=editarEje&id=<?= $e['id_eje'] ?>">

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
                                                <textarea name="descripcion_objetivo" class="form-control" rows="5"
                                                    required><?= htmlspecialchars($e['descripcion_objetivo']) ?></textarea>
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
                <form method="POST" action="index.php?action=guardarEje">

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
                            <textarea name="descripcion_objetivo" class="form-control" rows="5" required placeholder="Describa el objetivo a alcanzar..."></textarea>
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
    
    <script>
        // Mejora para la tabla responsive
        document.addEventListener('DOMContentLoaded', function() {
            // Agregar etiquetas de datos para responsividad
            const tableCells = document.querySelectorAll('.table tbody td');
            const headers = Array.from(document.querySelectorAll('.table thead th')).map(th => th.textContent);
            
            tableCells.forEach((cell, index) => {
                const headerIndex = index % headers.length;
                cell.setAttribute('data-label', headers[headerIndex]);
            });
            
            // Confirmación mejorada para eliminación
            const deleteButtons = document.querySelectorAll('a[href*="eliminarEje"]');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    if (!confirm('¿Está seguro que desea eliminar este eje? Esta acción no se puede deshacer.')) {
                        e.preventDefault();
                    }
                });
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