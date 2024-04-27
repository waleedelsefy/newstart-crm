<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto">
                <a class="navbar-brand" href="{{ route('dashboard.index') }}">
                    <div class="brand-logo"></div>
                    <h2 class="brand-text mb-0">New Start</h2>
                </a>
            </li>

            <li class="nav-item nav-toggle">
                <a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse">
                    <i class="feather icon-x d-block d-xl-none font-medium-4 primary toggle-icon"></i>
                    <i class="toggle-icon feather icon-disc font-medium-4 d-none d-xl-block primary"
                        data-ticon="icon-disc"></i>
                </a>
            </li>
        </ul>
    </div>

    <div class="shadow-bottom"></div>

    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">

            @foreach ($items as $item)
                @php
                    $hasSub = isset($item['sub_items']) && is_array($item['sub_items']);
                @endphp

                <li class="nav-item {{ $item['active'] }} {{ $hasSub ? 'has-sub' : '' }}">
                    <a href="{{ $item['route'] }}">
                        <i class="{{ $item['icon'] }}"></i>
                        <span class="menu-title">{{ $item['title'] }}</span>
                        {{-- <span class="badge badge badge-warning badge-pill float-right">2</span> --}}
                    </a>

                    @if ($hasSub)
                        <ul class="menu-content" style="">
                            @foreach ($item['sub_items'] as $sub_item)
                                <li class="{{ $sub_item['active'] }}">
                                    <a href="{{ $sub_item['route'] }}">
                                        <i class="{{ $sub_item['icon'] }}"></i>
                                        <span class="menu-item">{{ $sub_item['title'] }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</div>
