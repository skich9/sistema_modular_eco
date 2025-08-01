<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>@yield('title', 'Sistema de Cobros - Instituto Tecnológico CETA')</title>
	
	<!-- Tailwind CSS -->
	<script src="https://cdn.tailwindcss.com"></script>
	
	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
	
	<!-- Custom Styles -->
	<style>
		.bg-gradient-ceta {
			background:  linear-gradient(135deg, #134908 0%, #243ba9 50%, #243ba9 100%);
		}
		
		.text-shadow {
			text-shadow: 0 2px 4px rgba(0,0,0,0.3);
		}
		
		.card-shadow {
			box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
		}
		
		.input-focus:focus {
			border-color: #3b82f6;
			box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
		}
		
		.btn-primary {
			background: linear-gradient(135deg, #134908 0%, #243ba9 100%);
			transition: all 0.3s ease;
		}
		
		.btn-primary:hover {
			background: linear-gradient(135deg, #134908 0%, #243ba9 100%);
			transform: translateY(-1px);
		}
	</style>
	
	@stack('styles')
</head>
<body class="min-h-screen bg-gray-50">
	<!-- Menú de navegación -->
	@if(session()->has('usuario'))
		<x-navigation-menu :usuario="$usuario" />
	@endif
	
	<!-- Contenido principal -->
    <main class="{{ session()->has('usuario') ? 'pt-0' : '' }}">
        @yield('content')
    </main>
	<!-- Scripts -->
	<script>
		// Toggle password visibility
		function togglePassword(inputId, iconId) {
			const input = document.getElementById(inputId);
			const icon = document.getElementById(iconId);
			
			if (input.type === 'password') {
				input.type = 'text';
				icon.classList.remove('fa-eye');
				icon.classList.add('fa-eye-slash');
			} else {
				input.type = 'password';
				icon.classList.remove('fa-eye-slash');
				icon.classList.add('fa-eye');
			}
		}
		
		// Auto-hide alerts after 5 seconds
		setTimeout(() => {
			const alerts = document.querySelectorAll('.alert-auto-hide');
			alerts.forEach(alert => {
				alert.style.transition = 'opacity 0.5s ease';
				alert.style.opacity = '0';
				setTimeout(() => alert.remove(), 500);
			});
		}, 5000);
	</script>
	
	@stack('scripts')
</body>
</html>
