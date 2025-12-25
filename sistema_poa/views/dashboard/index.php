<?php
$planesPorEje = $planesPorEje ?? [];
$planesPorMes = $planesPorMes ?? [];
?>

<div class="container-fluid px-0 px-md-3">

<h4 class="mb-4 fw-bold text-dark px-3 px-md-0">Dashboard - Sistema POA</h4>

<!-- Cards de métricas -->
<div class="row mb-4 g-3 px-3 px-md-0">
    <div class="col-12 col-sm-6 col-md-6 col-lg-3">
        <div class="card metric-card-1 border-0 p-3 p-md-4 shadow-lg h-100 animate-card">
            <div class="card-icon mb-3">
                <div class="icon-wrapper bg-primary-gradient">
                    <i class="fas fa-clipboard-list"></i>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-start mb-3">
                <h6 class="text-muted mb-0 fs-6">Total de Planes</h6>
                <span class="badge bg-primary bg-opacity-10 text-primary fs-7 animate-badge">↑ 500%</span>
            </div>
            <h2 class="fw-bold display-7 display-md-6 mb-2 gradient-text-1"><?= $totalPlanes ?? '6' ?></h2>
            <p class="text-muted small mb-0">desde el mes pasado</p>
        </div>
    </div>
    
    <div class="col-12 col-sm-6 col-md-6 col-lg-3">
        <div class="card metric-card-2 border-0 p-3 p-md-4 shadow-lg h-100 animate-card">
            <div class="card-icon mb-3">
                <div class="icon-wrapper bg-success-gradient">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-start mb-3">
                <h6 class="text-muted mb-0 fs-6">Usuarios Activos</h6>
                <span class="badge bg-success bg-opacity-10 text-success fs-7 animate-badge">↑ 1100%</span>
            </div>
            <h2 class="fw-bold display-7 display-md-6 mb-2 gradient-text-2"><?= $usuariosActivos ?? '12' ?></h2>
            <p class="text-muted small mb-0">desde el mes pasado</p>
        </div>
    </div>
    
    <div class="col-12 col-sm-6 col-md-6 col-lg-3">
        <div class="card metric-card-3 border-0 p-3 p-md-4 shadow-lg h-100 animate-card">
            <div class="card-icon mb-3">
                <div class="icon-wrapper bg-warning-gradient">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-start mb-3">
                <h6 class="text-muted mb-0 fs-6">Planes Completados</h6>
                <span class="badge bg-warning bg-opacity-10 text-warning fs-7 animate-badge">↑ 100%</span>
            </div>
            <h2 class="fw-bold display-7 display-md-6 mb-2 gradient-text-3"><?= $planesCompletados ?? '2' ?></h2>
            <p class="text-muted small mb-0">desde el mes pasado</p>
        </div>
    </div>
    
    <div class="col-12 col-sm-6 col-md-6 col-lg-3">
        <div class="card metric-card-4 border-0 p-3 p-md-4 shadow-lg h-100 animate-card">
            <div class="card-icon mb-3">
                <div class="icon-wrapper bg-purple-gradient">
                    <i class="fas fa-sitemap"></i>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-start mb-3">
                <h6 class="text-white-50 mb-0 fs-6">Ejes Utilizados</h6>
            </div>
            <h2 class="fw-bold display-7 display-md-6 mb-2 text-white"><?= $totalEjes ?? '0' ?></h2>
            <p class="text-white-50 small mb-0">total de categorías</p>
        </div>
    </div>
</div>

<!-- Gráficos -->
<div class="row mt-4 mt-md-5 g-3 px-3 px-md-0">
    <div class="col-12 col-lg-6">
        <div class="card border-0 p-3 p-md-4 shadow-lg h-100 animate-slide-left">
            <div class="d-flex align-items-center mb-3">
                <div class="chart-icon me-3">
                    <i class="fas fa-chart-bar text-primary"></i>
                </div>
                <h5 class="fw-bold mb-0 text-dark fs-5">Planes por Eje</h5>
            </div>
            <div class="chart-container" style="position: relative; height: 300px; width:100%;">
                <canvas id="chartEjes"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-12 col-lg-6">
        <div class="card border-0 p-3 p-md-4 shadow-lg h-100 animate-slide-right">
            <div class="d-flex align-items-center mb-3">
                <div class="chart-icon me-3">
                    <i class="fas fa-chart-line text-success"></i>
                </div>
                <h5 class="fw-bold mb-0 text-dark fs-5">Planes por Mes</h5>
            </div>
            <div class="chart-container" style="position: relative; height: 300px; width:100%;">
                <canvas id="chartMeses"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Tabla -->
