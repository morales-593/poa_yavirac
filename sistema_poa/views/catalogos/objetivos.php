<?php require 'views/layout/header.php'; ?>

<h2>Objetivos Estratégicos</h2>

<form method="POST" action="index.php?action=guardarObjetivo" class="formulario">
    <select name="id_eje" required>
        <option value="">Seleccione eje</option>
        <?php foreach ($ejes as $e): ?>
            <option value="<?= $e['id_eje'] ?>"><?= $e['nombre'] ?></option>
        <?php endforeach; ?>
    </select>

    <input type="text" name="descripcion" placeholder="Descripción del objetivo" required>
    <button type="submit">Guardar</button>
</form>

<table class="tabla">
    <thead>
        <tr>
            <th>ID</th>
            <th>Eje</th>
            <th>Objetivo</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($objetivos as $o): ?>
        <tr>
            <td><?= $o['id_objetivo'] ?></td>
            <td><?= $o['eje'] ?></td>
            <td><?= $o['descripcion'] ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require 'views/layout/footer.php'; ?>
