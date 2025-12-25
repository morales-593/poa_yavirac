<div class="container-fluid">

    <div class="d-flex justify-content-between mb-3">
        <h4>Ejes y Objetivos</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalEje">
            Nuevo
        </button>
    </div>

    <table class="table table-bordered table-hover">
        <thead class="table-primary">
            <tr>
                <th>ID</th>
                <th>Eje</th>
                <th>Objetivo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ejes as $e): ?>
                <tr>
                    <td><?= $e['id_eje'] ?></td>
                    <td><?= $e['nombre_eje'] ?></td>
                    <td><?= $e['descripcion_objetivo'] ?></td>

                    <td>
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#modalEditar<?= $e['id_eje'] ?>">
                            Editar
                        </button>
                        <a href="index.php?action=eliminarEje&id=<?= $e['id_eje'] ?>"
                            class="btn btn-danger btn-sm">Eliminar</a>
                    </td>
                </tr>
                <div class="modal fade" id="modalEditar<?= $e['id_eje'] ?>">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">

                            <form method="POST" action="index.php?action=editarEje&id=<?= $e['id_eje'] ?>">

                                <div class="modal-header bg-primary text-white">
                                    <h5>Editar Eje y Objetivo</h5>
                                </div>

                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label>Nombre del Eje</label>
                                        <input type="text" name="nombre_eje" class="form-control"
                                            value="<?= $e['nombre_eje'] ?>" required>
                                    </div>

                                    <div class="mb-3">
                                        <label>Descripción del Objetivo</label>
                                        <textarea name="descripcion_objetivo" class="form-control" rows="4"
                                            required><?= $e['descripcion_objetivo'] ?></textarea>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button class="btn btn-primary">Guardar Cambios</button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
        </tbody>
    </table>

</div>

<!-- MODAL -->
<div class="modal fade" id="modalEje">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="index.php?action=guardarEje">

                <div class="modal-header bg-primary text-white">
                    <h5>Nuevo Eje y Objetivo</h5>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nombre del Eje</label>
                        <input type="text" name="nombre_eje" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Descripción del Objetivo</label>
                        <textarea name="descripcion_objetivo" class="form-control" rows="4" required></textarea>
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