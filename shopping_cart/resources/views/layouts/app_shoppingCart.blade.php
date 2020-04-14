<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--CSRF Token-->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--Styles-->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!--JQuery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!--Bootstrap-->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <!--Data table-->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript">
        $.ajaxSetup({
                 headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 }
        });  
    </script>

</head>
<body>

    @yield('super_admin')

    @yield('admin')

    @yield('cart')

    @yield('user')

    @yield('add_role_page')
</body>
</html>