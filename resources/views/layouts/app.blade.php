<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="author" content="Czechitas" />
    <meta name="description" content="Přihlašování na kurzy, školy v přírodě, výlety a tábory" />
    <meta name="robots" content="index, follow" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@hasSection('title') @yield('title') - @lang('app.short_name') @else @lang('app.name') @endif</title>

    <!-- Styles -->
    <link href="{{ asset(mix('css/styles.css')) }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700&amp;subset=latin-ext&amp;display=swap" rel="stylesheet">
    <link rel="shortcut icon" type="image/png" href="{{ asset('favicon.png') }}" sizes="64x64">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}" sizes="64x64">
</head>

<body class="section--{{ getResourceNameFromRoute(Route::currentRouteName()) }}">
    @if (app()->isDownForMaintenance())
        <div class="alert alert-danger mb-0 p-2 text-center" role="alert">
          Application is DOWN!!!
        </div>
    @endif
    <div class="main_wrap">
        <header class="header">
            @include('layouts.__top_navigation')
            <div class="header_img d-flex flex-column justify-content-around">

                <h1>@hasSection('header') @yield('header') @else @hasSection('title') @yield('title') @endif @endif</h1>

                @inject('breadcrumbService', 'CzechitasApp\Services\BreadcrumbService')
                @if ($breadcrumbService->isActive())
                    <nav class="d-none d-sm-flex" aria-label="breadcrumb">
                        @foreach ($breadcrumbService->toArray() as $element)
                            @if ($loop->last)
                                <span class="breadcrumb-item active">{{ $element['text'] }}</span>
                            @else
                                <span class="breadcrumb-item"><a href="{{ $element['route'] }}">{{ $element['text'] }}</a></span>
                            @endif
                        @endforeach
                    </nav>
                @endif
            </div>
            @include('layouts.__admin_navigation')
        </header>

        <div class="main_content container-fluid @yield('extra_wrapper_classes')">
            @yield('content')
        </div>

        <footer class="footer container-fluid">
            <div class="row footer__content">
                @include('layouts.__footer')
            </div>

            <div class="row footer__copyright align-items-center">
                <div class="col">Czechitas &copy; 2020 - {{ date("Y") }}</div>
                <div class="col text-center footer__socials">
                    <a href="https://www.facebook.com/czechitas" class="footer__icon fi-fb"></a>
                    <a href="https://twitter.com/czechitas" class="footer__icon fi-tw"></a>
                    <a href="https://www.instagram.com/czechitas/" class="footer__icon fi-ig"></a>
                </div>
                <div class="col text-right">@lang('app.footer.created') <a href="http://www.kutac.cz/"><img src="{{ asset('img/kutac.png') }}" alt="Kutáč.cz"></a></div>
            </div>
        </footer>
    </div>
    <!-- Scripts -->
    <script>var CzechitasAppConfig = { assetPath: "{{ asset('') }}", lang: "{{ app()->getLocale() }}", mdHelpLink: "{{ route('static.markdown') }}", datatables: {jsPath: "{{ mix('js/datatables.js') }}",cssPath: "{{ mix('css/datatables.css') }}", lang: "{{ app()->getLocale() }}" }, easymde: {jsPath: "{{ mix('js/easymde.js') }}",cssPath: "{{ mix('css/easymde.css') }}"}, magnificPopup: { jsPath: "{{ mix('js/magnific-popup.js') }}",cssPath: "{{ mix('css/magnific-popup.css') }}" }, loginRoute: @json(route('login')) };</script>
    <script src="{{ asset(mix('js/main.js')) }}"></script>
    @yield('scripts')
    <script type="text/javascript">
        @foreach (Alert::getMessages() as $type => $messages)
            @foreach ($messages as $message)
                toastr["{{ $type }}"]("{{ $message }}");
            @endforeach
        @endforeach
        @if (session('status'))
                toastr.success("{{ session('status') }}");
        @endif
        @if ( ($fields = count($errors->get("*"))) > 0 )
            toastr.error("{{ trans_choice('app.validation.error.text', $fields) }}", "{{ trans_choice('app.validation.error.heading', $fields) }}");

            var showPopup = @json($errors->first('anyErrorPushId'));
            if(showPopup){
                $("#"+showPopup).modal();
            }
        @endif
    </script>
</body>

</html>
