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
                        <div class="media-window-items row" id="media-window-items" >
                            
                        </div>
                    
                        <button class="btn btn-sm btn-info load-more-media-item mt-2 mb-5">
                            <i class="ri-loader-2-line"></i> load more
                        </button>
                        <div class="mb-5"></div>
                        <div class="media-window-actionbar border-top bg-white p-1 d-flex flex-wrap align-items-center">
                            <input type="text" class="" id='filename_search' placeholder="serach by name...."  >
                            <div class="mx-2">
                                <span class="mx-1 btn btn-outline-danger btn-sm media-window-bulk-delete-btn">
                                <i class="ri-delete-bin-7-line"></i> delete selected
                                </span>
                                <span class="mx-1 btn btn-outline-primary btn-sm media-window-upload-btn">
                                    <i class="ri-upload-2-fill"></i> upload media
                                </span>
                            </div>
                            <div class="ms-auto" >
                                <span class="btn btn-primary btn-sm insert-selected-media-btn">Insert Selected</span>
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
                        `<div class="media-window-item p-1 col-md-2 col-sm-4 col-6" data-mwid="${item.id}">
                            <div class="card">
                                <img class="card-img-top" src="${item.url}" alt="Card image cap" data-media-id=${item.id}>
                                <div class="card-body p-1 bg-light">
                                    <p class="card-text">${item.filename}.${item.extension} </p>
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

        // select media item on click
        if (e.target.closest('.media-window-item')) {

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


            console.log(selected_media)
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

    })

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

// });
