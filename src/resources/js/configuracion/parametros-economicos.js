/**
 * Script simplificado para la gestión de parámetros económicos
 * Sin imports para evitar problemas de carga
 */

// Variable global para almacenar el ID del parámetro a eliminar
let deleteId = null;

/**
 * Inicializa los eventos y funcionalidades de la página
 */
function init() {
	console.log('Inicializando parámetros económicos...');
	
	// Configurar navegación por pestañas
	setupTabs();

	// Configurar búsqueda para todas las tablas
	setupSearch();
	
	// Configurar eventos para modales (simplificado)
	setupModalEvents();
}

/**
 * Configura la navegación por pestañas
 */
function setupTabs() {
	console.log('setupTabs: Iniciando configuración...');
	
	const tabButtons = document.querySelectorAll('.tab-button');
	const tabContents = document.querySelectorAll('.tab-content');

	console.log('setupTabs: Encontrados', tabButtons.length, 'botones y', tabContents.length, 'contenidos');

	if (tabButtons.length === 0 || tabContents.length === 0) {
		console.log('setupTabs: No hay pestañas que configurar');
		return;
	}

	tabButtons.forEach((button, index) => {
		console.log('setupTabs: Configurando botón', index, 'con data-tab:', button.getAttribute('data-tab'));
		
		button.addEventListener('click', (e) => {
			e.preventDefault(); // Evitar navegación por defecto
			
			const tabId = button.getAttribute('data-tab');
			console.log('Tab clicked:', tabId);
			
			// Remover clase active de todos los botones y contenidos
			tabButtons.forEach(btn => {
				btn.classList.remove('active');
				console.log('Removiendo active de botón:', btn.getAttribute('data-tab'));
			});
			
			tabContents.forEach(content => {
				content.classList.remove('active');
				console.log('Removiendo active de contenido:', content.id);
			});
			
			// Agregar clase active al botón clickeado
			button.classList.add('active');
			console.log('Agregando active al botón:', tabId);
			
			// Mostrar el contenido correspondiente
			const tabContent = document.getElementById('tab-' + tabId);
			if (tabContent) {
				tabContent.classList.add('active');
				console.log('Tab content activated:', tabContent.id);
			} else {
				console.error('Tab content not found:', 'tab-' + tabId);
			}
		});
	});
	
	console.log('setupTabs: Configuración completada');
}

/**
 * Configura la funcionalidad de búsqueda básica
 */
function setupSearch() {
	console.log('setupSearch: Configurando búsqueda...');
	
	// Configurar búsqueda para cada input de búsqueda
	const searchConfigs = [
		{ inputId: 'searchSistemaInput', tableId: 'parametrosSistemaTable' },
		{ inputId: 'searchEconomicosInput', tableId: 'parametrosEconomicosTable' },
		{ inputId: 'searchItemsInput', tableId: 'itemsCobroTable' }
	];
	
	searchConfigs.forEach(function(config) {
		const input = document.getElementById(config.inputId);
		const table = document.getElementById(config.tableId);
		
		if (input && table) {
			console.log('setupSearch: Configurando búsqueda para', config.inputId, '->', config.tableId);
			
			input.addEventListener('keyup', function() {
				const filter = input.value.toUpperCase();
				const rows = table.getElementsByTagName('tr');
				
				// Comenzar desde 1 para omitir el encabezado
				for (let i = 1; i < rows.length; i++) {
					let found = false;
					const cells = rows[i].getElementsByTagName('td');
					
					for (let j = 0; j < cells.length; j++) {
						const cell = cells[j];
						if (cell && cell.textContent.toUpperCase().indexOf(filter) > -1) {
							found = true;
							break;
						}
					}
					
					rows[i].style.display = found ? '' : 'none';
				}
			});
		} else {
			console.log('setupSearch: No se encontró', config.inputId, 'o', config.tableId);
		}
	});
}

/**
 * Configura los eventos para los modales
 */
function setupModalEvents() {
	// Botón para crear nuevo parámetro
	const createButton = document.getElementById('createButton');
	if (createButton) {
		createButton.addEventListener('click', openCreateModal);
	}
	
	// Botones para cerrar modales
	const closeButtons = document.querySelectorAll('[data-close-modal]');
	closeButtons.forEach(button => {
		button.addEventListener('click', () => {
			const modalId = button.getAttribute('data-close-modal');
			closeModal(modalId);
		});
	});
}

/**
 * Abre el modal para crear un nuevo parámetro
 * @param {string} tipo - Tipo de parámetro: 'sistema', 'economico', 'item'
 */
export function openCreateModal(tipo = 'economico') {
	let titulo = 'Crear Parámetro Económico';
	
	switch(tipo) {
		case 'sistema':
			titulo = 'Crear Parámetro del Sistema';
			break;
		case 'item':
			titulo = 'Crear Item de Cobro';
			break;
	}
	
	document.getElementById('modal-title').textContent = titulo;
	document.getElementById('paramForm').reset();
	document.getElementById('param_id').value = '';
	document.getElementById('param_tipo').value = tipo;
	openModal('paramModal');
}

/**
 * Abre el modal para editar un parámetro existente
 * @param {number} id - ID del parámetro a editar
 */
