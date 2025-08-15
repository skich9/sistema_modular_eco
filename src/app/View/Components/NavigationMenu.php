<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;

class NavigationMenu extends Component
{
    public $usuario;
    public $menuItems;

    public function __construct($usuario = null)
    {
        $this->usuario = $usuario ?? session('usuario_autenticado', []);
        $this->menuItems = $this->filterMenuByRole();
    }

    private function filterMenuByRole()
    {
        $rol = $this->usuario['rol_nombre'] ?? 'guest';
        
        // Definir todas las opciones del menú con sus roles permitidos
        $allItems = [
            [
                'name' => 'Configuración',
                'icon' => 'fas fa-cog',
                'submenu' => [
                    [
                        'name' => 'Registro de Usuarios',
                        'route' => 'usuarios.index',
                        'icon' => 'fa-users',
                        'roles' => ['Administrador'],
                    ],
                    [
                        'name' => 'Gestión de Roles',
                        'route' => 'roles.index',
                        'icon' => 'fa-user-tag',
                        'roles' => ['Administrador'],
                    ],
                    [
                        'name' => 'Gestión de Funciones',
                        'route' => 'funciones.index',
                        'icon' => 'fa-tasks',
                        'roles' => ['Administrador', 'Secretaria'],
                    ],
                    [
                        'name' => 'Parámetros del Sistema',
                        'route' => 'parametros_sistema.index',
                        'icon' => 'fa-cogs',
                        'roles' => ['Administrador', 'Secretaria'],
                    ]
                ],
                'roles' => ['Administrador', 'Secretaria'],
            ],
            [
                'name' => 'Academico',
                'icon' => 'fas fa-cog',
                'submenu' => [
                    [
                        'name' => 'Electronica',
                        'route' => 'usuarios.index',
                        'icon' => 'fa-users',
                        'roles' => ['Administrador'],
                    ],
                    [
                        'name' => 'Mecanica',
                        'route' => 'usuarios.index',
                        'icon' => 'fa-users',
                        'roles' => ['Administrador'],
                    ],
                ],
                'roles' => ['Administrador', 'Secretaria'],
            ],
            // Añadir más opciones de menú aquí...
        ];

        // Filtrar opciones según el rol
        return array_filter($allItems, function ($item) use ($rol) {
            return in_array($rol, $item['roles']);
        });
    }

    public function render()
    {
        return view('components.navigation-menu');
    }
}
