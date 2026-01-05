<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seguimiento POA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Incluir jsPDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>

    <style>
        .card-header {
            background: linear-gradient(45deg, #6c757d, #5a6268);
            color: white;
        }

        .table-medios th {
            background-color: #343a40;
            color: white;
        }

        .campo-solo-lectura {
            background-color: #f8f9fa !important;
            border: 1px solid #dee2e6 !important;
            cursor: not-allowed;
        }

        .estado-badge {
            font-size: 0.85em;
            padding: 5px 10px;
        }

        .pdf-only {
            display: none;
        }

        .btn-export {
            background: linear-gradient(45deg, #dc3545, #c82333);
            border: none;
            color: white;
        }

        .btn-export:hover {
            background: linear-gradient(45deg, #c82333, #bd2130);
            color: white;
        }

        .observacion-calificacion {
            font-weight: bold;
            color: #0d6efd;
        }

        .porcentaje-excelente {
            color: #198754;
            font-weight: bold;
        }
        
        .porcentaje-bueno {
            color: #0dcaf0;
            font-weight: bold;
        }
        
        .porcentaje-regular {
            color: #ffc107;
            font-weight: bold;
        }
        
        .porcentaje-deficiente {
            color: #dc3545;
            font-weight: bold;
        }
        
        .tabla-medios td, .tabla-medios th {
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <div class="modal-header bg-dark text-white d-flex justify-content-between align-items-center">
        <div>
            <h5 class="modal-title mb-0">
                <i class="fas fa-chart-line me-2"></i>
                SEGUIMIENTO DEL PLAN OPERATIVO
            </h5>
            <small class="text-white-50">Información de seguimiento - Solo lectura excepto medios de verificación</small>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
    </div>

    <form method="POST" action="index.php?action=guardarSeguimiento" id="formSeguimiento" enctype="multipart/form-data">
        <input type="hidden" name="id_plan" value="<?= $id_plan ?>">
        <input type="hidden" name="id_elaboracion" value="<?= $datos_elaboracion['id_elaboracion'] ?? '' ?>">
        
        <div class="modal-body" style="max-height: 80vh; overflow-y: auto;">
            
            <!-- INFORMACIÓN GENERAL -->
            <div class="card mb-4 border-dark">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i> INFORMACIÓN GENERAL</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">TEMA</label>
                                <input type="text" class="form-control campo-solo-lectura" 
                                       value="<?= htmlspecialchars($datos_elaboracion['tema'] ?? '') ?>" readonly>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">EJE</label>
                                <input type="text" class="form-control campo-solo-lectura" 
                                       value="<?= htmlspecialchars($datos_elaboracion['nombre_eje'] ?? '') ?>" readonly>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">OBJETIVO</label>
                                <textarea class="form-control campo-solo-lectura" rows="3" readonly><?= htmlspecialchars($datos_elaboracion['objetivo'] ?? '') ?></textarea>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">INDICADOR</label>
                                <input type="text" class="form-control campo-solo-lectura" 
                                       value="<?= htmlspecialchars($datos_elaboracion['codigo'] ?? '') ?> - <?= htmlspecialchars($datos_elaboracion['descripcion_indicador'] ?? '') ?>" readonly>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">LÍNEA BASE</label>
                                <input type="text" class="form-control campo-solo-lectura" 
                                       value="<?= htmlspecialchars($datos_elaboracion['linea_base'] ?? '') ?>" readonly>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">POLÍTICAS</label>
                                <textarea class="form-control campo-solo-lectura" rows="2" readonly><?= htmlspecialchars($datos_elaboracion['politicas'] ?? '') ?></textarea>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">METAS</label>
                                <textarea class="form-control campo-solo-lectura" rows="2" readonly><?= htmlspecialchars($datos_elaboracion['metas'] ?? '') ?></textarea>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">ACTIVIDADES</label>
                                <textarea class="form-control campo-solo-lectura" rows="2" readonly><?= htmlspecialchars($datos_elaboracion['actividades'] ?? '') ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- INDICADOR DE RESULTADO -->
            <div class="card mb-4 border-primary">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0"><i class="fas fa-bullseye me-2"></i> INDICADOR DE RESULTADO</h6>
                </div>
                <div class="card-body">
                    <textarea class="form-control campo-solo-lectura" rows="2" readonly><?= htmlspecialchars($datos_elaboracion['indicador_resultado'] ?? '') ?></textarea>
                </div>
            </div>

            <!-- MEDIOS DE VERIFICACIÓN - SEGUIMIENTO -->
            <div class="card mb-4 border-success">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0"><i class="fas fa-clipboard-check me-2"></i> MEDIO DE VERIFICACIÓN - SEGUIMIENTO</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover tabla-medios" id="tabla-medios">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center">#</th>
                                    <th width="45%">DETALLE</th>
                                    <th width="15%">PLAZO</th>
                                    <th width="15%" class="text-center">CUMPLIMIENTO *</th>
                                    <th width="20%">ESTADO</th>
                                </tr>
                            </thead>
                            <tbody id="medios-tbody">
                                <?php if (empty($medios_verificacion)): ?>
                                        <tr>
                                            <td colspan="5" class="text-center py-4 text-muted">
                                                <i class="fas fa-exclamation-triangle fa-2x mb-3"></i>
                                                <p>No hay medios de verificación definidos</p>
                                            </td>
                                        </tr>
                                <?php else: ?>
                                        <?php foreach ($medios_verificacion as $index => $medio): ?>
                                                <?php
                                                // Obtener cumplimiento existente para este medio si existe
                                                $cumplimiento_existente = 'NO';
                                                $estado_existente = '';

                                                if (!empty($calificaciones_detalladas)) {
                                                    foreach ($calificaciones_detalladas as $calificacion) {
                                                        if ($calificacion['id_medio'] == $medio['id_medio']) {
                                                            $cumplimiento_existente = $calificacion['cumplimiento'];
                                                            $estado_existente = $calificacion['cumplimiento'] == 'SI'
                                                                ? 'CUMPLE - Medio verificado correctamente'
                                                                : 'NO CUMPLE - Medio no verificado';
                                                            break;
                                                        }
                                                    }
                                                }
                                                ?>
                                                <tr data-medio-id="<?= $medio['id_medio'] ?>">
                                                    <td class="text-center align-middle">
                                                        <strong><?= $index + 1 ?></strong>
                                                        <input type="hidden" name="id_medio_<?= $index ?>" value="<?= $medio['id_medio'] ?>">
                                                    </td>
                                                    <td class="align-middle">
                                                        <textarea class="form-control campo-solo-lectura detalle-medio" rows="2" readonly><?= htmlspecialchars($medio['detalle'] ?? '') ?></textarea>
                                                    </td>
                                                    <td class="align-middle">
                                                        <input type="text" class="form-control campo-solo-lectura plazo-medio" 
                                                               value="<?= htmlspecialchars($medio['nombre_plazo'] ?? '') ?>" readonly>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <div class="btn-group btn-group-sm" role="group">
                                                            <input type="radio" class="btn-check cumplimiento-radio" 
                                                                   name="cumplimiento_<?= $index ?>" 
                                                                   id="cumple_<?= $index ?>" value="SI" 
                                                                   <?= ($cumplimiento_existente == 'SI') ? 'checked' : '' ?>
                                                                   onchange="calcularPorcentaje()">
                                                            <label class="btn btn-outline-success" for="cumple_<?= $index ?>">Sí</label>
                                            
                                                            <input type="radio" class="btn-check cumplimiento-radio" 
                                                                   name="cumplimiento_<?= $index ?>" 
                                                                   id="no_cumple_<?= $index ?>" value="NO"
                                                                   <?= ($cumplimiento_existente == 'NO') ? 'checked' : '' ?>
                                                                   onchange="calcularPorcentaje()">
                                                            <label class="btn btn-outline-danger" for="no_cumple_<?= $index ?>">No</label>
                                                        </div>
                                                    </td>
                                                    <td class="align-middle">
                                                        <textarea class="form-control campo-solo-lectura estado-medio" rows="2" readonly 
                                                                  placeholder="Estado automático..."><?= htmlspecialchars($estado_existente) ?></textarea>
                                                        <input type="hidden" name="observacion_medio_<?= $index ?>" value="<?= htmlspecialchars($estado_existente) ?>">
                                                    </td>
                                                </tr>
                                        <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- PORCENTAJE DE CUMPLIMIENTO -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h6 class="card-title mb-3">PORCENTAJE DE CUMPLIMIENTO</h6>
                                    <?php if ($seguimiento_existente): ?>
                                            <?php
                                            $clase_porcentaje = '';
                                            $porcentaje = $seguimiento_existente['porcentaje_cumplimiento'] ?? 0;

                                            if ($porcentaje >= 90) {
                                                $clase_porcentaje = 'porcentaje-excelente';
                                            } elseif ($porcentaje >= 80) {
                                                $clase_porcentaje = 'porcentaje-bueno';
                                            } elseif ($porcentaje >= 70) {
                                                $clase_porcentaje = 'porcentaje-bueno';
                                            } elseif ($porcentaje >= 60) {
                                                $clase_porcentaje = 'porcentaje-regular';
                                            } else {
                                                $clase_porcentaje = 'porcentaje-deficiente';
                                            }
                                            ?>
                                            <div class="display-4 fw-bold <?= $clase_porcentaje ?>" id="porcentaje-total">
                                                <?= $porcentaje ?>%
                                            </div>
                                            <p class="text-muted mb-0 mt-2" id="resumen-porcentaje">
                                                <?php
                                                $cumplidos = 0;
                                                $total = count($medios_verificacion);
                                                if (!empty($calificaciones_detalladas)) {
                                                    foreach ($calificaciones_detalladas as $calificacion) {
                                                        if ($calificacion['cumplimiento'] == 'SI') {
                                                            $cumplidos++;
                                                        }
                                                    }
                                                }
                                                echo "$cumplidos de $total medios cumplidos";
                                                ?>
                                            </p>
                                    <?php else: ?>
                                            <div class="display-4 fw-bold text-primary" id="porcentaje-total">0%</div>
                                            <p class="text-muted mb-0 mt-2" id="resumen-porcentaje">
                                                <span id="contador-si">0</span> de <span id="total-medios"><?= count($medios_verificacion) ?></span> medios cumplidos
                                            </p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- INFORMACIÓN DE RESPONSABILIDAD -->
            <div class="card mb-4 border-info">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0"><i class="fas fa-users me-2"></i> INFORMACIÓN DE RESPONSABILIDAD</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">RESPONSABLE</label>
                                <input type="text" class="form-control campo-solo-lectura responsable-input" 
                                       value="<?= htmlspecialchars($datos_elaboracion['nombre_completo_responsable'] ?? '') ?>" readonly>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">FECHA DE SEGUIMIENTO *</label>
                                <input type="date" name="fecha_seguimiento" class="form-control fecha-seguimiento" 
                                       value="<?= $seguimiento_existente ? $seguimiento_existente['fecha_seguimiento'] : date('Y-m-d') ?>" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">NOMBRE ELABORADO</label>
                                <input type="text" class="form-control campo-solo-lectura elaborado-input" 
                                       value="<?= htmlspecialchars($datos_elaboracion['nombre_elaborado'] ?? '') ?>" readonly>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">NOMBRE RESPONSABLE</label>
                                <input type="text" class="form-control campo-solo-lectura nombre-responsable-input" 
                                       value="<?= htmlspecialchars($datos_elaboracion['nombre_responsable'] ?? '') ?>" readonly>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">OBSERVACIÓN GENERAL</label>
                        <textarea name="observacion_general" class="form-control observacion-general" rows="3" 
                                  placeholder="Observaciones generales del seguimiento..."><?= $seguimiento_existente ? htmlspecialchars($seguimiento_existente['observacion_general'] ?? '') : '' ?></textarea>
                    </div>
                </div>
            </div>

        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                <i class="fas fa-times me-1"></i> Cancelar
            </button>
            <button type="button" class="btn btn-export" onclick="exportarPDF()" id="btn-exportar">
                <i class="fas fa-file-pdf me-1"></i> Exportar PDF
            </button>
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save me-1"></i> Guardar Seguimiento
            </button>
        </div>
    </form>

    <script>
        // ==============================================
        // CALCULAR PORCENTAJE DE CUMPLIMIENTO
        // ==============================================
        function calcularPorcentaje() {
            const radios = document.querySelectorAll('.cumplimiento-radio:checked');
            const totalMedios = document.querySelectorAll('.cumplimiento-radio').length / 2;
            let siCount = 0;
            
            // Contar cuántos "SI" hay
            radios.forEach(radio => {
                if (radio.value === 'SI') {
                    siCount++;
                }
            });
            
            // Calcular porcentaje
            let porcentaje = 0;
            if (totalMedios > 0) {
                porcentaje = Math.round((siCount / totalMedios) * 100);
            }
            
            // Actualizar contadores
            document.getElementById('contador-si').textContent = siCount;
            document.getElementById('total-medios').textContent = totalMedios;
            
            // Actualizar el porcentaje
            const porcentajeElement = document.getElementById('porcentaje-total');
            porcentajeElement.textContent = porcentaje + '%';
            
            // Determinar color según porcentaje
            let colorClass = '';
            
            if (porcentaje >= 90) {
                colorClass = 'porcentaje-excelente';
            } else if (porcentaje >= 80) {
                colorClass = 'porcentaje-bueno';
            } else if (porcentaje >= 70) {
                colorClass = 'porcentaje-bueno';
            } else if (porcentaje >= 60) {
                colorClass = 'porcentaje-regular';
            } else {
                colorClass = 'porcentaje-deficiente';
            }
            
            // Actualizar color del porcentaje
            porcentajeElement.className = 'display-4 fw-bold ' + colorClass;
            
            // Actualizar texto de resumen
            const resumenElement = document.getElementById('resumen-porcentaje');
            resumenElement.innerHTML = `${siCount} de ${totalMedios} medios cumplidos`;
            
            // Actualizar estados individuales en cada medio
            const estados = document.querySelectorAll('.estado-medio');
            estados.forEach((estado, index) => {
                const radioSi = document.querySelector(`#cumple_${index}`);
                const radioNo = document.querySelector(`#no_cumple_${index}`);
                const hiddenObservacion = document.querySelector(`input[name="observacion_medio_${index}"]`);
                
                if (radioSi && radioSi.checked) {
                    estado.value = 'CUMPLE - Medio verificado correctamente';
                    estado.classList.remove('border-danger');
                    estado.classList.add('border-success');
                    hiddenObservacion.value = 'CUMPLE - Medio verificado correctamente';
                } else if (radioNo && radioNo.checked) {
                    estado.value = 'NO CUMPLE - Medio no verificado';
                    estado.classList.remove('border-success');
                    estado.classList.add('border-danger');
                    hiddenObservacion.value = 'NO CUMPLE - Medio no verificado';
                }
            });
            
            // Actualizar observación general si está vacía
            const observacionGeneral = document.querySelector('.observacion-general');
            if (!observacionGeneral.value.trim()) {
                observacionGeneral.value = `Porcentaje de cumplimiento: ${porcentaje}%\n\n`;
            }
            
            return {
                porcentaje: porcentaje,
                cumplidos: siCount,
                total: totalMedios
            };
        }
        
        // Calcular porcentaje al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            calcularPorcentaje();
        });
        
        // ==============================================
        // VALIDACIÓN DEL FORMULARIO
        // ==============================================
        document.getElementById('formSeguimiento').addEventListener('submit', function(e) {
            // Validar fecha
            const fechaInput = document.querySelector('input[name="fecha_seguimiento"]');
            if (!fechaInput.value) {
                alert('La fecha de seguimiento es obligatoria para guardar');
                fechaInput.focus();
                e.preventDefault();
                return false;
            }
            
            // Validar que todos los medios tengan cumplimiento seleccionado
            const totalMedios = <?= count($medios_verificacion) ?>;
            let mediosCompletos = true;
            
            for (let i = 0; i < totalMedios; i++) {
                const radioSi = document.querySelector(`#cumple_${i}`);
                const radioNo = document.querySelector(`#no_cumple_${i}`);
                
                if (!radioSi.checked && !radioNo.checked) {
                    mediosCompletos = false;
                    alert(`Debe seleccionar cumplimiento para el medio #${i + 1}`);
                    break;
                }
            }
            
            if (!mediosCompletos) {
                e.preventDefault();
                return false;
            }
            
            // Mostrar confirmación con porcentaje
            const porcentaje = calcularPorcentaje();
            if (!confirm(`¿Desea guardar el seguimiento con ${porcentaje.porcentaje}% de cumplimiento?`)) {
                e.preventDefault();
                return false;
            }
            
            // Deshabilitar botón mientras se procesa
            const btnSubmit = this.querySelector('button[type="submit"]');
            btnSubmit.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Guardando...';
            btnSubmit.disabled = true;
        });

        // ==============================================
        // FUNCIÓN PARA EXPORTAR A PDF
        // ==============================================
        function exportarPDF() {
            try {
                // Verificar si jsPDF está disponible
                if (typeof window.jspdf === 'undefined') {
                    alert('Error: La librería jsPDF no está cargada. Por favor recargue la página.');
                    return;
                }

                // Deshabilitar botón temporalmente
                const btnExportar = document.getElementById('btn-exportar');
                const originalText = btnExportar.innerHTML;
                btnExportar.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Generando...';
                btnExportar.disabled = true;

                const { jsPDF } = window.jspdf;
                const doc = new jsPDF('p', 'mm', 'a4');

                // Configurar fuente
                doc.setFont('helvetica');

                // ==============================
                // ENCABEZADO DEL DOCUMENTO
                // ==============================
                let yPos = 10;

                // Título principal
                doc.setFontSize(16);
                doc.setTextColor(0, 0, 128);
                doc.setFont('helvetica', 'bold');
                doc.text('INSTITUTO SUPERIOR TECNOLÓGICO TURÍSTICO Y PATRIMONIAL "YAVIRAC"', 105, yPos, { align: 'center' });
                yPos += 8;

                doc.setFontSize(14);
                doc.text('INFORME DE SEGUIMIENTO - PLAN OPERATIVO ANUAL', 105, yPos, { align: 'center' });
                yPos += 6;

                doc.setFontSize(11);
                doc.setTextColor(0, 0, 0);
                const fechaSeguimiento = document.querySelector('.fecha-seguimiento')?.value || 'No especificada';
                doc.text(`Fecha de Seguimiento: ${fechaSeguimiento}`, 105, yPos, { align: 'center' });
                yPos += 12;

                // Línea separadora
                doc.setDrawColor(0, 0, 128);
                doc.setLineWidth(0.5);
                doc.line(20, yPos, 190, yPos);
                yPos += 15;

                // ==============================
                // INFORMACIÓN GENERAL
                // ==============================
                doc.setFontSize(12);
                doc.setTextColor(0, 0, 128);
                doc.setFont('helvetica', 'bold');
                doc.text('1. INFORMACIÓN GENERAL DEL PLAN', 20, yPos);
                yPos += 8;

                // Función para crear sección
                function crearSeccion(titulo, contenido) {
                    if (yPos > 270) {
                        doc.addPage();
                        yPos = 20;
                    }
                    
                    doc.setFontSize(11);
                    doc.setTextColor(0, 0, 128);
                    doc.setFont('helvetica', 'bold');
                    doc.text(titulo + ':', 20, yPos);
                    yPos += 5;

                    doc.setFontSize(10);
                    doc.setTextColor(0, 0, 0);
                    doc.setFont('helvetica', 'normal');
                    
                    let texto = contenido || 'No especificado';
                    if (texto === 'No especificado') {
                        doc.setTextColor(120, 120, 120);
                    }
                    
                    const lineas = doc.splitTextToSize(texto, 170);
                    lineas.forEach((linea, idx) => {
                        doc.text(linea, 25, yPos + (idx * 4.5));
                    });
                    
                    yPos += (lineas.length * 4.5) + 8;
                    doc.setTextColor(0, 0, 0);
                }

                // Obtener datos
                const getValue = (selector) => {
                    const element = document.querySelector(selector);
                    return element ? element.value : 'No especificado';
                };

                const datos = {
                    tema: getValue('.campo-solo-lectura'),
                    eje: document.querySelectorAll('.campo-solo-lectura')[1]?.value || 'No especificado',
                    objetivo: document.querySelectorAll('textarea.campo-solo-lectura')[0]?.value || 'No especificado',
                    indicador: document.querySelectorAll('.campo-solo-lectura')[3]?.value || 'No especificado',
                    linea_base: document.querySelectorAll('.campo-solo-lectura')[4]?.value || 'No especificado',
                    politicas: document.querySelectorAll('textarea.campo-solo-lectura')[1]?.value || 'No especificado',
                    metas: document.querySelectorAll('textarea.campo-solo-lectura')[2]?.value || 'No especificado',
                    actividades: document.querySelectorAll('textarea.campo-solo-lectura')[3]?.value || 'No especificado',
                    indicador_resultado: document.querySelectorAll('textarea.campo-solo-lectura')[4]?.value || 'No especificado',
                    responsable: getValue('.responsable-input'),
                    fecha_seguimiento: getValue('.fecha-seguimiento'),
                    elaborado: getValue('.elaborado-input'),
                    nombre_responsable: getValue('.nombre-responsable-input'),
                    observacion_general: getValue('.observacion-general')
                };

                // Agregar secciones
                crearSeccion('Tema', datos.tema);
                crearSeccion('Eje Estratégico', datos.eje);
                crearSeccion('Objetivo', datos.objetivo);
                crearSeccion('Indicador', datos.indicador);
                crearSeccion('Línea Base', datos.linea_base);
                crearSeccion('Políticas', datos.politicas);
                crearSeccion('Metas', datos.metas);
                crearSeccion('Actividades', datos.actividades);
                crearSeccion('Indicador de Resultado', datos.indicador_resultado);

                // ==============================
                // MEDIOS DE VERIFICACIÓN Y PORCENTAJE
                // ==============================
                if (yPos > 200) {
                    doc.addPage();
                    yPos = 20;
                }

                doc.setFontSize(12);
                doc.setTextColor(0, 0, 128);
                doc.setFont('helvetica', 'bold');
                doc.text('2. EVALUACIÓN DE MEDIOS DE VERIFICACIÓN', 20, yPos);
                yPos += 10;

                // Calcular porcentaje general
                const porcentaje = calcularPorcentaje();
                
                // Mostrar resumen de porcentaje
                doc.setFontSize(11);
                doc.setFont('helvetica', 'bold');
                doc.text('PORCENTAJE DE CUMPLIMIENTO:', 20, yPos);
                yPos += 6;
                
                // Color según porcentaje
                if (porcentaje.porcentaje >= 90) {
                    doc.setTextColor(0, 128, 0);
                } else if (porcentaje.porcentaje >= 70) {
                    doc.setTextColor(0, 128, 255);
                } else if (porcentaje.porcentaje >= 60) {
                    doc.setTextColor(255, 193, 7);
                } else {
                    doc.setTextColor(255, 0, 0);
                }
                
                doc.setFontSize(14);
                doc.text(`${porcentaje.porcentaje}%`, 20, yPos);
                yPos += 8;
                
                doc.setFontSize(10);
                doc.setTextColor(0, 0, 0);
                doc.text(`${porcentaje.cumplidos} de ${porcentaje.total} medios cumplidos`, 20, yPos);
                yPos += 12;

                // Tabla de medios
                const mediosData = [];
                const filasMedios = document.querySelectorAll('#medios-tbody tr[data-medio-id]');
                
                filasMedios.forEach((fila, index) => {
                    const detalle = fila.querySelector('.detalle-medio')?.value || 'No especificado';
                    const plazo = fila.querySelector('.plazo-medio')?.value || 'No especificado';
                    const estado = fila.querySelector('.estado-medio')?.value || 'No evaluado';
                    
                    mediosData.push([
                        index + 1,
                        detalle,
                        plazo,
                        estado
                    ]);
                });

                if (mediosData.length > 0) {
                    doc.autoTable({
                        startY: yPos,
                        head: [['#', 'DETALLE DEL MEDIO', 'PLAZO', 'ESTADO']],
                        body: mediosData,
                        theme: 'grid',
                        headStyles: { 
                            fillColor: [52, 58, 64],
                            textColor: 255,
                            fontSize: 9,
                            fontStyle: 'bold'
                        },
                        bodyStyles: { fontSize: 8 },
                        columnStyles: {
                            0: { cellWidth: 10 },
                            1: { cellWidth: 80 },
                            2: { cellWidth: 25 },
                            3: { cellWidth: 55 }
                        },
                        margin: { left: 20, right: 20 },
                        didDrawPage: function(data) {
                            yPos = data.cursor.y + 10;
                        }
                    });
                    
                    yPos = doc.lastAutoTable.finalY + 10;
                }

                // ==============================
                // OBSERVACIÓN GENERAL
                // ==============================
                if (yPos > 250) {
                    doc.addPage();
                    yPos = 20;
                }

                doc.setFontSize(12);
                doc.setTextColor(0, 0, 128);
                doc.setFont('helvetica', 'bold');
                doc.text('3. OBSERVACIÓN GENERAL', 20, yPos);
                yPos += 8;

                if (datos.observacion_general && datos.observacion_general !== 'No especificado') {
                    doc.setFontSize(10);
                    doc.setTextColor(0, 0, 0);
                    doc.setFont('helvetica', 'normal');
                    
                    const lineas = doc.splitTextToSize(datos.observacion_general, 170);
                    lineas.forEach((linea, idx) => {
                        doc.text(linea, 20, yPos + (idx * 4.5));
                    });
                    
                    yPos += (lineas.length * 4.5) + 15;
                }

                // ==============================
                // FIRMAS
                // ==============================
                if (yPos > 200) {
                    doc.addPage();
                    yPos = 20;
                }

                doc.setFontSize(12);
                doc.setTextColor(0, 0, 128);
                doc.setFont('helvetica', 'bold');
                doc.text('4. FIRMAS DE RESPONSABILIDAD', 20, yPos);
                yPos += 15;

                // Firmas
                const anchoFirma = 75;
                
                // Elaborado por
                doc.setFontSize(11);
                doc.text('ELABORADO POR:', 20, yPos);
                doc.setFontSize(10);
                doc.setFont('helvetica', 'normal');
                doc.text(datos.elaborado, 20, yPos + 6);
                doc.setDrawColor(0, 0, 0);
                doc.setLineWidth(0.3);
                doc.line(20, yPos + 10, 20 + anchoFirma, yPos + 10);
                doc.setFontSize(8);
                doc.setTextColor(100, 100, 100);
                doc.text('Firma y sello', 20, yPos + 16);

                // Revisado por
                doc.setFontSize(11);
                doc.setTextColor(0, 0, 128);
                doc.setFont('helvetica', 'bold');
                doc.text('REVISADO POR:', 20 + anchoFirma + 20, yPos);
                doc.setFontSize(10);
                doc.setTextColor(0, 0, 0);
                doc.setFont('helvetica', 'normal');
                doc.text(datos.responsable, 20 + anchoFirma + 20, yPos + 6);
                doc.line(20 + anchoFirma + 20, yPos + 10, 20 + anchoFirma + 20 + anchoFirma, yPos + 10);
                doc.setFontSize(8);
                doc.setTextColor(100, 100, 100);
                doc.text('Firma y sello', 20 + anchoFirma + 20, yPos + 16);

                // ==============================
                // PIE DE PÁGINA
                // ==============================
                doc.setFontSize(8);
                doc.setTextColor(100, 100, 100);
                doc.text(`Documento generado el: ${new Date().toLocaleDateString('es-ES')}`, 105, 285, { align: 'center' });
                doc.text('ISTTP "YAVIRAC" - Sistema de Seguimiento POA', 105, 290, { align: 'center' });

                // ==============================
                // GUARDAR PDF
                // ==============================
                const fechaActual = new Date().toISOString().split('T')[0];
                const nombreElaborado = datos.elaborado.replace(/[^a-z0-9]/gi, '_') || 'Seguimiento';
                const nombreArchivo = `Seguimiento_POA_${nombreElaborado}_${fechaActual}.pdf`;
                
                // Guardar PDF
                doc.save(nombreArchivo);
                
                // Restaurar botón
                btnExportar.innerHTML = originalText;
                btnExportar.disabled = false;
                
                // Mostrar mensaje
                alert('✅ PDF generado exitosamente');

            } catch (error) {
                console.error('Error al generar PDF:', error);
                alert('❌ Error al generar el PDF: ' + error.message);
                
                // Restaurar botón en caso de error
                const btnExportar = document.getElementById('btn-exportar');
                btnExportar.innerHTML = '<i class="fas fa-file-pdf me-1"></i> Exportar PDF';
                btnExportar.disabled = false;
            }
        }
    </script>
</body>
</html>