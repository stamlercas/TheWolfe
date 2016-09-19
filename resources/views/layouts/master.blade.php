<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!--
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        -->
        <link rel='stylesheet' href='{{ asset('css/bootstrap.min.css') }}' />
        <link rel='stylesheet' href="//netdna.bootstrapcdn.com/bootstrap/3.0.0-rc2/css/bootstrap-glyphicons.css" />
        <link rel='stylesheet' href='{{ asset('css/main.css') }}' />
        <link rel='stylesheet' href='{{ asset('css/dropzone.css') }}' />
        <style>
            .content:before {
                background-image: url( 
              <?php
                        //uses the function to get the random pic and pass it into the
                        //variable in javascript within the function to call
                        function randPic()
                        {
                            $files = array(
                                'wolfe.jpg',
                                'wolfe2.jpg',
                                'wolfe3.jpg',
                                );
                            $file = array_rand($files);
                            return asset("img/welcome/$files[$file]");
                            /*
                            $dir = Storage::disk('public')->files('img/welcome');
                            $files = Storage::files('/public/img/welcome');//glob($dir . '/*.*');
                            $file = array_rand($files);
                            return print_r($files);
                            return $files[$file];
                             *
                             */
                        }
                        //need the quotes, or else it is not defined
                        echo randPic();
                    ?> )
            }
        </style>
        
        <link href="{{ asset('img/favicon.ico') }}" type="image/png" rel="icon">
        
        <script src='{{ asset('js/jquery-2.1.3.js') }}'></script>
        <script src='{{ asset('js/bootstrap.min.js') }}'></script>
        <script src='{{ asset('js/dropzone.js') }}'></script>
        <script src='{{ asset('js/main.js') }}'></script>
        <script>
            uploadRoute = "{{ route('post.image.upload') }}";
        </script>
        
        <title>@yield('title')</title>
    </head>
    @if ( \Request::route()->getPath() == '/' )
    <body class='content'>
    @else
    <body>
    @endif
        @include('includes.header')
        <div class='container'>
            @yield('content')
        </div>
        @include('includes.footer')
    </body>
</html>