@use(App\Models\User)
<nav class="navbar navbar-expand bg-light mb-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('home') }}">Dashboard</a>
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            @auth()
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page"
                       href="{{ route('user.code.create') }}">{{ __("trans.Create Code") }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page"
                       href="{{ route('user.codeCategory.create.show') }}">{{ __("trans.Create row category") }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page"
                       href="{{ route('user.codes') }}">{{ __("trans.My codes") }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page"
                       href="{{ route('user.codes.archive') }}">{{ __("trans.My archive") }}</a>
                </li>

                @if(auth()->user()->isAdmin())
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page"
                           href="{{ route('admin.show.approve') }}">{{ __('trans.Approve codes') }}</a>
                    </li>
                @endif
            @endauth
        </ul>
        <ul class="navbar-nav mb-2 mb-lg-0">
            <li class="nav-item dropdown nav-profile d-flex justify-content-center">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                   aria-expanded="false">
                    <i class="bi bi-person-circle"></i>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        @auth()
                            <form action="{{ route('logout') }}" method="post">
                                @csrf
                                <button type="submit" class="dropdown-item">{{__('trans.Logout')}}</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="dropdown-item">{{__('trans.Login')}}</a>
                            <a href="{{ route('register') }}" class="dropdown-item">{{__('trans.Register')}}</a>
                        @endauth
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown nav-languages d-flex justify-content-center">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                   aria-expanded="false">
                    {{ strtoupper(App::getLocale()) }}
                </a>
                <ul class="dropdown-menu">
                    @foreach(config('languages') as $language)
                        @unless($language == App::getLocale())
                            <a href="{{ route('lang', $language) }}"
                               class="dropdown-item">{{ strtoupper($language) }}</a>
                        @endunless
                    @endforeach
                </ul>
            </li>
        </ul>
    </div>
</nav>
