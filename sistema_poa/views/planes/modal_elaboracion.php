<div class="modal-header bg-primary text-white">
    <h5 class="modal-title"><i class="fas fa-clipboard-check me-2"></i>
        Elaboración POA - <?= htmlspecialchars($plan['nombre_elaborado']) ?>
    </h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
</div>

<form method="POST" action="index.php?action=guardarElaboracion" id="formElaboracion">
    <input type="hidden" name="id_plan" value="<?= $id_plan ?>">
    <?php if (isset($elab['id_elaboracion'])): ?>
        <input type="hidden" name="id_elaboracion" value="<?= $elab['id_elaboracion'] ?>">
        <input type="hidden" id="indicador_guardado" value="<?= $elab['id_indicador'] ?>">
    <?php endif ?>

    <div class="modal-body">
        <!-- SECCIÓN PRINCIPAL EN 2 COLUMNAS -->
        <div class="row">
            <!-- COLUMNA IZQUIERDA -->
            <div class="col-lg-6">
                <!-- CARD: EJE ESTRATÉGICO -->
                <div class="card mb-3 border-primary shadow-sm">
                    <div class="card-header bg-primary text-white py-2">
                        <h6 class="mb-0">
                            <i class="fas fa-bullseye me-1"></i>
                            1. Eje Estratégico
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Seleccione el Eje:</label>
                            <select id="eje_select" class="form-select form-select-sm" required>
                                <option value="">-- Seleccione un Eje --</option>
                                <?php foreach ($ejes as $e): ?>
                                        <?php
                                        $objetivo = $e['descripcion_objetivo'] ?? '';
                                        $selected = (isset($eje_actual) && $eje_actual == $e['id_eje']) ? 'selected' : '';
                                        ?>
                                        <option value="<?= $e['id_eje'] ?>" 
                                                data-objetivo="<?= htmlspecialchars($objetivo, ENT_QUOTES, 'UTF-8') ?>"
                                                <?= $selected ?>>
                                            <?= htmlspecialchars($e['nombre_eje']) ?>
                                        </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        
                        <div class="mb-0">
                            <label class="form-label fw-semibold small">Objetivo del Eje:</label>
                            <textarea id="objetivo_display" class="form-control form-control-sm bg-light" 
                                      readonly rows="3" style="font-size: 0.875rem;"></textarea>
                        </div>
                    </div>
                </div>

                <!-- CARD: INDICADORES (SE MOSTRARÁN COMO CARDS) -->
                <div class="card mb-3 border-info shadow-sm">
                    <div class="card-header bg-info text-white py-2">
                        <h6 class="mb-0">
                            <i class="fas fa-chart-line me-1"></i>
                            2. Selección de Indicador
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Indicador Seleccionado:</label>
                            <select name="id_indicador" id="indicador_select" class="form-select form-select-sm" required>
                                <option value="">-- Cargando indicadores... --</option>
                            </select>
                        </div>
                        
                        <!-- CONTENEDOR DE CARDS DE INDICADORES -->
                        <div class="alert alert-warning alert-sm mb-0">
                            <i class="fas fa-info-circle me-1"></i>
                            <small>Los indicadores disponibles aparecerán automáticamente al seleccionar un eje.</small>
                        </div>
                    </div>
                </div>

                <!-- CARD: TEMA Y RESPONSABLE -->
                <div class="card mb-3 border-success shadow-sm">
                    <div class="card-header bg-success text-white py-2">
                        <h6 class="mb-0">
                            <i class="fas fa-tags me-1"></i>
                            3. Configuración General
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">Tema:</label>
                                    <select name="id_tema" class="form-select form-select-sm" required>
                                        <option value="">-- Seleccione --</option>
                                        <?php foreach ($temas as $t): ?>
                                                <option value="<?= $t['id_tema'] ?>" 
                                                        <?= (isset($elab['id_tema']) && $elab['id_tema'] == $t['id_tema']) ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($t['descripcion']) ?>
                                                </option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">Responsable:</label>
                                    <select name="id_responsable" class="form-select form-select-sm" required>
                                        <option value="">-- Seleccione --</option>
                                        <?php foreach ($responsables as $r): ?>
                                                <option value="<?= $r['id_responsable'] ?>" 
                                                        <?= (isset($elab['id_responsable']) && $elab['id_responsable'] == $r['id_responsable']) ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($r['nombre_responsable']) ?>
                                                </option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- COLUMNA DERECHA -->
            <div class="col-lg-6">
                <!-- CARD: LÍNEA BASE Y POLÍTICAS -->
                <div class="card mb-3 border-warning shadow-sm">
                    <div class="card-header bg-warning text-white py-2">
                        <h6 class="mb-0">
                            <i class="fas fa-chart-bar me-1"></i>
                            4. Información Base
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Línea Base:</label>
                            <input type="text" name="linea_base" class="form-control form-control-sm" 
                                   value="<?= $elab['linea_base'] ?? '' ?>" 
                                   placeholder="Descripción de la línea base" required>
                            <div class="form-text"><small>Punto de partida para la medición</small></div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">Políticas:</label>
                                    <textarea name="politicas" class="form-control form-control-sm" rows="2" 
                                              placeholder="Políticas aplicables"><?= $elab['politicas'] ?? '' ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold small">Metas:</label>
                                    <textarea name="metas" class="form-control form-control-sm" rows="2" 
                                              placeholder="Metas a alcanzar"><?= $elab['metas'] ?? '' ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CARD: ACTIVIDADES E INDICADOR DE RESULTADO -->
                <div class="card mb-3 border-danger shadow-sm">
                    <div class="card-header bg-danger text-white py-2">
                        <h6 class="mb-0">
                            <i class="fas fa-tasks me-1"></i>
                            5. Ejecución
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Actividades:</label>
                            <textarea name="actividades" class="form-control form-control-sm" rows="3" 
                                      placeholder="Actividades a realizar" required><?= $elab['actividades'] ?? '' ?></textarea>
                            <div class="form-text"><small>Describa las actividades principales</small></div>
                        </div>
                        
                        <div class="mb-0">
                            <label class="form-label fw-semibold small">Indicador de Resultado:</label>
                            <textarea name="indicador_resultado" class="form-control form-control-sm" rows="2" 
                                      placeholder="Indicador para medir resultados"><?= $elab['indicador_resultado'] ?? '' ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- CARD: MEDIOS DE VERIFICACIÓN -->
                <div class="card mb-3 border-secondary shadow-sm">
                    <div class="card-header bg-secondary text-white py-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">
                                <i class="fas fa-file-alt me-1"></i>
                                6. Medios de Verificación
                            </h6>
                            <div>
                                <button type="button" class="btn btn-sm btn-light" onclick="agregarMedio()">
                                    <i class="fas fa-plus"></i> Agregar
                                </button>
                                <button type="button" class="btn btn-sm btn-light ms-1" onclick="limpiarMedios()">
                                    <i class="fas fa-broom"></i> Limpiar
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered mb-0" id="tablaMedios">
                                <thead class="table-light">
                                    <tr>
                                        <th width="5%" class="text-center">#</th>
                                        <th width="60%">Descripción del Medio</th>
                                        <th width="25%">Plazo</th>
                                        <th width="10%" class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="medios-container">
                                    <?php
                                    $contador = 1;
                                    if (isset($elab['id_elaboracion'])):
                                        $medios = Plan::obtenerMediosVerificacion($elab['id_elaboracion']);
                                        if (!empty($medios)):
                                            foreach ($medios as $medio): ?>
                                                            <tr id="fila-<?= $contador ?>">
                                                                <td class="text-center"><?= $contador ?></td>
                                                                <td>
                                                                    <input type="text" name="detalle[]" class="form-control form-control-sm border-0" 
                                                                           value="<?= htmlspecialchars($medio['detalle']) ?>" 
                                                                           placeholder="Descripción del medio" required>
                                                                </td>
                                                                <td>
                                                                    <select name="id_plazo[]" class="form-select form-select-sm border-0" required>
                                                                        <option value="">-- Seleccione --</option>
                                                                        <?php foreach ($plazos as $pl): ?>
                                                                                <option value="<?= $pl['id_plazo'] ?>" 
                                                                                        <?= ($medio['id_plazo'] == $pl['id_plazo']) ? 'selected' : '' ?>>
                                                                                    <?= htmlspecialchars($pl['nombre_plazo']) ?>
                                                                                </option>
                                                                        <?php endforeach ?>
                                                                    </select>
                                                                </td>
                                                                <td class="text-center">
                                                                    <button type="button" class="btn btn-sm btn-outline-danger py-0 px-1" 
                                                                            onclick="eliminarFila(<?= $contador ?>)" title="Eliminar">
                                                                        <i class="fas fa-times"></i>
                                                                    </button>
                                                                </td>
                                                            </tr>
                                                        <?php
                                                        $contador++;
                                            endforeach;
                                        else: ?>
                                                    <!-- Fila por defecto si no hay medios -->
                                                    <tr id="fila-1">
                                                        <td class="text-center">1</td>
                                                        <td>
                                                            <input type="text" name="detalle[]" class="form-control form-control-sm border-0" 
                                                                   placeholder="Descripción del medio" required>
                                                        </td>
                                                        <td>
                                                            <select name="id_plazo[]" class="form-select form-select-sm border-0" required>
                                                                <option value="">-- Seleccione --</option>
                                                                <?php foreach ($plazos as $pl): ?>
                                                                        <option value="<?= $pl['id_plazo'] ?>"><?= htmlspecialchars($pl['nombre_plazo']) ?></option>
                                                                <?php endforeach ?>
                                                            </select>
                                                        </td>
                                                        <td class="text-center">
                                                            <button type="button" class="btn btn-sm btn-outline-danger py-0 px-1" 
                                                                    onclick="eliminarFila(1)" title="Eliminar">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                <?php
                                                $contador = 2;
                                        endif;
                                    else: ?>
                                            <!-- Para nuevo registro, mostrar 2 filas por defecto -->
                                            <?php for ($i = 1; $i <= 2; $i++): ?>
                                                    <tr id="fila-<?= $i ?>">
                                                        <td class="text-center"><?= $i ?></td>
                                                        <td>
                                                            <input type="text" name="detalle[]" class="form-control form-control-sm border-0" 
                                                                   placeholder="Descripción del medio" required>
                                                        </td>
                                                        <td>
                                                            <select name="id_plazo[]" class="form-select form-select-sm border-0" required>
                                                                <option value="">-- Seleccione --</option>
                                                                <?php foreach ($plazos as $pl): ?>
                                                                        <option value="<?= $pl['id_plazo'] ?>"><?= htmlspecialchars($pl['nombre_plazo']) ?></option>
                                                                <?php endforeach ?>
                                                            </select>
                                                        </td>
                                                        <td class="text-center">
                                                            <button type="button" class="btn btn-sm btn-outline-danger py-0 px-1" 
                                                                    onclick="eliminarFila(<?= $i ?>)" title="Eliminar">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                            <?php endfor;
                                            $contador = 3;
                                    endif; ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-2">
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Total de medios: <span id="total-medios" class="badge bg-info"><?= ($contador - 1) ?></span>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECCIÓN DE CARDS DE INDICADORES (SE GENERA DINÁMICAMENTE) -->
        <div class="row mt-3" id="cards-indicadores-container" style="display: none;">
            <div class="col-12">
                <div class="card border-info">
                    <div class="card-header bg-info text-white py-2">
                        <h6 class="mb-0">
                            <i class="fas fa-list-alt me-1"></i>
                            Indicadores Disponibles
                        </h6>
                    </div>
                    <div class="card-body p-2">
                        <div class="row g-2" id="cards-indicadores">
                            <!-- Las cards se generarán aquí dinámicamente -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i> Cancelar
        </button>
        <button type="submit" class="btn btn-primary btn-sm">
            <i class="fas fa-save me-1"></i> Guardar Elaboración
        </button>
    </div>
