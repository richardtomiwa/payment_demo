function docready(fn){
    if (document.readyState==="complete" || document.readyState==="interactive") {
        setTimeout(fn,1);
    }else{
        document.addEventListener("DOMContentLoaded", fn);
    }
}
docready(function(){
    const sidenav_collapse=document.querySelector(".invisible_section");
    const sidenav_toggle=document.querySelector(".sidenav_toggle");
    const body=document.querySelector(".wrapper");
    const sidenav=document.querySelector(".sidebar");
    const search=document.querySelector(".search");
    const searchbutton=document.querySelector(".search-button");
    const searchoverlay=document.querySelector(".search_overlay");


    sidenav_collapse.addEventListener("click", 
        function(){
            sidenav.setAttribute("id", "inactive")
            sidenav_toggle.setAttribute("id", "toggle-off")
            sidenav_collapse.setAttribute("id", "collapsed")
            body.setAttribute("id", "sidebar-inactive") 
        }
    )
    
    sidenav_toggle.addEventListener("click", 
        function(){
            sidenav.removeAttribute("id", "inactive")
            sidenav_toggle.setAttribute("id", "toggle-on")
            sidenav_collapse.setAttribute("id", "expanded")
            body.setAttribute("id", "sidebar-active")
        }
    )

searchbutton.addEventListener("click", 

    function(){
        search.setAttribute("id", "active-search")
        searchoverlay.setAttribute("id", "overlay_active") 
    }
)


search.addEventListener("click", 

    function(event){
        if (event.target==search || event.target==searchbutton) {
            search.setAttribute("id", "inactive-search")
            searchoverlay.setAttribute("id", "overlay_inactive") 
        }else{

        }

    }
)
    
})





