@extends('layouts.app')

@section('title', 'Registro de Usuarios - Sistema de Cobros CETA')

@section('content')
<!-- Menú de navegación -->
<x-navigation-menu />

	<!-- Main Content -->
	<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
		<!-- Page Header -->
		<div class="mb-6">
			<h1 class="text-2xl font-bold text-gray-900">Registro Usuarios</h1>
		</div>

		<!-- Alerts -->
		@if(session('success'))
			<div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded alert-auto-hide">
				<div class="flex items-center">
					<i class="fas fa-check-circle mr-2"></i>
					<span>{{ session('success') }}</span>
				</div>
			</div>
		@endif

		@if(session('error'))
			<div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded alert-auto-hide">
				<div class="flex items-center">
					<i class="fas fa-exclamation-triangle mr-2"></i>
					<span>{{ session('error') }}</span>
				</div>
			</div>
		@endif

		<!-- Users Table Card -->
		<div class="bg-white shadow rounded-lg overflow-hidden">
			<!-- Table Header -->
			<div class="bg-blue-600 px-6 py-4">
				<h3 class="text-lg font-medium text-white">Lista de Usuarios</h3>
			</div>

			<!-- Controls -->
			<div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
				<div class="flex justify-between items-center">
					<div class="flex items-center space-x-4">
						<div class="flex items-center">
							<label class="text-sm text-gray-700 mr-2">Mostrando</label>
							<select id="perPage" class="border border-gray-300 rounded px-2 py-1 text-sm">
								<option value="10">10</option>
								<option value="25">25</option>
								<option value="50">50</option>
							</select>
							<span class="text-sm text-gray-700 ml-2">registros</span>
						</div>
					</div>
					
					<div class="flex items-center space-x-4">
						<div class="relative">
							<input 
								type="text" 
								id="searchInput"
								placeholder="Buscar..." 
								class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
							>
							<i class="fas fa-search absolute right-3 top-2.5 text-gray-400"></i>
						</div>
						<button 
							onclick="openCreateModal()" 
							class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-200"
						>
							<i class="fas fa-plus mr-2"></i>Añadir Usuario
						</button>
					</div>
				</div>
			</div>

			<!-- Table -->
			<div class="overflow-x-auto">
				<table class="min-w-full divide-y divide-gray-200">
					<thead class="bg-gray-50">
						<tr>
							<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
								<button class="flex items-center hover:text-gray-700">
									Usuario
									<i class="fas fa-sort ml-1"></i>
								</button>
							</th>
							<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
								<button class="flex items-center hover:text-gray-700">
									Nombre
									<i class="fas fa-sort ml-1"></i>
								</button>
							</th>
							<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
								<button class="flex items-center hover:text-gray-700">
									Rol
									<i class="fas fa-sort ml-1"></i>
								</button>
							</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
								<button class="flex items-center hover:text-gray-700">
									Cargo
									<i class="fas fa-sort ml-1"></i>
								</button>
							</th>
							<th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
								<button class="flex items-center hover:text-gray-700">
									Activo
									<i class="fas fa-sort ml-1"></i>
								</button>
							</th>
							<th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
								Editar
							</th>
						</tr>
					</thead>
					<tbody class="bg-white divide-y divide-gray-200" id="usersTableBody">
						@forelse($usuarios as $usuario)
							<tr class="hover:bg-gray-50">
								<td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
									{{ $usuario->nickname }}
								</td>
								<td class="px-6 py-4 whitespace-nowrap">
									<div class="text-sm text-blue-600 font-medium">
										{{ $usuario->nombre }} {{ $usuario->ap_paterno }} {{ $usuario->ap_materno }}
									</div>
								</td>
								<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
									{{ $usuario->rol->nombre ?? 'Sin rol' }}
								</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
									{{ $usuario->rol->descripcion ?? 'Sin descripción' }}
								</td>
								<td class="px-6 py-4 whitespace-nowrap text-center">
									<input 
										type="checkbox" 
										{{ $usuario->estado ? 'checked' : '' }}
										onchange="toggleUserStatus({{ $usuario->id_usuario }}, this.checked)"
										class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
									>
								</td>
								<td class="px-6 py-4 whitespace-nowrap text-center">
									<button 
										onclick="editUser({{ $usuario->id_usuario }})"
										class="bg-orange-500 hover:bg-orange-600 text-white px-3 py-1 rounded text-sm transition-colors duration-200"
									>
										<i class="fas fa-edit"></i>
									</button>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="6" class="px-6 py-4 text-center text-gray-500">
									No hay usuarios registrados
								</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>

			<!-- Pagination -->
			<div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
				<div class="flex items-center justify-between">
					<div class="text-sm text-gray-700">
						Mostrando de 1 al {{ $usuarios->count() }} de {{ $usuarios->count() }} registros
					</div>
					<div class="flex space-x-1">
						<button class="px-3 py-1 text-sm border border-gray-300 rounded hover:bg-gray-100">Primero</button>
						<button class="px-3 py-1 text-sm border border-gray-300 rounded hover:bg-gray-100">Anterior</button>
						<button class="px-3 py-1 text-sm bg-blue-600 text-white border border-blue-600 rounded">1</button>
						<button class="px-3 py-1 text-sm border border-gray-300 rounded hover:bg-gray-100">Siguiente</button>
						<button class="px-3 py-1 text-sm border border-gray-300 rounded hover:bg-gray-100">Último</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal para Crear/Editar Usuario -->
