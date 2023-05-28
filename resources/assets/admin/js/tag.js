$(function () {

    $('#tag-filter-form-perpage, #tag-filter-form-sortby, #tag-filter-form-sorttype')
        .on('change', function () {
            $('#filter-form').trigger("submit")
        })





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



    $('.delete-tag').on('click', (e) => {

        e.preventDefault()
        showConfirmbox().then((confirmed) => {
            confirmed == true ? $(e.target).closest('.delete-tag-form').trigger("submit") : ''
        });

    })


});
