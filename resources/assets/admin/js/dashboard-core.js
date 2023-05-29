const currentUrl = window.location.href;
let currentBaseUrl = currentUrl.split('?')[0].split("/").slice(0,5).join("/")

// sidebar sublinks toggle functionality and active class to links
let links = document.querySelectorAll('.sidebar__link,.sidebar__sublink');

for (let i = 0; i < links.length; i++) {

    if (links[i].classList.contains('sidebar__link')) {

        links[i].addEventListener('click', (e) => {

            e.target.closest('.admin-sidebar__link_item')
                .querySelector('.sidebar__link_sublinks')
                .classList.toggle('show_sublinks')
        })

    }
}

for (let i = 0; i < links.length; i++) {

    if (links[i].href === currentUrl.split('?')[0] ) {

        links[i].classList.add('active');

        links[i].closest('.admin-sidebar__link_item')
            .querySelector('.sidebar__link')
            .classList.add('active');

        let sublinks = links[i].closest('.admin-sidebar__link_item').querySelector('.sidebar__link_sublinks')
        sublinks!=null? sublinks.classList.add('show_sublinks'):'';
        
        break;
    }

    

}



// sidebar hide or show toggle function
let toggle_sidebar_icon = document.querySelector('.header-menu-icon');
let admin_sidebar = document.querySelector('.admin-sidebar');
let mobile_sidebar_close_btn = document.querySelector('.hide-small-device-sidebar');

toggle_sidebar_icon.addEventListener('click', (e) => {
    admin_sidebar.classList.toggle('admin-sidebar-hidden');
})

mobile_sidebar_close_btn.addEventListener('click', (e) => {
    admin_sidebar.classList.toggle('admin-sidebar-hidden');
})

