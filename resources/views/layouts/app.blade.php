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
<body class="nav-fixed @if(!auth()->check()) sidenav-toggled @endif">
@include('components.header')

<div id="layoutSidenav">
    @if(auth()->check())
        @include('components.sidebar')
    @endif
    <div id="layoutSidenav_content">
        @if (session()->has('generic.message'))
            <div class="container mt-2 mb-2">
                <div class="alert alert-success dark alert-dismissible fade show" role="alert"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-up"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path></svg>
                    {{ session('generic.message') }}
                    <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
            </div>
        @endif
        @if (session()->has('generic.opps'))
            <div class="container mt-2 mb-2" >
                <div class="alert alert-success dark alert-dismissible fade show" role="alert">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-triangle"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12" y2="17"></line></svg>                        {{ session('opps') }}
                    {{ session('generic.opps') }}
                    <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
            </div>
        @endif
        @if (session()->has('generic.error'))
            <div class="container mt-2 mb-2">
                <div class="alert alert-danger dark alert-dismissible fade show" role="alert"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-down"><path d="M10 15v4a3 3 0 0 0 3 3l4-9V2H5.72a2 2 0 0 0-2 1.7l-1.38 9a2 2 0 0 0 2 2.3zm7-13h2.67A2.31 2.31 0 0 1 22 4v7a2.31 2.31 0 0 1-2.33 2H17"></path></svg>
                    {{ session('generic.error') }}
                    <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
            </div>
        @endif
        @yield('content')

        @include('components.footer')
    </div>
</div>

@include('components.script')
@yield('scripts')



<!-- select2-bootstrap4-theme -->
<script >
    $("#sidebarToggle").on("click", function(e) {
        e.preventDefault();
        $("body").toggleClass("sidenav-toggled");
    });
    $(function () {
        $('.players').select2({
            theme: 'bootstrap4',
            language: "it",
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            allowClear: Boolean($(this).data('allow-clear')),
        });
    });
</script>
@livewireScripts

</body>
</html>
