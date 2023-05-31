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