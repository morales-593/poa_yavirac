<?php
$page = 'eje-objetivo';
$page_title = 'Eje y Objetivo';
require_once 'header.php';
?>

<div class="page-content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Ejes y Objetivos Estratégicos</h3>
            <button class="btn btn-primary" data-modal="addEjeModal">
                <i class="fas fa-plus"></i> Crear Eje
            </button>
        </div>
        <div class="card-body">
            <div class="info-section">
                <div class="info-icon">
                    <i class="fas fa-bullseye fa-3x"></i>
                </div>
                <div class="info-content">
                    <h3>Gestión de Ejes y Objetivos Estratégicos</h3>
                    <p>Define y administra los ejes estratégicos y sus objetivos correspondientes para alinear las actividades con la visión institucional.</p>
                    <div class="feature-grid">
                        <div class="feature-item">
                            <i class="fas fa-vector-square"></i>
                            <h4>Ejes Estratégicos</h4>
                            <p>Líneas maestras de acción</p>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-bullseye-arrow"></i>
                            <h4>Objetivos Específicos</h4>
                            <p>Metas cuantificables</p>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-chart-line"></i>
                            <h4>Indicadores</h4>
                            <p>Medición de progreso</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ejes-container">
                <div class="eje-card">
                    <div class="eje-header">
                        <h4><i class="fas fa-graduation-cap"></i> Eje Académico</h4>
                        <span class="eje-status active">Activo</span>
                    </div>
                    <div class="objetivos-list">
                        <div class="objetivo-item">
                            <i class="fas fa-check-circle completed"></i>
                            <span>Mejorar la calidad educativa en un 15%</span>
                        </div>
                        <div class="objetivo-item">
                            <i class="fas fa-spinner in-progress"></i>
                            <span>Implementar 5 nuevos programas de posgrado</span>
                        </div>
                        <div class="objetivo-item">
                            <i class="fas fa-clock pending"></i>
                            <span>Capacitar al 80% del personal docente</span>
                        </div>
                    </div>
                </div>

                <div class="eje-card">
                    <div class="eje-header">
                        <h4><i class="fas fa-flask"></i> Eje de Investigación</h4>
                        <span class="eje-status active">Activo</span>
                    </div>
                    <div class="objetivos-list">
                        <div class="objetivo-item">
                            <i class="fas fa-spinner in-progress"></i>
                            <span>Publicar 20 artículos científicos indexados</span>
                        </div>
                        <div class="objetivo-item">
                            <i class="fas fa-clock pending"></i>
                            <span>Obtener 3 patentes de investigación</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Eje Modal -->
<div id="addEjeModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Crear Nuevo Eje Estratégico</h3>
            <button type="button" class="modal-close">&times;</button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label class="form-label">Nombre del Eje</label>
                <input type="text" class="form-control" placeholder="Ej: Eje Académico, Eje de Investigación">
            </div>
            <div class="form-group">
                <label class="form-label">Descripción</label>
                <textarea class="form-control" rows="3" placeholder="Descripción del eje estratégico"></textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Prioridad</label>
                <select class="form-control">
                    <option value="alta">Alta</option>
                    <option value="media">Media</option>
                    <option value="baja">Baja</option>
                </select>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary modal-close">Cancelar</button>
            <button type="button" class="btn btn-primary">Crear Eje</button>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>