</form>

<style>
/* ESTILOS GENERALES PARA EL MODAL */
.modal-body {
    font-size: 0.875rem;
}

.card {
    border-radius: 8px;
    border-width: 2px;
}

.card-header {
    border-radius: 6px 6px 0 0 !important;
}

.card-header h6 {
    font-size: 0.95rem;
    font-weight: 600;
}

.form-label {
    font-size: 0.8rem;
    margin-bottom: 0.3rem;
}

.form-control-sm, .form-select-sm {
    font-size: 0.8rem;
    padding: 0.25rem 0.5rem;
}

.form-text {
    font-size: 0.75rem;
}

/* ESTILOS PARA LA TABLA DE MEDIOS */
#tablaMedios {
    font-size: 0.8rem;
}

#tablaMedios th {
    padding: 0.3rem 0.5rem;
    font-weight: 600;
}

#tablaMedios td {
    padding: 0.2rem 0.4rem;
    vertical-align: middle;
}

#tablaMedios .form-control-sm,
#tablaMedios .form-select-sm {
    border: 1px solid #dee2e6 !important;
    border-radius: 4px;
}

#tablaMedios .btn-sm {
    padding: 0.1rem 0.3rem;
    font-size: 0.7rem;
}

/* ESTILOS PARA LAS CARDS DE INDICADORES */
.indicador-card {
    transition: all 0.3s ease;
    cursor: pointer;
    border: 2px solid #dee2e6;
    border-radius: 6px;
    overflow: hidden;
}

