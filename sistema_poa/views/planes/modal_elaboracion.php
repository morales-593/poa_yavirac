<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planes Operativo</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="public/css/modal_elaboracion.css">
   
</head>

<body>
<div class="modal-header bg-primary text-white d-flex justify-content-between align-items-center">
    <div>
        <h5 class="modal-title mb-0"><i class="fas fa-clipboard-check me-2"></i>
            Elaboración POA - <?= htmlspecialchars($plan['nombre_elaborado']) ?>
        </h5>
        <small class="text-white-50">Complete todos los campos requeridos (*)</small>
    </div>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
</div>

<form method="POST" action="index.php?action=guardarElaboracion" id="formElaboracion">
    <input type="hidden" name="id_plan" value="<?= $id_plan ?>">
    <?php if (isset($elab['id_elaboracion'])): ?>
        <input type="hidden" name="id_elaboracion" value="<?= $elab['id_elaboracion'] ?>">
        <input type="hidden" id="indicador_guardado" value="<?= $elab['id_indicador'] ?>">
    <?php endif ?>

    <div class="modal-body formulario-container">
        <!-- Encabezado del documento -->
        <div class="document-header">
            <h1 class="document-title">PLAN OPERATIVO ANUAL 2024</h1>
            <div class="document-subtitle">
                <strong>Formulario:</strong> Elaboración POA 2024
            </div>
        </div>
        
        <div class="container-fluid">
            <!-- SECCIÓN 1: TEMA -->
            <div class="form-section">
                <div class="section-title">
                    <i class="fas fa-file-alt me-2"></i>INFORMACIÓN GENERAL
                </div>
                
                <div class="row">
                    <div class="col-md-6 field-group">
                        <label class="form-label-custom">TEMA <span class="required-asterisk">*</span></label>
                        <select name="id_tema" class="form-select form-control-custom" required>
                            <option value="">-- Seleccione un Tema --</option>
                            <?php foreach ($temas as $t): ?>
                                    <option value="<?= $t['id_tema'] ?>" 
                                            <?= (isset($elab['id_tema']) && $elab['id_tema'] == $t['id_tema']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($t['descripcion']) ?>
                                    </option>
                            <?php endforeach ?>
                        </select>
                        <small class="text-muted">Tema del plan operativo anual</small>
                    </div>
                    
                </div>
            </div>

            <!-- SECCIÓN 2: EJE ESTRATÉGICO E INDICADOR -->
            <div class="form-section">
                <div class="section-title">
                    <i class="fas fa-bullseye me-2"></i>EJE ESTRATÉGICO E INDICADOR
                </div>
                
                <div class="row">
                    <div class="col-md-6 field-group">
                        <label class="form-label-custom">1. EJE ESTRATÉGICO <span class="required-asterisk">*</span></label>
                        <select id="eje_select" class="form-select form-control-custom" required>
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
                        <small class="text-muted">Al seleccionar un objetivo, el eje se completará automáticamente</small>
                        
                        <div class="mt-3">
                            <label class="form-label-custom">OBJETIVO DEL EJE</label>
                            <textarea id="objetivo_display" class="form-control form-control-custom readonly-field" 
                                      rows="3" readonly></textarea>
                        </div>
                    </div>
                    
                    <div class="col-md-6 field-group">
                        <label class="form-label-custom">2. INDICADOR <span class="required-asterisk">*</span></label>
                        <select name="id_indicador" id="indicador_select" class="form-select form-control-custom" required>
                            <option value="">-- Cargando indicadores... --</option>
                        </select>
                        
                        <!-- Cards de indicadores (se mostrarán dinámicamente) -->
                        <div class="mt-3" id="cards-indicadores-container" style="display: none;">
                            <label class="form-label-custom">INDICADORES DISPONIBLES</label>
                            <div class="row g-2" id="cards-indicadores">
                                <!-- Las cards se generarán aquí dinámicamente -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECCIÓN 3: CONFIGURACIÓN GENERAL -->
            <div class="form-section">
                <div class="section-title">
                    <i class="fas fa-cogs me-2"></i>CONFIGURACIÓN GENERAL
                </div>
                
                <div class="row">
                    <div class="col-md-6 field-group">
                        <label class="form-label-custom">RESPONSABLE <span class="required-asterisk">*</span></label>
                        <select name="id_responsable" class="form-select form-control-custom" required>
                            <option value="">-- Seleccione un Responsable --</option>
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

            <!-- SECCIÓN 4: INFORMACIÓN BASE -->
            <div class="form-section">
                <div class="section-title">
                    <i class="fas fa-database me-2"></i>INFORMACIÓN BASE
                </div>
                
                <div class="row">
                    <div class="col-md-6 field-group">
                        <label class="form-label-custom">LÍNEA BASE <span class="required-asterisk">*</span></label>
                        <input type="text" name="linea_base" class="form-control form-control-custom" 
                               value="<?= $elab['linea_base'] ?? '' ?>" 
                               placeholder="Descripción de la línea base" required>
                        <small class="text-muted">Punto de partida para la medición</small>
                    </div>
                    
                    <div class="col-md-3 field-group">
                        <label class="form-label-custom">POLÍTICAS</label>
                        <textarea name="politicas" class="form-control form-control-custom" rows="2" 
                                  placeholder="Políticas aplicables"><?= $elab['politicas'] ?? '' ?></textarea>
                    </div>
                    
                    <div class="col-md-3 field-group">
                        <label class="form-label-custom">METAS</label>
                        <textarea name="metas" class="form-control form-control-custom" rows="2" 
                                  placeholder="Metas a alcanzar"><?= $elab['metas'] ?? '' ?></textarea>
                    </div>
                </div>
            </div>

            <!-- SECCIÓN 5: EJECUCIÓN -->
            <div class="form-section">
                <div class="section-title">
                    <i class="fas fa-play-circle me-2"></i>EJECUCIÓN
                </div>
                
                <div class="row">
                    <div class="col-md-6 field-group">
                        <label class="form-label-custom">ACTIVIDADES <span class="required-asterisk">*</span></label>
                        <textarea name="actividades" class="form-control form-control-custom" rows="3" 
                                  placeholder="Actividades a realizar" required><?= $elab['actividades'] ?? '' ?></textarea>
                        <small class="text-muted">Describa las actividades principales</small>
                    </div>
                    
                    <div class="col-md-6 field-group">
                        <label class="form-label-custom">INDICADOR DE RESULTADO</label>
                        <textarea name="indicador_resultado" class="form-control form-control-custom" rows="3" 
                                  placeholder="Indicador para medir resultados"><?= $elab['indicador_resultado'] ?? '' ?></textarea>
                    </div>
                </div>
            </div>

            <!-- SECCIÓN 6: MEDIOS DE VERIFICACIÓN -->
            <div class="form-section">
                <div class="section-title d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-file-check me-2"></i>MEDIOS DE VERIFICACIÓN
                    </div>
                    <div>
                        <button type="button" class="btn btn-sm btn-custom-primary" onclick="agregarMedio()">
                            <i class="fas fa-plus me-1"></i> Agregar
                        </button>
                        <button type="button" class="btn btn-sm btn-custom-secondary ms-1" onclick="limpiarMedios()">
                            <i class="fas fa-broom me-1"></i> Limpiar
                        </button>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-custom" id="tablaMedios">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center">#</th>
                                <th width="60%">DESCRIPCIÓN DEL MEDIO <span class="required-asterisk">*</span></th>
                                <th width="25%">PLAZO <span class="required-asterisk">*</span></th>
                                <th width="10%" class="text-center">ACCIONES</th>
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
                                                            <input type="text" name="detalle[]" class="form-control form-control-custom border" 
                                                                   value="<?= htmlspecialchars($medio['detalle']) ?>" 
                                                                   placeholder="Descripción del medio" required>
                                                        </td>
                                                        <td>
                                                            <select name="id_plazo[]" class="form-select form-control-custom" required>
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
                                                            <button type="button" class="btn btn-sm btn-outline-danger btn-custom-sm" 
                                                                    onclick="eliminarFila(<?= $contador ?>)" title="Eliminar">
                                                                <i class="fas fa-trash-alt"></i>
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
                                                <input type="text" name="detalle[]" class="form-control form-control-custom border" 
                                                       placeholder="Descripción del medio" required>
                                            </td>
                                            <td>
                                                <select name="id_plazo[]" class="form-select form-control-custom" required>
                                                    <option value="">-- Seleccione --</option>
                                                    <?php foreach ($plazos as $pl): ?>
                                                            <option value="<?= $pl['id_plazo'] ?>"><?= htmlspecialchars($pl['nombre_plazo']) ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm btn-outline-danger btn-custom-sm" 
                                                        onclick="eliminarFila(1)" title="Eliminar">
                                                    <i class="fas fa-trash-alt"></i>
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
                                                    <input type="text" name="detalle[]" class="form-control form-control-custom border" 
                                                           placeholder="Descripción del medio" required>
                                                </td>
                                                <td>
                                                    <select name="id_plazo[]" class="form-select form-control-custom" required>
                                                        <option value="">-- Seleccione --</option>
                                                        <?php foreach ($plazos as $pl): ?>
                                                                <option value="<?= $pl['id_plazo'] ?>"><?= htmlspecialchars($pl['nombre_plazo']) ?></option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-sm btn-outline-danger btn-custom-sm" 
                                                            onclick="eliminarFila(<?= $i ?>)" title="Eliminar">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                    <?php endfor;
                                    $contador = 3;
                            endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-2 text-end">
                    <small class="text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        Total de medios: <span id="total-medios" class="badge bg-primary"><?= ($contador - 1) ?></span>
                    </small>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-custom-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i> Cancelar
        </button>
        <button type="button" class="btn btn-custom-info" onclick="imprimirFormulario()">
            <i class="fas fa-print me-1"></i> Imprimir
        </button>
        <button type="submit" class="btn btn-custom-primary">
            <i class="fas fa-save me-1"></i> Guardar Elaboración
        </button>
    </div>
</form>

<script>
// VARIABLES Y FUNCIONES PARA EL MODAL

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
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="fw-bold text-primary">${ind.codigo}</span>
                    ${isSelected ? '<i class="fas fa-check-circle text-success"></i>' : ''}
                </div>
                <div class="indicador-descripcion small">${ind.descripcion.substring(0, 80)}${ind.descripcion.length > 80 ? '...' : ''}</div>
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

// FUNCIONES PARA MEDIOS DE VERIFICACIÓN

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
            <input type="text" name="detalle[]" class="form-control form-control-custom border" 
                   placeholder="Descripción del medio" required>
        </td>
        <td>
            <select name="id_plazo[]" class="form-select form-control-custom" required>
                ${opcionesPlazos}
            </select>
        </td>
        <td class="text-center">
            <button type="button" class="btn btn-sm btn-outline-danger btn-custom-sm" 
                    onclick="eliminarFila(${contadorFilas})" title="Eliminar">
                <i class="fas fa-trash-alt"></i>
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

// FUNCIÓN PARA IMPRIMIR

function imprimirFormulario() {
    console.log('🖨️ Imprimiendo formulario...');
    
    // Crear una copia del contenido del formulario para imprimir
    const contenidoOriginal = document.querySelector('.formulario-container').innerHTML;
    
    // Crear una nueva ventana para la impresión
    const ventanaImpresion = window.open('', '_blank');
    
    // Escribir el contenido en la nueva ventana
    ventanaImpresion.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>POA 2024 - Imprimir</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    font-size: 12px;
                    margin: 20px;
                }
                h1 {
                    color: #2c3e50;
                    text-align: center;
                }
                .section-title {
                    background-color: #e9ecef;
                    padding: 8px 15px;
                    margin: 15px 0;
                    font-weight: bold;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin: 10px 0;
                }
                table th, table td {
                    border: 1px solid #ddd;
                    padding: 8px;
                }
                table th {
                    background-color: #f1f8ff;
                }
                @media print {
                    body {
                        margin: 0;
                    }
                    .no-print {
                        display: none;
                    }
                }
            </style>
        </head>
        <body>
            <h1>PLAN OPERATIVO ANUAL 2024</h1>
            <p><strong>Formulario:</strong> Elaboración POA 2024</p>
            <p><strong>Fecha:</strong> ${new Date().toLocaleDateString('es-ES')}</p>
            
            ${contenidoOriginal}
            
            <div style="margin-top: 50px; padding-top: 20px; border-top: 1px solid #000;">
                <div style="float: left; width: 45%;">
                    <div style="border-top: 1px solid #000; width: 80%; padding-top: 5px;">
                        Firma del Responsable
                    </div>
                </div>
                <div style="float: right; width: 45%;">
                    <div style="border-top: 1px solid #000; width: 80%; padding-top: 5px;">
                        Firma de Revisión
                    </div>
                </div>
                <div style="clear: both;"></div>
            </div>
            
            <div class="no-print" style="margin-top: 30px; text-align: center;">
                <button onclick="window.print()" style="padding: 10px 20px; background: #007bff; color: white; border: none; cursor: pointer;">
                    Imprimir
                </button>
                <button onclick="window.close()" style="padding: 10px 20px; background: #6c757d; color: white; border: none; cursor: pointer; margin-left: 10px;">
                    Cerrar
                </button>
            </div>
            
            <script>
                // Auto-print después de 1 segundo
                setTimeout(function() {
                    window.print();
                }, 1000);
            <\/script>
        </body>
        </html>
    `);
    
    ventanaImpresion.document.close();
    
    mostrarMensajeModal('Abriendo ventana de impresión...', 'info');
}

// VALIDACIÓN DEL FORMULARIO

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

// INICIALIZACIÓN

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

</body>
</html>