/**
 * Script para la gestión de parámetros económicos
 */
import { showAlert } from '../common/alerts.js';
import { getCsrfToken } from '../common/utils.js';
import { openModal, closeModal, setupModalOutsideClick } from '../common/modals.js';

// Variable global para almacenar el ID del parámetro a eliminar
let deleteId = null;

/**
 * Inicializa los eventos y funcionalidades de la página
 */
export function init() {
	// Configurar búsqueda
	setupSearch();
	
	// Configurar eventos para modales
	setupModalEvents();
	
	// Configurar formulario
	setupForm();
	
	// Configurar botón de eliminar
	setupDeleteButton();
	
	// Configurar cierre de modales al hacer clic fuera
	setupModalOutsideClick();
}

/**
 * Configura la funcionalidad de búsqueda
 */
function setupSearch() {
	const searchInput = document.getElementById('searchInput');
	if (searchInput) {
		searchInput.addEventListener('keyup', function() {
			const searchTerm = this.value.toLowerCase();
			const rows = document.querySelectorAll('#parametrosTable .parametro-row');
			
			rows.forEach(row => {
				const nombre = row.cells[1].textContent.toLowerCase();
				const descripcion = row.cells[3].textContent.toLowerCase();
				
				if (nombre.includes(searchTerm) || descripcion.includes(searchTerm)) {
					row.style.display = '';
				} else {
					row.style.display = 'none';
				}
			});
		});
	}
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
 */
export function openCreateModal() {
	document.getElementById('modal-title').textContent = 'Crear Parámetro Económico';
	document.getElementById('paramForm').reset();
	document.getElementById('param_id').value = '';
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