<div id="userModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
	<div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
		<div class="mt-3">
			<h3 class="text-lg font-medium text-gray-900 mb-4" id="modalTitle">Crear Usuario</h3>
			
			<form id="userForm" method="POST">
				@csrf
				<div id="methodField"></div>
				
				<div class="space-y-4">
					<div>
						<label class="block text-sm font-medium text-gray-700 mb-1">Usuario</label>
						<input type="text" name="nickname" id="nickname" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
					</div>
					
					<div>
						<label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
						<input type="text" name="nombre" id="nombre" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
					</div>
					
					<div>
						<label class="block text-sm font-medium text-gray-700 mb-1">Apellido Paterno</label>
						<input type="text" name="ap_paterno" id="ap_paterno" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
					</div>
					
					<div>
						<label class="block text-sm font-medium text-gray-700 mb-1">Apellido Materno</label>
						<input type="text" name="ap_materno" id="ap_materno" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
					</div>
					
					<div>
						<label class="block text-sm font-medium text-gray-700 mb-1">CI</label>
						<input type="text" name="ci" id="ci" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
					</div>
					
					<div id="passwordField">
						<label class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
						<input type="password" name="contrasenia" id="contrasenia" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
					</div>
					
					<div>
						<label class="block text-sm font-medium text-gray-700 mb-1">Rol</label>
						<select name="id_rol" id="id_rol" required class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
							<option value="">Seleccione un rol</option>
							@foreach($roles as $rol)
								<option value="{{ $rol->id_rol }}">{{ $rol->nombre }}</option>
							@endforeach
						</select>
					</div>
					
					<div class="flex items-center">
						<input type="checkbox" name="estado" id="estado" value="1" checked class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
						<label for="estado" class="ml-2 block text-sm text-gray-700">Usuario Activo</label>
					</div>
				</div>
				
				<div class="flex justify-end space-x-3 mt-6">
					<button type="button" onclick="closeModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300">
						Cancelar
					</button>
					<button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
						Guardar
					</button>
				</div>
			</form>
		</div>
	</div>
</div>

@push('scripts')
<script>
	let isEditing = false;
	let editingUserId = null;

	function toggleDropdown() {
		const dropdown = document.getElementById('userDropdown');
		dropdown.classList.toggle('hidden');
	}

	function toggleConfigMenu() {
		const dropdown = document.getElementById('configDropdown');
		dropdown.classList.toggle('hidden');
	}

	function openCreateModal() {
		isEditing = false;
		document.getElementById('modalTitle').textContent = 'Crear Usuario';
		document.getElementById('userForm').action = '{{ route("usuarios.store") }}';
		document.getElementById('methodField').innerHTML = '';
		document.getElementById('passwordField').style.display = 'block';
		document.getElementById('contrasenia').required = true;
		
		// Limpiar formulario
		document.getElementById('userForm').reset();
		document.getElementById('estado').checked = true;
		
		document.getElementById('userModal').classList.remove('hidden');
	}

	function editUser(userId) {
		isEditing = true;
		editingUserId = userId;
		document.getElementById('modalTitle').textContent = 'Editar Usuario';
		document.getElementById('userForm').action = `/usuarios/${userId}`;
		document.getElementById('methodField').innerHTML = '@method("PUT")';
		document.getElementById('passwordField').style.display = 'none';
		document.getElementById('contrasenia').required = false;
		
		// Aquí cargarías los datos del usuario via AJAX
		// Por simplicidad, lo omito por ahora
		
		document.getElementById('userModal').classList.remove('hidden');
	}

	function closeModal() {
		document.getElementById('userModal').classList.add('hidden');
	}

	function toggleUserStatus(userId, status) {
		fetch(`/usuarios/${userId}/estado`, {
			method: 'PATCH',
			headers: {
				'Content-Type': 'application/json',
				'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
			},
			body: JSON.stringify({ estado: status })
		})
		.then(response => response.json())
		.then(data => {
			if (!data.success) {
				alert('Error al cambiar el estado del usuario');
				// Revertir checkbox
				event.target.checked = !status;
			}
		})
		.catch(error => {
			console.error('Error:', error);
			alert('Error al cambiar el estado del usuario');
			event.target.checked = !status;
		});
	}

	// Close dropdowns when clicking outside
	document.addEventListener('click', function(event) {
		const userDropdown = document.getElementById('userDropdown');
		const configDropdown = document.getElementById('configDropdown');
		const modal = document.getElementById('userModal');
		const button = event.target.closest('button');
		
		if (!button || (!button.onclick && !button.getAttribute('onclick'))) {
			userDropdown.classList.add('hidden');
			configDropdown.classList.add('hidden');
		}
		
		// Close modal when clicking outside
		if (event.target === modal) {
			closeModal();
		}
	});
</script>
@endpush
@endsection
