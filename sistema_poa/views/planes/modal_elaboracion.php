<form method="POST" action="index.php?action=guardarElaboracion">
<input type="hidden" name="id_plan" value="<?= $id_plan ?>">
<input type="hidden" name="id_elaboracion" value="<?= $elab['id_elaboracion'] ?? '' ?>">

<div class="modal-header bg-primary text-white"><h5>Elaboración</h5></div>
<div class="modal-body">

<select name="id_tema" class="form-control mb-2">
<?php foreach($temas as $t): ?>
<option value="<?= $t['id_tema'] ?>" <?= ($elab['id_tema']??'')==$t['id_tema']?'selected':'' ?>>
<?= $t['descripcion'] ?></option>
<?php endforeach ?>
</select>

<select name="id_indicador" class="form-control mb-2">
<?php foreach($indicadores as $i): ?>
<option value="<?= $i['id_indicador'] ?>" <?= ($elab['id_indicador']??'')==$i['id_indicador']?'selected':'' ?>>
<?= $i['codigo'] ?> - <?= $i['descripcion'] ?></option>
<?php endforeach ?>
</select>

<input name="linea_base" class="form-control mb-2" value="<?= $elab['linea_base'] ?? '' ?>" placeholder="Línea Base">

<textarea name="politicas" class="form-control mb-2"><?= $elab['politicas'] ?? '' ?></textarea>
<textarea name="metas" class="form-control mb-2"><?= $elab['metas'] ?? '' ?></textarea>
<textarea name="actividades" class="form-control mb-2"><?= $elab['actividades'] ?? '' ?></textarea>
<textarea name="indicador_resultado" class="form-control"><?= $elab['indicador_resultado'] ?? '' ?></textarea>

<select name="id_responsable" class="form-control mt-2">
<?php foreach($responsables as $r): ?>
<option value="<?= $r['id_responsable'] ?>" <?= ($elab['id_responsable']??'')==$r['id_responsable']?'selected':'' ?>>
<?= $r['nombre_responsable'] ?></option>
<?php endforeach ?>
</select>

</div>
<div class="modal-footer"><button class="btn btn-primary">Guardar</button></div>
</form>
