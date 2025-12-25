<?php require_once 'views/layout/header.php'; ?>

<div class="container-fluid">

<h4 class="mb-4">Dashboard - Sistema POA</h4>

<!-- ================= TARJETAS ================= -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white p-3 shadow">
            <h6>Total de Planes</h6>
            <h2><?= $totalPlanes ?></h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-success text-white p-3 shadow">
            <h6>Usuarios Activos</h6>
            <h2><?= $usuariosActivos ?></h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-warning text-white p-3 shadow">
            <h6>Planes Completados</h6>
            <h2><?= $planesCompletados ?></h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-info text-white p-3 shadow">
            <h6>Ejes Utilizados</h6>
            <h2><?= $totalEjes ?></h2>
        </div>
    </div>
</div>

<!-- ================= FILTRO ================= -->
<div class="card mb-4 shadow">
    <div class="card-body">
        <label class="fw-bold">Filtrar por Eje</label>
        <select id="filtroEje" class="form-select w-50">
            <option value="0">Todos los Ejes</option>
            <?php foreach($ejes as $e): ?>
                <option value="<?= $e['id_eje'] ?>">
                    <?= $e['nombre_eje'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
</div>

<!-- ================= GRAFICOS ================= -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header">Planes por Eje</div>
            <div class="card-body">
                <canvas id="chartEjes"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header">Planes por Mes</div>
            <div class="card-body">
                <canvas id="chartMeses"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- ================= TABLA ESTADO POR EJE ================= -->
<div class="card shadow mb-4">
    <div class="card-header">Estado de Planes por Eje</div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead class="table-primary">
                <tr>
                    <th>Eje</th>
                    <th>Total Planes</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($estadoPorEje as $e): ?>
                <tr>
                    <td><?= $e['nombre_eje'] ?></td>
                    <td><?= $e['total'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- ================= TABLA RESPONSABLES ================= -->
<div class="card shadow">
    <div class="card-header">Eficiencia por Responsable</div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead class="table-secondary">
                <tr>
                    <th>Responsable</th>
                    <th>Total Planes</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($eficiencia as $r): ?>
                <tr>
                    <td><?= $r['nombre_responsable'] ?></td>
                    <td><?= $r['total'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

</div>

<!-- ================= CHART.JS ================= -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ejes = <?= json_encode(array_column($planesPorEje,'nombre_eje')) ?>;
const valores = <?= json_encode(array_column($planesPorEje,'total')) ?>;

new Chart(document.getElementById('chartEjes'),{
    type:'bar',
    data:{
        labels:ejes,
        datasets:[{
            label:'Planes',
            data:valores,
            backgroundColor:'rgba(54,162,235,.8)'
        }]
    }
});

const meses = <?= json_encode(array_column($planesPorMes,'mes')) ?>;
const totales = <?= json_encode(array_column($planesPorMes,'total')) ?>;

new Chart(document.getElementById('chartMeses'),{
    type:'line',
    data:{
        labels:meses,
        datasets:[{
            label:'Planes',
            data:totales,
            borderColor:'rgba(75,192,192,1)',
            fill:false
        }]
    }
});
</script>

<?php require_once 'views/layout/footer.php'; ?>
