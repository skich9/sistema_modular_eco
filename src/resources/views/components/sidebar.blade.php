{{-- Sidebar Component - Menú lateral reutilizable --}}
<div class="bg-white shadow-lg h-full min-h-screen w-64 fixed left-0 top-0 z-40 transform transition-transform duration-300 ease-in-out" id="sidebar">
    {{-- Header del Sidebar --}}
    <div class="flex items-center justify-center h-16 bg-gradient-to-r from-blue-600 to-blue-800 text-white">
        <div class="flex items-center">
            <i class="fas fa-building text-2xl mr-3"></i>
            <span class="text-lg font-bold">Sistema CETA</span>
        </div>
    </div>

    {{-- Información del Usuario --}}
    <div class="p-4 border-b border-gray-200">
        <div class="flex items-center">
            <div class="h-10 w-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-medium">
                {{ substr(session('usuario')['nombre_completo'] ?? 'U', 0, 1) }}
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-900">{{ session('usuario')['nombre_completo'] ?? 'Usuario' }}</p>
                <p class="text-xs text-gray-500">{{ session('usuario')['rol_nombre'] ?? 'Sin rol' }}</p>
            </div>
        </div>
    </div>

    {{-- Navegación Principal --}}
    <nav class="mt-4">
        <div class="px-2">
            {{-- Dashboard --}}
            <a href="{{ route('dashboard') }}" 
               class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('dashboard') ? 'bg-blue-100 text-blue-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} transition-colors duration-200">
                <i class="fas fa-tachometer-alt mr-3 text-lg {{ request()->routeIs('dashboard') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-500' }}"></i>
                Dashboard
            </a>

            {{-- Gestión de Usuarios --}}
            @if(in_array('gestionar_usuarios', session('usuario')['funciones'] ?? []) || session('usuario')['rol_nombre'] === 'Administrador')
            <a href="{{ route('usuarios.index') }}" 
               class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('usuarios.*') ? 'bg-blue-100 text-blue-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} transition-colors duration-200">
                <i class="fas fa-users mr-3 text-lg {{ request()->routeIs('usuarios.*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-500' }}"></i>
                Usuarios
            </a>
            @endif

            {{-- Gestión de Roles --}}
            @if(in_array('gestionar_roles', session('usuario')['funciones'] ?? []) || session('usuario')['rol_nombre'] === 'Administrador')
            <a href="{{ route('roles.index') }}" 
               class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('roles.*') ? 'bg-blue-100 text-blue-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} transition-colors duration-200">
                <i class="fas fa-user-tag mr-3 text-lg {{ request()->routeIs('roles.*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-500' }}"></i>
                Roles
            </a>
            @endif

            {{-- Gestión de Funciones --}}
            @if(in_array('gestionar_funciones', session('usuario')['funciones'] ?? []) || session('usuario')['rol_nombre'] === 'Administrador')
            <a href="{{ route('funciones.index') }}" 
               class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('funciones.*') ? 'bg-blue-100 text-blue-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }} transition-colors duration-200">
                <i class="fas fa-cogs mr-3 text-lg {{ request()->routeIs('funciones.*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-gray-500' }}"></i>
                Funciones
            </a>
            @endif

            {{-- Separador --}}
            <div class="border-t border-gray-200 my-4"></div>

            {{-- Reportes --}}
            @if(in_array('ver_reportes', session('usuario')['funciones'] ?? []) || session('usuario')['rol_nombre'] === 'Administrador')
            <a href="#" 
               class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors duration-200">
                <i class="fas fa-chart-bar mr-3 text-lg text-gray-400 group-hover:text-gray-500"></i>
                Reportes
            </a>
            @endif

            {{-- Configuración --}}
            @if(in_array('configurar_sistema', session('usuario')['funciones'] ?? []) || session('usuario')['rol_nombre'] === 'Administrador')
            <a href="#" 
               class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors duration-200">
                <i class="fas fa-cog mr-3 text-lg text-gray-400 group-hover:text-gray-500"></i>
                Configuración
            </a>
            @endif
        </div>
    </nav>

    {{-- Footer del Sidebar --}}
    <div class="absolute bottom-0 w-full p-4 border-t border-gray-200">
        <div class="flex flex-col space-y-2">
            <a href="{{ route('change-password') }}" 
               class="flex items-center px-2 py-2 text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-md transition-colors duration-200">
                <i class="fas fa-key mr-3 text-gray-400"></i>
                Cambiar Contraseña
            </a>
            <a href="{{ route('logout') }}" 
               class="flex items-center px-2 py-2 text-sm text-red-600 hover:text-red-900 hover:bg-red-50 rounded-md transition-colors duration-200">
                <i class="fas fa-sign-out-alt mr-3 text-red-400"></i>
                Cerrar Sesión
            </a>
        </div>
    </div>
</div>

{{-- Overlay para móvil --}}
<div class="fixed inset-0 bg-gray-600 bg-opacity-75 z-30 lg:hidden" id="sidebar-overlay" onclick="toggleSidebar()" style="display: none;"></div>

{{-- Script para toggle del sidebar en móvil --}}
<script>
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    
    if (sidebar.classList.contains('-translate-x-full')) {
        sidebar.classList.remove('-translate-x-full');
        overlay.style.display = 'block';
    } else {
        sidebar.classList.add('-translate-x-full');
        overlay.style.display = 'none';
    }
}

// Cerrar sidebar en móvil cuando se hace clic en un enlace
document.addEventListener('DOMContentLoaded', function() {
    const sidebarLinks = document.querySelectorAll('#sidebar a');
    sidebarLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth < 1024) {
                toggleSidebar();
            }
        });
    });
});
</script>
