<div class="container-fluid">

    <div class="d-flex justify-content-between mb-3">
        <h4>Plan Operativo</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalPlan">+ Crear Plan</button>
    </div>

    <table class="table table-hover">
        <thead class="table-primary">
            <tr>
                <th>#</th>
                <th>Nombre Elaborado</th>
                <th>Responsable</th>
                <th>Estado</th>
                <th>Fecha</th>
                <th>Elaboración</th>
                <th>Seguimiento</th>
                <th>Ejecución</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($planes as $p): ?>
                <tr>
                    <td><?= $p['id_plan'] ?></td>
                    <td><?= $p['nombre_elaborado'] ?></td>
                    <td><?= $p['nombre_responsable'] ?></td>
                    <td>
                        <span class="badge bg-<?= $p['estado'] == 'ACTIVO' ? 'success' : 'secondary' ?>">
                            <?= $p['estado'] ?>
                        </span>
                    </td>
                    <td><?= date('d/m/Y', strtotime($p['fecha_creacion'])) ?></td>
                    <td>
                        <button class="btn btn-primary btn-sm" onclick="abrirElaboracion(<?= $p['id_plan'] ?>)">
                            Elaborar
                        </button>
                    </td>
                    <td><button class="btn btn-warning btn-sm">Seguimiento</button></td>
                    <td><button class="btn btn-success btn-sm">Ejecución</button></td>
                    <td>
                        <a href="index.php?action=eliminarPlan&id=<?= $p['id_plan'] ?>"
                            class="btn btn-danger btn-sm btn-eliminar">
                            Eliminar
                        </a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>

</div>

<!-- MODAL CREAR PLAN -->
<div class="modal fade" id="modalPlan" tabindex="-1" aria-labelledby="modalPlanLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="index.php?action=guardarPlan">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Nuevo Plan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nombre Elaborado</label>
                        <input name="nombre_elaborado" class="form-control" placeholder="Nombre Elaborado" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Responsable</label>
                        <input name="nombre_responsable" class="form-control" placeholder="Responsable" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL ELABORACIÓN (PARTE 4) -->
<div class="modal fade" id="modalElab" tabindex="-1" aria-labelledby="modalElabLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content" id="contenedorElab">
            <!-- El contenido se carga aquí dinámicamente -->
        </div>
    </div>
</div>

<!-- Script específico para la página planes -->
<script>
    // Script adicional para la página planes si es necesario
    $(document).ready(function () {
        // Puedes agregar funciones específicas para esta página aquí
        console.log('Página planes cargada');

        // Si necesitas hacer algo específico cuando se abre el modal de elaboración
        $('#modalElab').on('shown.bs.modal', function () {
            console.log('Modal de elaboración completamente mostrado');
        });
    });
</script>