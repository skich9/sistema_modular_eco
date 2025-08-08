@extends('layouts.app')

@section('content')
<!-- Menú de navegación -->
<x-navigation-menu />

<div class="container mx-auto px-4 py-6">
	<div class="flex justify-between items-center mb-6">
		<div>
			<h1 class="text-2xl font-bold text-gray-800">Parámetros Económicos</h1>
			<p class="text-sm text-gray-500">Administración de parámetros del sistema</p>
		</div>
		<button type="button" onclick="openCreateModal()" class="btn-primary">
			<i class="fas fa-plus mr-2"></i> Nuevo Parámetro
		</button>
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

	<!-- Tabla de parámetros económicos -->
	<div class="card">
		<div class="card-header flex justify-between items-center">
			<h3 class="text-lg font-medium">Lista de Parámetros</h3>
			<div class="flex space-x-2">
				<div class="relative">
					<input type="text" placeholder="Buscar parámetro..." class="form-input py-1 pl-8 pr-2 text-sm" id="searchInput">
					<div class="absolute inset-y-0 left-0 flex items-center pl-2">
						<i class="fas fa-search text-gray-400"></i>
					</div>
				</div>
			</div>
		</div>
		<div class="table-container">
			<table class="table">
				<thead>
					<tr>
						<th>Nro</th>
						<th>Nombre</th>
						<th>Valor</th>
						<th>Descripción</th>
						<th>Estado</th>
						<th>Acciones</th>
					</tr>
				</thead>
				<tbody id="parametrosTable">
				@forelse($parametros as $parametro)
				<tr class="parametro-row">
					<td>{{ $parametro->id_parametro_economico }}</td>
					<td>{{ $parametro->nombre }}</td>
					<td>{{ number_format($parametro->valor, 2) }}</td>
					<td>{{ $parametro->descripcion }}</td>
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
					<td colspan="6" class="text-center">No hay parámetros económicos registrados</td>
				</tr>
				@endforelse
			</tbody>
		</table>
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

@section('scripts')
@vite('resources/js/configuracion/parametros-economicos.js')
@endsection
