<div class="admin-sidebar">
    <div class="admin-sibar__logo">
        <a href="{{url('/admin')}}">
            <h2 class="logo-text" style="font-size:2.5rem">
                <span class="text-sb1">9</span><span class="text-b1">news</span>
            </h2></a>
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
