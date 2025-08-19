<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Carrera;

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
                'icon' => 'fas fa-graduation-cap',
                'submenu' => $this->getCarrerasSubmenu(),
                'roles' => ['Administrador', 'Secretaria'],
            ],
            // Añadir más opciones de menú aquí...
        ];

        // Filtrar opciones según el rol
        return array_filter($allItems, function ($item) use ($rol) {
            return in_array($rol, $item['roles']);
        });
    }

    /**
     * Obtiene las carreras desde la base de datos para el submenú Académico
     *
     * @return array
     */
    private function getCarrerasSubmenu()
    {
        try {
            // Obtener todas las carreras activas
            $carreras = Carrera::where('estado', true)->get();
            
            $submenu = [];
            
            foreach ($carreras as $carrera) {
                $submenu[] = [
                    'name' => $carrera->nombre,
                    'route' => 'carrera.show',
                    'icon' => 'fa-book',
                    'roles' => ['Administrador', 'Secretaria'],
                    'params' => ['codigo' => $carrera->codigo_carrera]
                ];
            }
            
            // Si no hay carreras, agregar un elemento vacío
            if (empty($submenu)) {
                $submenu[] = [
                    'name' => 'No hay carreras disponibles',
                    'route' => 'dashboard',
                    'icon' => 'fa-exclamation-circle',
                    'roles' => ['Administrador', 'Secretaria']
                ];
            }
            
            return $submenu;
        } catch (\Exception $e) {
            // En caso de error, retornar un submenu vacío
            return [
                [
                    'name' => 'Error al cargar carreras',
                    'route' => 'dashboard',
                    'icon' => 'fa-exclamation-triangle',
                    'roles' => ['Administrador', 'Secretaria']
                ]
            ];
        }
    }

    public function render()
    {
        return view('components.navigation-menu');
    }
}
