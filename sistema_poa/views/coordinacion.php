<?php
$page = 'coordinacion';
$page_title = 'Coordinación';
require_once 'header.php';

require_once '../controllers/CoordinacionController.php';
$controller = new CoordinacionController();

// Procesar acciones
if($_POST && isset($_POST['action'])) {
    switch($_POST['action']) {
        case 'create_user':
            if($controller->crearUsuario($_POST['username'], $_POST['password'])) {
                $_SESSION['alert'] = ['type' => 'success', 'message' => 'Usuario creado exitosamente'];
            } else {
                $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Error al crear usuario'];
            }
            header("Location: coordinacion.php");
            exit;
            
        case 'delete_user':
            if($controller->eliminarUsuario($_POST['user_id'])) {
                $_SESSION['alert'] = ['type' => 'success', 'message' => 'Usuario eliminado exitosamente'];
            } else {
                $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Error al eliminar usuario'];
            }
            header("Location: coordinacion.php");
            exit;
    }
}

// Obtener lista de usuarios
$usuarios = $controller->listarUsuarios();
?>

<div class="page-content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Usuarios del Sistema</h3>
            <button class="btn btn-primary" onclick="openAddUserModal()">
                <i class="fas fa-plus"></i> Crear Usuario
            </button>
        </div>
        <div class="card-body">
            <div class="card-grid" id="usersGrid">
                <?php if($usuarios->rowCount() > 0): ?>
                    <?php while($user = $usuarios->fetch(PDO::FETCH_ASSOC)): ?>
                    <div class="user-card">
                        <div class="user-card-header">
                            <div class="user-name"><?php echo htmlspecialchars($user['username']); ?></div>
                            <div class="user-actions">
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="action" value="delete_user">
                                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                    <button type="submit" class="btn btn-primary btn-sm" onclick="return confirmAction('¿Está seguro de eliminar este usuario?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="user-details">
                            ID: <?php echo $user['id']; ?> | Creado: <?php echo date('d/m/Y', strtotime($user['created_at'])); ?>
                        </div>
                    </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="no-data">
                        <i class="fas fa-users fa-3x"></i>
                        <h3>No hay usuarios registrados</h3>
                        <p>Comienza creando el primer usuario del sistema</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Add User Modal -->
<div id="addUserModal" class="modal">
    <div class="modal-content">
        <form method="POST">
            <input type="hidden" name="action" value="create_user">
            <div class="modal-header">
                <h3 class="modal-title">Crear Usuario</h3>
                <button type="button" class="modal-close">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Usuario</label>
                    <input type="text" name="username" class="form-control" placeholder="Ingrese el nombre de usuario" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Contraseña</label>
                    <input type="password" name="password" class="form-control" placeholder="Ingrese la contraseña" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary modal-close">Cancelar</button>
                <button type="submit" class="btn btn-primary">Guardar Usuario</button>
            </div>
        </form>
    </div>
</div>

<?php require_once 'footer.php'; ?>