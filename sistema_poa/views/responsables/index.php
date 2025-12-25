<div class="container-fluid">

<div class="d-flex justify-content-between mb-3">
    <h4>Responsables de Área</h4>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalResponsable">
        Nuevo Responsable
    </button>
</div>

<table class="table table-bordered table-hover">
<thead class="table-primary">
<tr>
    <th>ID</th>
    <th>Nombre</th>
    <th>Estado</th>
    <th>Acciones</th>
</tr>
</thead>
<tbody>
<?php foreach($responsables as $r): ?>
<tr>
    <td><?= $r['id_responsable'] ?></td>
    <td><?= $r['nombre_responsable'] ?></td>
    <td>
        <span class="badge bg-<?= $r['estado']=='ACTIVO'?'success':'danger' ?>">
            <?= $r['estado'] ?>
        </span>
    </td>
    <td>
        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editar<?= $r['id_responsable'] ?>">Editar</button>

        <a href="index.php?action=toggleResponsable&id=<?= $r['id_responsable'] ?>"
           class="btn btn-info btn-sm">Activar / Desactivar</a>

        <a href="index.php?action=eliminarResponsable&id=<?= $r['id_responsable'] ?>"
           class="btn btn-danger btn-sm">Eliminar</a>
    </td>
</tr>

<div class="modal fade" id="editar<?= $r['id_responsable'] ?>">
<div class="modal-dialog">
<div class="modal-content">
<form method="POST" action="index.php?action=actualizarResponsable&id=<?= $r['id_responsable'] ?>">
<div class="modal-header bg-warning">
<h5>Editar Responsable</h5>
</div>
<div class="modal-body">
<input type="text" name="nombre_responsable" class="form-control" value="<?= $r['nombre_responsable'] ?>" required>
</div>
<div class="modal-footer">
<button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
<button class="btn btn-warning">Actualizar</button>
</div>
</form>
</div>
</div>
</div>

<?php endforeach ?>
</tbody>
</table>

</div>

<div class="modal fade" id="modalResponsable">
<div class="modal-dialog">
<div class="modal-content">
<form method="POST" action="index.php?action=guardarResponsable">
<div class="modal-header bg-primary text-white">
<h5>Nuevo Responsable</h5>
</div>
<div class="modal-body">
<input type="text" name="nombre_responsable" class="form-control" required>
</div>
<div class="modal-footer">
<button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
<button class="btn btn-primary">Guardar</button>
</div>
</form>
</div>
</div>
</div>
