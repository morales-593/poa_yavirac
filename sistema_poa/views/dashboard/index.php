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
<link rel="stylesheet" href="public/css/dashboard.css">
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

