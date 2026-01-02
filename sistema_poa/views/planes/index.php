<div class="container-fluid">
    <div class="d-flex justify-content-between mb-3">
        <h4>Plan Operativo</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalPlan">
            + Crear Plan
        </button>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-primary">
            <tr>
                <th>#</th>
                <th>Nombre Elaborado</th>
                <th>Nombre Responsable</th>
                <th>Estado</th>
                <th>Fecha</th>
                <th>Elaboración</th>
                <th>Seguimiento</th>
                <th>Ejecución</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($planes as $i => $p): ?>
            <tr>
                <td><?= $i+1 ?></td>
                <td><?= $p['nombre_elaborado'] ?></td>
                <td><?= $p['nombre_responsable'] ?></td>
                <td>
                    <span class="badge bg-<?= $p['estado']=='COMPLETADO'?'success':'warning' ?>">
                        <?= $p['estado'] ?>
                    </span>
                </td>
                <td><?= date('d/m/Y', strtotime($p['fecha_creacion'])) ?></td>

                <td><a href="index.php?url=planes&action=ver&id=<?= $p['id_plan'] ?>" class="btn btn-primary btn-sm">Elaborar</a></td>
                <td><a href="#" class="btn btn-warning btn-sm">Seguimiento</a></td>
                <td><a href="#" class="btn btn-success btn-sm">Ejecución</a></td>

                <td>
                    <a href="index.php?url=planes&action=delete&id=<?= $p['id_plan'] ?>"
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('¿Eliminar este plan?')">
                       Eliminar
                    </a>
                </td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
</div>
<div class="modal fade" id="modalPlan">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<form method="POST" action="index.php?url=planes&action=store">
    <div class="modal-header bg-primary text-white">
        <h5>Crear Plan Operativo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>

    <div class="modal-body">
        <label>Nombre Elaborado</label>
        <input type="text" name="nombre_elaborado" class="form-control" required>

        <label class="mt-3">Nombre Responsable</label>
        <input type="text" name="nombre_responsable" class="form-control" required>
    </div>

    <div class="modal-footer">
        <button class="btn btn-success">Guardar</button>
    </div>
</form>
</div>
</div>
</div>
