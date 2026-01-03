<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0"><i class="fas fa-clipboard-list text-primary"></i> Plan Operativo Anual</h4>
            <p class="text-muted mb-0">Gestión de planes y elaboraciones</p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalPlan">
            <i class="fas fa-plus"></i> Crear Plan
        </button>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="table-primary">
                        <tr>
                            <th width="5%">#</th>
                            <th width="20%">Nombre Elaborado</th>
                            <th width="20%">Responsable</th>
                            <th width="10%">Estado</th>
                            <th width="15%">Fecha Creación</th>
                            <th width="30%">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($planes)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No hay planes registrados</p>
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalPlan">
                                        <i class="fas fa-plus"></i> Crear primer plan
                                    </button>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($planes as $p): ?>
                                <tr>
                                    <td><?= $p['id_plan'] ?></td>
                                    <td>
                                        <div class="fw-semibold"><?= htmlspecialchars($p['nombre_elaborado']) ?></div>
                                        <small class="text-muted">ID: <?= $p['id_plan'] ?></small>
                                    </td>
                                    <td><?= htmlspecialchars($p['nombre_responsable']) ?></td>
                                    <td>
                                        <span class="badge bg-<?= $p['estado'] == 'ACTIVO' ? 'success' : 'secondary' ?>">
                                            <?= $p['estado'] ?>
                                        </span>
                                    </td>
                                    <td><?= date('d/m/Y H:i', strtotime($p['fecha_creacion'])) ?></td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-primary btn-sm"
                                                onclick="abrirElaboracion(<?= $p['id_plan'] ?>)" title="Elaborar POA">
                                                <i class="fas fa-edit"></i> Elaborar
                                            </button>
                                            <button class="btn btn-warning btn-sm" title="Seguimiento" disabled>
                                                <i class="fas fa-chart-line"></i> Seguimiento
                                            </button>
                                            <button class="btn btn-success btn-sm" title="Ejecución" disabled>
                                                <i class="fas fa-play-circle"></i> Ejecución
                                            </button>
                                            <a href="index.php?action=eliminarPlan&id=<?= $p['id_plan'] ?>"
                                                class="btn btn-danger btn-sm btn-eliminar" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- MODAL CREAR PLAN -->
<div class="modal fade" id="modalPlan" tabindex="-1" aria-labelledby="modalPlanLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="index.php?action=guardarPlan">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="fas fa-plus-circle"></i> Nuevo Plan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nombre Elaborado</label>
                        <input type="text" name="nombre_elaborado" class="form-control"
                            placeholder="Nombre de quien elabora el plan" required>
                        <div class="form-text">Persona que elabora el documento</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Responsable</label>
                        <input type="text" name="nombre_responsable" class="form-control"
                            placeholder="Responsable del plan" required>
                        <div class="form-text">Persona responsable de ejecutar el plan</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Guardar Plan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL ELABORACIÓN -->
<div class="modal fade" id="modalElab" tabindex="-1" aria-labelledby="modalElabLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content" id="contenedorElab">
            <!-- El contenido se carga aquí dinámicamente -->
        </div>
    </div>
</div>

<!-- Estilos adicionales -->
<style>
    .btn-group .btn {
        border-radius: 0.375rem;
        margin-right: 2px;
    }

    .btn-group .btn:last-child {
        margin-right: 0;
    }

    .table th {
        font-weight: 600;
    }
</style>