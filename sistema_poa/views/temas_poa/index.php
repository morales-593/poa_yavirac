<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Temas POA</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="public/css/temas_poa.css">
</head>
<body>
    <!-- Alertas -->
    <?php if (isset($_SESSION['alert'])): ?>
    <div class="alert-container">
        <div class="alert alert-<?= $_SESSION['alert']['type'] ?> alert-dismissible fade show" role="alert">
            <i class="bi bi-<?= $_SESSION['alert']['type'] == 'success' ? 'check-circle' : 'exclamation-circle' ?> me-2"></i>
            <?= $_SESSION['alert']['message'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    <?php 
        unset($_SESSION['alert']);
    endif; 
    ?>

    <div class="container-fluid">

        <div class="page-header">
            <h4><i class="bi bi-tags me-2"></i>Temas POA</h4>
            <button class="btn btn-primary btn-modern" data-bs-toggle="modal" data-bs-target="#modalTema">
                <i class="bi bi-plus-circle"></i> Nuevo Tema
            </button>
        </div>

        <div class="table-container">
            <table class="table table-hover">
                <thead class="table-primary">
                    <tr>
                        <th width="80">ID</th>
                        <th>Descripción</th>
                        <th width="120">Estado</th>
                        <th width="180" class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($temas as $i => $t): ?>
                    <tr style="--i: <?= $i ?>;">
                        <td data-label="ID">
                            <span class="id-badge">#<?= $t['id_tema'] ?></span>
                        </td>
                        <td data-label="Descripción" class="descripcion-cell">
                            <?= htmlspecialchars($t['descripcion']) ?>
                        </td>
                        <td data-label="Estado">
                            <span class="status-badge status-<?= strtolower($t['estado']) ?>">
                                <i class="bi bi-<?= $t['estado']=='ACTIVO'?'check-circle':'x-circle' ?>"></i>
                                <?= $t['estado'] ?>
                            </span>
                        </td>
                        <td data-label="Acciones" class="actions-cell">
                            <div class="action-buttons">
                                <?php if ($t['estado'] == 'ACTIVO'): ?>
                                    <a href="index.php?action=estadoTema&id=<?= $t['id_tema'] ?>&estado=INACTIVO"
                                       class="btn btn-danger btn-sm btn-modern">
                                        <i class="bi bi-toggle-off"></i> Desactivar
                                    </a>
                                <?php else: ?>
                                    <a href="index.php?action=estadoTema&id=<?= $t['id_tema'] ?>&estado=ACTIVO"
                                       class="btn btn-success btn-sm btn-modern">
                                        <i class="bi bi-toggle-on"></i> Activar
                                    </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    
                    <?php if (empty($temas)): ?>
                    <tr>
                        <td colspan="4">
                            <div class="empty-state">
                                <i class="bi bi-tag"></i>
                                <h5>No hay temas POA registrados</h5>
                                <p>Comience agregando un nuevo tema</p>
                                <button class="btn btn-primary btn-modern mt-3" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modalTema">
                                    <i class="bi bi-plus-circle"></i> Crear primer tema
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>

    <!-- MODAL NUEVO TEMA -->
    <div class="modal fade" id="modalTema" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="index.php?action=guardarTema">
                    <div class="modal-header">
                        <h5><i class="bi bi-plus-circle me-2"></i>Nuevo Tema POA</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-4">
                            <label class="form-label">Descripción del Tema</label>
                            <input type="text" 
                                   name="descripcion" 
                                   class="form-control" 
                                   required
                                   placeholder="Ingrese la descripción del tema POA">
                            <div class="form-text">Ingrese una descripción clara para el tema POA.</div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-modern" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle"></i> Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary btn-modern">
                            <i class="bi bi-save"></i> Guardar Tema
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