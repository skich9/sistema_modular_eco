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
			<i class="fas fa-cog"></i> Parámetros del Sistema
		</a>
		<a href="#economicos" class="tab-button" data-tab="economicos">
			<i class="fas fa-money-bill"></i> Parámetros Económicos
		</a>
		<a href="#items" class="tab-button" data-tab="items">
			<i class="fas fa-list"></i> Items de Cobro
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
							<th>N°</th>
							<th>Concepto</th>
							<th>Monto</th>
							<th>Tipo</th>
							<th>Categoría</th>
							<th>Estado</th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody id="itemsCobroTable">
						<!-- Datos de ejemplo para la vista previa -->
						<tr class="item-row">
							<td>1</td>
							<td>Matrícula Semestral</td>
							<td><span class="currency-value">350.00</span></td>
							<td>Fijo</td>
							<td><span class="category-tag mensualidades">Mensualidades</span></td>
							<td><span class="badge badge-success">Activo</span></td>
							<td>
								<div class="action-buttons">
									<button type="button" onclick="openEditModalItem(1)" class="btn-icon btn-warning" title="Editar">
										<i class="fas fa-edit"></i>
									</button>
									<button type="button" onclick="confirmDelete(1)" class="btn-icon btn-danger" title="Eliminar">
										<i class="fas fa-trash-alt"></i>
									</button>
								</div>
							</td>
						</tr>
						<tr class="item-row">
							<td>2</td>
							<td>Examen de Recuperación</td>
							<td><span class="currency-value">75.00</span></td>
							<td>Fijo</td>
							<td><span class="category-tag examenes">Exámenes</span></td>
							<td><span class="badge badge-success">Activo</span></td>
							<td>
								<div class="action-buttons">
									<button type="button" onclick="openEditModalItem(2)" class="btn-icon btn-warning" title="Editar">
										<i class="fas fa-edit"></i>
									</button>
									<button type="button" onclick="confirmDelete(2)" class="btn-icon btn-danger" title="Eliminar">
										<i class="fas fa-trash-alt"></i>
									</button>
								</div>
							</td>
						</tr>
						<tr class="item-row">
							<td>3</td>
							<td>Certificado de Notas</td>
							<td><span class="currency-value">25.00</span></td>
							<td>Fijo</td>
							<td><span class="category-tag certificados">Certificados</span></td>
							<td><span class="badge badge-success">Activo</span></td>
							<td>
								<div class="action-buttons">
									<button type="button" onclick="openEditModalItem(3)" class="btn-icon btn-warning" title="Editar">
										<i class="fas fa-edit"></i>
									</button>
									<button type="button" onclick="confirmDelete(3)" class="btn-icon btn-danger" title="Eliminar">
										<i class="fas fa-trash-alt"></i>
									</button>
								</div>
							</td>
						</tr>
						<tr class="item-row">
							<td>4</td>
							<td>Recargo por Mora</td>
							<td><span class="currency-value">5.00%</span></td>
							<td>Porcentaje</td>
							<td><span class="category-tag intereses">Intereses</span></td>
							<td><span class="badge badge-success">Activo</span></td>
							<td>
								<div class="action-buttons">
									<button type="button" onclick="openEditModalItem(4)" class="btn-icon btn-warning" title="Editar">
										<i class="fas fa-edit"></i>
									</button>
									<button type="button" onclick="confirmDelete(4)" class="btn-icon btn-danger" title="Eliminar">
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
							<label for="concepto" class="form-label">Concepto</label>
							<input type="text" id="concepto" name="concepto" class="form-input" required>
						</div>
						<div class="form-group">
							<label for="monto" class="form-label">Monto</label>
							<input type="number" id="monto" name="monto" step="0.01" min="0" class="form-input" required>
						</div>
						<div class="form-group">
							<label for="tipo_item" class="form-label">Tipo</label>
							<select id="tipo_item" name="tipo_item" class="form-input">
								<option value="Fijo">Fijo</option>
								<option value="Porcentaje">Porcentaje</option>
							</select>
						</div>
						<div class="form-group">
							<label for="categoria" class="form-label">Categoría</label>
							<select id="categoria" name="categoria" class="form-input">
								<option value="mensualidades">Mensualidades</option>
								<option value="examenes">Exámenes</option>
								<option value="certificados">Certificados</option>
								<option value="intereses">Intereses</option>
							</select>
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
<script>
console.log('Script local de parámetros económicos cargado');

// Variables globales
let deleteId = null;

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
		}
	} else {
		// Cerrar todos los modales
		document.querySelectorAll('.modal-backdrop').forEach(modal => {
			modal.classList.add('hidden');
		});
	}
}

