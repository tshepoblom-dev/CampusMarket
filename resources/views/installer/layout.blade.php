<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Installer</title>

    @if (!alreadyInstalled())

        @if (indexFile() == true)
            <!-- style css -->
            <link rel="stylesheet" href="{{asset('installer/assets/css/style.css')}}">
        @else

            @if (env('ASSET_URL') !== null)

            <link rel="stylesheet" href="{{asset('installer/assets/css/style.css')}}">
            @else
            <link rel="stylesheet" href="{{asset('public/installer/assets/css/style.css')}}">
            @endif

        @endif

    @else
     <link rel="stylesheet" href="{{asset('installer/assets/css/style.css')}}">
    @endif
</head>

<body>

    @yield('content')



    @if (!alreadyInstalled())


      @if (indexFile() == true)
            <script src="{{asset('installer/assets/js/jquery-3.7.1.min.js')}}"></script>
            <script src="{{asset('installer/assets/js/js-confetti.browser.js')}}"></script>
            <script src="{{asset('installer/assets/js/main.js')}}"></script>
        @else

        @if (env('ASSET_URL') !== null)
            <script src="{{asset('installer/assets/js/jquery-3.7.1.min.js')}}"></script>
            <script src="{{asset('installer/assets/js/js-confetti.browser.js')}}"></script>
            <script src="{{asset('installer/assets/js/main.js')}}"></script>
        @else
        <script src="{{asset('public/installer/assets/js/jquery-3.7.1.min.js')}}"></script>
        <script src="{{asset('public/installer/assets/js/js-confetti.browser.js')}}"></script>
        <script src="{{asset('public/installer/assets/js/main.js')}}"></script>
        @endif

      @endif


    @else
        <script src="{{asset('installer/assets/js/jquery-3.7.1.min.js')}}"></script>
        <script src="{{asset('installer/assets/js/js-confetti.browser.js')}}"></script>
        <script src="{{asset('installer/assets/js/main.js')}}"></script>
    @endif

    @if (request()->is('/'))
    <script>
        window.location.replace(`install`);
    </script>
    @endif
    @if (request()->is('install/final'))
    <script>
       const canvas = document.getElementById('custom_canvas');
            const jsConfetti = new JSConfetti({ canvas })
            jsConfetti.addConfetti();

    </script>
    @endif
</body>
</html>
