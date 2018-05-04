<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{config('app.name','Laravel Gentelella')}} | @yield('title') </title>

    <!-- App Css -->
    <link href="{{asset('css/app.css')}}" rel="stylesheet">
    @yield('styles')
    @stack('header-scripts')
<style>input[type='number'] {
        appearance: textfield;
    }
    input[type='number']::-webkit-inner-spin-button,
    input[type='number']::-webkit-outer-spin-button,
    input[type='number']:hover::-webkit-inner-spin-button,
    input[type='number']:hover::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0; }</style>
</head>