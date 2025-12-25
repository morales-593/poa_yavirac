<div class="container-fluid">

<div class="d-flex justify-content-between mb-3">
    <h4>Temas POA</h4>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTema">
        Nuevo Tema
    </button>
</div>

<table class="table table-bordered table-hover">
    <thead class="table-primary">
        <tr>
            <th>ID</th>
            <th>Descripción</th>
            <th>Estado</th>
            <th style="width:180px">Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($temas as $t): ?>
        <tr>
            <td><?= $t['id_tema'] ?></td>
            <td><?= htmlspecialchars($t['descripcion']) ?></td>
            <td>
                <span class="badge bg-<?= $t['estado']=='ACTIVO'?'success':'danger' ?>">
                    <?= $t['estado'] ?>
                </span>
            </td>
            <td>
                <?php if ($t['estado'] == 'ACTIVO'): ?>
                    <a href="index.php?action=estadoTema&id=<?= $t['id_tema'] ?>&estado=INACTIVO"
                       class="btn btn-danger btn-sm">
                        Desactivar
                    </a>
                <?php else: ?>
                    <a href="index.php?action=estadoTema&id=<?= $t['id_tema'] ?>&estado=ACTIVO"
                       class="btn btn-success btn-sm">
                        Activar
                    </a>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</div>

<!-- MODAL NUEVO TEMA -->
<div class="modal fade" id="modalTema">
<div class="modal-dialog">
<div class="modal-content">
<form method="POST" action="index.php?action=guardarTema">

<div class="modal-header bg-primary text-white">
    <h5>Nuevo Tema POA</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
    <label class="form-label">Descripción</label>
    <input type="text" name="descripcion" class="form-control" required>
</div>

<div class="modal-footer">
    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
    <button class="btn btn-primary">Guardar</button>
</div>

</form>
</div>
</div>
</div>