.indicador-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.indicador-card.selected {
    border-color: #0d6efd;
    background-color: #e7f1ff;
}

.indicador-card-header {
    background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
    color: white;
    padding: 0.5rem;
    font-size: 0.75rem;
    font-weight: 600;
}

.indicador-card.selected .indicador-card-header {
    background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
}

.indicador-card-body {
    padding: 0.75rem;
    font-size: 0.8rem;
    background-color: white;
}

.indicador-codigo {
    font-weight: 600;
    color: #495057;
    font-size: 0.85rem;
    margin-bottom: 0.25rem;
}

.indicador-descripcion {
    color: #6c757d;
    font-size: 0.8rem;
    line-height: 1.3;
    margin-bottom: 0.5rem;
}

.indicador-seleccionado {
    display: none;
    color: #0d6efd;
    font-weight: 600;
    font-size: 0.75rem;
}

.indicador-card.selected .indicador-seleccionado {
    display: block;
}

/* ESTILOS PARA VALIDACIÓN */
.is-invalid {
    border-color: #dc3545 !important;
}

.is-valid {
    border-color: #198754 !important;
}

/* RESPONSIVE */
@media (max-width: 992px) {
    .col-lg-6 {
        width: 100%;
    }
    
    .modal-dialog {
        max-width: 95%;
    }
}
</style>

