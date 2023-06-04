$(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    // Open file upload window
    $(".open-file-upload-window").on("click", function () {
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
            url: window.location.origin + "/admin/media",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: (data) => {
                let media_items = document.querySelector(".media-items")
                $('#file-upload')[0].reset();

                data.files.forEach(file => {
                    let media_item =
                        `
                   <div class="media-item p-1 col-md-3 col-sm-4">
                   <div class="card " style="height:100% !important">
                     <img src="` + file.url + `" class="card-img-top" alt="` + file.filename + `">
                     <div class="card-body p-1 d-flex flex-column justify-content-between">
                        <div>
                        <a href="` + file.url + `" class="p">` + file.filename + `</a>
                        </div>
                        <div>
                        <span class="btn btn-sm btn-info">` + (file.size/1000) + ` kb</span>
                        <button class="btn btn-sm btn-danger delete-media-item" data-id="` + file.id + `">
                         Delete
                        </button>
                        </div>
              </div>
                   </div>
                  </div>
                   `
                    media_items.insertAdjacentHTML('afterbegin', media_item)
                });

            },
            error: function (data) {
                console.log(data);
            }
        });



    });


    $(document).on('click','.delete-media-item', function(e){

        let media_id = e.target.getAttribute('data-id')
        let url = window.location.origin + `/admin/media/${media_id}`
        $.ajax({
            url: url,
            type: 'DELETE',
            success: function (data) {
                e.target.closest('.media-item').remove()
            }
        });
    });



});
