// Funcionalidades generales del sistema
document.addEventListener('DOMContentLoaded', function() {
    initializeMenu();
    initializeModals();
    initializeAlerts();
});

// Inicializar menú
function initializeMenu() {
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('sidebar');
    const closeSidebar = document.getElementById('closeSidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    
    if(menuToggle && sidebar) {
        menuToggle.addEventListener('click', function() {
            sidebar.classList.add('active');
            if(sidebarOverlay) sidebarOverlay.classList.add('active');
        });
    }
    
    if(closeSidebar && sidebar) {
        closeSidebar.addEventListener('click', function() {
            sidebar.classList.remove('active');
            if(sidebarOverlay) sidebarOverlay.classList.remove('active');
        });
    }
    
    if(sidebarOverlay && sidebar) {
        sidebarOverlay.addEventListener('click', function() {
            sidebar.classList.remove('active');
            sidebarOverlay.classList.remove('active');
        });
    }
}

// Inicializar modales
function initializeModals() {
    // Open modal buttons
    document.querySelectorAll('[data-modal]').forEach(button => {
        button.addEventListener('click', function() {
            const modalId = this.getAttribute('data-modal');
            const modal = document.getElementById(modalId);
            if(modal) openModal(modal);
        });
    });
    
    // Close modal buttons
    document.querySelectorAll('.modal-close').forEach(button => {
        button.addEventListener('click', function() {
            const modal = this.closest('.modal');
            closeModal(modal);
        });
    });
    
    // Close modal when clicking outside
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal(this);
            }
        });
    });
}

// Inicializar alertas del sistema
function initializeAlerts() {
    // Mostrar alertas de PHP si existen
    const alertContainer = document.getElementById('alertContainer');
    if(alertContainer) {
        const existingAlerts = document.querySelectorAll('.alert');
        existingAlerts.forEach(alert => {
            setTimeout(() => {
                if (alert.parentNode) {
                    alert.remove();
                }
            }, 5000);
        });
    }
}

// Funciones de modal
function openModal(modal) {
    if(modal) {
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
}

function closeModal(modal) {
    if(modal) {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
}

// Funciones de alerta
function showAlert(type, message) {
    const alertContainer = document.getElementById('alertContainer');
    if(!alertContainer) return;
    
    // Remove existing alerts
    const existingAlerts = document.querySelectorAll('.alert');
    existingAlerts.forEach(alert => alert.remove());
    
    const alert = document.createElement('div');
    alert.className = `alert alert-${type}`;
    
    let icon = '';
    switch(type) {
        case 'success': icon = 'fa-check-circle'; break;
        case 'danger': icon = 'fa-exclamation-circle'; break;
        case 'warning': icon = 'fa-exclamation-triangle'; break;
        case 'info': icon = 'fa-info-circle'; break;
        default: icon = 'fa-info-circle';
    }
    
    alert.innerHTML = `
        <i class="fas ${icon}"></i>
        <span>${message}</span>
    `;
    
    alertContainer.appendChild(alert);
    
    // Remove alert after 5 seconds
    setTimeout(() => {
        if (alert.parentNode) {
            alert.remove();
        }
    }, 5000);
}

// Funciones específicas para Plan Operativo
function togglePlanEstado(planId, tipo) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.style.display = 'none';
    
    const actionInput = document.createElement('input');
    actionInput.type = 'hidden';
    actionInput.name = 'action';
    actionInput.value = 'toggle_estado';
    
    const planInput = document.createElement('input');
    planInput.type = 'hidden';
    planInput.name = 'plan_id';
    planInput.value = planId;
    
    const tipoInput = document.createElement('input');
    tipoInput.type = 'hidden';
    tipoInput.name = 'tipo';
    tipoInput.value = tipo;
    
    form.appendChild(actionInput);
    form.appendChild(planInput);
    form.appendChild(tipoInput);
    
    document.body.appendChild(form);
    form.submit();
}

function editPlanSection(planId, tipo) {
    // En un sistema real, aquí harías una petición AJAX
    // Por ahora, mostramos un mensaje
    showAlert('info', `Editando ${tipo} del plan ${planId}`);
    
    // Simulamos la carga de datos
    setTimeout(() => {
        document.getElementById('editPlanId').value = planId;
        document.getElementById('planSelect').value = tipo;
        
        let formContent = '';
        switch(tipo) {
            case 'elaboracion':
                formContent = `
                    <div class="form-group">
                        <label class="form-label">Información de Elaboración</label>
                        <textarea name="elaboracion_contenido" class="form-control" rows="6" placeholder="Ingrese la información de elaboración">Contenido de elaboración del plan ${planId}</textarea>
                    </div>
                    <input type="hidden" name="elaboracion_estado" value="1">
                `;
                break;
            case 'seguimiento':
                formContent = `
                    <div class="form-group">
                        <label class="form-label">Información de Seguimiento</label>
                        <textarea name="seguimiento_contenido" class="form-control" rows="6" placeholder="Ingrese la información de seguimiento">Contenido de seguimiento del plan ${planId}</textarea>
                    </div>
                    <input type="hidden" name="seguimiento_estado" value="1">
                `;
                break;
            case 'ejecucion':
                formContent = `
                    <div class="form-group">
                        <label class="form-label">Información de Ejecución</label>
                        <textarea name="ejecucion_contenido" class="form-control" rows="6" placeholder="Ingrese la información de ejecución">Contenido de ejecución del plan ${planId}</textarea>
                    </div>
                    <input type="hidden" name="ejecucion_estado" value="1">
                `;
                break;
        }
        
        document.getElementById('planFormContainer').innerHTML = formContent;
        openModal(document.getElementById('editPlanModal'));
    }, 500);
}

function downloadPDF(planId) {
    showAlert('info', `Generando PDF para el plan ${planId}`);
    // Simular generación de PDF
    setTimeout(() => {
        showAlert('success', 'PDF generado exitosamente');
    }, 2000);
}

function viewPlan(planId) {
    showAlert('info', `Vista previa del plan ${planId}`);
    // Aquí iría la lógica para mostrar el plan completo
}

// Funciones para coordinación
function openAddUserModal() {
    openModal(document.getElementById('addUserModal'));
}

// Funciones generales para formularios
function confirmAction(message) {
    return confirm(message || '¿Está seguro de realizar esta acción?');
}

// Manejo del responsive
window.addEventListener('resize', function() {
    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    
    if (window.innerWidth > 992 && sidebar) {
        sidebar.classList.remove('active');
        if(sidebarOverlay) sidebarOverlay.classList.remove('active');
    }
});