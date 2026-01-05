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
        
        .calificacion-excelente {
            color: #198754;
            font-weight: bold;
        }
        
        .calificacion-buena {
            color: #0dcaf0;
            font-weight: bold;
        }
        
        .calificacion-regular {
            color: #ffc107;
            font-weight: bold;
        }
        
        .calificacion-deficiente {
            color: #dc3545;
            font-weight: bold;
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
                        <table class="table table-bordered table-hover table-medios" id="tabla-medios">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center">#</th>
                                    <th width="45%">DETALLE</th>
                                    <th width="15%">PLAZO</th>
                                    <th width="15%" class="text-center">CUMPLIMIENTO *</th>
                                    <th width="20%">CALIFICACIÓN</th>
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
                                                // Obtener calificación existente para este medio si existe
                                                $cumplimiento_existente = 'NO';
                                                $calificacion_existente = '';
                                                
                                                if (!empty($calificaciones_detalladas)) {
                                                    foreach ($calificaciones_detalladas as $calificacion) {
                                                        if ($calificacion['id_medio'] == $medio['id_medio']) {
                                                            $cumplimiento_existente = $calificacion['cumplimiento'];
                                                            $calificacion_existente = $calificacion['calificacion_individual'];
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
                                                                   onchange="calcularCalificacion()">
                                                            <label class="btn btn-outline-success" for="cumple_<?= $index ?>">Sí</label>
                                                    
                                                            <input type="radio" class="btn-check cumplimiento-radio" 
                                                                   name="cumplimiento_<?= $index ?>" 
                                                                   id="no_cumple_<?= $index ?>" value="NO"
                                                                   <?= ($cumplimiento_existente == 'NO') ? 'checked' : '' ?>
                                                                   onchange="calcularCalificacion()">
                                                            <label class="btn btn-outline-danger" for="no_cumple_<?= $index ?>">No</label>
                                                        </div>
                                                    </td>
                                                    <td class="align-middle">
                                                        <textarea class="form-control campo-solo-lectura calificacion-medio" rows="2" readonly 
                                                                  placeholder="Calificación automática..."><?= htmlspecialchars($calificacion_existente) ?></textarea>
                                                        <input type="hidden" name="observacion_medio_<?= $index ?>" value="<?= htmlspecialchars($calificacion_existente) ?>">
                                                    </td>
                                                </tr>
                                        <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- CALIFICACIÓN GENERAL -->
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h6 class="card-title">CALIFICACIÓN AUTOMÁTICA</h6>
                                    <?php if ($seguimiento_existente): ?>
                                        <?php
                                        $clase_calificacion = '';
                                        if ($seguimiento_existente['calificacion'] == 'EXCELENTE') {
                                            $clase_calificacion = 'calificacion-excelente';
                                        } elseif ($seguimiento_existente['calificacion'] == 'MUY BUENO' || $seguimiento_existente['calificacion'] == 'BUENO') {
                                            $clase_calificacion = 'calificacion-buena';
                                        } elseif ($seguimiento_existente['calificacion'] == 'REGULAR') {
                                            $clase_calificacion = 'calificacion-regular';
                                        } elseif ($seguimiento_existente['calificacion'] == 'DEFICIENTE') {
                                            $clase_calificacion = 'calificacion-deficiente';
                                        }
                                        ?>
                                        <div class="display-4 fw-bold <?= $clase_calificacion ?>" id="calificacion-total">
                                            <?= $seguimiento_existente['porcentaje_cumplimiento'] ?? 0 ?>%
                                        </div>
                                        <p class="text-muted mb-0" id="resumen-calificacion">
                                            <?= $seguimiento_existente['calificacion'] ?? 'Sin calificar' ?>
                                        </p>
                                    <?php else: ?>
                                        <div class="display-4 fw-bold text-primary" id="calificacion-total">0%</div>
                                        <p class="text-muted mb-0" id="resumen-calificacion">
                                            <span id="contador-si">0</span> de <span id="total-medios"><?= count($medios_verificacion) ?></span> medios cumplidos
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title">ESCALA DE CALIFICACIÓN</h6>
                                    <ul class="list-unstyled mb-0">
                                        <li><span class="badge bg-success">90-100%</span> Excelente</li>
                                        <li><span class="badge bg-info">80-89%</span> Muy Bueno</li>
                                        <li><span class="badge bg-primary">70-79%</span> Bueno</li>
                                        <li><span class="badge bg-warning">60-69%</span> Regular</li>
                                        <li><span class="badge bg-danger">0-59%</span> Deficiente</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- ARCHIVO DE SEGUIMIENTO -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label fw-bold">ARCHIVO DE SEGUIMIENTO (OPCIONAL)</label>
                                <input type="file" name="archivo_seguimiento" class="form-control" accept=".pdf">
                                <small class="text-muted">Solo se aceptan archivos PDF. Máximo 10MB.</small>
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