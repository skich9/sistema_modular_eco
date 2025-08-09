@extends('layouts.app')

@section('content')
<!-- Menú de navegación -->
<x-navigation-menu />

<div class="container mx-auto px-4 py-6">
	<div class="flex justify-between items-center mb-6">
		<div>
			<h1 class="text-2xl font-bold text-gray-800">Parámetros del Sistema</h1>
			<p class="text-sm text-gray-500">Configuración de parámetros económicos y elementos de cobro</p>
		</div>
	</div>

	<!-- Alerta de éxito -->
	@if(session('success'))
	<div id="success-alert" class="alert alert-success" role="alert">
		<p>{{ session('success') }}</p>
		<button onclick="document.getElementById('success-alert').remove()" class="absolute top-0 right-0 mt-2 mr-2">
			<i class="fas fa-times"></i>
		</button>
	</div>
	@endif

	<!-- Alerta de error -->
	@if(session('error'))
	<div id="error-alert" class="alert alert-danger" role="alert">
		<p>{{ session('error') }}</p>
		<button onclick="document.getElementById('error-alert').remove()" class="absolute top-0 right-0 mt-2 mr-2">
			<i class="fas fa-times"></i>
		</button>
	</div>
	@endif

	<!-- Tarjeta de información -->
	<div class="info-card">
		<div class="info-card-icon">
			<i class="fas fa-info-circle"></i>
		</div>
		<div class="info-card-title">Guía de Configuración</div>
		<div class="info-card-description">
			Configure los parámetros del sistema para optimizar el funcionamiento de los cobros y gestión académica del Instituto CETA.
		</div>
	</div>

	<!-- Tarjetas de categorías -->
	<div class="category-cards">
		<div class="category-card">
			<div class="category-card-title">Parámetros del Sistema</div>
			<div class="category-card-description">Configuraciones generales que afectan el comportamiento del sistema académico.</div>
		</div>
		<div class="category-card">
			<div class="category-card-title">Parámetros Económicos</div>
			<div class="category-card-description">Tasas, comisiones y descuentos aplicables a las transacciones financieras.</div>
		</div>
		<div class="category-card">
			<div class="category-card-title">Items de Cobro</div>
			<div class="category-card-description">Elementos específicos que pueden ser cobrados a los estudiantes.</div>
		</div>
	</div>

	<!-- Navegación por pestañas -->
	<div class="tab-navigation">
		<a href="#sistema" class="tab-button active" data-tab="sistema">
			<i class="fas fa-cogs"></i> Parámetros del Sistema
		</a>
		<a href="#economicos" class="tab-button" data-tab="economicos">
			<i class="fas fa-dollar-sign"></i> Parámetros Económicos
		</a>
		<a href="#items" class="tab-button" data-tab="items">
			<i class="fas fa-list"></i> Items de Cobro
		</a>
		<a href="#materias" class="tab-button" data-tab="materias">
			<i class="fas fa-book"></i> Materias
		</a>
	</div>

	<!-- Contenido de las pestañas -->
	<div class="tab-content active" id="tab-sistema">
		<div class="card">
			<div class="card-header flex justify-between items-center">
				<h3 class="text-lg font-medium">Parámetros del Sistema</h3>
				<div class="flex space-x-2">
					<div class="relative">
						<input type="text" placeholder="Buscar parámetros..." class="form-input py-1 pl-8 pr-2 text-sm" id="searchSistemaInput">
						<div class="absolute inset-y-0 left-0 flex items-center pl-2">
							<i class="fas fa-search text-gray-400"></i>
						</div>
					</div>
					<button onclick="openCreateModal('sistema')" class="btn-primary">
						<i class="fas fa-plus"></i> Nuevo Parámetro
					</button>
				</div>
			</div>
			<div class="table-container">
				<table class="table">
					<thead>
						<tr>
							<th>N°</th>
							<th>Pensum</th>
							<th>Parámetro</th>
							<th>Valor</th>
							<th>Estado</th>
							<th>Módulo</th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody id="parametrosSistemaTable">
						<!-- Datos de ejemplo para la vista previa -->
						<tr class="parametro-row">
							<td>1</td>
							<td><span class="pensum-code">04-MTZ</span></td>
							<td>gestion_practica</td>
							<td>1/2024</td>
							<td><span class="badge badge-success">Activo</span></td>
							<td>Práctica Industrial</td>
							<td>
								<div class="action-buttons">
									<button type="button" onclick="openEditModalSistema(1)" class="btn-icon btn-warning" title="Editar">
										<i class="fas fa-edit"></i>
									</button>
									<button type="button" onclick="confirmDelete(1)" class="btn-icon btn-danger" title="Eliminar">
										<i class="fas fa-trash-alt"></i>
									</button>
								</div>
							</td>
						</tr>
						<tr class="parametro-row">
							<td>2</td>
							<td><span class="pensum-code">04-MTZ</span></td>
							<td>mensualidades</td>
							<td>5</td>
							<td><span class="badge badge-success">Activo</span></td>
							<td>Cobros Mensualidades</td>
							<td>
								<div class="action-buttons">
									<button type="button" onclick="openEditModalSistema(2)" class="btn-icon btn-warning" title="Editar">
										<i class="fas fa-edit"></i>
									</button>
									<button type="button" onclick="confirmDelete(2)" class="btn-icon btn-danger" title="Eliminar">
										<i class="fas fa-trash-alt"></i>
									</button>
								</div>
							</td>
						</tr>
						<tr class="parametro-row">
							<td>3</td>
							<td><span class="pensum-code">04-ELT</span></td>
							<td>modificacion_notas</td>
							<td>false</td>
							<td><span class="badge badge-danger">Inactivo</span></td>
							<td>Modificación de Notas</td>
							<td>
								<div class="action-buttons">
									<button type="button" onclick="openEditModalSistema(3)" class="btn-icon btn-warning" title="Editar">
										<i class="fas fa-edit"></i>
									</button>
									<button type="button" onclick="confirmDelete(3)" class="btn-icon btn-danger" title="Eliminar">
										<i class="fas fa-trash-alt"></i>
									</button>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- Contenido de la pestaña Parámetros Económicos -->
	<div class="tab-content" id="tab-economicos">
		<div class="card">
			<div class="card-header flex justify-between items-center">
				<h3 class="text-lg font-medium">Parámetros Económicos</h3>
				<div class="flex space-x-2">
					<div class="relative">
						<input type="text" placeholder="Buscar parámetros..." class="form-input py-1 pl-8 pr-2 text-sm" id="searchEconomicosInput">
						<div class="absolute inset-y-0 left-0 flex items-center pl-2">
							<i class="fas fa-search text-gray-400"></i>
						</div>
					</div>
					<button onclick="openCreateModal('economico')" class="btn-primary">
						<i class="fas fa-plus"></i> Nuevo Parámetro
					</button>
				</div>
			</div>
			<div class="table-container">
				<table class="table">
					<thead>
						<tr>
							<th>N°</th>
							<th>Nombre</th>
							<th>Valor</th>
							<th>Descripción</th>
							<th>Categoría</th>
							<th>Estado</th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody id="parametrosEconomicosTable">
						@forelse($parametros as $parametro)
						<tr class="parametro-row">
							<td>{{ $parametro->id_parametro_economico }}</td>
							<td>{{ $parametro->nombre }}</td>
							<td><span class="currency-value">{{ number_format($parametro->valor, 2) }}</span></td>
							<td>{{ $parametro->descripcion }}</td>
							<td>
								@php
								$categorias = ['intereses', 'comisiones', 'descuentos', 'mensualidades'];
								$categoria = $categorias[array_rand($categorias)];
								@endphp
								<span class="category-tag {{ $categoria }}">{{ ucfirst($categoria) }}</span>
							</td>
							<td>
								<span class="badge {{ $parametro->estado ? 'badge-success' : 'badge-danger' }}">
									{{ $parametro->estado ? 'Activo' : 'Inactivo' }}
								</span>
							</td>
							<td>
								<div class="action-buttons">
									<button type="button" onclick="toggleStatus({{ $parametro->id_parametro_economico }})" class="btn-icon btn-info" title="{{ $parametro->estado ? 'Desactivar' : 'Activar' }}">
										<i class="fas {{ $parametro->estado ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
									</button>
									<button type="button" onclick="openEditModal({{ $parametro->id_parametro_economico }})" class="btn-icon btn-warning" title="Editar">
										<i class="fas fa-edit"></i>
									</button>
									<button type="button" onclick="confirmDelete({{ $parametro->id_parametro_economico }})" class="btn-icon btn-danger" title="Eliminar">
										<i class="fas fa-trash-alt"></i>
									</button>
								</div>
							</td>
						</tr>
						@empty
						<tr>
							<td colspan="7" class="text-center">No hay parámetros económicos registrados</td>
						</tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- Contenido de la pestaña Items de Cobro -->
	<div class="tab-content" id="tab-items">
		<div class="card">
			<div class="card-header flex justify-between items-center">
				<h3 class="text-lg font-medium">Items de Cobro</h3>
				<div class="flex space-x-2">
					<div class="relative">
						<input type="text" placeholder="Buscar items..." class="form-input py-1 pl-8 pr-2 text-sm" id="searchItemsInput">
						<div class="absolute inset-y-0 left-0 flex items-center pl-2">
							<i class="fas fa-search text-gray-400"></i>
						</div>
					</div>
					<button onclick="openCreateModal('item')" class="btn-primary">
						<i class="fas fa-plus"></i> Nuevo Item
					</button>
				</div>
			</div>
			<div class="table-container">
				<table class="table">
					<thead>
						<tr>
							<th>ID</th>
							<th>Código Interno</th>
							<th>Nombre Servicio</th>
							<th>Créditos</th>
							<th>Costo</th>
							<th>Facturado</th>
							<th>Tipo Item</th>
							<th>Estado</th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody id="itemsCobroTable">
						<!-- Los datos se cargarán dinámicamente desde la base de datos -->
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- Contenido de la pestaña Materias -->
	<div class="tab-content" id="tab-materias">
		<div class="card">
			<div class="card-header flex justify-between items-center">
				<h3 class="text-lg font-medium">Materias</h3>
				<div class="flex space-x-2">
					<div class="relative">
						<input type="text" placeholder="Buscar materias..." class="form-input py-1 pl-8 pr-2 text-sm" id="searchMateriasInput">
						<div class="absolute inset-y-0 left-0 flex items-center pl-2">
							<i class="fas fa-search text-gray-400"></i>
						</div>
					</div>
					<button onclick="openCreateModal('materia')" class="btn-primary">
						<i class="fas fa-plus"></i> Nueva Materia
					</button>
				</div>
			</div>
			<div class="table-container">
				<table class="table">
					<thead>
						<tr>
							<th>Sigla</th>
							<th>Pensum</th>
							<th>Nombre Materia</th>
							<th>Nombre Oficial</th>
							<th>Créditos</th>
							<th>Orden</th>
							<th>Estado</th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody id="materiasTable">
						<!-- Los datos se cargarán dinámicamente desde la base de datos -->
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- Modal para crear/editar parámetro económico -->
	<div id="paramModal" class="modal-backdrop hidden">
		<div class="modal">
			<div class="modal-header">
				<h3 id="modal-title" class="text-xl"></h3>
				<button type="button" onclick="closeModal()" class="text-gray-500">
					<i class="fas fa-times"></i>
				</button>
			</div>
			<div class="modal-body">
				<form id="paramForm">
					<input type="hidden" id="param_id" name="param_id">
					<input type="hidden" id="param_tipo" name="param_tipo" value="economico">
					
					<!-- Campos para Parámetros Económicos -->
					<div id="campos-economicos" class="campos-tipo">
						<div class="form-group">
							<label for="nombre" class="form-label">Nombre</label>
							<input type="text" id="nombre" name="nombre" class="form-input" required>
						</div>
						<div class="form-group">
							<label for="valor" class="form-label">Valor</label>
							<input type="number" id="valor" name="valor" step="0.01" min="0" class="form-input" required>
						</div>
						<div class="form-group">
							<label for="descripcion" class="form-label">Descripción</label>
							<input type="text" id="descripcion" name="descripcion" class="form-input" required>
						</div>
					</div>
					
					<!-- Campos para Parámetros del Sistema -->
					<div id="campos-sistema" class="campos-tipo hidden">
						<div class="form-group">
							<label for="pensum" class="form-label">Pensum</label>
							<input type="text" id="pensum" name="pensum" class="form-input" required>
						</div>
						<div class="form-group">
							<label for="parametro" class="form-label">Parámetro</label>
							<input type="text" id="parametro" name="parametro" class="form-input" required>
						</div>
						<div class="form-group">
							<label for="valor_sistema" class="form-label">Valor</label>
							<input type="text" id="valor_sistema" name="valor_sistema" class="form-input" required>
						</div>
						<div class="form-group">
							<label for="modulo" class="form-label">Módulo</label>
							<input type="text" id="modulo" name="modulo" class="form-input" required>
						</div>
					</div>
					
					<!-- Campos para Items de Cobro -->
					<div id="campos-items" class="campos-tipo hidden">
						<div class="form-group">
							<label for="codigo_producto_interno" class="form-label">Código Interno</label>
							<input type="text" id="codigo_producto_interno" name="codigo_producto_interno" class="form-input" required>
						</div>
						<div class="form-group">
							<label for="nombre_servicio" class="form-label">Nombre Servicio</label>
							<input type="text" id="nombre_servicio" name="nombre_servicio" class="form-input" required>
						</div>
						<div class="form-group">
							<label for="nro_creditos" class="form-label">Créditos</label>
							<input type="number" id="nro_creditos" name="nro_creditos" step="0.01" min="0" class="form-input" required>
						</div>
						<div class="form-group">
							<label for="costo" class="form-label">Costo</label>
							<input type="number" id="costo" name="costo" min="0" class="form-input" required>
						</div>
						<div class="form-group">
							<label for="facturado" class="form-label">Facturado</label>
							<select id="facturado" name="facturado" class="form-select" required>
								<option value="1">Sí</option>
								<option value="0">No</option>
							</select>
						</div>
						<div class="form-group">
							<label for="actividad_economica" class="form-label">Actividad Económica</label>
							<input type="text" id="actividad_economica" name="actividad_economica" class="form-input" required>
						</div>
						<div class="form-group">
							<label for="tipo_item" class="form-label">Tipo Item</label>
							<select id="tipo_item" name="tipo_item" class="form-select" required>
								<option value="">Seleccione un tipo</option>
								<option value="Fijo">Fijo</option>
								<option value="Porcentaje">Porcentaje</option>
								<option value="Variable">Variable</option>
							</select>
						</div>
						<div class="form-group">
							<label for="id_parametro_economico" class="form-label">Parámetro Económico</label>
							<select id="id_parametro_economico" name="id_parametro_economico" class="form-select" required>
								<option value="">Seleccione un parámetro</option>
								<!-- Se cargará dinámicamente -->
							</select>
						</div>
						<div class="form-group">
							<label for="descripcion_item" class="form-label">Descripción</label>
							<input type="text" id="descripcion_item" name="descripcion_item" class="form-input">
						</div>
					</div>
					
					<!-- Campos para Materias -->
					<div id="campos-materias" class="campos-tipo hidden">
						<div class="form-group">
							<label for="sigla_materia" class="form-label">Sigla</label>
							<input type="text" id="sigla_materia" name="sigla_materia" class="form-input" required>
						</div>
						<div class="form-group">
							<label for="cod_pensum" class="form-label">Código Pensum</label>
							<input type="text" id="cod_pensum" name="cod_pensum" class="form-input" required>
						</div>
						<div class="form-group">
							<label for="nombre_materia" class="form-label">Nombre Materia</label>
							<input type="text" id="nombre_materia" name="nombre_materia" class="form-input" required>
						</div>
						<div class="form-group">
							<label for="nombre_material_oficial" class="form-label">Nombre Oficial</label>
							<input type="text" id="nombre_material_oficial" name="nombre_material_oficial" class="form-input" required>
						</div>
						<div class="form-group">
							<label for="nro_creditos_materia" class="form-label">Créditos</label>
							<input type="number" id="nro_creditos_materia" name="nro_creditos_materia" step="0.01" min="0" class="form-input" required>
						</div>
						<div class="form-group">
							<label for="orden" class="form-label">Orden</label>
							<input type="number" id="orden" name="orden" min="1" class="form-input" required>
						</div>
						<div class="form-group">
							<label for="id_parametro_economico_materia" class="form-label">Parámetro Económico</label>
							<select id="id_parametro_economico_materia" name="id_parametro_economico_materia" class="form-select" required>
								<option value="">Seleccione un parámetro</option>
								<!-- Se cargará dinámicamente -->
							</select>
						</div>
						<div class="form-group">
							<label for="descripcion_materia" class="form-label">Descripción</label>
							<input type="text" id="descripcion_materia" name="descripcion_materia" class="form-input">
						</div>
					</div>
					
					<!-- Campo Estado (común para todos) -->
					<div class="form-group">
						<label for="estado" class="form-label">Estado</label>
						<select id="estado" name="estado" class="form-input">
							<option value="1">Activo</option>
							<option value="0">Inactivo</option>
						</select>
					</div>
					
					<div class="modal-footer">
						<button type="button" onclick="closeModal()" class="btn-secondary">
							Cancelar
						</button>
						<button type="submit" class="btn-primary">
							Guardar
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Modal de confirmación para eliminar -->
	<div id="deleteModal" class="modal-backdrop hidden">
		<div class="modal">
			<div class="modal-header">
				<h3 class="text-xl">Confirmar Eliminación</h3>
				<button type="button" onclick="closeDeleteModal()" class="text-gray-500">
					<i class="fas fa-times"></i>
				</button>
			</div>
			<div class="modal-body">
				<p>¿Está seguro que desea eliminar este parámetro económico? Esta acción no se puede deshacer.</p>
			</div>
			<div class="modal-footer">
				<button type="button" onclick="closeDeleteModal()" class="btn-secondary">
					Cancelar
				</button>
				<button type="button" id="confirmDeleteBtn" class="btn-danger">
					Eliminar
				</button>
			</div>
		</div>
	</div>
