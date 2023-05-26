<div class="admin-header">
    <div class="boxed-bg-icon menu-icon">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path d="M3 4H21V6H3V4ZM9 11H21V13H9V11ZM3 18H21V20H3V18Z"></path>
        </svg>
    </div>
    <div class="position-relative language-switcher-icon svg-icon-style-1 ms-auto"  tabindex="0">
        {{ get_svgicon('earth') }}
        <div class="language-switcher d-none" style="position: absolute; top:110%;right:0%;cursor: pointer; width:100px">
            <div class="list-group">
                @foreach(config('app.locales') as $ln)
                <a href="/setlanguage/{{$ln}}" 
                class="{{ config('app.locale')==$ln?'bg-sb2 text-b1':'' }} list-group-item list-group-item-action h4 m-0 text-center "
               
                >
                    {{$ln}}
                </a>
                @endforeach
            </div>
        </div>
    </div>
    <div class="svg-icon-style-1 ms-4">
       {{ get_svgicon('user') }}
    </div>

</div>