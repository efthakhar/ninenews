
function buildNestedHTMLList(data, parentId = null, level = 1) {
    let html = "";
   
    data.forEach(item => {
      if (item.parent_category_id === parentId) {
        html += "<option class='p cursor-pointer text-lowercase' value="+item.id+">";
        // Add "-" sign based on the nesting level
        html += "-".repeat(level) + " " + item.name;
  
        const children = data.filter(child => child.parent_category_id === item.id);
        if (children.length > 0) {
          html += buildNestedHTMLList(data, item.id, level + 1); // Increase nesting level
        }
        html += "</option>";
      }
    });
  
    html += "";
  
    return html;
}
  
document.addEventListener('change',(e)=>{
    if(e.target.getAttribute('id')=='post_type'){
        enableParentCat()
    }
    if(e.target.getAttribute('id')=='lang'){
        enableParentCat()
    }
})

function enableParentCat() {

    let lang =  document.getElementById('lang').value
    let post_type =  document.getElementById('post_type').value
    console.log(lang,post_type)
    if( lang!='' && post_type!='' ) {
        fetchCategoryList(lang,post_type)
    }
}

function fetchCategoryList(lang, posttype) {
    let response = []
    let url = window.location.origin + `/admin/categories/list?language=${lang}&posttype=${posttype}` 
    $.ajax({
        url: url,
        type: 'GET',
        success: function (data) {

            response = data  
            if(response.length>0){ 
                const nestedHTMLList = buildNestedHTMLList(data);
                document.querySelector('#parent_category').innerHTML = 
                "<option value='' class='p cursor-pointer text-lowercase'>All</option>"+nestedHTMLList
                document.querySelector('#parent_category').removeAttribute('disabled')
            }else{
                document.querySelector('#parent_category').innerHTML = ''
                document.querySelector('#parent_category').value = ''
                document.querySelector('#parent_category').setAttribute("disabled",true)
            }    
           
        },
        error: function(data){
             response = []
           
        }
    });

    
}



$('.media-window-open-btn').on('click', (e) => {

    open_media_window(false)
    .then((media)=>{
        // Object.keys(media).forEach(key => {
        //     console.log(media[key])
        // });
       if (media){
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

