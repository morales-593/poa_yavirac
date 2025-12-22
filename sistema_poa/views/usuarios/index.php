<div class="container-fluid">

<!-- TÍTULO -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-primary fw-bold">
        <i class="fas fa-users me-2"></i>Usuarios del Sistema
    </h2>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrear">
        <i class="fas fa-plus me-2"></i>Nuevo Usuario
    </button>
</div>

<!-- BUSCADOR -->
<form method="GET" action="index.php" class="row g-2 mb-4">
    <input type="hidden" name="action" value="usuarios">
    <div class="col-md-9">
        <input type="text" name="search" class="form-control"
               placeholder="Buscar por nombre o usuario"
               value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
    </div>
    <div class="col-md-3">
        <button class="btn btn-primary w-100">Buscar</button>
    </div>
</form>

<!-- LISTADO -->
<div class="row">
<?php if (empty($usuarios)): ?>
    <div class="col-12">
        <div class="alert alert-info">No existen usuarios</div>
    </div>
<?php endif; ?>

<?php foreach ($usuarios as $u): ?>
<div class="col-md-4 mb-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h5><?= htmlspecialchars($u['nombres']) ?></h5>
            <p class="mb-1"><strong>Usuario:</strong> <?= $u['usuario'] ?></p>
            <p><strong>Estado:</strong> <?= $u['estado'] ?></p>

            <div class="text-end">
                <button class="btn btn-sm btn-outline-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#modalEditar<?= $u['id_usuario'] ?>">
                    Editar
                </button>

                <a href="index.php?action=eliminarUsuario&id=<?= $u['id_usuario'] ?>"
                   class="btn btn-sm btn-outline-danger"
                   onclick="return confirm('¿Desactivar usuario?')">
                    Eliminar
                </a>
            </div>
        </div>
    </div>
</div>

<!-- MODAL EDITAR -->
<div class="modal fade" id="modalEditar<?= $u['id_usuario'] ?>" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content">
<form method="POST" action="index.php?action=editarUsuario&id=<?= $u['id_usuario'] ?>">

<div class="modal-header bg-primary text-white">
    <h5 class="modal-title">Editar Usuario</h5>
    <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body row g-3">
    <div class="col-12">
        <label>Nombres</label>
        <input type="text" name="nombres" class="form-control"
               value="<?= htmlspecialchars($u['nombres']) ?>" required>
    </div>

    <div class="col-12">
        <label>Usuario</label>
        <input type="text" name="usuario" class="form-control"
               value="<?= $u['usuario'] ?>" required>
    </div>

    <div class="col-12">
        <label>Nueva Contraseña</label>
        <input type="password" name="password" class="form-control"
               placeholder="Opcional">
    </div>

    <div class="col-12">
        <label>Estado</label>
        <select name="estado" class="form-select">
            <option value="ACTIVO" <?= $u['estado']=='ACTIVO'?'selected':'' ?>>ACTIVO</option>
            <option value="INACTIVO" <?= $u['estado']=='INACTIVO'?'selected':'' ?>>INACTIVO</option>
        </select>
    </div>
</div>

<div class="modal-footer">
    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
    <button class="btn btn-primary">Guardar</button>
</div>

</form>
</div>
</div>
</div>

<?php endforeach; ?>
</div>

<!-- MODAL CREAR -->
<div class="modal fade" id="modalCrear" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content">
<form method="POST" action="index.php?action=crearUsuario">

<div class="modal-header bg-primary text-white">
    <h5 class="modal-title">Nuevo Usuario</h5>
    <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body row g-3">
    <div class="col-12">
        <label>Nombres</label>
        <input type="text" name="nombres" class="form-control" required>
    </div>

    <div class="col-12">
        <label>Usuario</label>
        <input type="text" name="usuario" class="form-control" required>
    </div>

    <div class="col-12">
        <label>Contraseña</label>
        <input type="password" name="password" class="form-control" required>
    </div>

    <div class="col-12">
        <label>Estado</label>
        <select name="estado" class="form-select">
            <option value="ACTIVO">ACTIVO</option>
            <option value="INACTIVO">INACTIVO</option>
        </select>
    </div>
</div>

<div class="modal-footer">
    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
    <button class="btn btn-primary">Crear</button>
</div>

</form>
</div>
</div>
</div>

</div>