<div class="row mt-4 mt-md-5 px-3 px-md-0">
    <div class="col-12">
        <div class="card border-0 shadow-lg animate-fade-in">
            <div class="card-body p-3 p-md-4">
                <div class="d-flex align-items-center mb-3">
                    <div class="table-icon me-3">
                        <i class="fas fa-table text-info"></i>
                    </div>
                    <h5 class="fw-bold mb-0 text-dark fs-5">Resumen por Eje</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-header-gradient">
                            <tr>
                                <th class="border-0 py-3 fs-6 text-white">
                                    <i class="fas fa-layer-group me-2"></i>Eje
                                </th>
                                <th class="border-0 py-3 text-end fs-6 text-white">
                                    <i class="fas fa-chart-pie me-2"></i>Planes
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        $rowColors = ['#f8f9ff', '#ffffff'];
                        $colorIndex = 0;
                        foreach($estadoPorEje as $e): 
                            $rowColor = $rowColors[$colorIndex % 2];
                            $colorIndex++;
                        ?>
                            <tr class="animate-table-row" style="background-color: <?= $rowColor ?>;">
                                <td class="py-3 fs-6">
                                    <span class="eje-badge me-2 d-none d-sm-inline">
                                        <i class="fas fa-circle text-primary"></i>
                                    </span>
                                    <?= $e['nombre_eje'] ?>
                                </td>
                                <td class="py-3 text-end fw-bold fs-6">
                                    <span class="plan-count-badge">
                                        <?= $e['total'] ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

</div>

<!-- Font Awesome Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Asegurar que los gráficos sean responsive
Chart.defaults.font.size = window.innerWidth < 768 ? 12 : 14;
Chart.defaults.plugins.legend.labels.boxWidth = window.innerWidth < 768 ? 12 : 16;

const ejes = <?= json_encode(array_column($planesPorEje,'nombre_eje')) ?>;
const totales = <?= json_encode(array_column($planesPorEje,'total')) ?>;

const ctxEjes = document.getElementById('chartEjes').getContext('2d');
const chartEjes = new Chart(ctxEjes, {
    type:'bar',
    data:{
        labels:ejes,
        datasets:[{
            label: 'Planes',
            data:totales,
            backgroundColor: [
                'rgba(66, 133, 244, 0.8)',
                'rgba(219, 68, 55, 0.8)',
                'rgba(244, 180, 0, 0.8)',
                'rgba(15, 157, 88, 0.8)',
                'rgba(171, 71, 188, 0.8)',
                'rgba(0, 172, 193, 0.8)'
            ],
            borderRadius: 12,
            borderSkipped: false,
            borderWidth: 1,
            borderColor: 'rgba(255,255,255,0.3)',
            barPercentage: 0.6,
            categoryPercentage: 0.8
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                mode: 'index',
                intersect: false,
                bodyFont: {
                    size: window.innerWidth < 768 ? 11 : 13
                },
                backgroundColor: 'rgba(0,0,0,0.8)',
                cornerRadius: 8,
                padding: 12,
                boxPadding: 6
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    display: true,
                    drawBorder: false,
                    color: 'rgba(0,0,0,0.05)'
                },
                ticks: {
                    font: {
                        size: window.innerWidth < 768 ? 11 : 13
                    },
                    padding: 10
                }
            },
            x: {
                grid: {
                    display: false
                },
                ticks: {
                    font: {
                        size: window.innerWidth < 768 ? 11 : 13
                    },
                    maxRotation: window.innerWidth < 768 ? 45 : 0,
                    padding: 10
                }
            }
        },
        interaction: {
            intersect: false,
            mode: 'nearest'
        },
        animation: {
            duration: 1500,
            easing: 'easeOutQuart'
        }
    }
});

const meses = <?= json_encode(array_column($planesPorMes,'mes')) ?>;
const tot = <?= json_encode(array_column($planesPorMes,'total')) ?>;

