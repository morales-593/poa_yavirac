<div class="container-fluid">

<h4 class="mb-3">Planes Operativos</h4>

<button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalPlan">
Nuevo Plan
</button>

<table class="table table-bordered">
<thead class="table-primary">
<tr>
<th>ID</th>
<th>Nombre</th>
<th>Responsable</th>
<th>Usuario</th>
<th>Estado</th>
<th>Acciones</th>
</tr>
</thead>
<tbody>
<?php foreach($planes as $p): ?>
<tr>
<td><?= $p['id_plan'] ?></td>
<td><?= $p['nombre_elaborado'] ?></td>
<td><?= $p['nombre_responsable'] ?></td>
<td><?= $p['nombres'] ?></td>
<td>
<span class="badge bg-<?= $p['estado']=='COMPLETADO'?'success':'warning' ?>">
<?= $p['estado'] ?>
</span>
</td>
<td>
<a href="index.php?action=eliminarPlan&id=<?= $p['id_plan'] ?>" class="btn btn-danger btn-sm">
Eliminar
</a>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

</div>

<!-- MODAL -->
<div class="modal fade" id="modalPlan">
<div class="modal-dialog">
<div class="modal-content">

<form method="POST" action="index.php?action=guardarPlan">

<div class="modal-header bg-primary text-white">
<h5>Nuevo Plan Operativo</h5>
</div>

<div class="modal-body">

<label>Nombre del Plan</label>
<input name="nombre" class="form-control mb-2" required>

<label>Responsable</label>
<select name="responsable" class="form-control mb-2" required>
<?php foreach($responsables as $r): ?>
<option value="<?= $r['id_responsable'] ?>"><?= $r['nombre_responsable'] ?></option>
<?php endforeach; ?>
</select>

<label>Fecha de Elaboración</label>
<input type="date" name="fecha" class="form-control" required>

</div>

<div class="modal-footer">
<button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
<button class="btn btn-primary">Guardar</button>
</div>

</form>

</div>
</div>
</div>
