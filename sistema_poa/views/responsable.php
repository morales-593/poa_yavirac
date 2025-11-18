<?php
$page = 'responsable';
$page_title = 'Responsable de Área';
require_once 'header.php';
?>

<div class="page-content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Responsables de Área</h3>
            <button class="btn btn-primary" data-modal="addResponsableModal">
                <i class="fas fa-plus"></i> Crear Responsable
            </button>
        </div>
        <div class="card-body">
            <div class="info-section">
                <div class="info-icon">
                    <i class="fas fa-user-tie fa-3x"></i>
                </div>
                <div class="info-content">
                    <h3>Gestión de Responsables</h3>
                    <p>Administra los responsables de cada área y asigna actividades específicas a cada uno.</p>
                    <div class="responsables-stats">
                        <div class="stat-item">
                            <strong>8</strong>
                            <span>Responsables Activos</span>
                        </div>
                        <div class="stat-item">
                            <strong>24</strong>
                            <span>Actividades Asignadas</span>
                        </div>
                        <div class="stat-item">
                            <strong>85%</strong>
                            <span>Eficiencia General</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="responsables-grid">
                <div class="responsable-card">
                    <div class="responsable-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="responsable-info">
                        <h4>Dra. Ana Martínez</h4>
                        <p class="responsable-area">Área Académica</p>
                        <div class="responsable-stats">
                            <span class="stat">5 actividades</span>
                            <span class="stat">80% completado</span>
                        </div>
                    </div>
                    <div class="responsable-actions">
                        <button class="btn btn-primary btn-sm">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn btn-primary btn-sm">
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>
                </div>

                <div class="responsable-card">
                    <div class="responsable-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="responsable-info">
                        <h4>Ing. Roberto Silva</h4>
                        <p class="responsable-area">Área de Investigación</p>
                        <div class="responsable-stats">
                            <span class="stat">3 actividades</span>
                            <span class="stat">65% completado</span>
                        </div>
                    </div>
                    <div class="responsable-actions">
                        <button class="btn btn-primary btn-sm">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn btn-primary btn-sm">
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>
                </div>

                <div class="responsable-card">
                    <div class="responsable-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="responsable-info">
                        <h4>Lic. Patricia Gómez</h4>
                        <p class="responsable-area">Área Administrativa</p>
                        <div class="responsable-stats">
                            <span class="stat">7 actividades</span>
                            <span class="stat">90% completado</span>
                        </div>
                    </div>
                    <div class="responsable-actions">
                        <button class="btn btn-primary btn-sm">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn btn-primary btn-sm">
                            <i class="fas fa-edit"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Responsable Modal -->
<div id="addResponsableModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Crear Nuevo Responsable</h3>
            <button type="button" class="modal-close">&times;</button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label class="form-label">Nombre Completo</label>
                <input type="text" class="form-control" placeholder="Nombre y apellidos del responsable">
            </div>
            <div class="form-group">
                <label class="form-label">Cargo</label>
                <input type="text" class="form-control" placeholder="Cargo o puesto">
            </div>
            <div class="form-group">
                <label class="form-label">Área</label>
                <select class="form-control">
                    <option value="">Seleccione área</option>
                    <option value="academica">Académica</option>
                    <option value="investigacion">Investigación</option>
                    <option value="administrativa">Administrativa</option>
                    <option value="vinculacion">Vinculación</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" placeholder="correo@institucion.edu">
            </div>
            <div class="form-group">
                <label class="form-label">Teléfono</label>
                <input type="tel" class="form-control" placeholder="Número de contacto">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary modal-close">Cancelar</button>
            <button type="button" class="btn btn-primary">Crear Responsable</button>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>