<div class="container-fluid">

<div class="d-flex justify-content-between mb-3">
    <h4>Indicadores</h4>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalIndicador">
        Nuevo Indicador
    </button>
</div>

<table class="table table-bordered table-hover">
<thead class="table-primary">
<tr>
    <th>ID</th>
    <th>Código</th>
    <th>Descripción</th>
    <th>Eje</th>
    <th>Acciones</th>
</tr>
</thead>
<tbody>
<?php foreach ($indicadores as $i): ?>
<tr>
    <td><?= $i['id_indicador'] ?></td>
    <td><?= $i['codigo'] ?></td>
    <td><?= $i['descripcion'] ?></td>
    <td><?= $i['nombre_eje'] ?></td>
    <td>
        <a href="index.php?action=eliminarIndicador&id=<?= $i['id_indicador'] ?>"
           class="btn btn-danger btn-sm">
           Eliminar
        </a>
    </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

</div>

<!-- MODAL -->
<div class="modal fade" id="modalIndicador">
<div class="modal-dialog">
<div class="modal-content">
<form method="POST" action="index.php?action=guardarIndicador">

<div class="modal-header bg-primary text-white">
<h5>Nuevo Indicador</h5>
</div>

<div class="modal-body">
    <div class="mb-3">
        <label>Código</label>
        <input type="text" name="codigo" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Descripción</label>
        <textarea name="descripcion" class="form-control" required></textarea>
    </div>

    <div class="mb-3">
        <label>Eje</label>
        <select name="id_eje" class="form-select" required>
            <option value="">Seleccione...</option>
            <?php foreach ($ejes as $e): ?>
                <option value="<?= $e['id_eje'] ?>"><?= $e['nombre_eje'] ?></option>
            <?php endforeach; ?>
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
