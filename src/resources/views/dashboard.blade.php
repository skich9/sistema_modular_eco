@extends('layouts.app')

@section('title', 'Dashboard - Sistema de Cobros CETA')

@section('content')
<div class="min-h-screen bg-gray-50">
	<!-- Navigation Header -->
	<nav class="bg-white shadow-lg">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
			<div class="flex justify-between h-16">
				<div class="flex items-center">
					<!-- Logo -->
					<div class="flex-shrink-0 flex items-center">
						<img src="{{ asset('images/logo-ceta.png') }}" alt="Logo CETA" class="h-8 w-8 mr-3">
						<span class="text-xl font-bold text-gray-900">Sistema de Cobros CETA</span>
					</div>
				</div>
				
				<!-- User Menu -->
				<div class="flex items-center space-x-4">
					<div class="text-sm text-gray-700">
						<span class="font-medium">{{ $usuario['nombre_completo'] }}</span>
						<span class="text-gray-500">({{ $usuario['rol_nombre'] }})</span>
					</div>
					
					<div class="relative">
						<button 
							type="button" 
							class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
							onclick="toggleDropdown()"
						>
							<div class="h-8 w-8 bg-blue-600 rounded-full flex items-center justify-center text-white font-medium">
								{{ substr($usuario['nombre_completo'], 0, 1) }}
							</div>
						</button>
						
						<!-- Dropdown Menu -->
						<div id="userDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
							<a href="{{ route('change-password') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
								<i class="fas fa-key mr-2"></i>Cambiar Contraseña
							</a>
							<a href="{{ route('logout') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
								<i class="fas fa-sign-out-alt mr-2"></i>Cerrar Sesión
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</nav>

	<!-- Menu de Navegación -->
	<nav class="bg-blue-600 shadow-sm">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
			<div class="flex space-x-8">
				<!-- Menu Configuración -->
				<div class="relative">
					<button 
						type="button" 
						class="text-white hover:bg-blue-700 px-3 py-4 text-sm font-medium flex items-center transition-colors duration-200"
						onclick="toggleConfigMenu()"
					>
						<i class="fas fa-cog mr-2"></i>
						Configuración
						<i class="fas fa-chevron-down ml-2 text-xs"></i>
					</button>
					
					<!-- Dropdown Configuración -->
					<div id="configDropdown" class="hidden absolute left-0 mt-0 w-56 bg-white rounded-md shadow-lg py-1 z-50">
						<a href="{{ route('usuarios.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
							<i class="fas fa-users mr-2"></i>Registro de Usuarios
						</a>
						<a href="{{ route('roles.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
							<i class="fas fa-user-tag mr-2"></i>Gestión de Roles
						</a>
						<a href="{{ route('funciones.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
							<i class="fas fa-tasks mr-2"></i>Gestión de Funciones
						</a>
					</div>
				</div>
			</div>
		</div>
	</nav>

	<!-- Main Content -->
	<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
		<!-- Welcome Message -->
		@if(session('success'))
			<div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded alert-auto-hide">
				<div class="flex items-center">
					<i class="fas fa-check-circle mr-2"></i>
					<span>{{ session('success') }}</span>
				</div>
			</div>
		@endif

		<!-- Page Header -->
		<div class="mb-8">
			<h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
			<p class="mt-2 text-gray-600">Bienvenido al Sistema de Cobros del Instituto Tecnológico CETA</p>
		</div>

		<!-- Stats Cards -->
		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
			<div class="bg-white overflow-hidden shadow rounded-lg">
				<div class="p-5">
					<div class="flex items-center">
						<div class="flex-shrink-0">
							<i class="fas fa-users text-2xl text-blue-600"></i>
						</div>
						<div class="ml-5 w-0 flex-1">
							<dl>
								<dt class="text-sm font-medium text-gray-500 truncate">Total Usuarios</dt>
								<dd class="text-lg font-medium text-gray-900">{{ $usuarioCompleto->count() ?? 0 }}</dd>
							</dl>
						</div>
					</div>
				</div>
			</div>

			<div class="bg-white overflow-hidden shadow rounded-lg">
				<div class="p-5">
					<div class="flex items-center">
						<div class="flex-shrink-0">
							<i class="fas fa-user-tag text-2xl text-green-600"></i>
						</div>
						<div class="ml-5 w-0 flex-1">
							<dl>
								<dt class="text-sm font-medium text-gray-500 truncate">Mi Rol</dt>
								<dd class="text-lg font-medium text-gray-900">{{ $usuario['rol_nombre'] }}</dd>
							</dl>
						</div>
					</div>
				</div>
			</div>

			<div class="bg-white overflow-hidden shadow rounded-lg">
				<div class="p-5">
					<div class="flex items-center">
						<div class="flex-shrink-0">
							<i class="fas fa-tasks text-2xl text-yellow-600"></i>
						</div>
						<div class="ml-5 w-0 flex-1">
							<dl>
								<dt class="text-sm font-medium text-gray-500 truncate">Mis Funciones</dt>
								<dd class="text-lg font-medium text-gray-900">{{ $usuarioCompleto->funciones->count() ?? 0 }}</dd>
							</dl>
						</div>
					</div>
				</div>
			</div>

			<div class="bg-white overflow-hidden shadow rounded-lg">
				<div class="p-5">
					<div class="flex items-center">
						<div class="flex-shrink-0">
							<i class="fas fa-clock text-2xl text-purple-600"></i>
						</div>
						<div class="ml-5 w-0 flex-1">
							<dl>
								<dt class="text-sm font-medium text-gray-500 truncate">Último Acceso</dt>
								<dd class="text-lg font-medium text-gray-900">{{ now()->format('H:i') }}</dd>
							</dl>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Quick Actions -->
		<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
			<!-- User Info Card -->
			<div class="bg-white shadow rounded-lg">
				<div class="px-4 py-5 sm:p-6">
					<h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
						<i class="fas fa-user mr-2"></i>Información Personal
					</h3>
					<div class="space-y-3">
						<div class="flex justify-between">
							<span class="text-sm font-medium text-gray-500">Nombre:</span>
							<span class="text-sm text-gray-900">{{ $usuario['nombre_completo'] }}</span>
						</div>
						<div class="flex justify-between">
							<span class="text-sm font-medium text-gray-500">Usuario:</span>
							<span class="text-sm text-gray-900">{{ $usuario['nickname'] }}</span>
						</div>
						<div class="flex justify-between">
							<span class="text-sm font-medium text-gray-500">CI:</span>
							<span class="text-sm text-gray-900">{{ $usuario['ci'] }}</span>
						</div>
						<div class="flex justify-between">
							<span class="text-sm font-medium text-gray-500">Rol:</span>
							<span class="text-sm text-gray-900">{{ $usuario['rol_nombre'] }}</span>
						</div>
					</div>
				</div>
			</div>

			<!-- Functions Card -->
			<div class="bg-white shadow rounded-lg">
				<div class="px-4 py-5 sm:p-6">
					<h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
						<i class="fas fa-tasks mr-2"></i>Mis Funciones Asignadas
					</h3>
					@if($usuarioCompleto->funciones && $usuarioCompleto->funciones->count() > 0)
						<div class="space-y-2">
							@foreach($usuarioCompleto->funciones as $funcion)
								<div class="flex items-center justify-between p-2 bg-gray-50 rounded">
									<span class="text-sm font-medium text-gray-900">{{ $funcion->nombre }}</span>
									<span class="text-xs text-gray-500">
										@if($funcion->pivot->fecha_fin)
											Finalizada
										@else
											Activa
										@endif
									</span>
								</div>
							@endforeach
						</div>
					@else
						<p class="text-sm text-gray-500">No tienes funciones asignadas actualmente.</p>
					@endif
				</div>
			</div>
		</div>

		<!-- Quick Access Menu -->
		<div class="mt-8">
			<h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Acceso Rápido</h3>
			<div class="grid grid-cols-2 md:grid-cols-4 gap-4">
				<a href="#" class="bg-white p-4 rounded-lg shadow hover:shadow-md transition-shadow duration-200 text-center">
					<i class="fas fa-users text-2xl text-blue-600 mb-2"></i>
					<p class="text-sm font-medium text-gray-900">Usuarios</p>
				</a>
				<a href="#" class="bg-white p-4 rounded-lg shadow hover:shadow-md transition-shadow duration-200 text-center">
					<i class="fas fa-user-tag text-2xl text-green-600 mb-2"></i>
					<p class="text-sm font-medium text-gray-900">Roles</p>
				</a>
				<a href="#" class="bg-white p-4 rounded-lg shadow hover:shadow-md transition-shadow duration-200 text-center">
					<i class="fas fa-tasks text-2xl text-yellow-600 mb-2"></i>
					<p class="text-sm font-medium text-gray-900">Funciones</p>
				</a>
				<a href="#" class="bg-white p-4 rounded-lg shadow hover:shadow-md transition-shadow duration-200 text-center">
					<i class="fas fa-chart-bar text-2xl text-purple-600 mb-2"></i>
					<p class="text-sm font-medium text-gray-900">Reportes</p>
				</a>
			</div>
		</div>
	</div>
</div>

@push('scripts')
<script>
	function toggleDropdown() {
		const dropdown = document.getElementById('userDropdown');
		dropdown.classList.toggle('hidden');
	}

	function toggleConfigMenu() {
		const dropdown = document.getElementById('configDropdown');
		dropdown.classList.toggle('hidden');
	}

	// Close dropdowns when clicking outside
	document.addEventListener('click', function(event) {
		const userDropdown = document.getElementById('userDropdown');
		const configDropdown = document.getElementById('configDropdown');
		const button = event.target.closest('button');
		
		if (!button || (!button.onclick && !button.getAttribute('onclick'))) {
			userDropdown.classList.add('hidden');
			configDropdown.classList.add('hidden');
		}
	});
</script>
@endpush
@endsection