<script>
// ============================================
// VARIABLES Y FUNCIONES PARA EL MODAL
// ============================================

// Variable global para el modal
window.idIndicadorGuardadoModal = "<?= $elab['id_indicador'] ?? '' ?>";
let contadorFilas = <?= $contador ?? 3 ?>;

// Función para inicializar el modal
function inicializarModal() {
    console.log('🔧 Inicializando modal mejorado...');
    
    const selectorEje = document.getElementById('eje_select');
    const txtObjetivo = document.getElementById('objetivo_display');
    
    if (!selectorEje) return;
    
    // Mostrar objetivo si ya hay eje seleccionado
    if (selectorEje.value && selectorEje.value !== "") {
        const opcion = selectorEje.options[selectorEje.selectedIndex];
        const objetivo = opcion.getAttribute('data-objetivo');
        if (objetivo && txtObjetivo) {
            txtObjetivo.value = objetivo;
        }
        
        // Cargar indicadores iniciales
        setTimeout(() => {
            cargarIndicadoresYMostrarCards(selectorEje.value);
        }, 300);
    }
    
    // Configurar evento change del eje
    selectorEje.addEventListener('change', function() {
        const opcion = this.options[this.selectedIndex];
        const objetivo = opcion.getAttribute('data-objetivo');
        if (txtObjetivo) {
            if (objetivo && objetivo.trim() !== "") {
                txtObjetivo.value = objetivo;
            } else {
                txtObjetivo.value = "No hay objetivo registrado para este eje.";
            }
        }
        
        // Cargar y mostrar cards de indicadores
        cargarIndicadoresYMostrarCards(this.value);
    });
    
    // Configurar evento change del select tradicional (por si acaso)
    const selectIndicador = document.getElementById('indicador_select');
    if (selectIndicador) {
        selectIndicador.addEventListener('change', function() {
            actualizarCardsSeleccionadas(this.value);
        });
    }
}

