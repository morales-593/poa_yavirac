<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Indicadores</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="public/css/indicadores.css">
</head>
<body>
    <div class="container-fluid">

        <div class="page-header">
            <h4><i class="bi bi-graph-up me-2"></i>Gestión de Indicadores</h4>
            <button class="btn btn-primary btn-modern" data-bs-toggle="modal" data-bs-target="#modalIndicador">
                <i class="bi bi-plus-circle"></i> Nuevo Indicador
            </button>
        </div>

        <div class="table-container">
            <table class="table table-hover">
                <thead class="table-primary">
                    <tr>
                        <th width="80">ID</th>
                        <th width="120">Código</th>
                        <th>Descripción</th>
                        <th width="150">Eje</th>
                        <th width="200" class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($indicadores as $i => $indicador): ?>
                        <tr style="--i: <?= $i ?>;">
                            <td data-label="ID">
                                <span class="id-badge">#<?= $indicador['id_indicador'] ?></span>
                            </td>
                            <td data-label="Código" class="codigo-column">
                                <span class="codigo-badge"><?= $indicador['codigo'] ?></span>
                            </td>
                            <td data-label="Descripción" class="descripcion-column">
                                <div class="descripcion-cell"><?= $indicador['descripcion'] ?></div>
                            </td>
                            <td data-label="Eje">
                                <span class="eje-badge"><?= $indicador['nombre_eje'] ?></span>
                            </td>
                            <td data-label="Acciones" class="actions-cell text-center">
                                <a href="index.php?action=eliminarIndicador&id=<?= $indicador['id_indicador'] ?>"
                                    class="btn btn-danger btn-sm btn-modern eliminar-btn">
                                    <i class="bi bi-trash"></i> Eliminar
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    
                    <?php if (empty($indicadores)): ?>
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <i class="bi bi-clipboard-data"></i>
                                    <h5>No hay indicadores registrados</h5>
                                    <p>Comience agregando un nuevo indicador</p>
                                    <button class="btn btn-primary btn-modern mt-3" data-bs-toggle="modal" data-bs-target="#modalIndicador">
                                        <i class="bi bi-plus-circle"></i> Crear primer indicador
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>

    <!-- MODAL para nuevo indicador -->
    <div class="modal fade" id="modalIndicador" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="index.php?action=guardarIndicador">

                    <div class="modal-header">
                        <h5><i class="bi bi-plus-circle me-2"></i>Nuevo Indicador</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-4">
                            <label class="form-label">Código del Indicador</label>
                            <input type="text" name="codigo" class="form-control" required 
                                   placeholder="Ej: IND-001, KPI-01, etc.">
                            <div class="form-text">Ingrese un código único para identificar el indicador.</div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Descripción del Indicador</label>
                            <textarea name="descripcion" class="form-control" rows="4" required 
                                      placeholder="Describa el indicador, qué mide y su importancia..."></textarea>
                            <div class="form-text">Describa el indicador de manera clara y específica.</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Eje Estratégico</label>
                            <select name="id_eje" class="form-select" required>
                                <option value="">Seleccione un eje estratégico...</option>
                                <?php foreach ($ejes as $eje): ?>
                                    <option value="<?= $eje['id_eje'] ?>"><?= $eje['nombre_eje'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="form-text">Seleccione el eje estratégico al que pertenece este indicador.</div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-modern" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle"></i> Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary btn-modern">
                            <i class="bi bi-save"></i> Guardar Indicador
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle con Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Agregar etiquetas de datos para responsividad
            const tableCells = document.querySelectorAll('.table tbody td');
            const headers = Array.from(document.querySelectorAll('.table thead th')).map(th => th.textContent);
            
            tableCells.forEach((cell, index) => {
                const headerIndex = index % headers.length;
                cell.setAttribute('data-label', headers[headerIndex]);
            });
            
            // Confirmación mejorada para eliminación
            const deleteButtons = document.querySelectorAll('.eliminar-btn');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    if (!confirm('¿Está seguro que desea eliminar este indicador? Esta acción no se puede deshacer.')) {
                        e.preventDefault();
                    }
                });
            });
            
            // Animación para modales
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => {
                modal.addEventListener('show.bs.modal', function() {
                    this.querySelector('.modal-content').style.transform = 'scale(0.9)';
                    setTimeout(() => {
                        this.querySelector('.modal-content').style.transform = 'scale(1)';
                        this.querySelector('.modal-content').style.transition = 'transform 0.3s ease';
                    }, 10);
                });
            });
            
            // Enfoque automático en el primer campo del modal
            const modalIndicador = document.getElementById('modalIndicador');
            if (modalIndicador) {
                modalIndicador.addEventListener('shown.bs.modal', function() {
                    const firstInput = this.querySelector('input[name="codigo"]');
                    if (firstInput) {
                        firstInput.focus();
                    }
                });
            }
            
            // Validación básica del código del indicador
            const codigoInput = document.querySelector('input[name="codigo"]');
            if (codigoInput) {
                codigoInput.addEventListener('input', function() {
                    // Convertir a mayúsculas automáticamente
                    this.value = this.value.toUpperCase();
                });
            }
        });
    </script>
</body>
</html>