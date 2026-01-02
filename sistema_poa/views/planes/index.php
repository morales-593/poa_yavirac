<div class="container-fluid">

<div class="d-flex justify-content-between mb-3">
<h4>Plan Operativo</h4>
<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalPlan">+ Crear Plan</button>
</div>

<table class="table table-hover">
<thead class="table-primary">
<tr>
<th>#</th><th>Nombre Elaborado</th><th>Responsable</th><th>Estado</th><th>Fecha</th>
<th>Elaboración</th><th>Seguimiento</th><th>Ejecución</th><th>Acciones</th>
</tr>
</thead>
<tbody>
<?php foreach($planes as $p): ?>
<tr>
<td><?= $p['id_plan'] ?></td>
<td><?= $p['nombre_elaborado'] ?></td>
<td><?= $p['nombre_responsable'] ?></td>
<td><?= $p['estado'] ?></td>
<td><?= date('d/m/Y',strtotime($p['fecha_creacion'])) ?></td>
<td><button class="btn btn-primary btn-sm"
onclick="abrirElaboracion(<?= $p['id_plan'] ?>)">Elaborar</button></td>
<td><button class="btn btn-warning btn-sm">Seguimiento</button></td>
<td><button class="btn btn-success btn-sm">Ejecución</button></td>
<td><a href="index.php?action=eliminarPlan&id=<?= $p['id_plan'] ?>" class="btn btn-danger btn-sm">Eliminar</a></td>
</tr>
<?php endforeach ?>
</tbody>
</table>

</div>

<!-- MODAL CREAR -->
<div class="modal fade" id="modalPlan">
<form method="POST" action="index.php?action=guardarPlan">
<div class="modal-dialog"><div class="modal-content">
<div class="modal-header bg-primary text-white"><h5>Nuevo Plan</h5></div>
<div class="modal-body">
<input name="nombre_elaborado" class="form-control mb-2" placeholder="Nombre Elaborado" required>
<input name="nombre_responsable" class="form-control" placeholder="Responsable" required>
</div>
<div class="modal-footer"><button class="btn btn-primary">Guardar</button></div>
</div></div>
</form>
</div>

<!-- Modal Elaboración -->
<div class="modal fade" id="modalElab">
<div class="modal-dialog modal-xl"><div class="modal-content" id="contenedorElab"></div></div>
</div>

<script>
function abrirElaboracion(id){
    fetch('index.php?action=modalElaboracion&id_plan='+id)
    .then(r=>r.text())
    .then(html=>{
        document.getElementById('contenedorElab').innerHTML=html;
        new bootstrap.Modal(document.getElementById('modalElab')).show();
    })
}
</script>
