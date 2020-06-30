<!DOCTYPE html>
<html>
<head>
	<title>Nuevo usuario</title>
</head>
<body>
	<h1>Un administrador acaba de crear una cuenta con sus credenciales</h1>
	Nombre: {{-- {{ $request['name'] }} --}}<br>
	Email: {{-- {{ $request['email'] }} --}}<br>
	Contraseña: {{-- {{ decrypt($request['contraseña']) }} --}}<br>

	<p>Por seguridad, por favor dirijase a <a href="http://mercatodo.test:8000">www.mercatodo.com.co</a> para cambiar su contraseña</p>

	<h1>Feliz día</h1>
</body>
</html>