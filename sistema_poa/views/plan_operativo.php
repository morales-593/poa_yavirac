<?php
$page = 'plan-operativo';
$page_title = 'Plan Operativo';
require_once 'header.php';

require_once '../controllers/PlanOperativoController.php';
$controller = new PlanOperativoController();

// Procesar acciones
if($_POST && isset($_POST['action'])) {
    switch($_POST['action']) {
        case 'create_plan':
            if($controller->crearPlan($_POST['elaborado'], $_POST['responsable'])) {
                $_SESSION['alert'] = ['type' => 'success', 'message' => 'Plan creado exitosamente'];
            } else {
                $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Error al crear plan'];
            }
            header("Location: plan_operativo.php");
            exit;
            
        case 'update_plan':
            if($controller->actualizarPlan($_POST)) {
                $_SESSION['alert'] = ['type' => 'success', 'message' => 'Plan actualizado exitosamente'];
            } else {
                $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Error al actualizar plan'];
            }
            header("Location: plan_operativo.php");
            exit;
            
        case 'delete_plan':
            if($controller->eliminarPlan($_POST['plan_id'])) {
                $_SESSION['alert'] = ['type' => 'success', 'message' => 'Plan eliminado exitosamente'];
            } else {
                $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Error al eliminar plan'];
            }
            header("Location: plan_operativo.php");
            exit;
            
        case 'toggle_estado':
            if($controller->toggleEstado($_POST['plan_id'], $_POST['tipo'])) {
                $_SESSION['alert'] = ['type' => 'success', 'message' => 'Estado actualizado correctamente'];
            } else {
                $_SESSION['alert'] = ['type' => 'danger', 'message' => 'Error al actualizar estado'];
            }
            header("Location: plan_operativo.php");
            exit;
    }
}

// Obtener lista de planes
$planes = $controller->listarPlanes();
?>

<div class="page-content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Plan Operativo</h3>
            <button class="btn btn-primary" data-modal="addPlanModal">
                <i class="fas fa-plus"></i> Crear Plan
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="planTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre Elaborado</th>
                            <th>Nombre Responsable</th>
                            <th>Elaboración</th>
                            <th>Seguimiento</th>
                            <th>Ejecución</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($planes->rowCount() > 0): ?>
                            <?php while($plan = $planes->fetch(PDO::FETCH_ASSOC)): ?>
                            <tr>
                                <td><?php echo $plan['id']; ?></td>
                                <td><?php echo htmlspecialchars($plan['nombre_elaborado']); ?></td>
                                <td><?php echo htmlspecialchars($plan['nombre_responsable']); ?></td>
                                
                                <!-- Elaboración -->
                                <td class="check-status">
                                    <div class="action-buttons">
                                        <button type="button" class="btn-icon" onclick="togglePlanEstado(<?php echo $plan['id']; ?>, 'elaboracion')">
                                            <i class="fas <?php echo $plan['elaboracion_estado'] ? 'fa-check-circle check-complete' : 'fa-times-circle check-incomplete'; ?>"></i>
                                        </button>
                                        <button class="btn btn-primary btn-xs" onclick="editPlanSection(<?php echo $plan['id']; ?>, 'elaboracion')">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </div>
                                </td>
                                
                                <!-- Seguimiento -->
                                <td class="check-status">
                                    <div class="action-buttons">
                                        <button type="button" class="btn-icon" onclick="togglePlanEstado(<?php echo $plan['id']; ?>, 'seguimiento')">
                                            <i class="fas <?php echo $plan['seguimiento_estado'] ? 'fa-check-circle check-complete' : 'fa-times-circle check-incomplete'; ?>"></i>
                                        </button>
                                        <button class="btn btn-primary btn-xs" onclick="editPlanSection(<?php echo $plan['id']; ?>, 'seguimiento')">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-primary btn-xs" onclick="downloadPDF(<?php echo $plan['id']; ?>)">
                                            <i class="fas fa-file-pdf"></i>
                                        </button>
                                    </div>
                                </td>
                                
                                <!-- Ejecución -->
                                <td class="check-status">
                                    <div class="action-buttons">
                                        <button type="button" class="btn-icon" onclick="togglePlanEstado(<?php echo $plan['id']; ?>, 'ejecucion')">
                                            <i class="fas <?php echo $plan['ejecucion_estado'] ? 'fa-check-circle check-complete' : 'fa-times-circle check-incomplete'; ?>"></i>
                                        </button>
                                        <button class="btn btn-primary btn-xs" onclick="editPlanSection(<?php echo $plan['id']; ?>, 'ejecucion')">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-primary btn-xs" onclick="viewPlan(<?php echo $plan['id']; ?>)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </td>
                                
                                <td>
                                    <form method="POST" style="display: inline;">
                                        <input type="hidden" name="action" value="delete_plan">
                                        <input type="hidden" name="plan_id" value="<?php echo $plan['id']; ?>">
                                        <button type="submit" class="btn btn-primary btn-sm" onclick="return confirmAction('¿Está seguro de eliminar este plan?')">
                                            <i class="fas fa-trash"></i> Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center no-data">
                                    <i class="fas fa-clipboard-list fa-2x"></i>
                                    <p>No hay planes registrados</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Plan Modal -->
<div id="addPlanModal" class="modal">
    <div class="modal-content">
        <form method="POST">
            <input type="hidden" name="action" value="create_plan">
            <div class="modal-header">
                <h3 class="modal-title">Crear Plan Operativo</h3>
                <button type="button" class="modal-close">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Nombre Elaborado</label>
                    <input type="text" name="elaborado" class="form-control" placeholder="Nombre completo del elaborador" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Nombre Responsable</label>
                    <input type="text" name="responsable" class="form-control" placeholder="Nombre completo del responsable" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary modal-close">Cancelar</button>
                <button type="submit" class="btn btn-primary">Crear Plan</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Plan Modal -->
<div id="editPlanModal" class="modal">
    <div class="modal-content">
        <form method="POST" id="editPlanForm">
            <input type="hidden" name="action" value="update_plan">
            <input type="hidden" name="id" id="editPlanId">
            <div class="modal-header">
                <h3 class="modal-title">Editar Plan Operativo</h3>
                <button type="button" class="modal-close">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Seleccione la información correspondiente</label>
                    <select id="planSelect" class="form-control" onchange="loadPlanForm(this.value)">
                        <option value="">-- Seleccione --</option>
                        <option value="elaboracion">Información de Elaboración</option>
                        <option value="seguimiento">Información de Seguimiento</option>
                        <option value="ejecucion">Información de Ejecución</option>
                    </select>
                </div>
                <div id="planFormContainer">
                    <!-- Dynamic form will be loaded here via JavaScript -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary modal-close">Cancelar</button>
                <button type="submit" class="btn btn-primary">Actualizar Plan</button>
            </div>
        </form>
    </div>
</div>

<script>
function loadPlanForm(tipo) {
    const planId = document.getElementById('editPlanId').value;
    if(!planId || !tipo) return;
    
    editPlanSection(planId, tipo);
}
</script>

<?php require_once 'footer.php'; ?>