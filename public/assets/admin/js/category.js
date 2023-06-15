
document.addEventListener('DOMContentLoaded',() => {
    enableParentCatForAddCategory()
});

document.addEventListener('change',(e)=>{
    if(e.target.getAttribute('id')=='post_type'){
        enableParentCatForAddCategory()
    }
    if(e.target.getAttribute('id')=='lang'){
        enableParentCatForAddCategory()
    }
})

async function enableParentCatForAddCategory() {

    let lang =  document.getElementById('lang').value
    let post_type =  document.getElementById('post_type').value
    // console.log(lang,post_type)
    if( lang!='' && post_type!='' ) {

       fetchCategoryList(lang,post_type).then((data)=>{
 
        response = data  
        if(response.length>0){ 
            const nestedHTMLList = buildNestedCategoryList(data);
            document.querySelector('#parent_category').innerHTML = 
            "<option value='' class='p cursor-pointer text-lowercase'>All</option>"+nestedHTMLList
            document.querySelector('#parent_category').removeAttribute('disabled')
        }else{
            document.querySelector('#parent_category').innerHTML = ''
            document.querySelector('#parent_category').value = ''
            document.querySelector('#parent_category').setAttribute("disabled",true)
        }   
       })

    }
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