// Función para cargar indicadores y mostrar cards
function cargarIndicadoresYMostrarCards(id_eje) {
    if (!id_eje || id_eje === "") {
        ocultarCardsIndicadores();
        return;
    }
    
    console.log('📊 Cargando indicadores para mostrar en cards...');
    
    const selectIndicador = document.getElementById('indicador_select');
    selectIndicador.innerHTML = '<option value="">Cargando indicadores...</option>';
    selectIndicador.disabled = true;
    
    fetch('index.php?action=indicadoresPorEje&id_eje=' + id_eje)
        .then(response => response.json())
        .then(data => {
            console.log('✅ Indicadores recibidos:', data);
            
            // Actualizar select tradicional
            actualizarSelectIndicadores(data);
            
            // Mostrar cards si hay datos
            if (data && Array.isArray(data) && data.length > 0) {
                mostrarCardsIndicadores(data);
            } else {
                ocultarCardsIndicadores();
                mostrarMensajeModal('No hay indicadores disponibles para este eje', 'warning');
            }
            
            selectIndicador.disabled = false;
        })
        .catch(error => {
            console.error('❌ Error:', error);
            ocultarCardsIndicadores();
            selectIndicador.innerHTML = '<option value="">Error al cargar</option>';
            selectIndicador.disabled = false;
        });
}

// Función para actualizar el select tradicional
function actualizarSelectIndicadores(data) {
    const selectIndicador = document.getElementById('indicador_select');
    let opciones = '<option value="">-- Seleccione un Indicador --</option>';
    
    if (data && data.length > 0) {
        const idIndicadorGuardado = window.idIndicadorGuardadoModal || '';
        
        data.forEach(ind => {
            const selected = (idIndicadorGuardado == ind.id_indicador) ? 'selected' : '';
            opciones += `<option value="${ind.id_indicador}" ${selected}>${ind.codigo} - ${ind.descripcion}</option>`;
        });
    } else {
        opciones = '<option value="">No hay indicadores</option>';
    }
    
    selectIndicador.innerHTML = opciones;
}

// Función para mostrar cards de indicadores
function mostrarCardsIndicadores(indicadores) {
    const container = document.getElementById('cards-indicadores-container');
    const cardsContainer = document.getElementById('cards-indicadores');
    
    if (!container || !cardsContainer) return;
    
    // Limpiar container
    cardsContainer.innerHTML = '';
    
    // Determinar indicador seleccionado
    const idIndicadorGuardado = window.idIndicadorGuardadoModal || '';
    const selectIndicador = document.getElementById('indicador_select');
    const idSelectSeleccionado = selectIndicador ? selectIndicador.value : '';
    
    // Crear cards para cada indicador
    indicadores.forEach(ind => {
        const isSelected = (idIndicadorGuardado == ind.id_indicador) || (idSelectSeleccionado == ind.id_indicador);
        
        const card = document.createElement('div');
        card.className = `col-md-6 col-lg-4 mb-2`;
        card.innerHTML = `
            <div class="indicador-card ${isSelected ? 'selected' : ''}" 
                 data-id="${ind.id_indicador}"
                 onclick="seleccionarIndicadorCard(${ind.id_indicador}, '${ind.codigo}', '${ind.descripcion.replace(/'/g, "\\'")}')">
                <div class="indicador-card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <span>${ind.codigo}</span>
                        ${isSelected ? '<i class="fas fa-check-circle"></i>' : ''}
                    </div>
                </div>
                <div class="indicador-card-body">
                    <div class="indicador-codigo">${ind.codigo}</div>
                    <div class="indicador-descripcion">${ind.descripcion.substring(0, 80)}${ind.descripcion.length > 80 ? '...' : ''}</div>
                    <div class="indicador-seleccionado">
                        <i class="fas fa-check me-1"></i> Seleccionado
                    </div>
                </div>
            </div>
        `;
        
        cardsContainer.appendChild(card);
    });
    
    // Mostrar el contenedor
    container.style.display = 'block';
}

// Función para ocultar cards
function ocultarCardsIndicadores() {
    const container = document.getElementById('cards-indicadores-container');
    if (container) {
        container.style.display = 'none';
    }
}

// Función para seleccionar indicador desde card
function seleccionarIndicadorCard(id, codigo, descripcion) {
    console.log('🎯 Seleccionando indicador desde card:', id, codigo);
    
    // Actualizar select tradicional
    const selectIndicador = document.getElementById('indicador_select');
    if (selectIndicador) {
        selectIndicador.value = id;
        
        // Disparar evento change
        selectIndicador.dispatchEvent(new Event('change'));
    }
    
    // Actualizar cards seleccionadas
    actualizarCardsSeleccionadas(id);
    
    // Mostrar mensaje
    mostrarMensajeModal(`Indicador seleccionado: <strong>${codigo}</strong>`, 'success');
}

