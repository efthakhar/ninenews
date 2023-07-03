function showConfirmbox() {

    return new Promise((resolve, reject) => {

        $('#delete-confirmbox-container').removeClass('d-none')

        $('#confirm-delete-action').on('click', function () {
            $('#delete-confirmbox-container').addClass('d-none')
            resolve(true)
        })

        $('#cancel-delete-action').on('click', function () {
            $('#delete-confirmbox-container').addClass('d-none')
            resolve(false)
        })

    });
}

let cross_svg =
`
<svg xmlns="http://www.w3.org/2000/svg" height="0.75em" viewBox="0 0 384 512">
    <!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
    <path
        d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z" />
</svg>
`


$(document).on('click', '.inserted_img .cross-btn', function () {
    $(this).closest('.inserted_img').remove()
})


$('.filter-toggle-btn').on('click', function (e) {
   $('.filter-form-container').toggleClass('d-none')
})



function buildNestedCategoryList(data,current_parent_category=null, parentId = null, level = 1) {
    let html = "";
    data.forEach(item => {
        let selected = current_parent_category==item.id?'selected':''
        
        if (item.parent_category_id === parentId) {

            html += "<option "+selected+" class='p cursor-pointer text-lowercase' value=" + item.id + ">";
            html += "<span> &#8212; </span>".repeat(level) + " " + item.name;

            const children = data.filter(child => child.parent_category_id === item.id);
            if (children.length > 0) {
                html += buildNestedCategoryList(data,current_parent_category, item.id, level + 1); // Increase nesting level
            }
            html += "</option>";
        }
    });

    html += "";

    return html;
}


function tr(key) {
    return lang[key]
}


function fetchCategoryList(lang, posttype) {

    let url = window.location.origin + `/admin/categories/list?language=${lang}&posttype=${posttype}`
    return Promise.resolve(
        $.ajax({
            url: url,
            type: 'GET',
        })
    );

}

function fetchParentableCategoryList(lang, posttype, id) {

    let url = window.location.origin + `/admin/categories/parentables/${lang}/${posttype}/${id}`
    return Promise.resolve(
        $.ajax({
            url: url,
            type: 'GET',
        })
    );

}