const ctxMeses = document.getElementById('chartMeses').getContext('2d');
const chartMeses = new Chart(ctxMeses, {
    type:'line',
    data:{
        labels:meses,
        datasets:[{
            label: 'Planes por Mes',
            data:tot,
            borderColor: '#4285f4',
            backgroundColor: 'rgba(66, 133, 244, 0.1)',
            fill: true,
            tension: 0.4,
            pointBackgroundColor: '#4285f4',
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: window.innerWidth < 768 ? 4 : 6,
            pointHoverRadius: window.innerWidth < 768 ? 6 : 8,
            borderWidth: 3,
            pointStyle: 'circle'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: true,
                position: 'top',
                labels: {
                    font: {
                        size: window.innerWidth < 768 ? 12 : 14
                    },
                    padding: 20,
                    usePointStyle: true,
                    pointStyle: 'circle'
                }
            },
            tooltip: {
                mode: 'index',
                intersect: false,
                bodyFont: {
                    size: window.innerWidth < 768 ? 11 : 13
                },
                backgroundColor: 'rgba(0,0,0,0.8)',
                cornerRadius: 8,
                padding: 12
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    display: true,
                    drawBorder: false,
                    color: 'rgba(0,0,0,0.05)'
                },
                ticks: {
                    font: {
                        size: window.innerWidth < 768 ? 11 : 13
                    },
                    padding: 10
                }
            },
            x: {
                grid: {
                    display: false
                },
                ticks: {
                    font: {
                        size: window.innerWidth < 768 ? 11 : 13
                    },
                    padding: 10
                }
            }
        },
        interaction: {
            intersect: false,
            mode: 'nearest'
        },
        animation: {
            duration: 2000,
            easing: 'easeOutQuart'
        }
    }
});

// Animaciones para elementos
document.addEventListener('DOMContentLoaded', function() {
    // Animar tarjetas al cargar
    const cards = document.querySelectorAll('.animate-card');
    cards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
    });
    
    // Animar filas de tabla
    const tableRows = document.querySelectorAll('.animate-table-row');
    tableRows.forEach((row, index) => {
        row.style.animationDelay = `${index * 0.05}s`;
    });
    
    // Efecto hover en tarjetas
    const metricCards = document.querySelectorAll('.metric-card-1, .metric-card-2, .metric-card-3, .metric-card-4');
    metricCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px) scale(1.02)';
            this.style.boxShadow = '0 20px 40px rgba(0,0,0,0.15)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
            this.style.boxShadow = '0 10px 25px rgba(0,0,0,0.1)';
        });
    });
});

// Redibujar gráficos al redimensionar la ventana
window.addEventListener('resize', function() {
    Chart.defaults.font.size = window.innerWidth < 768 ? 12 : 14;
    Chart.defaults.plugins.legend.labels.boxWidth = window.innerWidth < 768 ? 12 : 16;
    
    chartEjes.options.scales.x.ticks.font.size = window.innerWidth < 768 ? 11 : 13;
    chartEjes.options.scales.y.ticks.font.size = window.innerWidth < 768 ? 11 : 13;
    chartEjes.data.datasets[0].barPercentage = window.innerWidth < 768 ? 0.7 : 0.6;
    
    chartMeses.options.scales.x.ticks.font.size = window.innerWidth < 768 ? 11 : 13;
    chartMeses.options.scales.y.ticks.font.size = window.innerWidth < 768 ? 11 : 13;
    chartMeses.options.plugins.legend.labels.font.size = window.innerWidth < 768 ? 12 : 14;
    chartMeses.data.datasets[0].pointRadius = window.innerWidth < 768 ? 4 : 6;
    chartMeses.data.datasets[0].pointHoverRadius = window.innerWidth < 768 ? 6 : 8;
    
    chartEjes.update();
    chartMeses.update();
});
</script>

