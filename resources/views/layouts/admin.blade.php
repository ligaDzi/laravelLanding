<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, maximum-scale=1">
<title>{{$title}}</title>
<link rel="icon" href="favicon.png" type="image/png">
<link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('css/style.css')}}" rel="stylesheet" type="text/css"> 

<script type="text/javascript" src="{{asset('js/jquery-1.11.0.min.js')}}"></script>

<!--ckeditor - это редактор текста, который можно расположить на странице-->
<script type="text/javascript" src="{{asset('js/ckeditor/ckeditor.js')}}"></script>
<script type="text/javascript" src="{{asset('js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/bootstrap-filestyle.min.js')}}"></script>
 
</head>
<body>

<header id="header_wrapper">
	@yield('header') 
	
	
@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
</header>
	@yield('content')
</body>
</html>
