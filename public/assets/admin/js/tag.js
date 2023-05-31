$(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Admin Tag Data Start

    
    let sort_by = ''
    let sort_type = ''
    let query_name = ''
    let query_slug = ''

    let per_page = ''

    let total_page = 1
    let current_page = 1


    let sort_by_options = [
        {
            'label': 'sort by',
            'value': ''
        },
        {
            'label': 'name',
            'value': 'name'
        },
        {
            'label': 'slug',
            'value': 'slug'
        }
    ]

    let sort_type_options = [
        {
            'label': 'sort type',
            'value': ''
        },
        {
            'label': 'asc',
            'value': 'asc'
        },
        {
            'label': 'desc',
            'value': 'desc'
        }
    ]


    // Admin Tag Data End
    let content = document.querySelector('.admin-tag-page-content')



    function create_admin_tag_index_page_view(fetchtag) {

        content.innerHTML = ''
        let topbar =
            `
            <div class=" d-flex flex-wrap">
                <h4 class="h4 text-capitalize"> Tags </h4>          
                <a href="/admin/tags/create" class="btn btn-sm btn-primary ms-auto m-1 " role="button">
                    <i class="ri-add-fill h5"></i>
                    <span class="d-none d-sm-inline ms-1"> Add New</span>
                </a>   
            </div>
            `;
        content.insertAdjacentHTML('beforeend', topbar);


        // create tag index page filter bar
        let admin_tag_index_page_filterbar =
            `
            <div class="filter-form-container mt-2 row">
                    <div class="form-item col-sm-4 col-md-2">
                        <label for="">per page</label>
                        ${generate_select_list(perpage_options,'perpage','tag-filter-form-perpage',per_page, "form-control form-control-sm my-1")}
                    </div>  
                    <div class="form-item col-sm-4 col-md-2">
                        <label for="">sort by</label>
                        ${generate_select_list(sort_by_options,'sortby','tag-filter-form-sortby','', "form-control form-control-sm my-1")}
                    </div>  
                    <div class="form-item col-sm-4 col-md-2">
                        <label for="">sort by</label>
                        ${ generate_select_list(sort_type_options,'sorttype','tag-filter-form-sorttype','', "form-control form-control-sm my-1")}
                    </div>  
                    <div class="form-item col-sm-4 col-md-2">
                        <label for="">name</label>
                        <input type="text" class="form-control form-control-sm my-1" name='name' id="name"
                        value="${query_name}"  placeholder="type name.." >
                    </div>  
                    <div class="form-item col-sm-4 col-md-2">
                        <label for="">slug</label>
                        <input type="text" class="form-control form-control-sm my-1" name='slug' id="slug"
                        value="${query_slug}"  placeholder="type slug.." >
                    </div>  
            </div>`;
        content.insertAdjacentHTML('beforeend', admin_tag_index_page_filterbar)


        // create index page table wrapper
        let admin_tag_index_page_table =
            `
            <div class="admin-main-content-table-container mt-4">
                <div class="table-responsive tags-table">
                
                </div>
            </div>
           `
        content.insertAdjacentHTML('beforeend', admin_tag_index_page_table)

        // create pagination wrapper
        let pagination_wrapper = `
        <div class="pagination-container">
       
        </div> `;

        content.insertAdjacentHTML('beforeend', pagination_wrapper)
    }


    function fetch_tags(page, perpage, name, slug, sortby, sorttype, ) {

        $.ajax({
            url: window.location.origin + `/api/tags?page=${page}&perpage=${perpage}&name=${name}&slug=${slug}&sorttype=${sorttype}&sortby=${sortby}`,
            method: "GET",

            beforeSend: function (xhr) {

                content.querySelector('.tags-table')
                    .insertAdjacentHTML('afterbegin', `<div class="loader1-w"><div class="loader1"></div></div>`)

                content.querySelector('.pagination-container').innerHTML = ''    

            },

            success: function (response) {

                current_page = response.tags.current_page
                total_page = response.tags.last_page
                per_page = response.tags.per_page
        
                content.querySelector('#perpage').value = per_page

                let tag_rows_content = ` `;

                response.tags.data.forEach(tag => {

                    tag_rows_content +=
                        `
                        <tr>
                            <td>${tag.name}</td>
                            <td>${tag.slug}</td>
                            <td>
                            <div class="d-flex justify-center align-center">
                                <a href="" class="btn btn-sm p-0 text-info mx-1">
                                <i class="ri-eye-line h4"></i>
                                </a>
                                <a href="" class="btn btn-sm p-0 text-sb1 mx-1">
                                <i class="ri-edit-2-line h4"></i>
                                </a>
                                <button type="submit" class="p-0 btn btn-sm text-danger delete-tag mx-1" > 
                                    <i class="ri-delete-bin-line h4"></i>
                                </button>
                                
                            </div>
                            </td>
                        </tr>
                    `
                });

                let table =

                    ` <table class="table table-bordered" >
                     <thead>
                     <tr>
                         <th scope="col" class="mw100px">Name</th>
                         <th scope="col" class="mw200px">Slug</th>
                         <th scope="col" class="mw200px">Action</th>
                     </tr>
                     </thead>
                     <tbody id="tag-index-page-table-body">
                     ${tag_rows_content}
                     </tbody>
                     
                 </table>
                `;
                
                content.querySelector('.tags-table').innerHTML = table

                let pagination = response.tags.total > 0 ? generate_pagination(total_page,current_page,'tags_pagination_link') :''

                content.querySelector('.pagination-container').innerHTML = pagination

                

            },
            error: function (xhr, status, error) {
                console.log(error)
            }
        });

    }


    create_admin_tag_index_page_view()
    fetch_tags(1, per_page, query_name, query_slug, sort_by, sort_type)
   





    content.addEventListener('change', (e) => {

        if (e.target.getAttribute('id') == 'perpage') {
            per_page = e.target.value
            fetch_tags(1, per_page, query_name, query_slug, sort_by, sort_type)
        }
        if (e.target.getAttribute('id') == 'sorttype') {
            sort_type = e.target.value
            fetch_tags(1, per_page, query_name, query_slug, sort_by, sort_type)
        }
        if (e.target.getAttribute('id') == 'sortby') {
            sort_by = e.target.value
            fetch_tags(1, per_page, query_name, query_slug, sort_by, sort_type)
        }



    })

    content.addEventListener('keyup', (e) => {

        if (e.target.getAttribute('id') == 'slug') {
            query_slug = e.target.value
            fetch_tags(1, per_page, query_name, query_slug, sort_by, sort_type)
        }

        if (e.target.getAttribute('id') == 'name') {
            query_name = e.target.value
            fetch_tags(1, per_page, query_name, query_slug, sort_by, sort_type)
        }
    })

    content.addEventListener('click', (e) => {

        if (e.target.classList.contains('tags_pagination_link')) {
            let page = e.target.getAttribute('data-page')
            fetch_tags(page, per_page, query_name, query_slug, sort_by, sort_type)
        }

    })


    // function showConfirmbox() {

    //     return new Promise((resolve, reject) => {

    //         $('#delete-confirmbox-container').removeClass('d-none')

    //         $('#confirm-delete-action').on('click', function () {
    //             $('#delete-confirmbox-container').addClass('d-none')
    //             resolve(true)
    //         })

    //         $('#cancel-delete-action').on('click', function () {
    //             $('#delete-confirmbox-container').addClass('d-none')
    //             resolve(false)
    //         })

    //     });
    // }



    // $('.delete-tag').on('click', (e) => {

    //     e.preventDefault()
    //     showConfirmbox().then((confirmed) => {
    //         confirmed == true ? $(e.target).closest('.delete-tag-form').trigger("submit") : ''
    //     });

    // })




});
