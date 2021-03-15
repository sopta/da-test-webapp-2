@if (Auth::user() !== null && Auth::user()->isAdminOrMore())
    <nav class="navbar navbar-light navbar-expand-xl admin_menu justify-content-end px-2">
        <div class="d-xl-none my-2 flex-grow-1 nav_top_items">
            @can('list', \CzechitasApp\Models\User::class)
                <a class="nav-item nav-link d-inline-block px-2 py-0" href="{{ route('admin.users.index') }}"><i class="fa fa-users mr-2"></i>@lang('app.admin.menu.users')</a>
            @endcan
            @can('list', \CzechitasApp\Models\Order::class)
                <a class="nav-item nav-link d-inline-block px-2 py-0" href="{{ route('admin.orders.index') }}"><i class="fa fa-cart-plus mr-2"></i>@lang('app.admin.menu.orders')</a>
            @endcan
            @can('list', \CzechitasApp\Models\Term::class)
                <a class="nav-item nav-link d-inline-block px-2 py-0" href="{{ route('admin.terms.index') }}"><i class="fa fa-calendar-alt mr-2"></i>@lang('app.admin.menu.terms')</a>
            @endcan
            @can('list', \CzechitasApp\Models\Student::class)
                <a class="nav-item nav-link d-inline-block px-2 py-0" href="{{ route('admin.students.index') }}"><i class="fa fa-graduation-cap mr-2"></i>@lang('app.admin.menu.students')</a>
            @endcan
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#adminNavbar" aria-controls="adminNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="adminNavbar">
            <div class="navbar-nav mr-auto d-xl-block">
                @can('list', \CzechitasApp\Models\User::class)
                    <a class="nav-item nav-link d-none d-xl-inline-block py-xl-0" href="{{ route('admin.users.index') }}"><i class="fa fa-users mr-2"></i>@lang('app.admin.menu.users')</a>
                @endcan
                @can('list', \CzechitasApp\Models\Order::class)
                    <a class="nav-item nav-link d-none d-xl-inline-block py-xl-0" href="{{ route('admin.orders.index') }}"><i class="fa fa-cart-plus mr-2"></i>@lang('app.admin.menu.orders')</a>
                @endcan
                @can('list', \CzechitasApp\Models\Term::class)
                    <a class="nav-item nav-link d-none d-xl-inline-block py-xl-0" href="{{ route('admin.terms.index') }}"><i class="fa fa-calendar-alt mr-2"></i>@lang('app.admin.menu.terms')</a>
                @endcan
                @can('list', \CzechitasApp\Models\Student::class)
                    <a class="nav-item nav-link d-none d-xl-inline-block py-xl-0" href="{{ route('admin.students.index') }}"><i class="fa fa-graduation-cap mr-2"></i>@lang('app.admin.menu.students')</a>
                @endcan

                {{-- HERE IS THE MENU SPLIT --}}

                @can('list', \CzechitasApp\Models\Category::class)
                    <a class="nav-item nav-link d-xl-inline-block py-xl-0" href="{{ route('admin.categories.index') }}"><i class="fa fa-th-large mr-2"></i>@lang('app.admin.menu.categories')</a>
                @endcan
                @can('list', \CzechitasApp\Models\News::class)
                    <a class="nav-item nav-link d-xl-inline-block py-xl-0" href="{{ route('admin.news.index') }}"><i class="fa fa-newspaper mr-2"></i>@lang('app.admin.menu.news')</a>
                @endcan
                @can('exports.list')
                    <a class="nav-item nav-link d-xl-inline-block py-xl-0" href="{{ route('admin.exports.index') }}"><i class="fa fa-file-excel mr-2"></i>@lang('app.admin.menu.exports')</a>
                @endcan
            </div>
        </div>
    </nav>

@endif
