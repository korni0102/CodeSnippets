@use(App\Models\User)
<nav class="navbar navbar-expand-lg shadow-sm mb-4" style="background-color: #C8BEB7;">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold text-dark" href="{{ route('home') }}">CodeDashboard</a>

        <ul class="navbar-nav me-auto mb-2 mb-lg-0 border-start ps-3">
            @auth
                <li class="nav-item px-2 border-end">
                    <a class="nav-link text-dark" href="{{ route('user.code.create') }}">{{ __("trans.Create Code") }}</a>
                </li>
                <li class="nav-item px-2 border-end">
                    <a class="nav-link text-dark" href="{{ route('user.codeCategory.create.show') }}">{{ __("trans.Create row category") }}</a>
                </li>
                <li class="nav-item px-2 border-end">
                    <a class="nav-link text-dark" href="{{ route('user.codes') }}">{{ __("trans.My codes") }}</a>
                </li>
                <li class="nav-item px-2 border-end">
                    <a class="nav-link text-dark" href="{{ route('user.codes.archive') }}">{{ __("trans.My archive") }}</a>
                </li>
                @if(auth()->user()->isAdmin())
                    <li class="nav-item px-2 border-end">
                        <a class="nav-link text-dark" href="{{ route('admin.show.approve') }}">{{ __('trans.Approve codes') }}</a>
                    </li>
                @endif
            @endauth
        </ul>

        <ul class="navbar-nav d-flex align-items-center gap-2">
            @auth
                <li class="nav-item">
                    <span class="navbar-text text-dark fw-semibold">
                        {{ __('trans.Hi') }}, {{ auth()->user()->name }}
                    </span>
                </li>
            @endauth

            <!-- Profil ikon -->
            <li class="nav-item dropdown nav-profile">
                <a class="nav-link dropdown-toggle text-dark" href="#" role="button" data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle fs-5"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        @auth
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

            <!-- Nyelvválasztó -->
            <li class="nav-item dropdown nav-languages">
                <a class="nav-link dropdown-toggle text-dark" href="#" role="button" data-bs-toggle="dropdown">
                    {{ strtoupper(App::getLocale()) }}
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    @foreach(config('languages') as $language)
                        @unless($language == App::getLocale())
                            <a href="{{ route('lang', $language) }}" class="dropdown-item">
                                {{ strtoupper($language) }}
                            </a>
                        @endunless
                    @endforeach
                </ul>
            </li>
        </ul>
    </div>
</nav>
