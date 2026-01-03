<!-- Script de depuración -->
<script>
    console.log('=== MODAL ELABORACIÓN CARGADO ===');
    console.log('ID Plan: <?= $id_plan ?>');
    console.log('Eje actual: <?= $eje_actual ?? "NO SELECCIONADO" ?>');
    console.log('ID Indicador guardado: <?= $elab["id_indicador"] ?? "NO HAY" ?>');
</script>

<div class="modal-header bg-primary text-white">
    <h5 class="modal-title">Elaboración POA - <?= htmlspecialchars($plan['nombre_elaborado']) ?></h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<form method="POST" action="index.php?action=guardarElaboracion">
    <input type="hidden" name="id_plan" value="<?= $id_plan ?>">
    <?php if (isset($elab['id_elaboracion'])): ?>
        <input type="hidden" name="id_elaboracion" value="<?= $elab['id_elaboracion'] ?>">
    <?php endif ?>

    <div class="modal-body">
        <div class="row">
            <!-- SECCIÓN EJE E INDICADOR -->
            <div class="col-md-12 mb-3">
                <label class="fw-bold text-primary">1. Seleccione el Eje Estratégico</label>
                <select id="eje_select" class="form-select form-select-lg" required>
                    <option value="">-- Seleccione un Eje --</option>
                    <?php foreach ($ejes as $e): ?>
                        <option value="<?= $e['id_eje'] ?>"
                            data-objetivo="<?= htmlspecialchars($e['descripcion_objetivo'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                            <?= (isset($eje_actual) && $eje_actual == $e['id_eje']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($e['nombre_eje']) ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="col-md-12 mb-3">
                <label class="fw-bold">2. Objetivo del Eje</label>
                <textarea id="objetivo_display" class="form-control bg-light" readonly rows="3"
                    placeholder="El objetivo se cargará aquí..."></textarea>
            </div>

            <div class="col-md-12 mb-3">
                <label class="fw-bold text-primary">3. Seleccione el Indicador</label>
                <select name="id_indicador" id="indicador_select" class="form-select" required>
                    <option value="">-- Primero seleccione un eje --</option>
                </select>
            </div>

            <!-- SECCIÓN TEMA -->
            <div class="col-md-12 mb-3">
                <label class="fw-bold text-primary">4. Seleccione el Tema</label>
                <select name="id_tema" class="form-select" required>
                    <option value="">-- Seleccione un Tema --</option>
                    <?php foreach ($temas as $t): ?>
                        <option value="<?= $t['id_tema'] ?>" <?= (isset($elab['id_tema']) && $elab['id_tema'] == $t['id_tema']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($t['descripcion']) ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>

            <!-- SECCIÓN RESPONSABLE -->
            <div class="col-md-12 mb-3">
                <label class="fw-bold text-primary">5. Responsable</label>
                <select name="id_responsable" class="form-select" required>
                    <option value="">-- Seleccione Responsable --</option>
                    <?php foreach ($responsables as $r): ?>
                        <option value="<?= $r['id_responsable'] ?>" <?= (isset($elab['id_responsable']) && $elab['id_responsable'] == $r['id_responsable']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($r['nombre_responsable']) ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>

            <!-- SECCIÓN LÍNEA BASE -->
            <div class="col-md-12 mb-3">
                <label class="fw-bold text-primary">6. Línea Base</label>
                <input type="text" name="linea_base" class="form-control" value="<?= $elab['linea_base'] ?? '' ?>"
                    placeholder="Descripción de la línea base" required>
            </div>

            <!-- SECCIÓN POLÍTICAS -->
            <div class="col-md-12 mb-3">
                <label class="fw-bold text-primary">7. Políticas</label>
                <textarea name="politicas" class="form-control" rows="2"
                    placeholder="Políticas aplicables"><?= $elab['politicas'] ?? '' ?></textarea>
            </div>

            <!-- SECCIÓN METAS -->
            <div class="col-md-12 mb-3">
                <label class="fw-bold text-primary">8. Metas</label>
                <textarea name="metas" class="form-control" rows="2"
                    placeholder="Metas a alcanzar"><?= $elab['metas'] ?? '' ?></textarea>
            </div>

            <!-- SECCIÓN ACTIVIDADES -->
            <div class="col-md-12 mb-3">
                <label class="fw-bold text-primary">9. Actividades</label>
                <textarea name="actividades" class="form-control" rows="3" placeholder="Actividades a realizar"
                    required><?= $elab['actividades'] ?? '' ?></textarea>
            </div>

            <!-- SECCIÓN INDICADOR RESULTADO -->
            <div class="col-md-12 mb-3">
                <label class="fw-bold text-primary">10. Indicador de Resultado</label>
                <textarea name="indicador_resultado" class="form-control" rows="2"
                    placeholder="Indicador de resultado"><?= $elab['indicador_resultado'] ?? '' ?></textarea>
            </div>

            <!-- SECCIÓN MEDIOS DE VERIFICACIÓN -->
            <div class="col-md-12 mb-3">
                <label class="fw-bold text-primary">11. Medios de Verificación</label>
                <div id="medios-container">
                    <?php
                    // Cargar medios existentes si estamos editando
                    if (isset($elab['id_elaboracion'])):
                        $medios = Plan::obtenerMediosVerificacion($elab['id_elaboracion']);
                        if (!empty($medios)):
                            foreach ($medios as $medio): ?>
                                <div class="row mb-2">
                                    <div class="col-8">
                                        <input type="text" name="detalle[]" class="form-control"
                                            value="<?= htmlspecialchars($medio['detalle']) ?>" placeholder="Descripción del medio">
                                    </div>
                                    <div class="col-4">
                                        <select name="id_plazo[]" class="form-select">
                                            <option value="">-- Plazo --</option>
                                            <?php foreach ($plazos as $pl): ?>
                                                <option value="<?= $pl['id_plazo'] ?>" <?= ($medio['id_plazo'] == $pl['id_plazo']) ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($pl['nombre_plazo']) ?>
                                                </option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                            <?php endforeach;
                        else: ?>
                            <!-- Si no hay medios, mostrar 3 filas vacías -->
                            <?php for ($i = 0; $i < 3; $i++): ?>
                                <div class="row mb-2">
                                    <div class="col-8">
                                        <input type="text" name="detalle[]" class="form-control"
                                            placeholder="Descripción del medio">
                                    </div>
                                    <div class="col-4">
                                        <select name="id_plazo[]" class="form-select">
                                            <option value="">-- Plazo --</option>
                                            <?php foreach ($plazos as $pl): ?>
                                                <option value="<?= $pl['id_plazo'] ?>"><?= htmlspecialchars($pl['nombre_plazo']) ?>
                                                </option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>
                            <?php endfor; ?>
                        <?php endif;
                    else: ?>
                        <!-- Medios por defecto (3 filas) -->
                        <?php for ($i = 0; $i < 3; $i++): ?>
                            <div class="row mb-2">
                                <div class="col-8">
                                    <input type="text" name="detalle[]" class="form-control"
                                        placeholder="Descripción del medio">
                                </div>
                                <div class="col-4">
                                    <select name="id_plazo[]" class="form-select">
                                        <option value="">-- Plazo --</option>
                                        <?php foreach ($plazos as $pl): ?>
                                            <option value="<?= $pl['id_plazo'] ?>"><?= htmlspecialchars($pl['nombre_plazo']) ?>
                                            </option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                        <?php endfor; ?>
                    <?php endif; ?>
                </div>
                <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="agregarMedio()">+ Agregar
                    medio</button>
            </div>

        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary">Guardar Elaboración</button>
    </div>
</form>

<script>
    // Obtener el ID del indicador guardado desde PHP
    const idIndicadorGuardado = "<?= $elab['id_indicador'] ?? '' ?>";

    // Función para agregar más medios de verificación
    function agregarMedio() {
        const container = document.getElementById('medios-container');
        const newRow = document.createElement('div');
        newRow.className = 'row mb-2';
        newRow.innerHTML = `
        <div class="col-8">
            <input type="text" name="detalle[]" class="form-control" placeholder="Descripción del medio">
        </div>
        <div class="col-4">
            <select name="id_plazo[]" class="form-select">
                <option value="">-- Plazo --</option>
                <?php foreach ($plazos as $pl): ?>
                    <option value="<?= $pl['id_plazo'] ?>"><?= htmlspecialchars($pl['nombre_plazo']) ?></option>
                <?php endforeach ?>
            </select>
        </div>
    `;
        container.appendChild(newRow);
    }

    // Inicializar el modal cuando se carga
    document.addEventListener('DOMContentLoaded', function () {
        console.log('DOM del modal cargado');

        const selectorEje = document.getElementById('eje_select');
        const txtObjetivo = document.getElementById('objetivo_display');

        if (selectorEje && selectorEje.value !== "") {
            // Mostrar objetivo inmediatamente
            const opcion = selectorEje.options[selectorEje.selectedIndex];
            const objetivo = opcion.getAttribute('data-objetivo');

            console.log('Eje seleccionado:', selectorEje.value);
            console.log('Objetivo del data-attribute:', objetivo);

            if (objetivo && txtObjetivo) {
                txtObjetivo.value = objetivo;
            }

            // Cargar indicadores si tenemos la función global
            if (typeof actualizarTodo === 'function') {
                setTimeout(() => {
                    actualizarTodo(selectorEje, idIndicadorGuardado);
                }, 300);
            }
        }

        // Configurar evento change
        if (selectorEje) {
            selectorEje.addEventListener('change', function () {
                // Mostrar objetivo inmediatamente
                const opcion = this.options[this.selectedIndex];
                const objetivo = opcion.getAttribute('data-objetivo');
                if (objetivo && txtObjetivo) {
                    txtObjetivo.value = objetivo;
                }

                // Cargar indicadores
                if (typeof actualizarTodo === 'function') {
                    actualizarTodo(this);
                }
            });
        }
    });
</script>