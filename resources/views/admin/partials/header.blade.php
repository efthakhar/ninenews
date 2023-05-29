<div class="admin-header">
    <div class="boxed-bg-icon menu-icon">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path d="M3 4H21V6H3V4ZM9 11H21V13H9V11ZM3 18H21V20H3V18Z"></path>
        </svg>
    </div>
    <div class="position-relative language-switcher-icon svg-icon-style-1 ms-auto"  tabindex="0">
        <span class="" id="language-switcher-dropdown" data-bs-toggle="dropdown">{{ get_svgicon('earth') }}</span>
        <ul  class="dropdown-menu  p-0 " aria-labelledby="language-switcher-dropdown" >
            @foreach(config('app.locales') as $ln)
            <a href="/setlanguage/{{$ln}}" class="{{ config('app.locale')==$ln?'bg-sb2 text-b1':'' }} dropdown-item " >  {{$ln}} </a>
            @endforeach
        </ul>
    </div>


    <div class="position-relative svg-icon-style-1 ms-4">
      <span class="" id="topbar-user-dropdown" data-bs-toggle="dropdown" >{{ get_svgicon('user') }}</span> 
      <ul class="dropdown-menu p-0" aria-labelledby="topbar-user-dropdown">
        <li>
            <a class="dropdown-item svg-icon-sm-style-1 flex-center" href="{{route('logout')}}">
               <span class="me-2">logout</span>
               {{ get_svgicon('logout') }}
            </a>
        </li>
      </ul>
    </div>

</div>