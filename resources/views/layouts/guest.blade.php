<html>
<head>
    <title>{{ config('app.name', 'Laravel') }} - @yield('title')</title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content />
    <meta name="author" content />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <link rel="icon" type="image/x-icon" href="assets/img/favicon.png" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{asset('js/feather.min.js')}}"></script>
    <script src="{{asset('js/font-awesome-all.min.js')}}"></script>
    @livewireStyles
    <!-- bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- select2-bootstrap4-theme -->
    <link href="{{asset('css/select2.css')}}" rel="stylesheet"> <!-- for local development env -->
    <link href="{{asset('css/style.css')}}" rel="stylesheet"> <!-- for local development env -->


</head>
<body class="nav-fixed ">


<div id="layoutSidenav">


    <div id="layoutSidenav_content">

        @yield('content')

    </div>
</div>



<!-- select2-bootstrap4-theme -->
<script >
    $("#sidebarToggle").on("click", function(e) {
        e.preventDefault();
        $("body").toggleClass("sidenav-toggled");
    });

</script>
@livewireScripts

</body>
</html>
