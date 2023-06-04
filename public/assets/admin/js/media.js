$(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    // Open file upload window
    $(".open-file-upload-window").on("click",function(){
        $('#files').trigger('click')
    })


    $('#file-upload').on('change', function (e) {


        e.preventDefault();
        var formData = new FormData($('#file-upload')[0]);
        let TotalFiles = $('#files')[0].files.length; //Total files
        let files = $('#files')[0];
        for (let i = 0; i < TotalFiles; i++) {
            formData.append('files' + i, files.files[i]);
        }
        formData.append('TotalFiles', TotalFiles);
        $.ajax({
            type: 'POST',
            url: window.location.origin+"/admin/media",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: (data) => {
                $('#file-upload')[0].reset();
                console.log('Files has been uploaded using jQuery ajax');
                location.reload()
            },
            error: function (data) {
                //console.log(data.responseJSON.errors.files[0]);
                console.log(data);
            }
        });



    });



    // $('#file-upload').on('change', function () {
    //     console.log('sdfdf')
    // })



});
