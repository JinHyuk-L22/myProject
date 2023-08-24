<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>코로나19백신안전성연구센터</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2.0, minimum-scale=1.0, user-scalable=no, target-densityDpi=medium-dpi">
    
    <link type="text/css" rel="stylesheet" href="{{ asset( mix('/css/common_v3.css') )}}">
    <link type="text/css" rel="stylesheet" href="{{ asset( mix('/css/kovasc.css') )}}">
    
    <script type="text/javascript" src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/jquery/1.9.0/jquery.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/script/jquery.bxslider.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset( mix('/script/user.js') )}}"></script>
    
    <script src="{{ asset('vendor/jquery-validate/1.17.0/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery-validate/1.17.0/additional-methods.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery-validate/1.17.0/localization/messages_ko.min.js') }}"></script>

    <script src="{{ asset('vendor/sweetalert\sweetalert.all.js') }}"></script>

    @stack('styles')

</head>
<body>
@yield('content')

@include('layouts.partials.footer')
@include('sweetalert::alert')

</body>
</html>

