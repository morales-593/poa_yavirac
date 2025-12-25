<div class="sidebar bg-dark text-white vh-100" style="width: 250px;">
    <div class="p-3">

        <div class="text-center mb-4">
            <h4 class="fw-bold mb-0">Sistema POA</h4>
            <small class="text-muted">Yavirac</small>
        </div>

        <ul class="nav flex-column">

            <!-- Dashboard -->
            <li class="nav-item mb-2">
                <a class="nav-link text-white d-flex align-items-center <?= ($_GET['action'] ?? '') === 'dashboard' ? 'active bg-primary rounded' : '' ?>"
                    href="index.php?action=dashboard">
                    <i class="fas fa-tachometer-alt me-3"></i> Dashboard
                </a>
            </li>

            <!-- Coordinación -->
            <li class="nav-item mb-2">
                <a class="nav-link text-white d-flex align-items-center collapsed" data-bs-toggle="collapse"
                    href="#collapseCoordinacion">
                    <i class="fas fa-users-cog me-3"></i> Coordinación
                    <i class="fas fa-chevron-down ms-auto"></i>
                </a>
                <div class="collapse" id="collapseCoordinacion">
                    <ul class="nav flex-column ps-4">
                        <li class="nav-item">
                            <a class="nav-link text-white <?= ($_GET['action'] ?? '') === 'usuarios' ? 'active bg-primary rounded' : '' ?>"
                                href="index.php?action=usuarios">
                                <i class="fas fa-user me-2"></i> Usuarios
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Tema POA -->
            <li class="nav-item mb-2">
                <a class="nav-link text-white <?= ($_GET['action'] ?? '') === 'temas_poa' ? 'active bg-primary rounded' : '' ?>"
                    href="index.php?action=temas_poa">
                    <i class="fas fa-tags me-3"></i> Tema POA
                </a>
            </li>

            <!-- Ejes y Objetivos -->
            <li class="nav-item mb-2">
                <a class="nav-link text-white <?= ($_GET['action'] ?? '') === 'ejes' ? 'active bg-primary rounded' : '' ?>"
                    href="index.php?action=ejes">
                    <i class="fas fa-bullseye me-3"></i> Ejes y Objetivos
                </a>
            </li>

            <!-- Indicadores -->
            <li class="nav-item mb-2">
                <a class="nav-link text-white <?= ($_GET['action'] ?? '') === 'indicadores' ? 'active bg-primary rounded' : '' ?>"
                    href="index.php?action=indicadores">
                    <i class="fas fa-chart-line me-3"></i> Indicadores
                </a>
            </li>

            <!-- Plazos -->
            <li class="nav-item mb-2">
                <a class="nav-link text-white <?= ($_GET['action'] ?? '') === 'plazos' ? 'active bg-primary rounded' : '' ?>"
                    href="index.php?action=plazos">
                    <i class="fas fa-calendar me-3"></i> Plazos
                </a>
            </li>

            <!-- Responsables -->
            <li class="nav-item mb-2">
                <a class="nav-link text-white <?= ($_GET['action'] ?? '') === 'responsables' ? 'active bg-primary rounded' : '' ?>"
                    href="index.php?action=responsables">
                    <i class="fas fa-user-tie me-3"></i> Responsables
                </a>
            </li>

            <!-- Plan Operativo -->
            <a class="nav-link text-white <?= ($_GET['action'] ?? '') == 'planes' ? 'bg-primary' : '' ?>"
                href="index.php?action=planes">
                <i class="fas fa-file-alt me-2"></i> Planes Operativos
            </a>


        </ul>

        <div class="mt-5 pt-5 text-center">
            <small class="text-muted">v1.0.0</small>
        </div>

    </div>
</div>