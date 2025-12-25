<div class="container-fluid">

<div class="d-flex justify-content-between mb-3">
    <h4>Plazos</h4>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalPlazo">
        Nuevo Plazo
    </button>
</div>

<table class="table table-bordered">
<thead class="table-primary">
<tr>
    <th>ID</th>
    <th>Nombre</th>
    <th>Acciones</th>
</tr>
</thead>
<tbody>
<?php foreach($plazos as $p): ?>
<tr>
    <td><?= $p['id_plazo'] ?></td>
    <td><?= $p['nombre_plazo'] ?></td>
    <td>
        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editar<?= $p['id_plazo'] ?>">Editar</button>
        <a href="index.php?action=eliminarPlazo&id=<?= $p['id_plazo'] ?>" class="btn btn-danger btn-sm">Eliminar</a>
    </td>
</tr>

<div class="modal fade" id="editar<?= $p['id_plazo'] ?>">
<div class="modal-dialog">
<div class="modal-content">
<form method="POST" action="index.php?action=actualizarPlazo&id=<?= $p['id_plazo'] ?>">
<div class="modal-header bg-warning">
<h5>Editar Plazo</h5>
</div>
<div class="modal-body">
<input type="text" name="nombre_plazo" class="form-control" value="<?= $p['nombre_plazo'] ?>" required>
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

<div class="modal fade" id="modalPlazo">
<div class="modal-dialog">
<div class="modal-content">
<form method="POST" action="index.php?action=guardarPlazo">
<div class="modal-header bg-primary text-white">
<h5>Nuevo Plazo</h5>
</div>
<div class="modal-body">
<input type="text" name="nombre_plazo" class="form-control" required>
</div>
<div class="modal-footer">
<button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
<button class="btn btn-primary">Guardar</button>
</div>
</form>
</div>
</div>
</div>
