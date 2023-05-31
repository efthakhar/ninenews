

// Global Data:

// Per Page Options
let perpage_options = [
  {'label':'5','value':5},
  {'label':'10','value':10},
  {'label':'15','value':15},
  {'label':'20','value':20},
  {'label':'30','value':30},
  {'label':'40','value':40},
  {'label':'50','value':50},
  {'label':'60','value':60},
]


// Global Functions:

// Generate Select list
function generate_select_list(options, selectId, selectName, selectedValue='', cssClass='') {

  let select = `<select name="${selectName}" id="${selectId}" class="${cssClass}"> `
  
  for (let i = 0; i < options.length; i++) {
    select+= `<option 
    ${selectedValue==options[i].value?'selected':''} 
    value="${options[i].value}">
    ${options[i].label}
    </option>`;
  }

  return select + `</select>`;
}
// Generate Pagination
function generate_pagination(total,current,link_class='') {


  let pagination = 
  `
  <nav>
      <ul class="pagination">`
      +
      `<li class="page-item ${current==1?'not-allowed disabled':''}"" >
          <a class="page-link disabled ${link_class} ${current==1?'unclickable':''}"   data-page=${current-1} ${current==1?'disabled=true':''}>
          &laquo;
          </a>
      </li>`
      +
      `
      <li class="page-item">
        <a class="page-link ${link_class} ${current-1>1?'':'d-none'}"  data-page=${current-2}>
        ${current-2}
        </a>
      </li>
      <li class="page-item">
        <a class="page-link ${link_class} ${current>1?'':'d-none'}"  data-page=${current-1}>
        ${current-1}
        </a>
      </li>
      <li class="page-item active not-allowed">
        <a class="page-link ${link_class} unclickable" data-page=${current}>
        ${current}
        </a>
      </li>
      <li class="page-item ${current<total?'':'d-none'}">
        <a class="page-link  ${link_class}"  data-page=${current+1}>
        ${current+1}
        </a>
      </li>
      <li class="page-item ${current+1<total?'':'d-none'}">
        <a class="page-link ${link_class}"  data-page=${current+2}>
        ${current+2}
        </a>
      </li>
      
      `+
      `<li class="page-item ${current==total?'not-allowed disabled':''}" >
          <a class="page-link ${link_class} ${current==total?'unclickable':''} "  data-page=${current+1}  >
          &raquo;
          </a>
      </li>
      </ul>
  </nav>
  `
  return pagination
 
}
