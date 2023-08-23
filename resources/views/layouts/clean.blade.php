<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--[if IE 7]><html xmlns="http://www.w3.org/1999/xhtml" lang="eng" xml:lang="eng" class="ie7"><![endif]-->
<!--[if IE 8]><html xmlns="http://www.w3.org/1999/xhtml" lang="eng" xml:lang="eng" class="ie8"><![endif]-->
<!--[if IE 9]><html xmlns="http://www.w3.org/1999/xhtml" lang="eng" xml:lang="eng" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html xmlns="http://www.w3.org/1999/xhtml" lang="eng" xml:lang="eng"><!--<![endif]-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>코로나19백신안정성연구센터</title>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,Chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2.0, minimum-scale=1.0, user-scalable=no, target-densityDpi=medium-dpi"/>
    <link type="text/css" rel="stylesheet" href="{{ asset('/css/common_v3.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('/css/kovasc.css') }}">

    <script type="text/javascript" src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/jquery/1.9.0/jquery.js') }}"></script>
    @stack('styles')
</head>

<body>
@yield('content')

@stack('scripts')
</body>
</html>
