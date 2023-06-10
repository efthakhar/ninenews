// $(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let select_multiple = false
    let selected_media = { }
    let current_page = 1
    let last_page = 1
    let filename_serach = ''

    let typingTimer


    function open_media_window(multiple) {


        return new Promise((resolve,reject)=>{   

            select_multiple = multiple
            selected_media = { }
            current_page = 1
            last_page = 1
            filename_serach = ''

            document.querySelector('.popups-wrapper').insertAdjacentHTML(
                'beforeend',
                `<div class="media-window-container">
                <div class="media-window">
                    <div class="media-window-inner p-2">
                        <form  class="d-none" action="" enctype="multipart/form-data" id="mw-upload-form" >
                            <input type="file" name="mw_uploads[]" id="mw_uploads" multiple>
                        </form>
                        <div class="media-window-items row" id="media-window-items" >
                            
                        </div>
                    
                        <button class="btn btn-sm btn-info load-more-media-item mt-2 mb-5">
                            <i class="ri-loader-2-line"></i> load more
                        </button>
                        <div class="mb-5"></div>
                        <div class="media-window-actionbar border-top bg-white p-2 d-flex flex-wrap align-items-center">
                            <input type="text" class="mx-2 my-1" id='filename_search' placeholder="serach by name...."  >
                            <div class="mx-2 my-1">
                                <span class="mx-1 btn btn-outline-danger btn-sm media-window-bulk-delete-btn">
                                <i class="ri-delete-bin-7-line"></i> 
                                <span class="d-none d-sm-inline ms-1"> Delete Selected </span>
                                </span>
                                <span class="mx-1 btn btn-outline-primary btn-sm media-window-upload-btn">
                                    <i class="ri-upload-2-fill"></i>
                                    <span class="d-none d-sm-inline ms-1"> Upload Media </span>
                                </span>
                            </div>
                            <div class="ms-auto m-1" >
                                <span class="btn btn-primary btn-sm insert-selected-media-btn">Insert Seleted</span>
                                <span class="btn btn-danger btn-sm ms-1 close-media-window">Close</span>
                            </div>
                        </div>
                    </div>
                </div>
                </div>`
            )

            $(document).on('click', '.load-more-media-item', function () {
                current_page += 1
                fetchMedia(current_page, filename_serach)
            })

            $(document).on('click', '.close-media-window', function () {
                document.querySelector('.popups-wrapper').innerHTML = ``
                resolve(false)
            })

            $(document).on('click', '.insert-selected-media-btn', function () {
                document.querySelector('.popups-wrapper').innerHTML = ``
                if(select_multiple==true){
                    resolve(selected_media)
                }else{
                    resolve(Object.values(selected_media)[0])
                }
                
            })

            let mediaWindowInner = document.querySelector('.media-window-inner')
            mediaWindowInner.addEventListener('scroll', function () {

                if (
                    (last_page != current_page) &&
                    (mediaWindowInner.scrollTop + mediaWindowInner.clientHeight >= mediaWindowInner.scrollHeight)
                ) {
                    current_page += 1
                    fetchMedia(current_page, filename_serach)
                }

            })

            fetchMedia(current_page, filename_serach)
        })    

    }

    function fetchMedia(page, filename = '') {
        current_page = page
        let url = window.location.origin + `/admin/media` + `?page=` + current_page + "&filename=" + filename
        $.ajax({
            url: url,
            type: 'GET',
            success: function (data) {

                last_page = data.last_page
                let html = ``
                data.media.forEach(item => {
                    html +=
                        `<div class="media-window-item p-1 col-md-2 col-sm-4 col-6 position-relative" data-mwid="${item.id}">
                            <span class="copy-media-link"><i class="ri-links-line copy-media-link-icon"></i> </span>
                            <div class="card mwi-card">
                                <img class="card-img-top mwi-img" src="${item.url}" alt="Card image cap" data-media-id=${item.id}>
                                <div class="p-1 bg-light mwi-info">
                                    <p class="text-dark m-0 text"> ${item.filename}.${item.extension}  </p>
                                    <p class="text-black-50 m-0 fw-light"> ${item.size} kb  </p>                 
                                </div>
                            </div>
                    </div>`
                });

                document.querySelector('.media-window-items').insertAdjacentHTML('beforeend', html)

                last_page == current_page ?
                    document.querySelector('.load-more-media-item').classList.add('d-none') :
                    document.querySelector('.load-more-media-item').classList.remove('d-none')

            }
        });
    }


    document.addEventListener('click', function (e) {

        // copy media link to clipbord
        if (e.target.classList.contains('copy-media-link')||e.target.classList.contains('copy-media-link-icon')) {

            
            if(e.target.closest('.copy-media-link').classList.contains('copied')){
                e.target.closest('.copy-media-link').classList.remove('copied')
                navigator.clipboard.writeText('');
            }else{
                let copy_media_links =  document.querySelectorAll('.copy-media-link')
                for (let i = 0; i < copy_media_links.length; i++) {
                    copy_media_links[i].classList.remove('copied')
                }
                e.target.closest('.copy-media-link').classList.add('copied') 
                let link = e.target.closest('.media-window-item').querySelector('.mwi-img').getAttribute('src')
                navigator.clipboard.writeText(link);
            }
            
        }


        // select media item on click
        if (e.target.closest('.media-window-item') && 
            (
            e.target.classList.contains('mwi-img') || 
            e.target.closest('.mwi-info')
            )
            ) {

            let media_item = e.target.closest('.media-window-item')

            let media_id = media_item.querySelector('img').getAttribute('data-media-id')
            let media_src = media_item.querySelector('img').getAttribute('src')

            if (select_multiple == false) {
               
                let media_items = document.querySelectorAll('.media-window-item')
                for (let i = 0; i < media_items.length; i++) {
                    media_items[i].classList.remove('selected')
                }
                selected_media = { }
            }

        
            if(media_item.classList.contains('selected')){
                media_item.classList.remove('selected')
                delete selected_media[media_id]
            }else{
                media_item.classList.add('selected')
                selected_media[media_id] = { 'id'  : media_id, 'src' : media_src }
            }


            // console.log(selected_media)
        }


        // delete selected media items
        if (e.target.closest('.media-window-bulk-delete-btn')) {

            if(JSON.stringify(selected_media) === "{}"){ return }
            
            showConfirmbox().then((confirmed) => {  
                
                if(confirmed == false){ return }

                let items_to_delete = [ ]

                Object.keys(selected_media).forEach(key => {
                    items_to_delete.push(selected_media[key].id)
                    $(`[data-mwid="${selected_media[key].id}"]`).remove();
                });
    
                items_to_delete = items_to_delete.join(',')
               
                let url = window.location.origin + `/admin/media/${items_to_delete}`
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    success: function (data) {                
                        selected_media = { }
                    }
                });
            });
           
        }

        // open file upload pc window
        if (e.target.closest('.media-window-upload-btn')) {
            $('#mw_uploads').trigger('click')    
        }

    },true)


    document.addEventListener('keyup', function (e) {

        if (e.target.getAttribute('id') == "filename_search") {

            selected_media = { }

            clearTimeout(typingTimer);

            typingTimer = setTimeout(function () {

                document.getElementById('media-window-items').innerHTML = ''
                filename_serach = e.target.value
                fetchMedia(1, filename_serach)
                clearTimeout(typingTimer);

            }, 250);

        }
    })


    document.addEventListener('change', function (e) {

        if (e.target.getAttribute('id') == "mw_uploads") {

            e.preventDefault();
            var formData = new FormData($('#mw-upload-form')[0]);
   
        
            $.ajax({
                type: 'POST',
                url: window.location.origin + "/admin/media",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: (data) => {
                    $('#mw-upload-form')[0].reset();
                    let html = ``
                    data.files.forEach(item => {
                        html +=
                            `<div class="media-window-item p-1 col-md-2 col-sm-4 col-6" data-mwid="${item.id}">
                                <div class="card">
                                    <img class="card-img-top" src="${item.url}" alt="Card image cap" data-media-id=${item.id}>
                                    <div class="card-body p-1 bg-light">
                                        <p class="card-text">${item.filename}.${item.extension} </p>
                                    </div>
                                </div>
                        </div>`
                    });

                    document.querySelector('.media-window-items').insertAdjacentHTML("afterbegin", html)
                },
                error: function (data) {
                    console.log(data);
                }
            });

        }
    })



// });
