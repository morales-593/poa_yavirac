<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejecución POA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .drop-zone {
            border: 2px dashed #28a745;
            border-radius: 10px;
            padding: 40px 20px;
            text-align: center;
            background-color: #f8f9fa;
            cursor: pointer;
            transition: all 0.3s;
        }

        .drop-zone:hover,
        .drop-zone.dragover {
            background-color: #e8f5e9;
            border-color: #218838;
        }

        .estado-activo {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            border-left: 5px solid #28a745;
        }

        .estado-pendiente {
            background-color: #fff3cd;
            color: #856404;
            padding: 10px;
            border-radius: 5px;
            border-left: 5px solid #ffc107;
        }
    </style>
</head>

<body>
    <div class="modal-header bg-success text-white d-flex justify-content-between align-items-center">
        <div>
            <h5 class="modal-title mb-0">
                <i class="fas fa-play-circle me-2"></i>
                EJECUCIÓN DEL PLAN OPERATIVO
            </h5>
            <small class="text-white-50">Carga de documentos finales</small>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
    </div>

    <form method="POST" action="index.php?action=guardarEjecucion" enctype="multipart/form-data" id="formEjecucion">
        <input type="hidden" name="id_plan" value="<?= $id_plan ?>">
        <input type="hidden" name="id_elaboracion" value="<?= $datos_elaboracion['id_elaboracion'] ?? '' ?>">
        <?php if (isset($ejecucion_existente['id_ejecucion'])): ?>
            <input type="hidden" name="id_ejecucion" value="<?= $ejecucion_existente['id_ejecucion'] ?>">
        <?php endif; ?>

        <div class="modal-body" style="max-height: 80vh; overflow-y: auto;">

            <!-- ESTADO ACTUAL -->
            <div class="card mb-4 border-success">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0"><i class="fas fa-clipboard-list me-2"></i> ESTADO ACTUAL DEL PLAN</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-4">
                            <div class="estado-activo">
                                <i class="fas fa-check-circle fa-2x mb-2"></i>
                                <h5>ELABORACIÓN</h5>
                                <p class="mb-0">COMPLETADA</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="<?= Plan::tieneSeguimiento($id_plan) ? 'estado-activo' : 'estado-pendiente' ?>">
                                <i
                                    class="fas <?= Plan::tieneSeguimiento($id_plan) ? 'fa-check-circle' : 'fa-clock' ?> fa-2x mb-2"></i>
                                <h5>SEGUIMIENTO</h5>
                                <p class="mb-0"><?= Plan::tieneSeguimiento($id_plan) ? 'COMPLETADO' : 'PENDIENTE' ?></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="<?= Plan::tieneEjecucion($id_plan) ? 'estado-activo' : 'estado-pendiente' ?>">
                                <i
                                    class="fas <?= Plan::tieneEjecucion($id_plan) ? 'fa-check-circle' : 'fa-play-circle' ?> fa-2x mb-2"></i>
                                <h5>EJECUCIÓN</h5>
                                <p class="mb-0"><?= Plan::tieneEjecucion($id_plan) ? 'COMPLETADA' : 'EN PROCESO' ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- INFORMACIÓN DE EJECUCIÓN -->
            <div class="card mb-4 border-primary">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i> INFORMACIÓN DE EJECUCIÓN</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">NOMBRE DE EJECUCIÓN *</label>
                                <input type="text" name="nombre_ejecucion" class="form-control"
                                    value="<?= htmlspecialchars($ejecucion_existente['nombre_ejecucion'] ?? 'Ejecución Final ' . date('Y')) ?>"
                                    required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">FECHA DE EJECUCIÓN *</label>
                                <input type="date" name="fecha_ejecucion" class="form-control"
                                    value="<?= $ejecucion_existente['fecha_ejecucion'] ?? date('Y-m-d') ?>" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">RESULTADO FINAL *</label>
                                <select name="resultado_final" class="form-select" required>
                                    <option value="">-- Seleccione --</option>
                                    <option value="APROBADO" <?= ($ejecucion_existente['resultado_final'] ?? '') == 'APROBADO' ? 'selected' : '' ?>>Aprobado</option>
                                    <option value="RECHAZADO" <?= ($ejecucion_existente['resultado_final'] ?? '') == 'RECHAZADO' ? 'selected' : '' ?>>Rechazado</option>
                                    <option value="PENDIENTE" <?= ($ejecucion_existente['resultado_final'] ?? '') == 'PENDIENTE' ? 'selected' : '' ?>>Pendiente</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">PERSONA RESPONSABLE *</label>
                                <input type="text" name="persona_responsable" class="form-control"
                                    value="<?= htmlspecialchars($ejecucion_existente['persona_responsable'] ?? $datos_elaboracion['nombre_completo_responsable'] ?? '') ?>"
                                    required>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="mb-3">
                                <label class="form-label fw-bold">OBSERVACIONES DE EJECUCIÓN</label>
                                <textarea name="observaciones_ejecucion" class="form-control" rows="3"
                                    placeholder="Observaciones adicionales sobre la ejecución..."><?= htmlspecialchars($ejecucion_existente['observaciones_ejecucion'] ?? '') ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CARGA DE ARCHIVOS -->
            <div class="card mb-4 border-warning">
                <div class="card-header bg-warning text-white">
                    <h6 class="mb-0"><i class="fas fa-file-upload me-2"></i> CARGA DE DOCUMENTOS (PDF)</h6>
                </div>
                <div class="card-body">

                    <!-- ARCHIVO DE ELABORACIÓN -->
                    <div class="mb-4">
                        <h6 class="border-bottom pb-2 mb-3">1. Documento de Elaboración *</h6>
                        <div class="drop-zone" id="dropZoneElaboracion"
                            onclick="document.getElementById('fileElaboracion').click()">
                            <i class="fas fa-file-pdf fa-3x text-danger mb-3"></i>
                            <h5>Documento PDF de Elaboración</h5>
                            <p class="text-muted">Arrastra o haz clic para seleccionar el documento final de elaboración
                            </p>
                            <input type="file" name="archivo_elaboracion" id="fileElaboracion" accept=".pdf"
                                style="display: none;" required>
                        </div>
                        <div id="elaboracionFileInfo" class="mt-2"></div>
                    </div>

                    <!-- ARCHIVO DE SEGUIMIENTO -->
                    <div class="mb-4">
                        <h6 class="border-bottom pb-2 mb-3">2. Documento de Seguimiento *</h6>
                        <div class="drop-zone" id="dropZoneSeguimiento"
                            onclick="document.getElementById('fileSeguimiento').click()">
                            <i class="fas fa-chart-line fa-3x text-primary mb-3"></i>
                            <h5>Documento PDF de Seguimiento</h5>
                            <p class="text-muted">Arrastra o haz clic para seleccionar el documento de seguimiento</p>
                            <input type="file" name="archivo_seguimiento" id="fileSeguimiento" accept=".pdf"
                                style="display: none;" required>
                        </div>
                        <div id="seguimientoFileInfo" class="mt-2"></div>
                    </div>

                    <!-- ARCHIVOS ADICIONALES -->
                    <div class="mb-4">
                        <h6 class="border-bottom pb-2 mb-3">3. Archivos Adicionales (Opcional)</h6>
                        <div class="drop-zone" id="dropZoneAdicionales"
                            onclick="document.getElementById('fileAdicionales').click()">
                            <i class="fas fa-folder-plus fa-3x text-secondary mb-3"></i>
                            <h5>Archivos Adicionales</h5>
                            <p class="text-muted">Arrastra o haz clic para seleccionar archivos adicionales</p>
                            <input type="file" name="archivos_adicionales[]" id="fileAdicionales" multiple accept=".pdf"
                                style="display: none;">
                        </div>
                        <div id="adicionalesFileInfo" class="mt-2"></div>
                    </div>

                    <!-- ARCHIVOS EXISTENTES -->
                    <?php if (!empty($archivos_ejecucion)): ?>
                        <div class="mt-4">
                            <h6 class="border-bottom pb-2">Archivos ya subidos</h6>
                            <div class="list-group">
                                <?php foreach ($archivos_ejecucion as $archivo): ?>
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-file-pdf text-danger fa-2x me-3"></i>
                                            <div>
                                                <div class="fw-bold"><?= htmlspecialchars($archivo['nombre_archivo']) ?></div>
                                                <small class="text-muted">
                                                    Tipo: <?= $archivo['tipo_archivo'] ?> |
                                                    Subido: <?= date('d/m/Y H:i', strtotime($archivo['fecha_subida'])) ?>
                                                </small>
                                            </div>
                                        </div>
                                        <div>
                                            <a href="<?= $archivo['ruta_archivo'] ?>" target="_blank"
                                                class="btn btn-sm btn-outline-primary me-2" title="Ver">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="index.php?action=eliminarArchivoEjecucion&id=<?= $archivo['id_archivo_ejec'] ?>&id_plan=<?= $id_plan ?>"
                                                class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('¿Eliminar este archivo?')" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>
            </div>

        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                <i class="fas fa-times me-1"></i> Cancelar
            </button>
            <button type="submit" class="btn btn-success" id="btnSubmitEjecucion">
                <i class="fas fa-save me-1"></i> Guardar Ejecución
            </button>
        </div>
    </form>

    <script>
        // Configurar drag & drop para cada zona
        function setupDropZone(dropZoneId, fileInputId, fileInfoId) {
            const dropZone = document.getElementById(dropZoneId);
            const fileInput = document.getElementById(fileInputId);
            const fileInfo = document.getElementById(fileInfoId);

            if (!dropZone || !fileInput) return;

            // Eventos drag & drop
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            // Efectos visuales
            ['dragenter', 'dragover'].forEach(eventName => {
                dropZone.addEventListener(eventName, () => dropZone.classList.add('dragover'), false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, () => dropZone.classList.remove('dragover'), false);
            });

            // Manejar archivo soltado
            dropZone.addEventListener('drop', handleDrop, false);

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;

                if (files.length > 0) {
                    // Validar que sea PDF
                    const file = files[0];
                    if (file.type !== 'application/pdf') {
                        alert('Solo se permiten archivos PDF');
                        return;
                    }

                    // Asignar archivo al input
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    fileInput.files = dataTransfer.files;

                    // Mostrar información del archivo
                    showFileInfo(file);
                }
            }

            // Cambio en input de archivo
            fileInput.addEventListener('change', function () {
                if (this.files.length > 0) {
                    showFileInfo(this.files[0]);
                }
            });

            function showFileInfo(file) {
                const fileSize = (file.size / 1024 / 1024).toFixed(2); // MB
                fileInfo.innerHTML = `
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>
                        <strong>${file.name}</strong> (${fileSize} MB)
                        <br><small>Archivo listo para subir</small>
                    </div>
                `;
            }
        }

        // Configurar las tres zonas
        document.addEventListener('DOMContentLoaded', function () {
            setupDropZone('dropZoneElaboracion', 'fileElaboracion', 'elaboracionFileInfo');
            setupDropZone('dropZoneSeguimiento', 'fileSeguimiento', 'seguimientoFileInfo');
            setupDropZone('dropZoneAdicionales', 'fileAdicionales', 'adicionalesFileInfo');

            // Configurar validación del formulario
            document.getElementById('formEjecucion').addEventListener('submit', function (e) {
                // Validar campos requeridos
                const requiredFields = [
                    { name: 'nombre_ejecucion', label: 'Nombre de ejecución' },
                    { name: 'fecha_ejecucion', label: 'Fecha de ejecución' },
                    { name: 'resultado_final', label: 'Resultado final' },
                    { name: 'persona_responsable', label: 'Persona responsable' }
                ];

                let errores = [];

                requiredFields.forEach(field => {
                    const element = document.querySelector(`[name="${field.name}"]`);
                    if (element && !element.value) {
                        element.classList.add('is-invalid');
                        errores.push(field.label);
                    } else if (element) {
                        element.classList.remove('is-invalid');
                    }
                });

                // Validar archivos
                const archivoElaboracion = document.getElementById('fileElaboracion');
                const archivoSeguimiento = document.getElementById('fileSeguimiento');

                if (!archivoElaboracion.files.length) {
                    errores.push('Documento de elaboración');
                }

                if (!archivoSeguimiento.files.length) {
                    errores.push('Documento de seguimiento');
                }

                if (errores.length > 0) {
                    e.preventDefault();
                    alert('Complete los siguientes campos requeridos:\n- ' + errores.join('\n- '));
                    return false;
                }

                // Deshabilitar botón mientras se procesa
                const btnSubmit = document.getElementById('btnSubmitEjecucion');
                btnSubmit.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Procesando...';
                btnSubmit.disabled = true;
            });
        });
    </script>
</body>

</html>