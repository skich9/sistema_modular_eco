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
									<button type="button" class="btn-icon btn-warning" title="Editar">
										<i class="fas fa-edit"></i>
									</button>
									<button type="button" class="btn-icon btn-danger" title="Eliminar">
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
									<button type="button" class="btn-icon btn-warning" title="Editar">
										<i class="fas fa-edit"></i>
									</button>
									<button type="button" class="btn-icon btn-danger" title="Eliminar">
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
									<button type="button" class="btn-icon btn-warning" title="Editar">
										<i class="fas fa-edit"></i>
									</button>
									<button type="button" class="btn-icon btn-danger" title="Eliminar">
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
									<button type="button" class="btn-icon btn-warning" title="Editar">
										<i class="fas fa-edit"></i>
									</button>
									<button type="button" class="btn-icon btn-danger" title="Eliminar">
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
									<button type="button" class="btn-icon btn-warning" title="Editar">
										<i class="fas fa-edit"></i>
									</button>
									<button type="button" class="btn-icon btn-danger" title="Eliminar">
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
									<button type="button" class="btn-icon btn-warning" title="Editar">
										<i class="fas fa-edit"></i>
									</button>
									<button type="button" class="btn-icon btn-danger" title="Eliminar">
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
									<button type="button" class="btn-icon btn-warning" title="Editar">
										<i class="fas fa-edit"></i>
									</button>
									<button type="button" class="btn-icon btn-danger" title="Eliminar">
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
<!-- Script externo de parámetros económicos con Vite -->
@vite('resources/js/configuracion/parametros-economicos.js')
@endpush
