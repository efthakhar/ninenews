$(function () {

    let select_multiple = false
    let current_page = 1
    let last_page = 1
    let filename_serach = ''

    let typingTimer;

    $('.media-window-open-btn').on('click', (e) => {

        open_media_window(true)
    })



    function open_media_window(multiple) {

        select_multiple = multiple


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
                    <div class="media-window-actionbar border-top bg-white p-1 d-flex flex-wrap">
                        <input type="text" class="" id='filename_search' placeholder="serach by name...."  >
                        <div class="ms-auto" >
                            <span class="btn btn-primary btn-sm">Insert Selected</span>
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

    }

    function fetchMedia(page, filename = '') {
        current_page = page
        let url = window.location.origin + `/admin/media` + `?page=` + current_page + "&filename=" + filename
        $.ajax({
            url: url,
            type: 'GET',
            success: function (data) {

                last_page = data.last_page
                console.log(data.media)
                let html = ``
                data.media.forEach(item => {
                    html +=
                        `<div class="media-window-item p-1 col-md-2 col-sm-4 col-6">
                            <div class="card">
                                <img class="card-img-top" src="${item.url}" alt="Card image cap">
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

            if (select_multiple == false) {

                let media_items = document.querySelectorAll('.media-window-item')
                for (let i = 0; i < media_items.length; i++) {
                    media_items[i].classList.remove('selected')
                }
            }

            e.target.closest('.media-window-item').classList.toggle('selected')
        }

    })

    document.addEventListener('keyup', function (e) {

        if (e.target.getAttribute('id') == "filename_search") {

            clearTimeout(typingTimer);
            typingTimer = setTimeout(function () {
                document.getElementById('media-window-items').innerHTML = ''
                filename_serach = e.target.value
                fetchMedia(1, filename_serach)
                clearTimeout(typingTimer);
            }, 250);

        }

    })

});
