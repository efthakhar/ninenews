

$(document).ready(function() {

    $('#tag-filter-form-perpage, #tag-filter-form-sortby, #tag-filter-form-sorttype')
    .on('change',function(){
        $('#filter-form').submit()
    })
   
})