</div>

@endsection

@push('scripts')
<!-- Script para gestión de parámetros económicos -->
<script>
// Variables globales
let deleteId = null;
let deleteType = null;
let parametrosEconomicos = [];
let itemsCobro = [];
let materias = [];

// Función para inicializar la página
function init() {
	console.log('Inicializando página de parámetros económicos...');
	
	// Configurar pestañas
	setupTabs();
	
	// Configurar búsqueda
	setupSearch();
	
	// Cargar datos iniciales
	loadParametrosSistema();
	loadParametrosEconomicos();
	loadItemsCobro();
	loadMaterias();
	
	// Configurar eventos de formularios
	setupFormEvents();
	
	// Configurar botón de eliminar
	setupDeleteButton();
}

// Función para configurar eventos de formularios
function setupFormEvents() {
	console.log('Configurando eventos de formularios...');
	const paramForm = document.getElementById('paramForm');
	
	if (paramForm) {
		paramForm.addEventListener('submit', function(e) {
			e.preventDefault();
			console.log('Formulario enviado');
			
			// Obtener tipo de parámetro y ID
			const paramTipo = document.getElementById('param_tipo').value;
			const paramId = document.getElementById('param_id').value;
			
			// Crear FormData para enviar
			const formData = new FormData(paramForm);
			
			// Determinar URL y método según tipo y si es creación o edición
			let url = '';
			let method = 'POST';
			
			switch(paramTipo) {
				case 'sistema':
					url = paramId ? `/configuracion/parametros-sistema/${paramId}` : '/configuracion/parametros-sistema';
					break;
				case 'item':
					url = paramId ? `/configuracion/items-cobro/${paramId}` : '/configuracion/items-cobro';
					break;
				case 'materia':
					url = paramId ? `/configuracion/materias/${paramId}` : '/configuracion/materias';
					break;
				case 'economico':
				default:
					url = paramId ? `/configuracion/parametros-economicos/${paramId}` : '/configuracion/parametros-economicos';
					break;
			}
			
			// Si es edición, usar método PUT
			if (paramId) {
				method = 'PUT';
				formData.append('_method', 'PUT'); // Laravel requiere esto para simular PUT
			}
			
			// Agregar token CSRF
			formData.append('_token', getCsrfToken());
			
			// Enviar petición
			fetch(url, {
				method: method === 'PUT' ? 'POST' : method, // Laravel simula PUT con POST + _method
				body: formData,
				headers: {
					'X-Requested-With': 'XMLHttpRequest'
				}
			})
			.then(response => response.json())
			.then(data => {
				console.log('Respuesta:', data);
				if (data.success) {
					showAlert(data.message || 'Operación realizada con éxito', 'success');
					closeModal();
					
					// Recargar datos según tipo
					switch(paramTipo) {
						case 'sistema':
							loadParametrosSistema();
							break;
						case 'item':
							loadItemsCobro();
							break;
						case 'materia':
							loadMaterias();
							break;
						case 'economico':
						default:
							loadParametrosEconomicos();
							break;
					}
				} else {
					showAlert(data.message || 'Error al procesar la solicitud', 'danger');
				}
			})
			.catch(error => {
				console.error('Error:', error);
				showAlert('Error al procesar la solicitud', 'danger');
			});
		});
	} else {
		console.error('Formulario no encontrado');
	}
}

