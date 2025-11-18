<?php
$page = 'tema-poa';
$page_title = 'Tema POA';
require_once 'header.php';
?>

<div class="page-content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Gestión de Temas POA</h3>
            <button class="btn btn-primary" data-modal="addTemaModal">
                <i class="fas fa-plus"></i> Crear Tema
            </button>
        </div>
        <div class="card-body">
            <div class="info-section">
                <div class="info-icon">
                    <i class="fas fa-folder fa-3x"></i>
                </div>
                <div class="info-content">
                    <h3>Gestión de Temas del Plan Operativo Anual</h3>
                    <p>En esta sección puedes administrar los diferentes temas que componen el Plan Operativo Anual de tu organización.</p>
                    <ul class="feature-list">
                        <li><i class="fas fa-check"></i> Crear nuevos temas POA</li>
                        <li><i class="fas fa-check"></i> Editar temas existentes</li>
                        <li><i class="fas fa-check"></i> Organizar por categorías</li>
                        <li><i class="fas fa-check"></i> Asignar responsables</li>
                    </ul>
                </div>
            </div>
            
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-list-alt"></i>
                    </div>
                    <div class="stat-info">
                        <h3>15</h3>
                        <p>Temas Activos</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-info">
                        <h3>8</h3>
                        <p>Completados</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-info">
                        <h3>5</h3>
                        <p>En Progreso</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-info">
                        <h3>12</h3>
                        <p>Responsables</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Tema Modal -->
<div id="addTemaModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Crear Nuevo Tema POA</h3>
            <button type="button" class="modal-close">&times;</button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label class="form-label">Nombre del Tema</label>
                <input type="text" class="form-control" placeholder="Ingrese el nombre del tema">
            </div>
            <div class="form-group">
                <label class="form-label">Descripción</label>
                <textarea class="form-control" rows="4" placeholder="Descripción del tema"></textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Categoría</label>
                <select class="form-control">
                    <option value="">Seleccione categoría</option>
                    <option value="academico">Académico</option>
                    <option value="administrativo">Administrativo</option>
                    <option value="investigacion">Investigación</option>
                    <option value="vinculacion">Vinculación</option>
                </select>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary modal-close">Cancelar</button>
            <button type="button" class="btn btn-primary">Crear Tema</button>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>