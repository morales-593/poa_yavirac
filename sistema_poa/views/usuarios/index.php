<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios del Sistema</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="public/css/usuarios.css">
</head>
<body>
    <div class="container-fluid">

        <!-- TÍTULO -->
        <div class="page-header">
            <h2><i class="bi bi-people me-2"></i>Usuarios del Sistema</h2>
            <button class="btn btn-primary btn-modern" data-bs-toggle="modal" data-bs-target="#modalCrear">
                <i class="bi bi-plus-circle me-2"></i>Nuevo Usuario
            </button>
        </div>

        <!-- BUSCADOR -->
        <div class="search-container">
            <form method="GET" action="index.php" class="row g-3">
                <input type="hidden" name="action" value="usuarios">
                <div class="col-md-9">
                    <label class="form-label">Buscar usuarios</label>
                    <input type="text" 
                           name="search" 
                           class="form-control"
                           placeholder="Buscar por nombre o usuario..."
                           value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button class="btn btn-primary btn-modern w-100">
                        <i class="bi bi-search me-2"></i> Buscar
                    </button>
                </div>
            </form>
        </div>

        <!-- LISTADO -->
        <div class="row">
            <?php if (empty($usuarios)): ?>
                <div class="col-12">
                    <div class="empty-state">
                        <i class="bi bi-people"></i>
                        <h5>No hay usuarios registrados</h5>
                        <p>Comience agregando un nuevo usuario al sistema</p>
                        <button class="btn btn-primary btn-modern mt-3" data-bs-toggle="modal" data-bs-target="#modalCrear">
                            <i class="bi bi-plus-circle me-2"></i> Crear primer usuario
                        </button>
                    </div>
                </div>
            <?php endif; ?>

            <?php foreach ($usuarios as $i => $u): ?>
            <div class="col-md-4 mb-4">
                <div class="card user-card" style="--i: <?= $i ?>;">
                    <div class="card-body">
                        <div class="user-name"><?= htmlspecialchars($u['nombres']) ?></div>
                        
                        <div class="user-info">
                            <p><strong>Usuario:</strong> <?= $u['usuario'] ?></p>
                            <p><strong>Estado:</strong> 
                                <span class="status-badge status-<?= strtolower($u['estado']) ?>">
                                    <i class="bi bi-<?= $u['estado']=='ACTIVO'?'check-circle':'x-circle' ?>"></i>
                                    <?= $u['estado'] ?>
                                </span>
                            </p>
                        </div>

                        <div class="d-flex justify-content-between">
                            <button class="btn btn-outline-primary btn-sm btn-modern"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalEditar<?= $u['id_usuario'] ?>">
                                <i class="bi bi-pencil-square"></i> Editar
                            </button>

                            <a href="index.php?action=eliminarUsuario&id=<?= $u['id_usuario'] ?>"
                               class="btn btn-outline-danger btn-sm btn-modern"
                               onclick="return confirm('¿Está seguro de desactivar este usuario?')">
                                <i class="bi bi-trash"></i> Desactivar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

    </div>

    <!-- MODALES DE EDICIÓN (FUERA del contenedor principal) -->
    <?php foreach ($usuarios as $u): ?>
    <div class="modal fade" id="modalEditar<?= $u['id_usuario'] ?>" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="index.php?action=editarUsuario&id=<?= $u['id_usuario'] ?>">
                    <div class="modal-header">
                        <h5><i class="bi bi-pencil-square me-2"></i>Editar Usuario</h5>
                        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">Nombres Completos</label>
                                <input type="text" 
                                       name="nombres" 
                                       class="form-control"
                                       value="<?= htmlspecialchars($u['nombres']) ?>" 
                                       required
                                       placeholder="Ingrese nombres completos">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Nombre de Usuario</label>
                                <input type="text" 
                                       name="usuario" 
                                       class="form-control"
                                       value="<?= $u['usuario'] ?>" 
                                       required
                                       placeholder="Ingrese nombre de usuario">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Nueva Contraseña</label>
                                <input type="password" 
                                       name="password" 
                                       class="form-control"
                                       placeholder="Dejar en blanco para mantener la actual">
                                <div class="form-text">Solo complete si desea cambiar la contraseña</div>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Estado del Usuario</label>
                                <select name="estado" class="form-select">
                                    <option value="ACTIVO" <?= $u['estado']=='ACTIVO'?'selected':'' ?>>ACTIVO</option>
                                    <option value="INACTIVO" <?= $u['estado']=='INACTIVO'?'selected':'' ?>>INACTIVO</option>
                                </select>
                            </div>
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

    <!-- MODAL CREAR -->
    <div class="modal fade" id="modalCrear" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="index.php?action=crearUsuario">
                    <div class="modal-header">
                        <h5><i class="bi bi-plus-circle me-2"></i>Nuevo Usuario</h5>
                        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">Nombres Completos</label>
                                <input type="text" 
                                       name="nombres" 
                                       class="form-control" 
                                       required
                                       placeholder="Ingrese nombres completos">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Nombre de Usuario</label>
                                <input type="text" 
                                       name="usuario" 
                                       class="form-control" 
                                       required
                                       placeholder="Ingrese nombre de usuario">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Contraseña</label>
                                <input type="password" 
                                       name="password" 
                                       class="form-control" 
                                       required
                                       placeholder="Ingrese contraseña">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Estado Inicial</label>
                                <select name="estado" class="form-select">
                                    <option value="ACTIVO">ACTIVO</option>
                                    <option value="INACTIVO">INACTIVO</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-modern" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle"></i> Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary btn-modern">
                            <i class="bi bi-person-plus"></i> Crear Usuario
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