<div class="admin-sidebar">
    <div class="admin-sibar__logo">

        <span class="admin-sibar__logo_icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path
                    d="M1.94631 9.31555C1.42377 9.14137 1.41965 8.86034 1.95706 8.6812L21.0433 2.31913C21.5717 2.14297 21.8748 2.43878 21.7268 2.95706L16.2736 22.0433C16.1226 22.5718 15.8179 22.5901 15.5946 22.0877L12.0002 14.0002L18.0002 6.00017L10.0002 12.0002L1.94631 9.31555Z"
                    fill="rgba(0,132,255,1)"></path>
            </svg>
        </span>
        <h2 class="logo-text" style="font-size:2.5rem">
            <span class="text-sb1">9</span><span class="text-b1">news</span>
        </h2>
        <span class="hide-small-device-sidebar">
            <i class="ri-menu-fold-fill h2 "></i>
        </span>
    </div>
    <div class="admin-sidebar__links">
        @foreach ($navlinks as $navlink)
            <div class="admin-sidebar__link_item">
                @if (isset($navlink['sublinks']))
                    <li class="sidebar__link">   
                        <span > <i class="{{$navlink['icon']}} me-2"></i> {{ $navlink['label'] }}</span>
                    </li>
                    <div class="sidebar__link_sublinks">
                        @foreach ($navlink['sublinks'] as $sublink)
                            <a href="{{ $sublink['link'] }}" class="sidebar__sublink">                 
                                <span class="ms-2"> <i class="ri-arrow-right-fill me-2"></i> {{ $sublink['label'] }}</span>
                            </a>
                        @endforeach
                    </div>
                @else
                    <a class="sidebar__link" href="{{ $navlink['link'] }}">
                        <span> <i class="{{$navlink['icon']}}  me-2"></i> {{ $navlink['label'] }}</span>
                    </a>
                @endif
            </div>
        @endforeach
    </div>
</div>
