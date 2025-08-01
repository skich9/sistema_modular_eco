<!-- Navigation Header -->
<nav class="bg-white shadow-lg">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		<div class="flex justify-between h-16">
			<div class="flex items-center">
				<a href="{{ route('dashboard') }}" class="flex items-center">
					<img src="{{ asset('images/logo-ceta.png') }}" alt="Logo CETA" class="h-8 w-8 mr-3">
					<span class="text-xl font-bold text-gray-900">Sistema de Cobros CETA</span>
				</a>
			</div>
			
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

<!-- Secondary Navigation -->
<nav class="bg-blue-600 shadow-sm">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		<div class="flex space-x-8">
			@foreach ($menuItems as $item)
				<div class="relative">
					<button type="button" class="text-white hover:bg-blue-700 px-3 py-4 text-sm font-medium flex items-center transition-colors duration-200" onclick="toggleConfigMenu()">
						<i class="{{ $item['icon'] }} mr-2"></i>
						{{ $item['name'] }}
						<i class="fas fa-chevron-down ml-2 text-xs"></i>
					</button>
					
					<div id="configDropdown" class="hidden absolute left-0 mt-0 w-56 bg-white rounded-md shadow-lg py-1 z-50">
						@foreach ($item['submenu'] as $subitem)
							<a href="{{ route($subitem['route']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request()->routeIs($subitem['route']) ? 'bg-blue-50' : '' }}">
								<i class="fas {{ $subitem['icon'] }} mr-2"></i>{{ $subitem['name'] }}
							</a>
						@endforeach
					</div>
				</div>
			@endforeach
		</div>
	</div>
</nav>

@push('scripts')
<script>
	function toggleDropdown() {
		document.getElementById('userDropdown').classList.toggle('hidden');
	}
	
	function toggleConfigMenu() {
		document.getElementById('configDropdown').classList.toggle('hidden');
	}
</script>
@endpush
