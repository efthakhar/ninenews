<div class="admin-header">
    <div class="boxed-bg-icon header-menu-icon">
        <i class="ri-menu-3-line"></i>
    </div>
    <div class="ms-auto"  tabindex="0">
        <span class="cursor-pointer" id="language-switcher-dropdown" data-bs-toggle="dropdown">
            <i class="ri-global-fill h3 text-sb1"></i>
        </span>
        <ul  class="dropdown-menu fit-content p-0 " aria-labelledby="language-switcher-dropdown">
            @foreach(config('app.locales_label_value_pairs') as $ln)
            <a href="/admin/setlanguage/{{$ln['value']}}" class="{{ config('app.locale')==$ln['value'] ? ' active':'' }} dropdown-item " >  {{$ln['label']}} </a>
            @endforeach
        </ul>
    </div>


    <div class="position-relative svg-icon-style-1 ms-4">
      <span class="cursor-pointer" id="topbar-user-dropdown" data-bs-toggle="dropdown" >
        <i class="ri-user-3-line  h3 text-sb1"></i>
      </span> 
      <ul class="dropdown-menu p-0" aria-labelledby="topbar-user-dropdown">
        <li>
            <a class="dropdown-item svg-icon-sm-style-1 flex-center" href="{{route('logout')}}">
               <span class="me-2">logout <i class="ri-logout-circle-r-line h5 ms-1 text-danger"></i></span>
               
            </a>
        </li>
      </ul>
    </div>

</div>