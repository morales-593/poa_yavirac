<div class="sidebar bg-dark text-white vh-100" style="width: 250px;">
    <div class="p-3">
        <!-- Logo -->
        <div class="text-center mb-4">
            <h4 class="fw-bold mb-0">Sistema POA</h4>
            <small class="text-muted">Yavirac</small>
        </div>
        
        <!-- Menú de navegación -->
        <ul class="nav flex-column">
            <!-- Coordinación -->
            <li class="nav-item mb-2">
                <a class="nav-link text-white d-flex align-items-center collapsed" 
                   data-bs-toggle="collapse" 
                   href="#collapseCoordinacion">
                    <i class="fas fa-users-cog me-3"></i>
                    Coordinación
                    <i class="fas fa-chevron-down ms-auto"></i>
                </a>
                <div class="collapse" id="collapseCoordinacion">
                    <ul class="nav flex-column ps-4">
                        <li class="nav-item">
                            <a class="nav-link text-white d-flex align-items-center <?= ($_GET['action'] ?? '') === 'usuarios' ? 'active bg-primary rounded' : '' ?>" 
                               href="index.php?action=usuarios">
                                <i class="fas fa-user me-2"></i>
                                Usuarios del Sistema
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            
            <!-- Plan Operativo -->
            <li class="nav-item mb-2">
                <a class="nav-link text-white d-flex align-items-center" href="#">
                    <i class="fas fa-file-alt me-3"></i>
                    Plan Operativo
                </a>
            </li>
            
            <!-- Dashboard -->
            <li class="nav-item mb-2">
                <a class="nav-link text-white d-flex align-items-center <?= ($_GET['action'] ?? '') === 'dashboard' ? 'active bg-primary rounded' : '' ?>" 
                   href="index.php?action=dashboard">
                    <i class="fas fa-tachometer-alt me-3"></i>
                    Dashboard
                </a>
            </li>
            
            <!-- Tema POA -->
            <li class="nav-item mb-2">
                <a class="nav-link text-white d-flex align-items-center" href="#">
                    <i class="fas fa-tags me-3"></i>
                    Tema POA
                </a>
            </li>
            
            <!-- Eje y Objetivo -->
            <li class="nav-item mb-2">
                <a class="nav-link text-white d-flex align-items-center" href="#">
                    <i class="fas fa-bullseye me-3"></i>
                    Eje y Objetivo
                </a>
            </li>
            
            <!-- Indicadores -->
            <li class="nav-item mb-2">
                <a class="nav-link text-white d-flex align-items-center" href="#">
                    <i class="fas fa-chart-line me-3"></i>
                    Indicadores
                </a>
            </li>
            
            <!-- Plazo -->
            <li class="nav-item mb-2">
                <a class="nav-link text-white d-flex align-items-center" href="#">
                    <i class="fas fa-calendar me-3"></i>
                    Plazo
                </a>
            </li>
            
            <!-- Responsable de Área -->
            <li class="nav-item mb-2">
                <a class="nav-link text-white d-flex align-items-center" href="#">
                    <i class="fas fa-user-tie me-3"></i>
                    Responsable de Área
                </a>
            </li>
        </ul>
        
        <!-- Versión -->
        <div class="mt-5 pt-5 text-center">
            <small class="text-muted">v1.0.0</small>
        </div>
    </div>
</div>