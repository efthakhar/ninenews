$(function () {

    $('#tag-filter-form-perpage, #tag-filter-form-sortby, #tag-filter-form-sorttype')
        .on('change', function () {
            $('#filter-form').trigger("submit")
        })



    $('.delete-tag').on('click', (e) => {

        e.preventDefault()
        showConfirmbox().then((confirmed) => {
            confirmed == true ? $(e.target).closest('.delete-tag-form').trigger("submit") : ''
        });

    })


});
