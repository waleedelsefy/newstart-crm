<div class="content-overlay"></div>
<div class="header-navbar-shadow"></div>
<nav class="header-navbar navbar-expand-lg navbar navbar-with-menu floating-nav navbar-light navbar-shadow">
    <div class="navbar-wrapper">
        <div class="navbar-container content">
            <div class="navbar-collapse" id="navbar-mobile">
                <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                    <ul class="nav navbar-nav">
                        <li class="nav-item mobile-menu d-xl-none mr-auto"><a
                                class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i
                                    class="ficon feather icon-menu"></i></a></li>


                    </ul>

                    @can('change-current-branch')

                        @php
                            $branches = [];

                            if (auth()->user()->owner) {
                                $branches = \App\Models\Branch::all();
                            } else {
                                $branches = auth()->user()->branches;
                            }
                        @endphp

                        <form action="{{ route('dashboard.change-branch') }}" method="POST" class="header-change-branch">
                            @csrf
                            @method('PUT')

                            <x-form.select :select2="true" name="branch_id" onchange="this.form.submit()">
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}" @selected($branch->id == auth()->user()->branch_id)>
                                        {{ $branch->name }}
                                    </option>
                                @endforeach
                            </x-form.select>
                        </form>
                    @endcan


                </div>


                <ul class="nav navbar-nav float-right">



                    <li class="dropdown dropdown-language nav-item">
                        <a class="dropdown-toggle nav-link" id="dropdown-flag" href="#" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">

                            @if (LaravelLocalization::getCurrentLocale() == 'en')
                                <i class="flag-icon flag-icon-us"></i>
                                <span class="selected-language">English</span>
                            @elseif (LaravelLocalization::getCurrentLocale() == 'ar')
                                <i class="flag-icon flag-icon-eg"></i>
                                <span class="selected-language">العربية</span>
                            @endif

                        </a>

                        <div class="dropdown-menu" aria-labelledby="dropdown-flag">

                            @foreach (LaravelLocalization::getLocalesOrder() as $localeCode => $properties)
                                <a class="dropdown-item"
                                    href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">

                                    @if ($localeCode == 'en')
                                        <i class="flag-icon flag-icon-us"></i>
                                    @elseif ($localeCode == 'ar')
                                        <i class="flag-icon flag-icon-eg"></i>
                                    @endif

                                    {{ $properties['native'] }}
                                </a>
                            @endforeach
                        </div>
                    </li>

                    {{-- <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-expand"><i
                                class="ficon feather icon-maximize"></i></a></li> --}}



                    <x-layouts.notifications :notifications="auth()->user()->unreadNotifications" />


                    <li class="dropdown dropdown-user nav-item">
                        <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                            <div class="user-nav d-sm-flex d-none">
                                <span class="user-name text-bold-600">
                                    {{ Auth::user()->name }}
                                </span>
                                <span class="user-status">
                                    <x-badges.primary text="{{ Auth::user()->jobTitle() }}"
                                        icon="feather icon-shield" />
                                </span>
                            </div>
                            <span>
                                <img class="round" src="{{ Auth::user()->getPhoto() }}" alt="avatar" height="40"
                                    width="40" style="object-fit: cover">
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            {{-- <a class="dropdown-item" href="#">
                                <i class="feather icon-user"></i> {{ __('My Profile') }}
                            </a>

                            <div class="dropdown-divider"></div> --}}

                            <form action="{{ route('logout') }}" method="POST">
                                @csrf

                                <button class="dropdown-item w-100">
                                    <i class="feather icon-power"></i> {{ __('Logout') }}
                                </button>
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
