const currentUrl = window.location.href;
let currentBaseUrl = currentUrl.split('?')[0].split("/").slice(0, 5).join("/")
let currentUrlWithoutQuery = currentUrl.split('?')[0]




let sidebar_links = document.querySelectorAll('.sidebar__link');
let sidebar_sub_links = document.querySelectorAll('.sidebar__sublink');

// sidebar links toggle functionality 
for (let i = 0; i < sidebar_links.length; i++) {

    sidebar_links[i].addEventListener('click', (e) => {
        e.target.closest('.admin-sidebar__link_item').querySelector('.sidebar__link_sublinks')
        .classList.toggle('show_sublinks')
    })

    if (sidebar_links[i].href === currentUrl.split('?')[0]) {

        sidebar_links[i].classList.add('active');
    }
}


for (let i = 0; i < sidebar_sub_links.length; i++) {

    // Sidebar Sublinks Add Active Class on url match
    if (sidebar_sub_links[i].href === currentUrl.split('?')[0]) {

        sidebar_sub_links[i].classList.add('active');
    }

    // Sidebar sublink open on base url match
    if (currentBaseUrl == sidebar_sub_links[i].href.split("/").slice(0, 5).join("/")) {

        sidebar_sub_links[i].closest('.admin-sidebar__link_item')
            .querySelector('.sidebar__link')
            .classList.add('active');

        let sublinks = sidebar_sub_links[i].closest('.admin-sidebar__link_item').querySelector('.sidebar__link_sublinks')
        sublinks != null ? sublinks.classList.add('show_sublinks') : '';
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
