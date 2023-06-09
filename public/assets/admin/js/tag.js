$(function () {

    $('#tag-filter-form-perpage, #tag-filter-form-sortby, #tag-filter-form-sorttype, #tag-filter-form-language,#tag-filter-form-posttype')
        .on('change', function () {
            $('#filter-form').trigger("submit")
        })



    $('.delete-tag').on('click', (e) => {

        e.preventDefault()
        showConfirmbox().then((confirmed) => {
            confirmed == true ? $(e.target).closest('.delete-tag-form').trigger("submit") : ''
        });

    })

    $('.media-window-open-btn').on('click', (e) => {

        open_media_window(true)
        .then((media)=>{
            // Object.keys(media).forEach(key => {
            //     console.log(media[key])
            // });
           if (media){
                $('#tag_thumbnail_img_container').html('')
                $('#tag_thumbnail_img_container')
                .html(
                `<div class="inserted_img">
                <input type="hidden" name="tag_thumbnail" value="${media.id}">
                <img src=${media.src} />
                <span class="cross-btn p-0"> 
                    ${cross_svg}
                </span>
                </div>`) 
           }

        })
    })


});