// Función para configurar botón de eliminar
function setupDeleteButton() {
	console.log('Configurando botón de eliminar...');
	const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
	
	if (confirmDeleteBtn) {
		confirmDeleteBtn.addEventListener('click', function() {
			if (!deleteId || !deleteType) {
				console.error('ID o tipo no definido para eliminar');
				showAlert('Error al eliminar: ID o tipo no definido', 'danger');
				closeDeleteModal();
				return;
			}
			
			// Determinar URL según tipo
			let url = '';
			switch(deleteType) {
				case 'sistema':
					url = `/configuracion/parametros-sistema/${deleteId}`;
					break;
				case 'item':
					url = `/configuracion/items-cobro/${deleteId}`;
					break;
				case 'materia':
					url = `/configuracion/materias/${deleteId}`;
					break;
				case 'economico':
				default:
					url = `/configuracion/parametros-economicos/${deleteId}`;
					break;
			}
			
			// Crear FormData para enviar
			const formData = new FormData();
			formData.append('_method', 'DELETE'); // Laravel requiere esto para simular DELETE
			formData.append('_token', getCsrfToken());
			
			// Enviar petición
			fetch(url, {
				method: 'POST', // Laravel simula DELETE con POST + _method
				body: formData,
				headers: {
					'X-Requested-With': 'XMLHttpRequest'
				}
			})
			.then(response => response.json())
			.then(data => {
				console.log('Respuesta:', data);
				if (data.success) {
					showAlert(data.message || 'Elemento eliminado con éxito', 'success');
					
					// Recargar datos según tipo
					switch(deleteType) {
						case 'sistema':
							loadParametrosSistema();
							break;
						case 'item':
							loadItemsCobro();
							break;
						case 'materia':
							loadMaterias();
							break;
						case 'economico':
						default:
							loadParametrosEconomicos();
							break;
					}
				} else {
					showAlert(data.message || 'Error al eliminar el elemento', 'danger');
				}
				
				closeDeleteModal();
			})
			.catch(error => {
				console.error('Error:', error);
				showAlert('Error al eliminar el elemento', 'danger');
				closeDeleteModal();
			});
		});
	} else {
		console.error('Botón de confirmación de eliminación no encontrado');
	}
}

// Funciones para modales
function openModal(modalId) {
	console.log('Abriendo modal:', modalId);
	const modal = document.getElementById(modalId);
	if (modal) {
		modal.classList.remove('hidden');
	} else {
		console.error('Modal no encontrado:', modalId);
	}
}

function closeModal(modalId = null) {
	console.log('Cerrando modal:', modalId);
	if (modalId) {
		const modal = document.getElementById(modalId);
		if (modal) {
			modal.classList.add('hidden');
		} else {
			console.error('Modal no encontrado:', modalId);
		}
	} else {
		// Si no se especifica modalId, cerrar todos los modales
		const modals = document.querySelectorAll('.modal');
		modals.forEach(modal => modal.classList.add('hidden'));
	}
}

function confirmDelete(id, tipo = 'economico') {
	console.log('Confirmando eliminación de elemento:', id, 'tipo:', tipo);
	
	// Guardar ID y tipo para uso en el botón de confirmación
	deleteId = id;
	deleteType = tipo;
	
	// Personalizar mensaje según tipo
	let mensaje = '¿Está seguro de eliminar este parámetro económico?';
	switch(tipo) {
		case 'sistema':
			mensaje = '¿Está seguro de eliminar este parámetro del sistema?';
			break;
		case 'item':
			mensaje = '¿Está seguro de eliminar este item de cobro?';
			break;
		case 'materia':
			mensaje = '¿Está seguro de eliminar esta materia?';
			break;
	}
	
	// Actualizar mensaje en el modal
	const deleteMessage = document.getElementById('deleteMessage');
	if (deleteMessage) {
		deleteMessage.textContent = mensaje;
	}
	
	// Abrir modal de confirmación
	openModal('deleteModal');
}

function closeDeleteModal() {
	closeModal('deleteModal');
	
	// Limpiar variables
	deleteId = null;
	deleteType = null;
}

function showAlert(message, type = 'info') {
	console.log('Mostrando alerta:', message, type);
	alert(message); // Por ahora usamos alert simple
}

function getCsrfToken() {
	const token = document.querySelector('meta[name="csrf-token"]');
	if (!token) {
		throw new Error('Token CSRF no encontrado');
	}
	return token.getAttribute('content');
}

// Esta función ha sido reemplazada por una versión más completa arriba
	
	// Mostrar solo el grupo correspondiente
	switch(tipo) {
		case 'sistema':
			if (camposSistema) camposSistema.classList.remove('hidden');
			break;
		case 'item':
			if (camposItems) camposItems.classList.remove('hidden');
			break;
		case 'materia':
			if (camposMaterias) camposMaterias.classList.remove('hidden');
			break;
		case 'economico':
		default:
			if (camposEconomicos) camposEconomicos.classList.remove('hidden');
			break;
	}
}

// Esta función ha sido reemplazada por una versión más completa arriba

// Funciones específicas para cada tipo de parámetro
function openEditModalSistema(id) {
	console.log('Abriendo modal de edición para Parámetro del Sistema ID:', id);
	const modalTitle = document.getElementById('modal-title');
	const paramForm = document.getElementById('paramForm');
	const paramId = document.getElementById('param_id');
	const paramTipo = document.getElementById('param_tipo');
	
	if (modalTitle) modalTitle.textContent = 'Editar Parámetro del Sistema';
	if (paramForm) paramForm.reset();
	if (paramId) paramId.value = id;
	if (paramTipo) paramTipo.value = 'sistema';
	
	// Mostrar campos apropiados para parámetros del sistema
	showFieldsForType('sistema');
	
	// Para parámetros del sistema, usar datos estáticos por ahora
	// TODO: Implementar API específica para parámetros del sistema
	const datosEjemplo = {
		1: { pensum: 'ING-SIS', parametro: 'gestion_practica', valor: '1/2024', modulo: 'Práctica Industrial', estado: true },
		2: { pensum: 'ING-SIS', parametro: 'mensualidades', valor: '5', modulo: 'Cobros Mensualidades', estado: true },
		3: { pensum: 'ING-SIS', parametro: 'modificacion_notas', valor: 'false', modulo: 'Modificación de Notas', estado: false }
	};
	
	const parametro = datosEjemplo[id];
	if (parametro) {
		const pensum = document.getElementById('pensum');
		const parametroField = document.getElementById('parametro');
		const valorSistema = document.getElementById('valor_sistema');
		const modulo = document.getElementById('modulo');
		const estado = document.getElementById('estado');
		
		if (pensum) pensum.value = parametro.pensum || '';
		if (parametroField) parametroField.value = parametro.parametro || '';
		if (valorSistema) valorSistema.value = parametro.valor || '';
		if (modulo) modulo.value = parametro.modulo || '';
		if (estado) estado.value = parametro.estado ? '1' : '0';
		
		openModal('paramModal');
	} else {
		showAlert('Parámetro del sistema no encontrado', 'danger');
	}
}