<style>
/* Variables de color */
:root {
    --primary-gradient: linear-gradient(135deg, #4285f4 0%, #0d47a1 100%);
    --success-gradient: linear-gradient(135deg, #0f9d58 0%, #0a8043 100%);
    --warning-gradient: linear-gradient(135deg, #f4b400 0%, #f09300 100%);
    --purple-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --info-gradient: linear-gradient(135deg, #00acc1 0%, #00838f 100%);
    --table-gradient: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
}

body {
    background-color: #f8f9fa;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    min-height: 100vh;
}

/* Tarjetas de métricas con diferentes colores */
.metric-card-1 {
    background: white;
    border-radius: 20px;
    border: none;
    box-shadow: 0 10px 25px rgba(66, 133, 244, 0.1);
    border-left: 5px solid #4285f4;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.metric-card-2 {
    background: white;
    border-radius: 20px;
    border: none;
    box-shadow: 0 10px 25px rgba(15, 157, 88, 0.1);
    border-left: 5px solid #0f9d58;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.metric-card-3 {
    background: white;
    border-radius: 20px;
    border: none;
    box-shadow: 0 10px 25px rgba(244, 180, 0, 0.1);
    border-left: 5px solid #f4b400;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.metric-card-4 {
    background: var(--purple-gradient);
    border-radius: 20px;
    border: none;
    box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
    border-left: 5px solid #764ba2;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

/* Iconos en tarjetas */
.card-icon {
    display: flex;
    justify-content: flex-end;
}

.icon-wrapper {
    width: 60px;
    height: 60px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    transition: transform 0.3s ease;
}

.icon-wrapper:hover {
    transform: rotate(15deg) scale(1.1);
}

.bg-primary-gradient {
    background: var(--primary-gradient);
}

.bg-success-gradient {
    background: var(--success-gradient);
}

.bg-warning-gradient {
    background: var(--warning-gradient);
}

.bg-purple-gradient {
    background: var(--purple-gradient);
}

/* Textos con gradiente */
.gradient-text-1 {
    background: var(--primary-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.gradient-text-2 {
    background: var(--success-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.gradient-text-3 {
    background: var(--warning-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* Badges animados */
.animate-badge {
    animation: pulse 2s infinite;
    box-shadow: 0 0 10px currentColor;
}

@keyframes pulse {
    0% { box-shadow: 0 0 0 0 rgba(66, 133, 244, 0.7); }
    70% { box-shadow: 0 0 0 10px rgba(66, 133, 244, 0); }
    100% { box-shadow: 0 0 0 0 rgba(66, 133, 244, 0); }
}

/* Animaciones */
.animate-card {
    animation: fadeInUp 0.6s ease-out forwards;
    opacity: 0;
}

.animate-slide-left {
    animation: slideInLeft 0.8s ease-out forwards;
    opacity: 0;
}

.animate-slide-right {
    animation: slideInRight 0.8s ease-out forwards;
    opacity: 0;
}

.animate-fade-in {
    animation: fadeIn 1s ease-out forwards;
    opacity: 0;
}

.animate-table-row {
    animation: fadeInRow 0.5s ease-out forwards;
    opacity: 0;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideInLeft {
    from {
        opacity: 0;
        transform: translateX(-50px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(50px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes fadeInRow {
    from {
        opacity: 0;
        transform: translateX(-20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* Tarjetas de gráficos */
.card {
    border-radius: 20px;
    border: none;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    overflow: hidden;
}

.card:hover {
    box-shadow: 0 15px 35px rgba(0,0,0,0.15);
    transform: translateY(-5px);
}

.chart-icon {
    width: 40px;
    height: 40px;
    background: rgba(66, 133, 244, 0.1);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
}

.table-icon {
    width: 40px;
    height: 40px;
    background: rgba(0, 172, 193, 0.1);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
}

/* Tabla estilizada */
.table-header-gradient {
    background: var(--table-gradient) !important;
    border-radius: 10px 10px 0 0;
}

.table {
    border-collapse: separate;
    border-spacing: 0;
    border-radius: 10px;
    overflow: hidden;
}

.table thead th {
    border: none;
    font-weight: 600;
    letter-spacing: 0.5px;
}

.table tbody tr {
    transition: all 0.3s ease;
}

.table tbody tr:hover {
    background-color: rgba(66, 133, 244, 0.05) !important;
    transform: scale(1.01);
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}

.plan-count-badge {
    background: linear-gradient(135deg, #4285f4 0%, #0d47a1 100%);
    color: white;
    padding: 5px 15px;
    border-radius: 20px;
    font-size: 0.9rem;
    box-shadow: 0 3px 10px rgba(66, 133, 244, 0.3);
}

/* Sombras mejoradas */
.shadow-lg {
    box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important;
}

/* Responsive */
@media (max-width: 768px) {
    .display-7 {
        font-size: 1.75rem;
    }
    
    .icon-wrapper {
        width: 50px;
        height: 50px;
        font-size: 1.2rem;
    }
    
    .card {
        border-radius: 15px;
    }
    
    .animate-slide-left,
    .animate-slide-right {
        animation: fadeInUp 0.6s ease-out forwards;
    }
}

/* Scroll personalizado */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #4285f4 0%, #0d47a1 100%);
    border-radius: 10px;
}

::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #0d47a1 0%, #4285f4 100%);
}
</style>