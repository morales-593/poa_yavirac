<h2>Ejes Estratégicos</h2>

<form method="POST" action="index.php?action=guardarEje">
    <input type="text" name="nombre" placeholder="Nombre del eje" required>
    <input type="text" name="descripcion" placeholder="Descripción">
    <button type="submit">Guardar</button>
</form>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Descripción</th>
    </tr>
    <?php foreach ($ejes as $e): ?>
    <tr>
        <td><?= $e['id_eje'] ?></td>
        <td><?= $e['nombre'] ?></td>
        <td><?= $e['descripcion'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>
