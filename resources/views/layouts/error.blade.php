<!DOCTYPE html>
<html lang="cs">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@hasSection('title') @yield('title') - @lang('app.short_name') @else @lang('app.name') @endif</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:200&amp;display=swap&amp;subset=latin-ext" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #f4f3f1;
                color: #636b6f;
                font-family: 'Montserrat', sans-serif;
                font-weight: 300;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 36px;
                padding: 20px;
            }
            img{ border: 0; }
            a{ text-decoration: none; }
            .logo{ display: inline-block; margin-bottom: 15px; }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title">
                    <a href="/" class="logo"><img src="/img/logo.png" alt="Czechitas"></a>
                    <br>
                    @yield('message')
                </div>
            </div>
        </div>
    </body>
</html>