function closeDeleteModal() {
	console.log('Cerrando modal de eliminación');
	closeModal('deleteModal');
	deleteId = null;
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

// Función para mostrar campos según tipo de parámetro
function showFieldsForType(tipo) {
	console.log('Mostrando campos para tipo:', tipo);
	
	// Ocultar todos los grupos de campos
	const camposEconomicos = document.getElementById('campos-economicos');
	const camposSistema = document.getElementById('campos-sistema');
	const camposItems = document.getElementById('campos-items');
	
	if (camposEconomicos) camposEconomicos.classList.add('hidden');
	if (camposSistema) camposSistema.classList.add('hidden');
	if (camposItems) camposItems.classList.add('hidden');
	
	// Mostrar solo el grupo correspondiente
	switch(tipo) {
		case 'sistema':
			if (camposSistema) camposSistema.classList.remove('hidden');
			break;
		case 'item':
			if (camposItems) camposItems.classList.remove('hidden');
			break;
		case 'economico':
		default:
			if (camposEconomicos) camposEconomicos.classList.remove('hidden');
			break;
	}
}

// Funciones principales para botones
function openCreateModal(tipo = 'economico') {
	console.log('Abriendo modal de creación para tipo:', tipo);
	let titulo = 'Crear Parámetro Económico';
	switch(tipo) {
		case 'sistema':
			titulo = 'Crear Parámetro del Sistema';
			break;
		case 'item':
			titulo = 'Crear Item de Cobro';
			break;
	}
	
	const modalTitle = document.getElementById('modal-title');
	const paramForm = document.getElementById('paramForm');
	const paramId = document.getElementById('param_id');
	const paramTipo = document.getElementById('param_tipo');
	
	if (modalTitle) modalTitle.textContent = titulo;
	if (paramForm) paramForm.reset();
	if (paramId) paramId.value = '';
	if (paramTipo) paramTipo.value = tipo;
	
	// Mostrar campos apropiados para el tipo
	showFieldsForType(tipo);
	
	openModal('paramModal');
}

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
	
	// Para items de cobro, usar datos estáticos por ahora
	// TODO: Implementar API específica para items de cobro
	const datosEjemplo = {
		1: { concepto: 'Matrícula Semestral', monto: '350.00', tipo_item: 'Fijo', categoria: 'mensualidades', estado: true },
		2: { concepto: 'Examen de Recuperación', monto: '75.00', tipo_item: 'Fijo', categoria: 'examenes', estado: true },
		3: { concepto: 'Certificado de Notas', monto: '25.00', tipo_item: 'Fijo', categoria: 'certificados', estado: true },
		4: { concepto: 'Recargo por Mora', monto: '5.00', tipo_item: 'Porcentaje', categoria: 'intereses', estado: true }
	};
	
	const parametro = datosEjemplo[id];
	if (parametro) {
		const concepto = document.getElementById('concepto');
		const monto = document.getElementById('monto');
		const tipoItem = document.getElementById('tipo_item');
		const categoria = document.getElementById('categoria');
		const estado = document.getElementById('estado');
		
		if (concepto) concepto.value = parametro.concepto || '';
		if (monto) monto.value = parametro.monto || '';
		if (tipoItem) tipoItem.value = parametro.tipo_item || 'Fijo';
		if (categoria) categoria.value = parametro.categoria || 'mensualidades';
		if (estado) estado.value = parametro.estado ? '1' : '0';
		
		openModal('paramModal');
	} else {
		showAlert('Item de cobro no encontrado', 'danger');
	}
}

// Función genérica (mantener para compatibilidad)
function openEditModal(id) {
	console.log('Usando función genérica openEditModal para ID:', id);
	// Por defecto, usar la función de parámetros económicos
	openEditModalEconomico(id);
}

function confirmDelete(id) {
	console.log('Confirmando eliminación para ID:', id);
	deleteId = id;
	openModal('deleteModal');
}

function executeDelete() {
	console.log('Ejecutando eliminación para ID:', deleteId);
	if (!deleteId) {
		showAlert('No hay elemento seleccionado para eliminar', 'danger');
		return;
	}
	
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
			console.log('Respuesta de eliminación:', data);
			if (data.success) {
				closeDeleteModal();
				window.location.reload();
			} else {
				showAlert('Error al eliminar el parámetro económico: ' + (data.message || 'Error desconocido'), 'danger');
			}
		})
		.catch(error => {
			console.error('Error:', error);
			showAlert('Error al eliminar el parámetro económico: ' + error.message, 'danger');
		});
	} catch (error) {
		showAlert(error.message, 'danger');
	}
}

function toggleStatus(id) {
	console.log('Cambiando estado para ID:', id);
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
			console.log('Respuesta de cambio de estado:', data);
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

// Configuración de búsqueda
function setupSearch() {
	console.log('Configurando búsqueda');
	const searchConfigs = [
		{ inputId: 'searchSistemaInput', tableId: 'parametrosSistemaTable' },
		{ inputId: 'searchEconomicosInput', tableId: 'parametrosEconomicosTable' },
		{ inputId: 'searchItemsInput', tableId: 'itemsCobroTable' }
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

// Inicialización
function init() {
	console.log('Inicializando script local');
	setupTabs();
	setupSearch();
	console.log('Script local inicializado correctamente');
}

// Ejecutar cuando el DOM esté listo
if (document.readyState === 'loading') {
	document.addEventListener('DOMContentLoaded', init);
} else {
	init();
}
</script>
@endpush
