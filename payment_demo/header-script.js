const wholebody=document.body;
const sidenav_collapse=document.querySelector(".invisible_section");
const sidenav_toggle=document.querySelector(".sidenav_toggle");
const body=document.querySelector(".wrapper");
const sidenav=document.querySelector(".sidebar");
const search=document.querySelector(".search");
const searchbutton=document.querySelector(".search-button");



sidenav_collapse.addEventListener("click", 
    function(){
        sidenav.setAttribute("id", "inactive")
        sidenav_toggle.setAttribute("id", "toggle-off")
        sidenav_collapse.setAttribute("id", "collapsed")
        body.setAttribute("id", "sidebar-inactive") 
        wholebody.classList.remove("no-scroll");
    }
)

sidenav_toggle.addEventListener("click", 
    function(){
        sidenav.removeAttribute("id", "inactive")
        sidenav_toggle.setAttribute("id", "toggle-on")
        sidenav_collapse.setAttribute("id", "expanded")
        body.setAttribute("id", "sidebar-active")
        wholebody.classList.add("no-scroll");
    }
)

searchbutton.addEventListener("click", 

function(){
    search.setAttribute("id", "active-search")
}
)


search.addEventListener("click", 

function(event){
    if (event.target==search || event.target==searchbutton) {
        search.setAttribute("id", "inactive-search")
    }else{

    }

}
)
