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
                                        class="btn btn-info btn-sm btn-modern">
                                        <i class="bi bi-toggle-<?= $r['estado'] == 'ACTIVO' ? 'on' : 'off' ?>"></i>
                                        <?= $r['estado'] == 'ACTIVO' ? 'Desactivar' : 'Activar' ?>
                                    </a>

                                    <a href="index.php?action=eliminarResponsable&id=<?= $r['id_responsable'] ?>"
                                        class="btn btn-danger btn-sm btn-modern">
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

    <!-- Bootstrap JS Bundle con Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>