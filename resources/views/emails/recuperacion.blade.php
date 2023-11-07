<!-- En tu vista de Blade, usa los datos que pasaste desde el controlador -->
<h1>Hola, {{ $data['nombre'] }}</h1>
<p>Este es un correo de Comic Nexus</p>
<p>Para reestablecer tu contraseña presiona el siguiente enlace:</p>
<a href="{{ $data['link']  }}">Ver contenido</a>
