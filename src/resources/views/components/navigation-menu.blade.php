<!-- Navigation Header -->
<nav class="nav-menu shadow-lg">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		<div class="flex justify-between h-16">
			<div class="flex items-center">
				<a href="{{ route('dashboard') }}" class="flex items-center">
					<img src="{{ asset('images/logo-ceta.png') }}" alt="Logo CETA" class="h-8 w-8 mr-2">
					<span class="text-xl font-bold text-dark-color">Sistema de Cobros CETA</span>
				</a>
			</div>

			<div class="flex items-center space-x-4">
				<div class="text-sm">
					<span class="font-bold">{{ $usuario['nombre_completo'] }}</span>
					<span class="text-secondary-color">({{ $usuario['rol_nombre'] }})</span>
				</div>
				
				<div class="relative">
					<button 
						type="button" 
						class="flex items-center text-sm rounded-full focus:outline-none"
						onclick="toggleDropdown()"
					>
						<div class="h-8 w-8 rounded-full flex items-center justify-center text-white font-medium" style="background-color: var(--primary-color);">
							{{ substr($usuario['nombre_completo'], 0, 1) }}
						</div>
					</button>
					
					<div id="userDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded shadow py-1 z-50">
						<a href="{{ route('change-password') }}" class="block px-4 py-2 text-sm hover:bg-light-color">
							<i class="fas fa-key mr-2"></i>Cambiar Contraseña
						</a>
						<a href="{{ route('logout') }}" class="block px-4 py-2 text-sm hover:bg-light-color">
							<i class="fas fa-sign-out-alt mr-2"></i>Cerrar Sesión
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</nav>

<!-- Secondary Navigation -->
<nav class="nav-menu-secondary shadow-sm">
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		<div class="flex space-x-8">
			@foreach ($menuItems as $item)
				<div class="relative">
					<button type="button" class="text-white hover:bg-primary-dark px-3 py-4 text-sm font-medium flex items-center transition-colors duration-200" onclick="toggleConfigMenu('{{ $loop->index }}')">
						<i class="{{ $item['icon'] }} mr-2"></i>
						{{ $item['name'] }}
						<i class="fas fa-chevron-down ml-2 text-xs"></i>
					</button>
					
					<div id="configDropdown{{ $loop->index }}" class="hidden absolute left-0 mt-0 w-56 bg-white rounded shadow py-1 z-50">
						@foreach ($item['submenu'] as $subitem)
							<a href="{{ route($subitem['route']) }}" class="block px-4 py-2 text-sm hover:bg-light-color {{ request()->routeIs($subitem['route']) ? 'bg-light-color text-primary-color' : '' }}">
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
		const dropdown = document.getElementById('userDropdown');
		
		// Cerrar todos los menús de configuración primero
		closeAllConfigMenus();
		
		// Toggle del dropdown de usuario
		if (dropdown.classList.contains('hidden')) {
			dropdown.classList.remove('hidden');
			dropdown.classList.add('show');
			
			// Agregar clase activa al botón
			const button = document.querySelector('button[onclick="toggleDropdown()"]');
			button.classList.add('active');
		} else {
			dropdown.classList.add('hidden');
			dropdown.classList.remove('show');
			
			// Quitar clase activa del botón
			const button = document.querySelector('button[onclick="toggleDropdown()"]');
			button.classList.remove('active');
		}
	}
	
	function toggleConfigMenu(index) {
		const dropdown = document.getElementById('configDropdown' + index);
		const allDropdowns = document.querySelectorAll('[id^="configDropdown"]');
		
		// Cerrar el dropdown de usuario primero
		document.getElementById('userDropdown').classList.add('hidden');
		document.getElementById('userDropdown').classList.remove('show');
		
		// Cerrar todos los demás menús de configuración
		allDropdowns.forEach(function(menu) {
			if (menu.id !== 'configDropdown' + index) {
				menu.classList.add('hidden');
				menu.classList.remove('show');
			}
		});
		
		// Toggle del dropdown actual
		if (dropdown.classList.contains('hidden')) {
			dropdown.classList.remove('hidden');
			dropdown.classList.add('show');
			
			// Agregar clase activa al botón
			const button = document.querySelector(`button[onclick="toggleConfigMenu('${index}')"]`);
			button.classList.add('active');
		} else {
			dropdown.classList.add('hidden');
			dropdown.classList.remove('show');
			
			// Quitar clase activa del botón
			const button = document.querySelector(`button[onclick="toggleConfigMenu('${index}')"]`);
			button.classList.remove('active');
		}
	}
	
	function closeAllConfigMenus() {
		// Cerrar todos los menús de configuración
		const configDropdowns = document.querySelectorAll('[id^="configDropdown"]');
		configDropdowns.forEach(function(dropdown) {
			dropdown.classList.add('hidden');
			dropdown.classList.remove('show');
		});
		
		// Quitar clase activa de todos los botones
		const configButtons = document.querySelectorAll('button[onclick^="toggleConfigMenu"]');
		configButtons.forEach(function(button) {
			button.classList.remove('active');
		});
	}

	// Cerrar dropdowns al hacer clic fuera de ellos
	document.addEventListener('click', function(event) {
		const userDropdown = document.getElementById('userDropdown');
		const userButton = document.querySelector('button[onclick="toggleDropdown()"]');
		
		// Si el clic no fue en el botón de usuario ni en su dropdown
		if (!userButton.contains(event.target) && !userDropdown.contains(event.target)) {
			userDropdown.classList.add('hidden');
			userDropdown.classList.remove('show');
			userButton.classList.remove('active');
		}
		
		// Si el clic no fue en ningún botón de menú de configuración
		if (!event.target.closest('button[onclick^="toggleConfigMenu"]')) {
			// Cerrar todos los menús de configuración
			const configDropdowns = document.querySelectorAll('[id^="configDropdown"]');
			configDropdowns.forEach(function(dropdown) {
				if (!dropdown.contains(event.target)) {
					dropdown.classList.add('hidden');
					dropdown.classList.remove('show');
				}
			});
			
			// Quitar clase activa de todos los botones
			const configButtons = document.querySelectorAll('button[onclick^="toggleConfigMenu"]');
			configButtons.forEach(function(button) {
				button.classList.remove('active');
			});
		}
	});
	
	// Inicialización cuando el DOM está listo
	document.addEventListener('DOMContentLoaded', function() {
		// Asegurar que todos los dropdowns estén ocultos inicialmente
		const allDropdowns = document.querySelectorAll('#userDropdown, [id^="configDropdown"]');
		allDropdowns.forEach(function(dropdown) {
			dropdown.classList.add('hidden');
			dropdown.classList.remove('show');
		});
	});
</script>
@endpush