export function openEditModal(id) {
	document.getElementById('modal-title').textContent = 'Editar Parámetro Económico';
	document.getElementById('paramForm').reset();
	document.getElementById('param_id').value = id;
	
	// Obtener datos del parámetro
	fetch(`/configuracion/parametros-economicos/${id}/show`)
		.then(response => response.json())
		.then(data => {
			if (data.success) {
				const parametro = data.data;
				document.getElementById('nombre').value = parametro.nombre;
				document.getElementById('valor').value = parametro.valor;
				document.getElementById('descripcion').value = parametro.descripcion;
				document.getElementById('estado').value = parametro.estado ? '1' : '0';
				openModal('paramModal');
			} else {
				showAlert('Error al cargar los datos del parámetro económico', 'danger');
			}
		})
		.catch(error => {
			console.error('Error:', error);
			showAlert('Error al cargar los datos del parámetro económico', 'danger');
		});
}

/**
 * Cierra el modal de parámetros
 */
export function closeParamModal() {
	closeModal('paramModal');
}

/**
 * Abre el modal de confirmación para eliminar un parámetro
 * @param {number} id - ID del parámetro a eliminar
 */
export function confirmDelete(id) {
	deleteId = id;
	openModal('deleteModal');
}

/**
 * Cierra el modal de confirmación para eliminar
 */
export function closeDeleteModal() {
	closeModal('deleteModal');
	deleteId = null;
}

/**
 * Cambia el estado de un parámetro (activo/inactivo)
 * @param {number} id - ID del parámetro
 */
export function toggleStatus(id) {
	try {
		const token = getCsrfToken();
		
		fetch(`/configuracion/parametros-economicos/${id}/toggle-status`, {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json',
				'X-CSRF-TOKEN': token
			}
		})
		.then(response => {
			if (!response.ok) {
				throw new Error(`HTTP error! status: ${response.status}`);
			}
			return response.json();
		})
		.then(data => {
			if (data.success) {
				window.location.reload();
			} else {
				showAlert('Error al cambiar el estado del parámetro económico: ' + (data.message || 'Error desconocido'), 'danger');
			}
		})
		.catch(error => {
			console.error('Error:', error);
			showAlert('Error al cambiar el estado del parámetro económico: ' + error.message, 'danger');
		});
	} catch (error) {
		showAlert(error.message, 'danger');
	}
}

/**
 * Configura el formulario de parámetros
 */
function setupForm() {
	const form = document.getElementById('paramForm');
	if (form) {
		form.addEventListener('submit', function(e) {
			e.preventDefault();
			
			try {
				const token = getCsrfToken();
				
				const id = document.getElementById('param_id').value;
				const formData = {
					nombre: document.getElementById('nombre').value,
					valor: document.getElementById('valor').value,
					descripcion: document.getElementById('descripcion').value,
					estado: document.getElementById('estado').value === '1'
				};
				
				const url = id ? `/configuracion/parametros-economicos/${id}` : '/configuracion/parametros-economicos';
				const method = id ? 'PUT' : 'POST';
				
				fetch(url, {
					method: method,
					headers: {
						'Content-Type': 'application/json',
						'X-CSRF-TOKEN': token
					},
					body: JSON.stringify(formData)
				})
				.then(response => {
					if (!response.ok) {
						throw new Error(`HTTP error! status: ${response.status}`);
					}
					return response.json();
				})
				.then(data => {
					if (data.success) {
						window.location.reload();
					} else if (data.errors) {
						const errorMessages = Object.values(data.errors).flat().join('\n');
						showAlert(`Error: ${errorMessages}`, 'danger');
					} else {
						showAlert(`Error: ${data.message || 'Error desconocido'}`, 'danger');
					}
				})
				.catch(error => {
					console.error('Error:', error);
					showAlert('Error al guardar el parámetro económico: ' + error.message, 'danger');
				});
			} catch (error) {
				showAlert(error.message, 'danger');
			}
		});
	}
}

/**
 * Configura el botón de eliminar parámetro
 */
function setupDeleteButton() {
	const deleteButton = document.getElementById('confirmDeleteBtn');
	if (deleteButton) {
		deleteButton.addEventListener('click', function() {
			if (deleteId) {
				try {
					const token = getCsrfToken();
					
					fetch(`/configuracion/parametros-economicos/${deleteId}`, {
						method: 'DELETE',
						headers: {
							'Content-Type': 'application/json',
							'X-CSRF-TOKEN': token
						}
					})
					.then(response => {
						if (!response.ok) {
							throw new Error(`HTTP error! status: ${response.status}`);
						}
						return response.json();
					})
					.then(data => {
						if (data.success) {
							window.location.reload();
						} else {
							showAlert(`Error: ${data.message || 'Error desconocido'}`, 'danger');
							closeDeleteModal();
						}
					})
					.catch(error => {
						console.error('Error:', error);
						showAlert('Error al eliminar el parámetro económico: ' + error.message, 'danger');
						closeDeleteModal();
					});
				} catch (error) {
					showAlert(error.message, 'danger');
					closeDeleteModal();
				}
			}
		});
	}
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', init);
