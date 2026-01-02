<form method="POST" action="index.php?action=guardarElaboracion">

<input type="hidden" name="id_plan" value="<?= $plan['id_plan'] ?>">
<input type="hidden" name="id_elaboracion" value="<?= $elab['id_elaboracion'] ?? '' ?>">

<div class="modal-header bg-primary text-white">
    <h5>PLAN OPERATIVO - ELABORACIÓN</h5>
</div>

<div class="modal-body">

<div class="row">
    <div class="col-md-6">
        <label>Eje</label>
        <select id="eje" class="form-select" onchange="cargarEje(this)">
            <option value="">Seleccione eje</option>
            <?php foreach($ejes as $e): ?>
                <option value="<?= $e['id_eje'] ?>" data-obj="<?= $e['descripcion_objetivo'] ?>">
                    <?= $e['nombre_eje'] ?>
                </option>
            <?php endforeach ?>
        </select>
    </div>

    <div class="col-md-6">
        <label>Objetivo</label>
        <input id="objetivo" class="form-control" readonly>
    </div>
</div>

<label class="mt-2">Tema POA</label>
<select name="id_tema" class="form-select" required>
<?php foreach($temas as $t): ?>
<option value="<?= $t['id_tema'] ?>" <?= ($elab['id_tema']??'')==$t['id_tema']?'selected':'' ?>>
<?= $t['descripcion'] ?>
</option>
<?php endforeach ?>
</select>

<label class="mt-2">Indicador</label>
<select name="id_indicador" id="indicadores" class="form-select" required>
    <option value="">Seleccione eje primero</option>
</select>

<label class="mt-2">Responsable</label>
<select name="id_responsable" class="form-select">
<?php foreach($responsables as $r): ?>
<option value="<?= $r['id_responsable'] ?>" <?= ($elab['id_responsable']??'')==$r['id_responsable']?'selected':'' ?>>
<?= $r['nombre_responsable'] ?>
</option>
<?php endforeach ?>
</select>

<div class="row mt-3">
<div class="col">
    <label>Indicador de resultado</label>
    <input name="indicador_resultado" class="form-control" value="<?= $elab['indicador_resultado'] ?? '' ?>">
</div>
<div class="col">
    <label>Línea base</label>
    <input name="linea_base" class="form-control" value="<?= $elab['linea_base'] ?? '' ?>">
</div>
</div>

<label>Políticas</label>
<textarea name="politicas" class="form-control"><?= $elab['politicas'] ?? '' ?></textarea>

<label>Metas</label>
<textarea name="metas" class="form-control"><?= $elab['metas'] ?? '' ?></textarea>

<label>Actividades</label>
<textarea name="actividades" class="form-control"><?= $elab['actividades'] ?? '' ?></textarea>

<h5 class="mt-3">Medios de verificación</h5>

<table class="table" id="tablaMedios">
<tr><th>Detalle</th><th>Plazo</th><th></th></tr>
<tr>
<td><input name="detalle[]" class="form-control"></td>
<td>
<select name="id_plazo[]" class="form-select">
<?php foreach($plazos as $p): ?>
<option value="<?= $p['id_plazo'] ?>"><?= $p['nombre_plazo'] ?></option>
<?php endforeach ?>
</select>
</td>
<td><button type="button" class="btn btn-danger" onclick="this.parentNode.parentNode.remove()">X</button></td>
</tr>
</table>

<button type="button" class="btn btn-secondary" onclick="agregarFila()">Agregar medio</button>

<hr>

<label>Nombre del plan</label>
<input class="form-control" value="<?= $plan['nombre_elaborado'] ?>" readonly>

<label>Responsable del plan</label>
<input class="form-control" value="<?= $plan['nombre_responsable'] ?>" readonly>

</div>

<div class="modal-footer">
<button class="btn btn-primary">Guardar</button>
</div>

</form>
<script>
function cargarEje(sel){
    document.getElementById('objetivo').value = sel.options[sel.selectedIndex].dataset.obj;

    fetch('index.php?action=indicadoresPorEje&id_eje=' + sel.value)
    .then(r=>r.json())
    .then(data=>{
        let html = '<option value="">Seleccione</option>';
        data.forEach(i=>{
            html += `<option value="${i.id_indicador}">${i.codigo} - ${i.descripcion}</option>`;
        });
        document.getElementById('indicadores').innerHTML = html;
    });
}

function agregarFila(){
    let tr = document.querySelector('#tablaMedios tr:last-child').cloneNode(true);
    tr.querySelectorAll('input').forEach(i=>i.value='');
    document.querySelector('#tablaMedios').appendChild(tr);
}
</script>
