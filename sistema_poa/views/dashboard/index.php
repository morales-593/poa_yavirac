<?php require_once 'views/layout/header.php'; ?>

<div class="container-fluid">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php?action=dashboard"><i class="fas fa-home"></i></a></li>
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </nav>

    <!-- Welcome Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title mb-1">Bienvenido, <?= htmlspecialchars($_SESSION['usuario']['nombre']) ?></h4>
                            <p class="card-text mb-0">Sistema de Planificación Operativa Anual - Yavirac</p>
                        </div>
                        <div>
                            <span class="badge bg-light text-primary fs-6"><?= date('d/m/Y') ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cards de Resumen -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-subtitle mb-2">Planes Activos</h6>
                            <h2 class="card-title">12</h2>
                        </div>
                        <div>
                            <i class="fas fa-calendar-alt fa-2x opacity-50"></i>
                        </div>
                    </div>
                    <a href="index.php?action=planes" class="text-white text-decoration-none">
                        <small>Ver todos <i class="fas fa-arrow-right ms-1"></i></small>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-subtitle mb-2">Indicadores</h6>
                            <h2 class="card-title">48</h2>
                        </div>
                        <div>
                            <i class="fas fa-chart-line fa-2x opacity-50"></i>
                        </div>
                    </div>
                    <a href="index.php?action=indicadores" class="text-white text-decoration-none">
                        <small>Ver todos <i class="fas fa-arrow-right ms-1"></i></small>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-subtitle mb-2">En Ejecución</h6>
                            <h2 class="card-title">8</h2>
                        </div>
                        <div>
                            <i class="fas fa-play-circle fa-2x opacity-50"></i>
                        </div>
                    </div>
                    <a href="#" class="text-white text-decoration-none">
                        <small>Ver detalles <i class="fas fa-arrow-right ms-1"></i></small>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-3">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-subtitle mb-2">Atrasados</h6>
                            <h2 class="card-title">3</h2>
                        </div>
                        <div>
                            <i class="fas fa-exclamation-triangle fa-2x opacity-50"></i>
                        </div>
                    </div>
                    <a href="#" class="text-white text-decoration-none">
                        <small>Ver pendientes <i class="fas fa-arrow-right ms-1"></i></small>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficos y Tablas -->
    <div class="row">
        <!-- Gráfico de Progreso -->
        <div class="col-md-8 mb-4">
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Progreso de Planes por Mes</h5>
                    <select class="form-select form-select-sm w-auto">
                        <option>2024</option>
                        <option>2023</option>
                    </select>
                </div>
                <div class="card-body">
                    <canvas id="progresoChart" height="250"></canvas>
                </div>
            </div>
        </div>

        <!-- Últimos Planes -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Planes Recientes</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <?php for($i = 1; $i <= 5; $i++): ?>
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-1">Plan Operativo <?= $i ?></h6>
                                <small class="text-muted">Actualizado: 15/05/2024</small>
                            </div>
                            <span class="badge bg-success rounded-pill">85%</span>
                        </a>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Actividades -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Actividades Recientes</h5>
                    <a href="#" class="btn btn-sm btn-primary">Ver Todas</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Actividad</th>
                                    <th>Responsable</th>
                                    <th>Fecha Límite</th>
                                    <th>Estado</th>
                                    <th>Progreso</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php for($i = 1; $i <= 5; $i++): ?>
                                <tr>
                                    <td>Actividad <?= $i ?> - Descripción breve</td>
                                    <td>Juan Pérez</td>
                                    <td>25/05/2024</td>
                                    <td>
                                        <span class="badge bg-success">En progreso</span>
                                    </td>
                                    <td>
                                        <div class="progress" style="height: 6px;">
                                            <div class="progress-bar bg-success" style="width: <?= rand(50, 100) ?>%"></div>
                                        </div>
                                    </td>
                                </tr>
                                <?php endfor; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Gráfico de progreso
    const ctx = document.getElementById('progresoChart').getContext('2d');
    const progresoChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            datasets: [{
                label: 'Completado %',
                data: [65, 59, 80, 81, 56, 55, 40, 70, 75, 82, 90, 85],
                backgroundColor: 'rgba(54, 162, 235, 0.8)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    ticks: {
                        callback: function(value) {
                            return value + '%';
                        }
                    }
                }
            }
        }
    });
</script>

<?php require_once 'views/layout/footer.php'; ?>