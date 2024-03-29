$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

document.addEventListener('DOMContentLoaded', () => {
    let url = window.location.href

    if (url.includes('edit') && url.includes('categories')) {
        enableParentCatForEditCategory()
    }
    if (url.includes('create') && url.includes('categories')) {
        enableParentCatForAddCategory()
    }

});

document.addEventListener('change', (e) => {
    if (e.target.getAttribute('id') == 'post_type') {
        enableParentCatForAddCategory()
    }
    if (e.target.getAttribute('id') == 'lang') {
        enableParentCatForAddCategory()
    }
    if (e.target.getAttribute('id') == 'edit_cat_post_type') {
        enableParentCatForEditCategory()
    }
    if (e.target.getAttribute('id') == 'edit_cat_lang') {
        enableParentCatForEditCategory()
    }
})

async function enableParentCatForAddCategory() {

    let lang = document.getElementById('lang').value
    let post_type = document.getElementById('post_type').value

    if (lang != '' && post_type != '') {

        fetchCategoryList(lang, post_type).then((data) => {

            response = data
            if (response.length > 0) {
                const nestedHTMLList = buildNestedCategoryList(data,null);
                document.querySelector('#parent_category').innerHTML =
                    "<option value='' class='p cursor-pointer text-lowercase'>All</option>" + nestedHTMLList
                document.querySelector('#parent_category').removeAttribute('disabled')
            } else {
                document.querySelector('#parent_category').innerHTML = ''
                document.querySelector('#parent_category').value = ''
                document.querySelector('#parent_category').setAttribute("disabled", true)
            }
        })

    }
}

async function enableParentCatForEditCategory() {

    let lang = document.getElementById('edit_cat_lang').value
    let post_type = document.getElementById('edit_cat_post_type').value
    let current_parent_cat_id = document.getElementById('edit_cat_parent_category').getAttribute('data-cat-id')
    let current_cat_id = document.getElementById('current_cat_id').value
  
    if (lang != '' && post_type != '') {

        fetchParentableCategoryList(lang, post_type, current_cat_id).then((data) => {

            response = data
            if (response.length > 0) {
                const nestedHTMLList = buildNestedCategoryList(data,current_parent_cat_id );
                document.querySelector('#edit_cat_parent_category').innerHTML =
                    "<option value='' class='p cursor-pointer text-lowercase'>All</option>" + nestedHTMLList
                document.querySelector('#edit_cat_parent_category').removeAttribute('disabled')
            } else {
                document.querySelector('#edit_cat_parent_category').innerHTML = ''
                document.querySelector('#edit_cat_parent_category').value = ''
                document.querySelector('#edit_cat_parent_category').setAttribute("disabled", true)
            }
        })

    }
}



$('.media-window-open-btn').on('click', (e) => {

    open_media_window(false)
        .then((media) => {
            // Object.keys(media).forEach(key => {
            //     console.log(media[key])
            // });
            if (media) {
                $('#category_thumbnail_img_container').html('')
                $('#category_thumbnail_img_container')
                    .html(
                        `<div class="inserted_img">
            <input type="hidden" name="category_thumbnail" value="${media.id}">
            <img src=${media.src} />
            <span class="cross-btn p-0"> 
                ${cross_svg}
            </span>
            </div>`)
            }

        })
})




$(document).on('click', '.delete-category', (e) => {

    showConfirmbox().then((confirmed) => {
        if (confirmed == true) {
            let id = e.target.closest('.delete-category').getAttribute('data-category-id')
            let url = window.location.origin + `/admin/categories/${id}`
            $.ajax({
                url: url,
                type: 'DELETE',
                success: function (data) {
                    e.target.closest('tr').remove()
                }
            });
        }
    });

})
