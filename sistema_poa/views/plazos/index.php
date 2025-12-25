<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Plazos</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="public/css/plazos.css">
</head>
<body>
    <div class="container-fluid">

        <div class="page-header">
            <h4><i class="bi bi-calendar-check me-2"></i>Plazos</h4>
            <button class="btn btn-primary btn-modern" data-bs-toggle="modal" data-bs-target="#modalPlazo">
                <i class="bi bi-plus-circle"></i> Nuevo Plazo
            </button>
        </div>

        <div class="table-container">
            <table class="table table-hover">
                <thead class="table-primary">
                    <tr>
                        <th width="80">ID</th>
                        <th>Nombre</th>
                        <th width="200" class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($plazos as $i => $p): ?>
                    <tr style="--i: <?= $i ?>;">
                        <td data-label="ID">
                            <span class="id-badge">#<?= $p['id_plazo'] ?></span>
                        </td>
                        <td data-label="Nombre" class="nombre-cell">
                            <?= $p['nombre_plazo'] ?>
                        </td>
                        <td data-label="Acciones" class="actions-cell">
                            <div class="action-buttons">
                                <button class="btn btn-warning btn-sm btn-modern" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editar<?= $p['id_plazo'] ?>">
                                    <i class="bi bi-pencil-square"></i> Editar
                                </button>
                                <a href="index.php?action=eliminarPlazo&id=<?= $p['id_plazo'] ?>" 
                                   class="btn btn-danger btn-sm btn-modern">
                                    <i class="bi bi-trash"></i> Eliminar
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach ?>
                    
                    <?php if (empty($plazos)): ?>
                    <tr>
                        <td colspan="3">
                            <div class="empty-state">
                                <i class="bi bi-calendar-x"></i>
                                <h5>No hay plazos registrados</h5>
                                <p>Comience agregando un nuevo plazo</p>
                                <button class="btn btn-primary btn-modern mt-3" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modalPlazo">
                                    <i class="bi bi-plus-circle"></i> Crear primer plazo
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
    <?php foreach($plazos as $p): ?>
    <div class="modal fade" id="editar<?= $p['id_plazo'] ?>" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="index.php?action=actualizarPlazo&id=<?= $p['id_plazo'] ?>">
                    <div class="modal-header warning-header">
                        <h5><i class="bi bi-pencil-square me-2"></i>Editar Plazo</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-4">
                            <label class="form-label">Nombre del Plazo</label>
                            <input type="text" 
                                   name="nombre_plazo" 
                                   class="form-control" 
                                   value="<?= $p['nombre_plazo'] ?>" 
                                   required>
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

    <!-- Modal para nuevo plazo -->
    <div class="modal fade" id="modalPlazo" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="index.php?action=guardarPlazo">
                    <div class="modal-header">
                        <h5><i class="bi bi-plus-circle me-2"></i>Nuevo Plazo</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-4">
                            <label class="form-label">Nombre del Plazo</label>
                            <input type="text" 
                                   name="nombre_plazo" 
                                   class="form-control" 
                                   required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-modern" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle"></i> Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary btn-modern">
                            <i class="bi bi-save"></i> Guardar Plazo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle con Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>