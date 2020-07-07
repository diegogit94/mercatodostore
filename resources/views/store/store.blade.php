@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html>
<head>
	<title>Tienda</title>
</head>
<body>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-center"></div>
				<div>
					<img src="https://www.giorgiosalvatori.cl/wp-content/uploads/2015/08/construccion.jpg" alt="Aviso de sitio en construccion" class="rounded mx-auto d-block">
					<a href="/" type="submit" 
                	class="btn btn-lg btn-block btn-warning">{{ __('Volver') }}</a>
				</div>
		</div>
	</div>

</body>
</html>
@endsection