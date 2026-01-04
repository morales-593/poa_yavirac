<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elaboración POA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Incluir jsPDF -->

    <style>
        /* Estilos para el PDF (ocultos normalmente) */
        .pdf-only {
            display: none;
        }

        .modal-content {
            max-height: 90vh;
            overflow-y: auto;
        }
    </style>
</head>

<body>
    <div class="modal-header bg-primary text-white d-flex justify-content-between align-items-center">
        <div>
            <h5 class="modal-title mb-0"><i class="fas fa-clipboard-check me-2"></i>
                Elaboración POA - <?= htmlspecialchars($plan['nombre_elaborado']) ?>
            </h5>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
    </div>

    <form method="POST" action="index.php?action=guardarElaboracion" id="formElaboracion">
        <input type="hidden" name="id_plan" value="<?= $id_plan ?>">
        <?php if (isset($elab['id_elaboracion'])): ?>
            <input type="hidden" name="id_elaboracion" value="<?= $elab['id_elaboracion'] ?>">
        <?php endif ?>

        <div class="modal-body">
            <!-- SECCIÓN 1: TEMA -->
            <div class="mb-4">
                <h6 class="text-primary mb-3"><i class="fas fa-file-alt me-2"></i>TEMA</h6>
                <select name="id_tema" class="form-select" required>
                    <option value="">-- Seleccione un Tema --</option>
                    <?php foreach ($temas as $t): ?>
                        <option value="<?= $t['id_tema'] ?>" <?= (isset($elab['id_tema']) && $elab['id_tema'] == $t['id_tema']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($t['descripcion']) ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>

            <!-- SECCIÓN 2: EJE E INDICADOR -->
            <div class="mb-4">
                <h6 class="text-primary mb-3"><i class="fas fa-bullseye me-2"></i>EJE ESTRATÉGICO E INDICADOR</h6>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">EJE ESTRATÉGICO *</label>
                        <select id="eje_select" class="form-select" required>
                            <option value="">-- Seleccione un Eje --</option>
                            <?php foreach ($ejes as $e): ?>
                                <?php
                                $selected = (isset($eje_actual) && $eje_actual == $e['id_eje']) ? 'selected' : '';
                                ?>
                                <option value="<?= $e['id_eje'] ?>"
                                    data-objetivo="<?= htmlspecialchars($e['descripcion_objetivo'] ?? '', ENT_QUOTES) ?>"
                                    <?= $selected ?>>
                                    <?= htmlspecialchars($e['nombre_eje']) ?>
                                </option>
                            <?php endforeach ?>
                        </select>

                        <div class="mt-3">
                            <label class="form-label">OBJETIVO DEL EJE</label>
                            <textarea id="objetivo_display" class="form-control" rows="3" readonly
                                style="background-color: #f8f9fa;"></textarea>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">INDICADOR *</label>
                        <select name="id_indicador" id="indicador_select" class="form-select" required>
                            <option value="">-- Primero seleccione un eje --</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- SECCIÓN 3: RESPONSABLE -->
            <div class="mb-4">
                <h6 class="text-primary mb-3"><i class="fas fa-user me-2"></i>RESPONSABLE</h6>
                <select name="id_responsable" class="form-select" required>
                    <option value="">-- Seleccione un Responsable --</option>
                    <?php foreach ($responsables as $r): ?>
                        <option value="<?= $r['id_responsable'] ?>" <?= (isset($elab['id_responsable']) && $elab['id_responsable'] == $r['id_responsable']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($r['nombre_responsable']) ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>

            <!-- SECCIÓN 4: INFORMACIÓN BASE -->
            <div class="mb-4">
                <h6 class="text-primary mb-3"><i class="fas fa-database me-2"></i>INFORMACIÓN BASE</h6>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">LÍNEA BASE *</label>
                        <input type="text" name="linea_base" class="form-control"
                            value="<?= $elab['linea_base'] ?? '' ?>" required>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">POLÍTICAS</label>
                        <textarea name="politicas" class="form-control"
                            rows="2"><?= $elab['politicas'] ?? '' ?></textarea>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label">METAS</label>
                        <textarea name="metas" class="form-control" rows="2"><?= $elab['metas'] ?? '' ?></textarea>
                    </div>
                </div>
            </div>

            <!-- SECCIÓN 5: EJECUCIÓN -->
            <div class="mb-4">
                <h6 class="text-primary mb-3"><i class="fas fa-play-circle me-2"></i>EJECUCIÓN</h6>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">ACTIVIDADES *</label>
                        <textarea name="actividades" class="form-control" rows="3"
                            required><?= $elab['actividades'] ?? '' ?></textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">INDICADOR DE RESULTADO</label>
                        <textarea name="indicador_resultado" class="form-control"
                            rows="3"><?= $elab['indicador_resultado'] ?? '' ?></textarea>
                    </div>
                </div>
            </div>

            <!-- SECCIÓN 6: MEDIOS DE VERIFICACIÓN -->
            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="text-primary mb-0"><i class="fas fa-file-check me-2"></i>MEDIOS DE VERIFICACIÓN</h6>
                    <div>
                        <button type="button" class="btn btn-sm btn-primary" onclick="agregarMedio()">
                            <i class="fas fa-plus me-1"></i> Agregar
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center">#</th>
                                <th width="65%">DESCRIPCIÓN DEL MEDIO *</th>
                                <th width="20%">PLAZO *</th>
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
                                                <input type="text" name="detalle[]" class="form-control"
                                                    value="<?= htmlspecialchars($medio['detalle']) ?>" required>
                                            </td>
                                            <td>
                                                <select name="id_plazo[]" class="form-select" required>
                                                    <option value="">-- Seleccione --</option>
                                                    <?php foreach ($plazos as $pl): ?>
                                                        <option value="<?= $pl['id_plazo'] ?>" <?= ($medio['id_plazo'] == $pl['id_plazo']) ? 'selected' : '' ?>>
                                                            <?= htmlspecialchars($pl['nombre_plazo']) ?>
                                                        </option>
                                                    <?php endforeach ?>
                                                </select>
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm btn-danger"
                                                    onclick="eliminarFila(<?= $contador ?>)" title="Eliminar">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <?php
                                        $contador++;
                                    endforeach;
                                else: ?>
                                    <tr id="fila-1">
                                        <td class="text-center">1</td>
                                        <td>
                                            <input type="text" name="detalle[]" class="form-control" required>
                                        </td>
                                        <td>
                                            <select name="id_plazo[]" class="form-select" required>
                                                <option value="">-- Seleccione --</option>
                                                <?php foreach ($plazos as $pl): ?>
                                                    <option value="<?= $pl['id_plazo'] ?>">
                                                        <?= htmlspecialchars($pl['nombre_plazo']) ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-danger" onclick="eliminarFila(1)"
                                                title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <?php
                                    $contador = 2;
                                endif;
                            else: ?>
                                <tr id="fila-1">
                                    <td class="text-center">1</td>
                                    <td>
                                        <input type="text" name="detalle[]" class="form-control" required>
                                    </td>
                                    <td>
                                        <select name="id_plazo[]" class="form-select" required>
                                            <option value="">-- Seleccione --</option>
                                            <?php foreach ($plazos as $pl): ?>
                                                <option value="<?= $pl['id_plazo'] ?>">
                                                    <?= htmlspecialchars($pl['nombre_plazo']) ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-danger" onclick="eliminarFila(1)"
                                            title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr id="fila-2">
                                    <td class="text-center">2</td>
                                    <td>
                                        <input type="text" name="detalle[]" class="form-control" required>
                                    </td>
                                    <td>
                                        <select name="id_plazo[]" class="form-select" required>
                                            <option value="">-- Seleccione --</option>
                                            <?php foreach ($plazos as $pl): ?>
                                                <option value="<?= $pl['id_plazo'] ?>">
                                                    <?= htmlspecialchars($pl['nombre_plazo']) ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-danger" onclick="eliminarFila(2)"
                                            title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php
                                $contador = 3;
                            endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                <i class="fas fa-times me-1"></i> Cancelar
            </button>
            <button type="button" class="btn btn-info" onclick="exportarPDF()">
                <i class="fas fa-file-pdf me-1"></i> Exportar PDF
            </button>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-1"></i> Guardar
            </button>
        </div>
    </form>

    <script>
        // Variables globales
        let contadorFilas = <?= $contador ?? 3 ?>;

        // Inicializar cuando el DOM esté listo
        document.addEventListener('DOMContentLoaded', function () {
            const selectorEje = document.getElementById('eje_select');
            const txtObjetivo = document.getElementById('objetivo_display');

            if (selectorEje) {
                // Mostrar objetivo si ya hay eje seleccionado
                if (selectorEje.value) {
                    const opcion = selectorEje.options[selectorEje.selectedIndex];
                    const objetivo = opcion.getAttribute('data-objetivo');
                    if (objetivo && txtObjetivo) {
                        txtObjetivo.value = objetivo;
                    }

                    // Cargar indicadores si hay eje seleccionado
                    cargarIndicadores(selectorEje.value);
                }

                // Configurar evento change
                selectorEje.addEventListener('change', function () {
                    const opcion = this.options[this.selectedIndex];
                    const objetivo = opcion.getAttribute('data-objetivo');
                    if (txtObjetivo) {
                        txtObjetivo.value = objetivo || "No hay objetivo registrado para este eje.";
                    }

                    cargarIndicadores(this.value);
                });
            }
        });

        // Función para cargar indicadores
        function cargarIndicadores(id_eje) {
            if (!id_eje) return;

            const selectIndicador = document.getElementById('indicador_select');
            if (!selectIndicador) return;

            selectIndicador.innerHTML = '<option value="">Cargando indicadores...</option>';
            selectIndicador.disabled = true;

            fetch('index.php?action=indicadoresPorEje&id_eje=' + id_eje)
                .then(response => response.json())
                .then(data => {
                    let opciones = '<option value="">-- Seleccione un Indicador --</option>';

                    if (data && Array.isArray(data) && data.length > 0) {
                        data.forEach(ind => {
                            opciones += `<option value="${ind.id_indicador}">${ind.codigo} - ${ind.descripcion}</option>`;
                        });
                    } else {
                        opciones = '<option value="">No hay indicadores para este eje</option>';
                    }

                    selectIndicador.innerHTML = opciones;
                    selectIndicador.disabled = false;
                })
                .catch(error => {
                    console.error('Error:', error);
                    selectIndicador.innerHTML = '<option value="">Error al cargar</option>';
                    selectIndicador.disabled = false;
                });
        }

        // Funciones para medios de verificación
        function agregarMedio() {
            const tbody = document.getElementById('medios-container');
            if (!tbody) return;

            const nuevaFila = document.createElement('tr');
            nuevaFila.id = 'fila-' + contadorFilas;

            let opcionesPlazos = '<option value="">-- Seleccione --</option>';
            const primerSelect = tbody.querySelector('select[name="id_plazo[]"]');
            if (primerSelect) {
                opcionesPlazos = primerSelect.innerHTML.replace('selected', '');
            }

            nuevaFila.innerHTML = `
        <td class="text-center">${contadorFilas}</td>
        <td>
            <input type="text" name="detalle[]" class="form-control" required>
        </td>
        <td>
            <select name="id_plazo[]" class="form-select" required>
                ${opcionesPlazos}
            </select>
        </td>
        <td class="text-center">
            <button type="button" class="btn btn-sm btn-danger" 
                    onclick="eliminarFila(${contadorFilas})" title="Eliminar">
                <i class="fas fa-trash"></i>
            </button>
        </td>
    `;

            tbody.appendChild(nuevaFila);
            contadorFilas++;
        }

        function eliminarFila(numeroFila) {
            const fila = document.getElementById('fila-' + numeroFila);
            if (!fila) return;

            if (confirm('¿Eliminar este medio de verificación?')) {
                fila.remove();
                renumerarFilas();
            }
        }

        function renumerarFilas() {
            const filas = document.querySelectorAll('#medios-container tr');
            let nuevoContador = 1;

            filas.forEach((fila) => {
                const tdNumero = fila.querySelector('td:first-child');
                if (tdNumero) {
                    tdNumero.textContent = nuevoContador;
                }

                fila.id = 'fila-' + nuevoContador;
                const btnEliminar = fila.querySelector('button');
                if (btnEliminar) {
                    btnEliminar.setAttribute('onclick', `eliminarFila(${nuevoContador})`);
                }

                nuevoContador++;
            });

            contadorFilas = nuevoContador;
        }

        // Función principal para exportar PDF
        function exportarPDF() {
            // Validar formulario primero
            if (!validarFormularioParaPDF()) {
                alert('Por favor complete todos los campos requeridos (*) antes de exportar el PDF.');
                return;
            }

            // Obtener datos del formulario
            const datos = obtenerDatosFormulario();

            // Crear PDF con el diseño de tablas
            crearPDFConTablas(datos);
        }

        // Función para validar el formulario para PDF
        function validarFormularioParaPDF() {
            // Campos requeridos
            const camposRequeridos = [
                { id: 'eje_select', nombre: 'Eje Estratégico' },
                { name: 'id_tema', nombre: 'Tema' },
                { id: 'indicador_select', nombre: 'Indicador' },
                { name: 'id_responsable', nombre: 'Responsable' },
                { name: 'linea_base', nombre: 'Línea Base' },
                { name: 'actividades', nombre: 'Actividades' }
            ];

            for (let campo of camposRequeridos) {
                let elemento;
                if (campo.id) {
                    elemento = document.getElementById(campo.id);
                } else if (campo.name) {
                    elemento = document.querySelector(`[name="${campo.name}"]`);
                }

                if (elemento && (!elemento.value || elemento.value.includes('-- Seleccione'))) {
                    elemento.classList.add('is-invalid');
                    return false;
                } else if (elemento) {
                    elemento.classList.remove('is-invalid');
                }
            }

            // Validar medios de verificación
            const medios = document.querySelectorAll('#medios-container tr');
            if (medios.length === 0) {
                alert('Debe agregar al menos un medio de verificación.');
                return false;
            }

            return true;
        }

        // Función para obtener datos del formulario
        function obtenerDatosFormulario() {
            // Obtener el objetivo del eje
            const selectorEje = document.getElementById('eje_select');
            const opcionEje = selectorEje.options[selectorEje.selectedIndex];
            const objetivoEje = opcionEje ? opcionEje.getAttribute('data-objetivo') : '';

            // Obtener datos de medios de verificación
            const medios = [];
            document.querySelectorAll('#medios-container tr').forEach((fila, index) => {
                const detalle = fila.querySelector('input[name="detalle[]"]').value;
                const plazoSelect = fila.querySelector('select[name="id_plazo[]"]');
                const plazo = plazoSelect ? plazoSelect.options[plazoSelect.selectedIndex].textContent : '';

                if (detalle && plazo) {
                    medios.push({ detalle, plazo });
                }
            });

            return {
                // Información general
                tema: document.querySelector('select[name="id_tema"] option:selected').textContent,
                eje: document.querySelector('#eje_select option:selected').textContent,
                objetivo: objetivoEje,
                indicador: document.querySelector('#indicador_select option:selected').textContent,
                responsable: document.querySelector('select[name="id_responsable"] option:selected').textContent,

                // Información base
                linea_base: document.querySelector('input[name="linea_base"]').value,
                politicas: document.querySelector('textarea[name="politicas"]').value,
                metas: document.querySelector('textarea[name="metas"]').value,

                // Ejecución
                actividades: document.querySelector('textarea[name="actividades"]').value,
                indicador_resultado: document.querySelector('textarea[name="indicador_resultado"]').value,

                // Medios de verificación
                medios: medios,

                // Información adicional
                elaborado_por: "<?= htmlspecialchars($plan['nombre_elaborado']) ?>",
                fecha: new Date().toLocaleDateString('es-ES')
            };
        }

        // ==============================================
        // NUEVA FUNCIÓN: Crear PDF con diseño de tablas
        // ==============================================
        function crearPDFConTablas(datos) {
            try {
                // Verificar si jsPDF está disponible
                if (typeof window.jspdf === 'undefined') {
                    alert('Error: La librería jsPDF no está cargada. Por favor recargue la página.');
                    return;
                }

                const { jsPDF } = window.jspdf;
                const doc = new jsPDF('p', 'mm', 'a4');

                // Configurar fuente
                doc.setFont('helvetica');

                // ==============================
                // ENCABEZADO DEL DOCUMENTO
                // ==============================
                let yPos = 10;

                // Título principal
                doc.setFontSize(16);
                doc.setTextColor(0, 0, 128);
                doc.setFont('helvetica', 'bold');
                doc.text('INSTITUTO SUPERIOR TECNOLÓGICO TURÍSTICO Y PATRIMONIAL "YAVIRAC"', 105, yPos, { align: 'center' });
                yPos += 8;

                doc.setFontSize(14);
                doc.text('PLAN OPERATIVO ANUAL - 2024', 105, yPos, { align: 'center' });
                yPos += 6;

                doc.setFontSize(11);
                doc.setTextColor(0, 0, 0);
                doc.text('Formulario de Elaboración', 105, yPos, { align: 'center' });
                yPos += 12;

                // Línea separadora
                doc.setDrawColor(0, 0, 128);
                doc.setLineWidth(0.5);
                doc.line(20, yPos, 190, yPos);
                yPos += 15;

                // ==============================
                // TABLA PRINCIPAL
                // ==============================
                doc.setFontSize(12);
                doc.setTextColor(0, 0, 128);
                doc.setFont('helvetica', 'bold');
                doc.text('INFORMACIÓN GENERAL', 20, yPos);
                yPos += 8;

                // Configurar dimensiones de tabla
                const anchoPagina = 170;
                const anchoCol1 = 35;
                const anchoCol2 = anchoPagina - anchoCol1;

                // Función auxiliar para crear filas de tabla
                function crearFilaTabla(etiqueta, valor, esMultilinea = false) {
                    // Fondo gris para etiqueta
                    doc.setFillColor(240, 240, 240);
                    doc.rect(20, yPos, anchoCol1, 8, 'F');

                    // Bordes
                    doc.setDrawColor(0, 0, 0);
                    doc.setLineWidth(0.1);
                    doc.rect(20, yPos, anchoCol1, 8);
                    doc.rect(20 + anchoCol1, yPos, anchoCol2, 8);

                    // Etiqueta
                    doc.setFontSize(10);
                    doc.setTextColor(0, 0, 0);
                    doc.setFont('helvetica', 'bold');

                    const etiquetaLineas = doc.splitTextToSize(etiqueta, anchoCol1 - 5);
                    let alturaEtiqueta = 8;
                    if (etiquetaLineas.length > 1) {
                        alturaEtiqueta = etiquetaLineas.length * 4 + 4;
                        // Redibujar rectángulo con nueva altura
                        doc.rect(20, yPos, anchoCol1, alturaEtiqueta, 'F');
                        doc.rect(20, yPos, anchoCol1, alturaEtiqueta);
                        doc.rect(20 + anchoCol1, yPos, anchoCol2, alturaEtiqueta);
                    }

                    etiquetaLineas.forEach((linea, idx) => {
                        doc.text(linea, 22, yPos + 5 + (idx * 4));
                    });

                    // Valor
                    doc.setFont('helvetica', 'normal');
                    let valorText = valor || 'No especificado';
                    if (valorText === 'No especificado') {
                        doc.setTextColor(120, 120, 120);
                    }

                    const valorLineas = doc.splitTextToSize(valorText, anchoCol2 - 5);
                    let alturaValor = 8;
                    if (valorLineas.length > 1 || esMultilinea) {
                        alturaValor = valorLineas.length * 4 + 4;
                        // Ajustar altura si es mayor que la de la etiqueta
                        if (alturaValor > alturaEtiqueta) {
                            alturaEtiqueta = alturaValor;
                            doc.rect(20, yPos, anchoCol1, alturaEtiqueta, 'F');
                            doc.rect(20, yPos, anchoCol1, alturaEtiqueta);
                            doc.rect(20 + anchoCol1, yPos, anchoCol2, alturaEtiqueta);
                        }
                    }

                    valorLineas.forEach((linea, idx) => {
                        doc.text(linea, 20 + anchoCol1 + 2, yPos + 5 + (idx * 4));
                    });

                    doc.setTextColor(0, 0, 0);

                    // Avanzar posición Y
                    yPos += Math.max(alturaEtiqueta, alturaValor);

                    // Verificar si necesitamos nueva página
                    if (yPos > 270) {
                        doc.addPage();
                        yPos = 20;
                    }
                }

                // ==============================
                // INFORMACIÓN GENERAL
                // ==============================
                crearFilaTabla('TEMA', datos.tema);
                crearFilaTabla('EJE ESTRATÉGICO', datos.eje);
                crearFilaTabla('OBJETIVO', datos.objetivo, true);
                crearFilaTabla('INDICADOR', datos.indicador);
                crearFilaTabla('RESPONSABLE', datos.responsable);

                yPos += 8;

                // ==============================
                // TABLA INFORMACIÓN BASE
                // ==============================
                doc.setFontSize(12);
                doc.setTextColor(0, 0, 128);
                doc.setFont('helvetica', 'bold');
                doc.text('INFORMACIÓN BASE', 20, yPos);
                yPos += 8;

                crearFilaTabla('LÍNEA BASE', datos.linea_base);
                crearFilaTabla('POLÍTICAS', datos.politicas, true);
                crearFilaTabla('METAS', datos.metas, true);

                yPos += 8;

                // ==============================
                // TABLA EJECUCIÓN
                // ==============================
                doc.setFontSize(12);
                doc.setTextColor(0, 0, 128);
                doc.setFont('helvetica', 'bold');
                doc.text('EJECUCIÓN', 20, yPos);
                yPos += 8;

                crearFilaTabla('ACTIVIDADES', datos.actividades, true);
                crearFilaTabla('INDICADOR DE RESULTADO', datos.indicador_resultado, true);

                yPos += 8;

                // ==============================
                // TABLA MEDIOS DE VERIFICACIÓN
                // ==============================
                doc.setFontSize(12);
                doc.setTextColor(0, 0, 128);
                doc.setFont('helvetica', 'bold');
                doc.text('MEDIOS DE VERIFICACIÓN', 20, yPos);
                yPos += 8;

                if (datos.medios.length > 0) {
                    // Cabecera de la tabla de medios
                    const anchoNum = 10;
                    const anchoDetalle = 120;
                    const anchoPlazo = 40;

                    // Fondo cabecera
                    doc.setFillColor(220, 220, 220);
                    doc.rect(20, yPos, anchoNum, 7, 'F');
                    doc.rect(20 + anchoNum, yPos, anchoDetalle, 7, 'F');
                    doc.rect(20 + anchoNum + anchoDetalle, yPos, anchoPlazo, 7, 'F');

                    // Texto cabecera
                    doc.setFontSize(10);
                    doc.setTextColor(0, 0, 0);
                    doc.setFont('helvetica', 'bold');
                    doc.text('#', 22, yPos + 5);
                    doc.text('DETALLE', 20 + anchoNum + 2, yPos + 5);
                    doc.text('PLAZO', 20 + anchoNum + anchoDetalle + 2, yPos + 5);

                    // Bordes cabecera
                    doc.setDrawColor(0, 0, 0);
                    doc.rect(20, yPos, anchoNum, 7);
                    doc.rect(20 + anchoNum, yPos, anchoDetalle, 7);
                    doc.rect(20 + anchoNum + anchoDetalle, yPos, anchoPlazo, 7);

                    yPos += 7;

                    // Filas de medios
                    datos.medios.forEach((medio, index) => {
                        // Verificar si necesitamos nueva página
                        if (yPos > 270) {
                            doc.addPage();
                            yPos = 20;
                            // Redibujar cabecera en nueva página
                            doc.setFillColor(220, 220, 220);
                            doc.rect(20, yPos, anchoNum, 7, 'F');
                            doc.rect(20 + anchoNum, yPos, anchoDetalle, 7, 'F');
                            doc.rect(20 + anchoNum + anchoDetalle, yPos, anchoPlazo, 7, 'F');

                            doc.setFontSize(10);
                            doc.setFont('helvetica', 'bold');
                            doc.text('#', 22, yPos + 5);
                            doc.text('DETALLE', 20 + anchoNum + 2, yPos + 5);
                            doc.text('PLAZO', 20 + anchoNum + anchoDetalle + 2, yPos + 5);

                            doc.setDrawColor(0, 0, 0);
                            doc.rect(20, yPos, anchoNum, 7);
                            doc.rect(20 + anchoNum, yPos, anchoDetalle, 7);
                            doc.rect(20 + anchoNum + anchoDetalle, yPos, anchoPlazo, 7);

                            yPos += 7;
                        }

                        // Calcular altura necesaria para esta fila
                        doc.setFont('helvetica', 'normal');
                        const detalleLineas = doc.splitTextToSize(medio.detalle, anchoDetalle - 4);
                        const alturaFila = Math.max(8, detalleLineas.length * 4 + 3);

                        // Fondo alternado para mejor legibilidad
                        if (index % 2 === 0) {
                            doc.setFillColor(250, 250, 250);
                        } else {
                            doc.setFillColor(245, 245, 245);
                        }

                        doc.rect(20, yPos, anchoNum, alturaFila, 'F');
                        doc.rect(20 + anchoNum, yPos, anchoDetalle, alturaFila, 'F');
                        doc.rect(20 + anchoNum + anchoDetalle, yPos, anchoPlazo, alturaFila, 'F');

                        // Número
                        doc.text((index + 1).toString(), 22, yPos + 5);

                        // Detalle
                        detalleLineas.forEach((linea, idx) => {
                            doc.text(linea, 20 + anchoNum + 2, yPos + 5 + (idx * 4));
                        });

                        // Plazo
                        doc.text(medio.plazo, 20 + anchoNum + anchoDetalle + 2, yPos + 5);

                        // Bordes de la fila
                        doc.setDrawColor(0, 0, 0);
                        doc.rect(20, yPos, anchoNum, alturaFila);
                        doc.rect(20 + anchoNum, yPos, anchoDetalle, alturaFila);
                        doc.rect(20 + anchoNum + anchoDetalle, yPos, anchoPlazo, alturaFila);

                        yPos += alturaFila;
                    });
                } else {
                    doc.setFontSize(10);
                    doc.setFont('helvetica', 'normal');
                    doc.setTextColor(120, 120, 120);
                    doc.text('No se han definido medios de verificación', 22, yPos + 5);
                    yPos += 8;
                }

                yPos += 10;

                // ==============================
                // TABLA DE FIRMAS
                // ==============================
                // Verificar si necesitamos nueva página para las firmas
                if (yPos > 200) {
                    doc.addPage();
                    yPos = 20;
                }

                doc.setFontSize(12);
                doc.setTextColor(0, 0, 128);
                doc.setFont('helvetica', 'bold');
                doc.text('FIRMAS DE RESPONSABILIDAD', 20, yPos);
                yPos += 10;

                // Dimensiones para firmas
                const anchoFirma = 75;

                // Elaborado
                doc.setFontSize(11);
                doc.setFont('helvetica', 'bold');
                doc.text('ELABORADO POR:', 20, yPos);

                doc.setFontSize(10);
                doc.setFont('helvetica', 'normal');
                doc.text(datos.elaborado_por, 20, yPos + 6);

                // Línea de firma
                doc.setDrawColor(0, 0, 0);
                doc.setLineWidth(0.3);
                doc.line(20, yPos + 10, 20 + anchoFirma, yPos + 10);

                doc.setFontSize(9);
                doc.setTextColor(100, 100, 100);
                doc.text('COORDINACIÓN DE PLANIFICACIÓN ESTRATÉGICA', 20, yPos + 16);

                // Revisado
                doc.setFontSize(11);
                doc.setTextColor(0, 0, 128);
                doc.setFont('helvetica', 'bold');
                doc.text('REVISADO POR:', 20 + anchoFirma + 20, yPos);

                doc.setFontSize(10);
                doc.setTextColor(0, 0, 0);
                doc.setFont('helvetica', 'normal');
                doc.text('_________________________', 20 + anchoFirma + 20, yPos + 6);

                // Línea de firma
                doc.line(20 + anchoFirma + 20, yPos + 10, 20 + anchoFirma + 20 + anchoFirma, yPos + 10);

                doc.setFontSize(9);
                doc.setTextColor(100, 100, 100);
                doc.text('UNIDAD RESPONSABLE', 20 + anchoFirma + 20, yPos + 16);

                yPos += 25;

                // ==============================
                // PIE DE PÁGINA
                // ==============================
                doc.setFontSize(8);
                doc.setTextColor(100, 100, 100);
                doc.text(`Documento generado el: ${datos.fecha}`, 105, 290, { align: 'center' });
                doc.text('ISTTP "YAVIRAC" - Sistema de Planificación', 105, 295, { align: 'center' });

                // ==============================
                // GUARDAR PDF
                // ==============================
                const nombreArchivo = `POA_${datos.elaborado_por.replace(/[^a-z0-9]/gi, '_')}_${new Date().getFullYear()}.pdf`;
                doc.save(nombreArchivo);

                // Mostrar mensaje de éxito
                alert('PDF generado exitosamente con diseño de tablas. Se ha descargado el documento.');

            } catch (error) {
                console.error('Error al generar PDF:', error);
                alert('Error al generar el PDF: ' + error.message);
            }
        }

        // Validación del formulario al enviar
        document.getElementById('formElaboracion').addEventListener('submit', function (e) {
            // Validación básica
            const camposRequeridos = [
                { name: 'id_tema', nombre: 'Tema' },
                { id: 'eje_select', nombre: 'Eje' },
                { id: 'indicador_select', nombre: 'Indicador' },
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

                if (elemento && (!elemento.value || elemento.value.includes('-- Seleccione'))) {
                    elemento.classList.add('is-invalid');
                    errores.push(campo.nombre);
                } else if (elemento) {
                    elemento.classList.remove('is-invalid');
                }
            });

            // Validar medios de verificación
            const medios = document.querySelectorAll('input[name="detalle[]"]');
            let mediosValidos = true;

            medios.forEach((input, index) => {
                if (!input.value.trim()) {
                    input.classList.add('is-invalid');
                    errores.push(`Medio de verificación ${index + 1}`);
                    mediosValidos = false;
                } else {
                    input.classList.remove('is-invalid');
                }
            });

            if (errores.length > 0) {
                e.preventDefault();
                alert('Por favor complete los siguientes campos: ' + errores.join(', '));
                return false;
            }

            // Mostrar mensaje de guardando
            const btnSubmit = this.querySelector('button[type="submit"]');
            btnSubmit.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Guardando...';
            btnSubmit.disabled = true;
        });
    </script>

</body>

</html>