// Función para actualizar cards seleccionadas
function actualizarCardsSeleccionadas(idSeleccionado) {
    // Quitar selección de todas las cards
    document.querySelectorAll('.indicador-card').forEach(card => {
        card.classList.remove('selected');
    });
    
    // Agregar selección a la card correspondiente
    const cardSeleccionada = document.querySelector(`.indicador-card[data-id="${idSeleccionado}"]`);
    if (cardSeleccionada) {
        cardSeleccionada.classList.add('selected');
    }
}

// Función para mostrar mensajes en el modal
function mostrarMensajeModal(texto, tipo = 'info') {
    // Crear o actualizar mensaje
    let mensaje = document.getElementById('mensaje-modal-temporal');
    if (!mensaje) {
        mensaje = document.createElement('div');
        mensaje.id = 'mensaje-modal-temporal';
        mensaje.style.position = 'fixed';
        mensaje.style.top = '70px';
        mensaje.style.right = '20px';
        mensaje.style.zIndex = '9999';
        mensaje.style.minWidth = '300px';
        document.body.appendChild(mensaje);
    }
    
    // Determinar clase según tipo
    let clase = 'alert-info';
    switch(tipo) {
        case 'success': clase = 'alert-success'; break;
        case 'warning': clase = 'alert-warning'; break;
        case 'danger': clase = 'alert-danger'; break;
    }
    
    mensaje.className = `alert ${clase} alert-dismissible fade show shadow`;
    mensaje.innerHTML = `
        <div class="d-flex align-items-center">
            <i class="fas fa-${tipo === 'success' ? 'check-circle' : 'info-circle'} me-2"></i>
            <div class="flex-grow-1">${texto}</div>
            <button type="button" class="btn-close" onclick="this.parentElement.parentElement.remove()"></button>
        </div>
    `;
    
    // Auto-eliminar después de 3 segundos
    setTimeout(() => {
        if (mensaje.parentElement) {
            mensaje.remove();
        }
    }, 3000);
}

// ============================================
// FUNCIONES PARA MEDIOS DE VERIFICACIÓN
// ============================================

// Función para agregar medio
function agregarMedio() {
    const tbody = document.getElementById('medios-container');
    if (!tbody) return;
    
    const nuevaFila = document.createElement('tr');
    nuevaFila.id = 'fila-' + contadorFilas;
    
    // Obtener opciones de plazos
    let opcionesPlazos = '<option value="">-- Seleccione --</option>';
    const primerSelect = tbody.querySelector('select[name="id_plazo[]"]');
    if (primerSelect) {
        opcionesPlazos = primerSelect.innerHTML.replace('selected', '');
    }
    
    nuevaFila.innerHTML = `
        <td class="text-center">${contadorFilas}</td>
        <td>
            <input type="text" name="detalle[]" class="form-control form-control-sm border-0" 
                   placeholder="Descripción del medio" required>
        </td>
        <td>
            <select name="id_plazo[]" class="form-select form-select-sm border-0" required>
                ${opcionesPlazos}
            </select>
        </td>
        <td class="text-center">
            <button type="button" class="btn btn-sm btn-outline-danger py-0 px-1" 
                    onclick="eliminarFila(${contadorFilas})" title="Eliminar">
                <i class="fas fa-times"></i>
            </button>
        </td>
    `;
    
    tbody.appendChild(nuevaFila);
    contadorFilas++;
    actualizarContador();
    
    // Animación
    nuevaFila.style.opacity = '0';
    setTimeout(() => {
        nuevaFila.style.transition = 'opacity 0.3s';
        nuevaFila.style.opacity = '1';
    }, 10);
    
    mostrarMensajeModal('Nuevo medio agregado', 'success');
}

// Función para eliminar fila
function eliminarFila(numeroFila) {
    const fila = document.getElementById('fila-' + numeroFila);
    if (!fila) return;
    
    if (confirm('¿Eliminar este medio de verificación?')) {
        fila.remove();
        renumerarFilas();
        actualizarContador();
        mostrarMensajeModal('Medio eliminado', 'warning');
    }
}

