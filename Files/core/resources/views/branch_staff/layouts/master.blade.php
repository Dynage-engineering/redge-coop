<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $general->siteName($pageTitle ?? '') }}</title>

    <link rel="shortcut icon" type="image/png" href="{{ getImage(getFilePath('logoIcon') . '/favicon.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/global/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/global/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/global/css/line-awesome.min.css') }}">

    @stack('style-lib')

    <link rel="stylesheet" href="{{ asset('assets/admin/css/vendor/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/vendor/datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/app.css') }}">
    <style>
        .image-upload .thumb .profilePicUpload {
            position: absolute;
        }

        .image-upload .thumb .avatar-edit label {
            margin-top: 15px;
        }
    </style>
    @stack('style')
</head>

<body>
    @yield('content')

    <script src="{{ asset('assets/global/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/global/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/vendor/jquery.slimscroll.min.js') }}"></script>

    @include('partials.notify')
    @stack('script-lib')

    <script src="{{ asset('assets/admin/js/nicEdit.js') }}"></script>

    <script src="{{ asset('assets/admin/js/vendor/select2.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/app.js') }}"></script>
    <script src="{{ asset('assets/admin/js/cu-modal.js') }}"></script>

    @stack('script')

</body>

</html>