function openEditModalEconomico(id) {
	console.log('Abriendo modal de edición para Parámetro Económico ID:', id);
	const modalTitle = document.getElementById('modal-title');
	const paramForm = document.getElementById('paramForm');
	const paramId = document.getElementById('param_id');
	const paramTipo = document.getElementById('param_tipo');
	
	if (modalTitle) modalTitle.textContent = 'Editar Parámetro Económico';
	if (paramForm) paramForm.reset();
	if (paramId) paramId.value = id;
	if (paramTipo) paramTipo.value = 'economico';
	
	// Mostrar campos apropiados para parámetros económicos
	showFieldsForType('economico');
	
	// Hacer petición para obtener datos del parámetro económico
	fetch(`/configuracion/parametros-economicos/${id}/show`)
		.then(response => response.json())
		.then(data => {
			console.log('Datos recibidos:', data);
			if (data.success) {
				const parametro = data.data;
				const nombre = document.getElementById('nombre');
				const valor = document.getElementById('valor');
				const descripcion = document.getElementById('descripcion');
				const estado = document.getElementById('estado');
				
				if (nombre) nombre.value = parametro.nombre || '';
				if (valor) valor.value = parametro.valor || '';
				if (descripcion) descripcion.value = parametro.descripcion || '';
				if (estado) estado.value = parametro.estado ? '1' : '0';
				
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

function openEditModalItem(id) {
	console.log('Abriendo modal de edición para Item de Cobro ID:', id);
	const modalTitle = document.getElementById('modal-title');
	const paramForm = document.getElementById('paramForm');
	const paramId = document.getElementById('param_id');
	const paramTipo = document.getElementById('param_tipo');
	
	if (modalTitle) modalTitle.textContent = 'Editar Item de Cobro';
	if (paramForm) paramForm.reset();
	if (paramId) paramId.value = id;
	if (paramTipo) paramTipo.value = 'item';
	
	// Mostrar campos apropiados para items de cobro
	showFieldsForType('item');
	
	// Hacer petición para obtener datos del item de cobro
	fetch(`/configuracion/items-cobro/${id}/show`)
		.then(response => response.json())
		.then(data => {
			console.log('Datos recibidos:', data);
			if (data.success) {
				const item = data.data;
				const concepto = document.getElementById('concepto');
				const monto = document.getElementById('monto');
				const tipoItem = document.getElementById('tipo_item');
				const categoria = document.getElementById('categoria');
				const estado = document.getElementById('estado');
				
				if (concepto) concepto.value = item.concepto || '';
				if (monto) monto.value = item.monto || '';
				if (tipoItem) tipoItem.value = item.tipo_item || 'Fijo';
				if (categoria) categoria.value = item.categoria || 'mensualidades';
				if (estado) estado.value = item.estado ? '1' : '0';
				
				openModal('paramModal');
			} else {
				showAlert('Error al cargar los datos del item de cobro', 'danger');
			}
		})
		.catch(error => {
			console.error('Error:', error);
			showAlert('Error al cargar los datos del item de cobro', 'danger');
		});
}

// Función para abrir el modal de edición de materias
function openEditModalMateria(id) {
	console.log('Abriendo modal de edición para Materia ID:', id);
	const modalTitle = document.getElementById('modal-title');
	const paramForm = document.getElementById('paramForm');
	const paramId = document.getElementById('param_id');
	const paramTipo = document.getElementById('param_tipo');
	
	if (modalTitle) modalTitle.textContent = 'Editar Materia';
	if (paramForm) paramForm.reset();
	if (paramId) paramId.value = id;
	if (paramTipo) paramTipo.value = 'materia';
	
	// Mostrar campos apropiados para materias
	showFieldsForType('materia');
	
	// Hacer petición para obtener datos de la materia
	fetch(`/configuracion/materias/${id}/show`)
		.then(response => response.json())
		.then(data => {
			console.log('Datos recibidos:', data);
			if (data.success) {
				const materia = data.data;
				const sigla = document.getElementById('sigla_materia');
				const nombre = document.getElementById('nombre_materia');
				const creditos = document.getElementById('creditos');
				const horasTeoricas = document.getElementById('horas_teoricas');
				const horasPracticas = document.getElementById('horas_practicas');
				const estado = document.getElementById('estado');
				
				if (sigla) sigla.value = materia.sigla || '';
				if (nombre) nombre.value = materia.nombre || '';
				if (creditos) creditos.value = materia.creditos || '';
				if (horasTeoricas) horasTeoricas.value = materia.horas_teoricas || '';
				if (horasPracticas) horasPracticas.value = materia.horas_practicas || '';
				if (estado) estado.value = materia.estado ? '1' : '0';
				
				openModal('paramModal');
			} else {
				showAlert('Error al cargar los datos de la materia', 'danger');
			}
		})
		.catch(error => {
			console.error('Error:', error);
			showAlert('Error al cargar los datos de la materia', 'danger');
		});
}

// Función para mostrar/ocultar campos según el tipo de entidad
function showFieldsForType(tipo) {
	console.log('Mostrando campos para tipo:', tipo);
	
	// Obtener todos los contenedores de campos
	const camposEconomicos = document.getElementById('campos-economicos');
	const camposSistema = document.getElementById('campos-sistema');
	const camposItems = document.getElementById('campos-items');
	const camposMaterias = document.getElementById('campos-materias');
	
	// Ocultar todos los contenedores primero
	if (camposEconomicos) camposEconomicos.classList.add('hidden');
	if (camposSistema) camposSistema.classList.add('hidden');
	if (camposItems) camposItems.classList.add('hidden');
	if (camposMaterias) camposMaterias.classList.add('hidden');
	
	// Mostrar solo el contenedor correspondiente al tipo
	switch(tipo) {
		case 'sistema':
			if (camposSistema) camposSistema.classList.remove('hidden');
			break;
		case 'item':
			if (camposItems) camposItems.classList.remove('hidden');
			// Cargar parámetros económicos disponibles para el select
			cargarParametrosEconomicos('id_parametro_economico');
			break;
		case 'materia':
			if (camposMaterias) camposMaterias.classList.remove('hidden');
			// Cargar parámetros económicos disponibles para el select
			cargarParametrosEconomicos('id_parametro_economico_materia');
			break;
		case 'economico':
		default:
			if (camposEconomicos) camposEconomicos.classList.remove('hidden');
			break;
	}
}

// Función para cargar parámetros económicos en selects
function cargarParametrosEconomicos(selectId) {
	const select = document.getElementById(selectId);
	if (!select) return;
	
	// Limpiar opciones actuales excepto la primera
	while (select.options.length > 1) {
		select.remove(1);
	}
	
	// Cargar parámetros económicos desde el servidor
	fetch('/configuracion/parametros-economicos/list')
		.then(response => response.json())
		.then(data => {
			if (data.success) {
				data.data.forEach(param => {
					const option = document.createElement('option');
					option.value = param.id;
					option.textContent = `${param.nombre} (${param.valor})`;
					select.appendChild(option);
				});
			} else {
				console.error('Error al cargar parámetros económicos:', data.message);
			}
		})
		.catch(error => {
			console.error('Error al cargar parámetros económicos:', error);
		});
}

// Función genérica para abrir modal de creación
function openCreateModal(tipo) {
	console.log('Abriendo modal de creación para tipo:', tipo);
	const modalTitle = document.getElementById('modal-title');
	const paramForm = document.getElementById('paramForm');
	const paramId = document.getElementById('param_id');
	const paramTipo = document.getElementById('param_tipo');
	
	// Configurar título y tipo según el parámetro
	let titulo = '';
	switch(tipo) {
		case 'sistema':
			titulo = 'Crear Nuevo Parámetro del Sistema';
			break;
		case 'item':
			titulo = 'Crear Nuevo Item de Cobro';
			break;
		case 'materia':
			titulo = 'Crear Nueva Materia';
			break;
		case 'economico':
		default:
			titulo = 'Crear Nuevo Parámetro Económico';
			tipo = 'economico';
			break;
	}
	
	if (modalTitle) modalTitle.textContent = titulo;
	if (paramForm) paramForm.reset();
	if (paramId) paramId.value = '';
	if (paramTipo) paramTipo.value = tipo;
	
	// Mostrar campos apropiados para el tipo
	showFieldsForType(tipo);
	
	// Establecer valores predeterminados según el tipo
	switch(tipo) {
		case 'sistema':
			// Valores predeterminados para parámetros del sistema
			const pensum = document.getElementById('pensum');
			const estado = document.getElementById('estado');
			
			if (pensum) pensum.value = 'ING-SIS';
			if (estado) estado.value = '1';
			break;
			
		case 'item':
			// Valores predeterminados para items de cobro
			const tipoItem = document.getElementById('tipo_item');
			const facturado = document.getElementById('facturado');
			const estadoItem = document.getElementById('estado');
			
			if (tipoItem) tipoItem.value = 'Fijo';
			if (facturado) facturado.value = '1';
			if (estadoItem) estadoItem.value = '1';
			break;
			
		case 'materia':
			// Valores predeterminados para materias
			const codPensum = document.getElementById('cod_pensum');
			const creditos = document.getElementById('nro_creditos_materia');
			const orden = document.getElementById('orden');
			const estadoMateria = document.getElementById('estado');
			
			if (codPensum) codPensum.value = 'ING-SIS';
			if (creditos) creditos.value = '4';
			if (orden) orden.value = '1';
			if (estadoMateria) estadoMateria.value = '1';
			break;
			
		case 'economico':
		default:
			// Valores predeterminados para parámetros económicos
			const valor = document.getElementById('valor');
			const estadoEconomico = document.getElementById('estado');
			
			if (valor) valor.value = '0.00';
			if (estadoEconomico) estadoEconomico.value = '1';
			break;
	}
	
	openModal('paramModal');
}

// Función genérica (mantener para compatibilidad)
function openEditModal(id) {
	console.log('Usando función genérica openEditModal para ID:', id);
	// Por defecto, usar la función de parámetros económicos
	openEditModalEconomico(id);
}

function confirmDelete(id, tipo = 'economico') {
	console.log('Confirmando eliminación para ID:', id, 'Tipo:', tipo);
	deleteId = id;
	deleteType = tipo;
	
	// Actualizar mensaje de confirmación según tipo
	const mensaje = document.getElementById('deleteMessage');
	if (mensaje) {
		switch(tipo) {
			case 'item':
				mensaje.textContent = '¿Está seguro de eliminar este item de cobro?';
				break;
			case 'materia':
				mensaje.textContent = '¿Está seguro de eliminar esta materia?';
				break;
			case 'economico':
			default:
				mensaje.textContent = '¿Está seguro de eliminar este parámetro económico?';
				break;
		}
	}
	
	openModal('deleteModal');
}

function executeDelete() {
	console.log('Ejecutando eliminación para ID:', deleteId, 'Tipo:', deleteType);
	if (!deleteId) {
		showAlert('No hay elemento seleccionado para eliminar', 'danger');
		return;
	}
	
	// Determinar la URL según el tipo
	let url = '';
	let mensaje = '';
	switch(deleteType) {
		case 'item':
			url = `/configuracion/items-cobro/${deleteId}`;
			mensaje = 'item de cobro';
			break;
		case 'materia':
			url = `/configuracion/materias/${deleteId}`;
			mensaje = 'materia';
			break;
		case 'economico':
		default:
			url = `/configuracion/parametros-economicos/${deleteId}`;
			mensaje = 'parámetro económico';
			break;
	}
	
	try {
		const token = getCsrfToken();
		fetch(url, {
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
			console.log('Respuesta de eliminación:', data);
			if (data.success) {
				closeDeleteModal();
				
				// Actualizar la tabla correspondiente
				switch(deleteType) {
					case 'item':
						loadItemsCobro();
						break;
					case 'materia':
						loadMaterias();
						break;
					case 'economico':
					default:
						loadParametrosEconomicos();
						break;
				}
				
				showAlert(`El ${mensaje} ha sido eliminado correctamente`, 'success');
			} else {
				showAlert(`Error al eliminar el ${mensaje}: ` + (data.message || 'Error desconocido'), 'danger');
			}
		})
		.catch(error => {
			console.error('Error:', error);
			showAlert(`Error al eliminar el ${mensaje}: ` + error.message, 'danger');
		});
	} catch (error) {
		showAlert(error.message, 'danger');
	}
}

function toggleStatus(id, tipo = 'economico') {
	console.log('Cambiando estado para ID:', id, 'Tipo:', tipo);
	
	// Determinar la URL según el tipo
	let url = '';
	let mensaje = '';
	switch(tipo) {
		case 'item':
			url = `/configuracion/items-cobro/${id}/toggle-status`;
			mensaje = 'item de cobro';
			break;
		case 'materia':
			url = `/configuracion/materias/${id}/toggle-status`;
			mensaje = 'materia';
			break;
		case 'economico':
		default:
			url = `/configuracion/parametros-economicos/${id}/toggle-status`;
			mensaje = 'parámetro económico';
			break;
	}
	
	try {
		const token = getCsrfToken();
		fetch(url, {
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
			console.log('Respuesta de cambio de estado:', data);
			if (data.success) {
				// Actualizar la tabla correspondiente
				switch(tipo) {
					case 'item':
						loadItemsCobro();
						break;
					case 'materia':
						loadMaterias();
						break;
					case 'economico':
					default:
						loadParametrosEconomicos();
						break;
				}
				
				showAlert(`El estado del ${mensaje} ha sido actualizado correctamente`, 'success');
			} else {
				showAlert(`Error al cambiar el estado del ${mensaje}: ` + (data.message || 'Error desconocido'), 'danger');
			}
		})
		.catch(error => {
			console.error('Error:', error);
			showAlert(`Error al cambiar el estado del ${mensaje}: ` + error.message, 'danger');
		});
	} catch (error) {
		showAlert(error.message, 'danger');
	}
}

// Función para renderizar parámetros económicos en la tabla
function renderParametrosEconomicos() {
	console.log('Renderizando parámetros económicos...');
	const tbody = document.querySelector('#parametrosEconomicosTable tbody');
	
	if (!tbody) {
		console.error('No se encontró la tabla de parámetros económicos');
		return;
	}
	
	// Limpiar tabla
	tbody.innerHTML = '';
	
	// Si no hay datos, mostrar mensaje
	if (!parametrosEconomicos || parametrosEconomicos.length === 0) {
		const tr = document.createElement('tr');
		tr.innerHTML = `<td colspan="5" class="text-center py-4">No hay parámetros económicos registrados</td>`;
		tbody.appendChild(tr);
		return;
	}
	
	// Renderizar cada parámetro
	parametrosEconomicos.forEach(param => {
		const tr = document.createElement('tr');
		tr.innerHTML = `
			<td>${param.nombre || ''}</td>
			<td>${param.valor || ''}</td>
			<td>${param.descripcion || ''}</td>
			<td>
				<span class="badge ${param.estado ? 'badge-success' : 'badge-danger'}">
					${param.estado ? 'Activo' : 'Inactivo'}
				</span>
			</td>
			<td class="text-right">
				<div class="btn-group">
					<button type="button" class="btn btn-sm btn-outline-primary" onclick="openEditModalEconomico(${param.id})">
						<i class="fas fa-edit"></i>
					</button>
					<button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete(${param.id}, 'economico')">
						<i class="fas fa-trash"></i>
					</button>
					<button type="button" class="btn btn-sm ${param.estado ? 'btn-outline-warning' : 'btn-outline-success'}" onclick="toggleStatus(${param.id}, 'economico')">
						<i class="fas ${param.estado ? 'fa-ban' : 'fa-check'}"></i>
					</button>
				</div>
			</td>
		`;
		tbody.appendChild(tr);
	});
}

// Función para renderizar items de cobro en la tabla
function renderItemsCobro() {
	console.log('Renderizando items de cobro...');
	const tbody = document.querySelector('#itemsCobroTable tbody');
	
	if (!tbody) {
		console.error('No se encontró la tabla de items de cobro');
		return;
	}
	
	// Limpiar tabla
	tbody.innerHTML = '';
	
	// Si no hay datos, mostrar mensaje
	if (!itemsCobro || itemsCobro.length === 0) {
		const tr = document.createElement('tr');
		tr.innerHTML = `<td colspan="5" class="text-center py-4">No hay items de cobro registrados</td>`;
		tbody.appendChild(tr);
		return;
	}
	
	// Renderizar cada item
	itemsCobro.forEach(item => {
		const tr = document.createElement('tr');
		tr.innerHTML = `
			<td>${item.concepto || ''}</td>
			<td>${item.monto || ''}</td>
			<td>${item.tipo_item || ''}</td>
			<td>
				<span class="badge ${item.estado ? 'badge-success' : 'badge-danger'}">
					${item.estado ? 'Activo' : 'Inactivo'}
				</span>
			</td>
			<td class="text-right">
				<div class="btn-group">
					<button type="button" class="btn btn-sm btn-outline-primary" onclick="openEditModalItem(${item.id})">
						<i class="fas fa-edit"></i>
					</button>
					<button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete(${item.id}, 'item')">
						<i class="fas fa-trash"></i>
					</button>
					<button type="button" class="btn btn-sm ${item.estado ? 'btn-outline-warning' : 'btn-outline-success'}" onclick="toggleStatus(${item.id}, 'item')">
						<i class="fas ${item.estado ? 'fa-ban' : 'fa-check'}"></i>
					</button>
				</div>
			</td>
		`;
		tbody.appendChild(tr);
	});
}

// Función para renderizar materias en la tabla
function renderMaterias() {
	console.log('Renderizando materias...');
	const tbody = document.querySelector('#materiasTable tbody');
	
	if (!tbody) {
		console.error('No se encontró la tabla de materias');
		return;
	}
	
	// Limpiar tabla
	tbody.innerHTML = '';
	
	// Si no hay datos, mostrar mensaje
	if (!materias || materias.length === 0) {
		const tr = document.createElement('tr');
		tr.innerHTML = `<td colspan="6" class="text-center py-4">No hay materias registradas</td>`;
		tbody.appendChild(tr);
		return;
	}
	
	// Renderizar cada materia
	materias.forEach(materia => {
		const tr = document.createElement('tr');
		tr.innerHTML = `
			<td>${materia.sigla || ''}</td>
			<td>${materia.nombre || ''}</td>
			<td>${materia.creditos || ''}</td>
			<td>${materia.horas_teoricas || ''}</td>
			<td>
				<span class="badge ${materia.estado ? 'badge-success' : 'badge-danger'}">
					${materia.estado ? 'Activo' : 'Inactivo'}
				</span>
			</td>
			<td class="text-right">
				<div class="btn-group">
					<button type="button" class="btn btn-sm btn-outline-primary" onclick="openEditModalMateria(${materia.id})">
						<i class="fas fa-edit"></i>
					</button>
					<button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete(${materia.id}, 'materia')">
						<i class="fas fa-trash"></i>
					</button>
					<button type="button" class="btn btn-sm ${materia.estado ? 'btn-outline-warning' : 'btn-outline-success'}" onclick="toggleStatus(${materia.id}, 'materia')">
						<i class="fas ${materia.estado ? 'fa-ban' : 'fa-check'}"></i>
					</button>
				</div>
			</td>
		`;
		tbody.appendChild(tr);
	});
}

// Configuración de pestañas
function setupTabs() {
	console.log('Configurando pestañas');
	const tabButtons = document.querySelectorAll('.tab-button');
	const tabContents = document.querySelectorAll('.tab-content');
	
	console.log('Botones encontrados:', tabButtons.length);
	console.log('Contenidos encontrados:', tabContents.length);
	
	tabButtons.forEach((button, index) => {
		button.addEventListener('click', (e) => {
			e.preventDefault();
			const tabId = button.getAttribute('data-tab');
			console.log('Tab clicked:', tabId);
			
			// Remover clase active de todos
			tabButtons.forEach(btn => btn.classList.remove('active'));
			tabContents.forEach(content => content.classList.remove('active'));
			
			// Activar el seleccionado
			button.classList.add('active');
			const targetContent = document.getElementById('tab-' + tabId);
			if (targetContent) {
				targetContent.classList.add('active');
				console.log('Tab content activated:', 'tab-' + tabId);
			}
		});
	});
}

// Configuración de eventos de formulario
function setupFormEvents() {
	console.log('Configurando eventos de formulario...');
	
	// Configurar el formulario principal
	const paramForm = document.getElementById('paramForm');
	if (paramForm) {
		paramForm.addEventListener('submit', function(e) {
			e.preventDefault();
			saveParam();
		});
	}
	
	// Configurar botón de eliminar
	setupDeleteButton();
}

// Configurar botón de eliminar
function setupDeleteButton() {
	console.log('Configurando botón de eliminar...');
	const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
	if (confirmDeleteBtn) {
		confirmDeleteBtn.addEventListener('click', function() {
			executeDelete();
		});
	}
}

// Función para guardar parámetros
function saveParam() {
	console.log('Guardando parámetro...');
	
	// Obtener tipo y ID
	const tipo = document.getElementById('param_tipo').value;
	const id = document.getElementById('param_id').value;
	
	// Crear FormData para enviar
	const formData = new FormData(document.getElementById('paramForm'));
	
	// Determinar URL y método según tipo y si es creación o edición
	let url = '';
	let method = 'POST';
	let mensaje = '';
	
	switch(tipo) {
		case 'item':
			if (id) {
				url = `/configuracion/items-cobro/${id}`;
				method = 'PUT';
				mensaje = 'Item de cobro actualizado';
			} else {
				url = '/configuracion/items-cobro';
				mensaje = 'Item de cobro creado';
			}
			break;
		case 'materia':
			if (id) {
				url = `/configuracion/materias/${id}`;
				method = 'PUT';
				mensaje = 'Materia actualizada';
			} else {
				url = '/configuracion/materias';
				mensaje = 'Materia creada';
			}
			break;
		case 'economico':
		default:
			if (id) {
				url = `/configuracion/parametros-economicos/${id}`;
				method = 'PUT';
				mensaje = 'Parámetro económico actualizado';
			} else {
				url = '/configuracion/parametros-economicos';
				mensaje = 'Parámetro económico creado';
			}
			break;
	}
	
	// Obtener token CSRF
	const token = getCsrfToken();
	
	// Convertir FormData a objeto para enviar como JSON
	const data = {};
	formData.forEach((value, key) => {
		data[key] = value;
	});
	
	// Enviar petición
	fetch(url, {
		method: method,
		headers: {
			'Content-Type': 'application/json',
			'X-CSRF-TOKEN': token
		},
		body: JSON.stringify(data)
	})
	.then(response => {
		if (!response.ok) {
			throw new Error(`HTTP error! status: ${response.status}`);
		}
		return response.json();
	})
	.then(data => {
		console.log('Respuesta:', data);
		if (data.success) {
			// Cerrar modal
			closeModal('paramModal');
			
			// Actualizar tabla correspondiente
			switch(tipo) {
				case 'item':
					loadItemsCobro();
					break;
				case 'materia':
					loadMaterias();
					break;
				case 'economico':
				default:
					loadParametrosEconomicos();
					break;
			}
			
			// Mostrar mensaje de éxito
			showAlert(`${mensaje} correctamente`, 'success');
		} else {
			showAlert(`Error: ${data.message || 'Error desconocido'}`, 'danger');
		}
	})
	.catch(error => {
		console.error('Error:', error);
		showAlert(`Error: ${error.message}`, 'danger');
	});
}

// Configuración de búsqueda
function setupSearch() {
	console.log('Configurando búsqueda');
	const searchConfigs = [
		{ inputId: 'searchSistemaInput', tableId: 'parametrosSistemaTable' },
		{ inputId: 'searchEconomicosInput', tableId: 'parametrosEconomicosTable' },
		{ inputId: 'searchItemsInput', tableId: 'itemsCobroTable' },
		{ inputId: 'searchMateriasInput', tableId: 'materiasTable' }
	];
	
	searchConfigs.forEach(function(config) {
		const input = document.getElementById(config.inputId);
		const table = document.getElementById(config.tableId);
		
		if (input && table) {
			console.log('Configurando búsqueda para:', config.inputId);
			input.addEventListener('keyup', function() {
				const filter = input.value.toUpperCase();
				const rows = table.getElementsByTagName('tr');
				
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
		}
	});
}

// Cargar parámetros económicos
function loadParametrosEconomicos() {
	console.log('Cargando parámetros económicos...');
	$.ajax({
		url: '/configuracion/parametros-economicos',
		type: 'GET',
		dataType: 'json',
		success: function(response) {
			console.log('Parámetros económicos cargados:', response);
			if (response.success) {
				parametrosEconomicos = response.data;
				renderParametrosEconomicos();
				// También cargar parámetros económicos para los selectores
				populateParametrosEconomicosSelects();
			} else {
				console.error('Error en respuesta:', response);
				showNotification('Error al cargar parámetros económicos', 'error');
			}
		},
		error: function(xhr, status, error) {
			console.error('Error al cargar parámetros económicos:', error);
			showNotification('Error al cargar parámetros económicos', 'error');
		}
	});
}

// Cargar items de cobro
function loadItemsCobro() {
	console.log('Cargando items de cobro...');
	$.ajax({
		url: '/configuracion/items-cobro',
		type: 'GET',
		dataType: 'json',
		success: function(response) {
			console.log('Items de cobro cargados:', response);
			if (response.success) {
				itemsCobro = response.data;
				renderItemsCobro();
				// También cargar parámetros económicos para los selectores
				if (parametrosEconomicos.length === 0) {
					loadParametrosEconomicosForSelects();
				}
			} else {
				console.error('Error en respuesta:', response);
				showNotification('Error al cargar items de cobro', 'error');
			}
		},
		error: function(xhr, status, error) {
			console.error('Error al cargar items de cobro:', error);
			showNotification('Error al cargar items de cobro', 'error');
		}
	});
}

// Cargar materias
function loadMaterias() {
	console.log('Cargando materias...');
	$.ajax({
		url: '/configuracion/materias',
		type: 'GET',
		dataType: 'json',
		success: function(response) {
			console.log('Materias cargadas:', response);
			if (response.success) {
				materias = response.data;
				renderMaterias();
			} else {
				console.error('Error en respuesta:', response);
				showNotification('Error al cargar materias', 'error');
			}
		},
		error: function(xhr, status, error) {
			console.error('Error al cargar materias:', error);
			showNotification('Error al cargar materias', 'error');
		}
	});
}

// Cargar parámetros económicos para selectores
// Función para cargar parámetros económicos
function loadParametrosEconomicos() {
	console.log('Cargando parámetros económicos...');
	
	fetch('/configuracion/parametros-economicos')
		.then(response => {
			if (!response.ok) {
				throw new Error(`HTTP error! status: ${response.status}`);
			}
			return response.json();
		})
		.then(data => {
			console.log('Parámetros económicos cargados:', data);
			if (data.success) {
				parametrosEconomicos = data.data;
				renderParametrosEconomicos();
			} else {
				showAlert('Error al cargar los parámetros económicos', 'danger');
			}
		})
		.catch(error => {
			console.error('Error:', error);
			showAlert('Error al cargar los parámetros económicos', 'danger');
		});
}

// Función para cargar items de cobro
function loadItemsCobro() {
	console.log('Cargando items de cobro...');
	
	fetch('/configuracion/items-cobro')
		.then(response => {
			if (!response.ok) {
				throw new Error(`HTTP error! status: ${response.status}`);
			}
			return response.json();
		})
		.then(data => {
			console.log('Items de cobro cargados:', data);
			if (data.success) {
				itemsCobro = data.data;
				renderItemsCobro();
			} else {
				showAlert('Error al cargar los items de cobro', 'danger');
			}
		})
		.catch(error => {
			console.error('Error:', error);
			showAlert('Error al cargar los items de cobro', 'danger');
		});
}

// Función para cargar materias
function loadMaterias() {
	console.log('Cargando materias...');
	
	fetch('/configuracion/materias')
		.then(response => {
			if (!response.ok) {
				throw new Error(`HTTP error! status: ${response.status}`);
			}
			return response.json();
		})
		.then(data => {
			console.log('Materias cargadas:', data);
			if (data.success) {
				materias = data.data;
				renderMaterias();
			} else {
				showAlert('Error al cargar las materias', 'danger');
			}
		})
		.catch(error => {
			console.error('Error:', error);
			showAlert('Error al cargar las materias', 'danger');
		});
}

function loadParametrosEconomicosForSelects() {
	$.ajax({
		url: '/configuracion/parametros-economicos',
		type: 'GET',
		dataType: 'json',
		success: function(response) {
			console.log('Parámetros económicos cargados para selectores:', response);
			if (response.success) {
				parametrosEconomicos = response.data;
				populateParametrosEconomicosSelects();
			} else {
				console.error('Error en respuesta:', response);
			}
		},
		error: function(xhr, status, error) {
			console.error('Error al cargar parámetros económicos para selectores:', error);
		}
	});
}

// Poblar selectores de parámetros económicos
function populateParametrosEconomicosSelects() {
	const selects = ['#id_parametro_economico', '#id_parametro_economico_materia'];
	
	selects.forEach(selectId => {
		const select = $(selectId);
		select.empty();
		select.append('<option value="">Seleccione un parámetro</option>');
		
		parametrosEconomicos.forEach(param => {
			select.append(`<option value="${param.id}">${param.nombre} - ${param.valor}</option>`);
		});
	});
}

// Renderizar parámetros económicos
function renderParametrosEconomicos() {
	const tbody = $('#parametrosEconomicosTable');
	tbody.empty();
	
	if (parametrosEconomicos.length === 0) {
		tbody.append('<tr><td colspan="5" class="text-center">No hay parámetros económicos registrados</td></tr>');
		return;
	}
	
	parametrosEconomicos.forEach(param => {
		const estado = param.estado ? '<span class="badge badge-success">Activo</span>' : '<span class="badge badge-danger">Inactivo</span>';
		
		tbody.append(`
			<tr>
				<td>${param.id}</td>
				<td>${param.nombre}</td>
				<td><span class="currency-value">${param.valor}</span></td>
				<td>${param.descripcion}</td>
				<td>${estado}</td>
				<td>
					<div class="action-buttons">
						<button type="button" onclick="openEditModalParam(${param.id})" class="btn-icon btn-warning" title="Editar">
							<i class="fas fa-edit"></i>
						</button>
						<button type="button" onclick="confirmDeleteParam(${param.id})" class="btn-icon btn-danger" title="Eliminar">
							<i class="fas fa-trash-alt"></i>
						</button>
					</div>
				</td>
			</tr>
		`);
	});
}

// Renderizar items de cobro
function renderItemsCobro() {
	const tbody = $('#itemsCobroTable');
	tbody.empty();
	
	if (itemsCobro.length === 0) {
		tbody.append('<tr><td colspan="7" class="text-center">No hay items de cobro registrados</td></tr>');
		return;
	}
	
	itemsCobro.forEach(item => {
		const estado = item.estado ? '<span class="badge badge-success">Activo</span>' : '<span class="badge badge-danger">Inactivo</span>';
		const facturado = item.facturado ? 'Sí' : 'No';
		let categoriaClass = '';
		
		// Asignar clase según tipo de item
		switch(item.tipo_item) {
			case 'Fijo': categoriaClass = 'mensualidades'; break;
			case 'Porcentaje': categoriaClass = 'intereses'; break;
			case 'Variable': categoriaClass = 'examenes'; break;
			default: categoriaClass = 'otros';
		}
		
		tbody.append(`
			<tr>
				<td>${item.codigo_producto_interno}</td>
				<td>${item.nombre_servicio}</td>
				<td><span class="currency-value">${item.costo}</span></td>
				<td>${facturado}</td>
				<td><span class="category-tag ${categoriaClass}">${item.tipo_item}</span></td>
				<td>${estado}</td>
				<td>
					<div class="action-buttons">
						<button type="button" onclick="openEditModalItem(${item.id})" class="btn-icon btn-warning" title="Editar">
							<i class="fas fa-edit"></i>
						</button>
						<button type="button" onclick="confirmDeleteItem(${item.id})" class="btn-icon btn-danger" title="Eliminar">
							<i class="fas fa-trash-alt"></i>
						</button>
					</div>
				</td>
			</tr>
		`);
	});
}

// Renderizar materias
function renderMaterias() {
	const tbody = $('#materiasTable');
	tbody.empty();
	
	if (materias.length === 0) {
		tbody.append('<tr><td colspan="8" class="text-center">No hay materias registradas</td></tr>');
		return;
	}
	
	materias.forEach(materia => {
		const estado = materia.estado ? '<span class="badge badge-success">Activo</span>' : '<span class="badge badge-danger">Inactivo</span>';
		
		tbody.append(`
			<tr>
				<td>${materia.sigla}</td>
				<td>${materia.cod_pensum}</td>
				<td>${materia.nombre_materia}</td>
				<td>${materia.nombre_material_oficial}</td>
				<td>${materia.nro_creditos}</td>
				<td>${materia.orden}</td>
				<td>${estado}</td>
				<td>
					<div class="action-buttons">
						<button type="button" onclick="openEditModalMateria('${materia.sigla}')" class="btn-icon btn-warning" title="Editar">
							<i class="fas fa-edit"></i>
						</button>
						<button type="button" onclick="confirmDeleteMateria('${materia.sigla}')" class="btn-icon btn-danger" title="Eliminar">
							<i class="fas fa-trash-alt"></i>
						</button>
					</div>
				</td>
			</tr>
		`);
	});
}

// Abrir modal para crear
function openCreateModal(tipo) {
	resetForm();
	
	// Configurar el modal según el tipo
	if (tipo === 'economico') {
		$('#modal-title').text('Crear Parámetro Económico');
		$('#param_tipo').val('economico');
		$('.campos-tipo').addClass('hidden');
		$('#campos-economicos').removeClass('hidden');
	} else if (tipo === 'sistema') {
		$('#modal-title').text('Crear Parámetro del Sistema');
		$('#param_tipo').val('sistema');
		$('.campos-tipo').addClass('hidden');
		$('#campos-sistema').removeClass('hidden');
	} else if (tipo === 'item') {
		$('#modal-title').text('Crear Item de Cobro');
		$('#param_tipo').val('item');
		$('.campos-tipo').addClass('hidden');
		$('#campos-items').removeClass('hidden');
	} else if (tipo === 'materia') {
		$('#modal-title').text('Crear Materia');
		$('#param_tipo').val('materia');
		$('.campos-tipo').addClass('hidden');
		$('#campos-materias').removeClass('hidden');
	}
	
	// Mostrar el modal
	$('#paramModal').removeClass('hidden');
}

// Abrir modal para editar parámetro
function openEditModalParam(id) {
	resetForm();
	
	// Buscar el parámetro
	const param = parametrosEconomicos.find(p => p.id === id);
	if (!param) return;
	
	// Configurar el modal
	$('#modal-title').text('Editar Parámetro Económico');
	$('#param_id').val(param.id);
	$('#param_tipo').val('economico');
	$('.campos-tipo').addClass('hidden');
	$('#campos-economicos').removeClass('hidden');
	
	// Llenar los campos
	$('#nombre').val(param.nombre);
	$('#valor').val(param.valor);
	$('#descripcion').val(param.descripcion);
	
	// Mostrar el modal
	$('#paramModal').removeClass('hidden');
}

// Abrir modal para editar item
function openEditModalItem(id) {
	resetForm();
	
	// Buscar el item
	const item = itemsCobro.find(i => i.id === id);
	if (!item) return;
	
	// Configurar el modal
	$('#modal-title').text('Editar Item de Cobro');
	$('#param_id').val(item.id);
	$('#param_tipo').val('item');
	$('.campos-tipo').addClass('hidden');
	$('#campos-items').removeClass('hidden');
	
	// Llenar los campos
	$('#codigo_producto_interno').val(item.codigo_producto_interno);
	$('#nombre_servicio').val(item.nombre_servicio);
	$('#nro_creditos').val(item.nro_creditos);
	$('#costo').val(item.costo);
	$('#facturado').val(item.facturado ? '1' : '0');
	$('#actividad_economica').val(item.actividad_economica);
	$('#tipo_item').val(item.tipo_item);
	$('#id_parametro_economico').val(item.id_parametro_economico);
	$('#descripcion_item').val(item.descripcion);
	
	// Mostrar el modal
	$('#paramModal').removeClass('hidden');
}

// Abrir modal para editar materia
function openEditModalMateria(sigla) {
	resetForm();
	
	// Buscar la materia
	const materia = materias.find(m => m.sigla === sigla);
	if (!materia) return;
	
	// Configurar el modal
	$('#modal-title').text('Editar Materia');
	$('#param_id').val(materia.sigla); // Usamos sigla como ID
	$('#param_tipo').val('materia');
	$('.campos-tipo').addClass('hidden');
	$('#campos-materias').removeClass('hidden');
	
	// Llenar los campos
	$('#sigla_materia').val(materia.sigla);
	$('#sigla_materia').prop('readonly', true); // No permitir cambiar la sigla
	$('#cod_pensum').val(materia.cod_pensum);
	$('#nombre_materia').val(materia.nombre_materia);
	$('#nombre_material_oficial').val(materia.nombre_material_oficial);
	$('#nro_creditos_materia').val(materia.nro_creditos);
	$('#orden').val(materia.orden);
	$('#id_parametro_economico_materia').val(materia.id_parametro_economico);
	$('#descripcion_materia').val(materia.descripcion);
	
	// Mostrar el modal
	$('#paramModal').removeClass('hidden');
}

// Cerrar modal
function closeModal() {
	$('#paramModal').addClass('hidden');
	resetForm();
}

// Resetear formulario
function resetForm() {
	$('#paramForm')[0].reset();
	$('#param_id').val('');
	$('#sigla_materia').prop('readonly', false);
}

// Guardar parámetro
function saveParam() {
	const tipo = $('#param_tipo').val();
	const id = $('#param_id').val();
	let url, method, data;
	
	// Configurar según el tipo
	if (tipo === 'economico') {
		data = {
			nombre: $('#nombre').val(),
			valor: $('#valor').val(),
			descripcion: $('#descripcion').val()
		};
		
		if (id) {
			url = `/configuracion/parametros-economicos/${id}`;
			method = 'PUT';
		} else {
			url = '/configuracion/parametros-economicos';
			method = 'POST';
		}
	} else if (tipo === 'sistema') {
		data = {
			pensum: $('#pensum').val(),
			parametro: $('#parametro').val(),
			valor: $('#valor_sistema').val(),
			modulo: $('#modulo').val()
		};
		
		if (id) {
			url = `/configuracion/parametros-sistema/${id}`;
			method = 'PUT';
		} else {
			url = '/configuracion/parametros-sistema';
			method = 'POST';
		}
	} else if (tipo === 'item') {
		data = {
			codigo_producto_interno: $('#codigo_producto_interno').val(),
			nombre_servicio: $('#nombre_servicio').val(),
			nro_creditos: $('#nro_creditos').val(),
			costo: $('#costo').val(),
			facturado: $('#facturado').val() === '1',
			actividad_economica: $('#actividad_economica').val(),
			tipo_item: $('#tipo_item').val(),
			id_parametro_economico: $('#id_parametro_economico').val(),
			descripcion: $('#descripcion_item').val()
		};
		
		if (id) {
			url = `/configuracion/items-cobro/${id}`;
			method = 'PUT';
		} else {
			url = '/configuracion/items-cobro';
			method = 'POST';
		}
	} else if (tipo === 'materia') {
		data = {
			sigla: $('#sigla_materia').val(),
			cod_pensum: $('#cod_pensum').val(),
			nombre_materia: $('#nombre_materia').val(),
			nombre_material_oficial: $('#nombre_material_oficial').val(),
			nro_creditos: $('#nro_creditos_materia').val(),
			orden: $('#orden').val(),
			id_parametro_economico: $('#id_parametro_economico_materia').val(),
			descripcion: $('#descripcion_materia').val()
		};
		
		if (id) {
			url = `/configuracion/materias/${id}`;
			method = 'PUT';
		} else {
			url = '/configuracion/materias';
			method = 'POST';
		}
	}
	
	// Enviar solicitud
	$.ajax({
		url: url,
		type: method,
		data: data,
		dataType: 'json',
		success: function(response) {
			closeModal();
			showNotification('Guardado correctamente', 'success');
			
			// Recargar datos según el tipo
			if (tipo === 'economico') {
				loadParametrosEconomicos();
			} else if (tipo === 'sistema') {
				// Recargar parámetros del sistema
			} else if (tipo === 'item') {
				loadItemsCobro();
			} else if (tipo === 'materia') {
				loadMaterias();
			}
		},
		error: function(xhr, status, error) {
			console.error('Error al guardar:', error);
			showNotification('Error al guardar', 'error');
		}
	});
}

// Confirmar eliminación de parámetro
function confirmDeleteParam(id) {
	if (confirm('¿Está seguro de eliminar este parámetro económico?')) {
		deleteParam(id);
	}
}

// Eliminar parámetro
function deleteParam(id) {
	$.ajax({
		url: `/configuracion/parametros-economicos/${id}`,
		type: 'DELETE',
		dataType: 'json',
		success: function(response) {
			showNotification('Eliminado correctamente', 'success');
			loadParametrosEconomicos();
		},
		error: function(xhr, status, error) {
			console.error('Error al eliminar:', error);
			showNotification('Error al eliminar', 'error');
		}
	});
}

// Confirmar eliminación de item
function confirmDeleteItem(id) {
	if (confirm('¿Está seguro de eliminar este item de cobro?')) {
		deleteItem(id);
	}
}

// Eliminar item
function deleteItem(id) {
	$.ajax({
		url: `/configuracion/items-cobro/${id}`,
		type: 'DELETE',
		dataType: 'json',
		success: function(response) {
			showNotification('Eliminado correctamente', 'success');
			loadItemsCobro();
		},
		error: function(xhr, status, error) {
			console.error('Error al eliminar:', error);
			showNotification('Error al eliminar', 'error');
		}
	});
}

// Confirmar eliminación de materia
function confirmDeleteMateria(sigla) {
	if (confirm('¿Está seguro de eliminar esta materia?')) {
		deleteMateria(sigla);
	}
}

// Eliminar materia
function deleteMateria(sigla) {
	$.ajax({
		url: `/configuracion/materias/${sigla}`,
		type: 'DELETE',
		dataType: 'json',
		success: function(response) {
			showNotification('Eliminado correctamente', 'success');
			loadMaterias();
		},
		error: function(xhr, status, error) {
			console.error('Error al eliminar:', error);
			showNotification('Error al eliminar', 'error');
		}
	});
}

// Mostrar notificación
function showNotification(message, type = 'info') {
	console.log(`Notificación (${type}):`, message);
	
	// Crear elemento de notificación
	const notification = $(`
		<div class="notification notification-${type}">
			<div class="notification-icon">
				<i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle'}"></i>
			</div>
			<div class="notification-content">
				<p>${message}</p>
			</div>
			<button class="notification-close">
				<i class="fas fa-times"></i>
			</button>
		</div>
	`);
	
	// Agregar al contenedor de notificaciones
	const container = $('#notification-container');
	if (container.length === 0) {
		$('body').append('<div id="notification-container"></div>');
	}
	
	$('#notification-container').append(notification);
	
	// Configurar cierre
	notification.find('.notification-close').on('click', function() {
		notification.remove();
	});
	
	// Auto-cerrar después de 5 segundos
	setTimeout(function() {
		notification.fadeOut(300, function() {
			notification.remove();
		});
	}, 5000);
}

// Inicializar
function init() {
	setupAjax();
	setupSearch();
	
	// Configurar envío del formulario
	$('#paramForm').on('submit', function(e) {
		e.preventDefault();
		saveParam();
	});
	
	// Cargar datos iniciales
	loadParametrosEconomicos();
	loadItemsCobro();
	loadMaterias();
}

// Iniciar cuando el DOM esté listo
$(document).ready(function() {
	console.log('DOM listo, inicializando...');
	// Configurar pestañas
	setupTabs();
	
	// Configurar búsqueda
	setupSearch();
	
	// Cargar datos iniciales
	loadParametrosEconomicos();
	loadItemsCobro();
	loadMaterias();
	
	// Configurar eventos de formulario
	$('#paramForm').on('submit', function(e) {
		e.preventDefault();
		saveParam();
	});
});
</script>
@endpush