// Función para renumerar filas
function renumerarFilas() {
    const filas = document.querySelectorAll('#medios-container tr');
    let nuevoContador = 1;
    
    filas.forEach((fila, index) => {
        // Actualizar número
        const tdNumero = fila.querySelector('td:first-child');
        if (tdNumero) {
            tdNumero.textContent = nuevoContador;
        }
        
        // Actualizar ID y onclick
        fila.id = 'fila-' + nuevoContador;
        const btnEliminar = fila.querySelector('button');
        if (btnEliminar) {
            btnEliminar.setAttribute('onclick', `eliminarFila(${nuevoContador})`);
        }
        
        nuevoContador++;
    });
    
    contadorFilas = nuevoContador;
}

// Función para actualizar contador
function actualizarContador() {
    const total = document.querySelectorAll('#medios-container tr').length;
    const contadorElement = document.getElementById('total-medios');
    if (contadorElement) {
        contadorElement.textContent = total;
    }
}

// Función para limpiar medios
function limpiarMedios() {
    const total = document.querySelectorAll('#medios-container tr').length;
    if (total === 0) {
        mostrarMensajeModal('No hay medios para limpiar', 'info');
        return;
    }
    
    if (confirm(`¿Limpiar todos los medios de verificación? (${total} medios)`)) {
        document.querySelectorAll('#medios-container tr').forEach(fila => {
            fila.remove();
        });
        
        // Agregar una fila vacía
        contadorFilas = 1;
        agregarMedio();
        
        mostrarMensajeModal('Medios limpiados', 'info');
    }
}

// ============================================
// VALIDACIÓN DEL FORMULARIO
// ============================================

document.getElementById('formElaboracion').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Validar campos básicos
    const camposRequeridos = [
        { id: 'eje_select', nombre: 'Eje Estratégico' },
        { id: 'indicador_select', nombre: 'Indicador' },
        { name: 'id_tema', nombre: 'Tema' },
        { name: 'id_responsable', nombre: 'Responsable' },
        { name: 'linea_base', nombre: 'Línea Base' },
        { name: 'actividades', nombre: 'Actividades' }
    ];
    
    let errores = [];
    
    camposRequeridos.forEach(campo => {
        let elemento;
        if (campo.id) {
            elemento = document.getElementById(campo.id);
        } else if (campo.name) {
            elemento = document.querySelector(`[name="${campo.name}"]`);
        }
        
        if (elemento && !elemento.value.trim()) {
            elemento.classList.add('is-invalid');
            errores.push(campo.nombre);
        } else if (elemento) {
            elemento.classList.remove('is-invalid');
        }
    });
    
    // Validar medios de verificación
    const medios = document.querySelectorAll('input[name="detalle[]"]');
    if (medios.length === 0) {
        errores.push('Medios de Verificación');
    } else {
        medios.forEach((input, index) => {
            if (!input.value.trim()) {
                input.classList.add('is-invalid');
                errores.push(`Medio ${index + 1}`);
            } else {
                input.classList.remove('is-invalid');
            }
        });
        
        document.querySelectorAll('select[name="id_plazo[]"]').forEach((select, index) => {
            if (!select.value) {
                select.classList.add('is-invalid');
                if (!errores.includes(`Medio ${index + 1}`)) {
                    errores.push(`Medio ${index + 1}`);
                }
            } else {
                select.classList.remove('is-invalid');
            }
        });
    }
    
    if (errores.length > 0) {
        mostrarMensajeModal(`Complete los campos requeridos: ${errores.join(', ')}`, 'danger');
        return false;
    }
    
    // Deshabilitar botón de enviar
    const btnSubmit = this.querySelector('button[type="submit"]');
    const originalHTML = btnSubmit.innerHTML;
    btnSubmit.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Guardando...';
    btnSubmit.disabled = true;
    
    // Enviar formulario
    setTimeout(() => {
        this.submit();
    }, 500);
});

// ============================================
// INICIALIZACIÓN
// ============================================

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    console.log('📋 Modal de elaboración cargado');
    console.log('🎯 ID Indicador guardado:', window.idIndicadorGuardadoModal);
    
    // Inicializar después de un breve delay
    setTimeout(inicializarModal, 200);
    
    // También inicializar cuando el modal se muestre completamente
    const modalEl = document.getElementById('modalElab');
    if (modalEl) {
        modalEl.addEventListener('shown.bs.modal', function() {
            setTimeout(inicializarModal, 300);
        });
    }
});
</script>