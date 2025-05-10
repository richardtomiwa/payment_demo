    const scrollright=document.getElementById("right");
    const scrollleft=document.getElementById("left");
    const scrollcontainer=document.querySelector(".card-container");
    const background=document.querySelector(".index-background");
    const newscrollright=document.getElementById("new-right");
    const newscrollleft=document.getElementById("new-left");
    const newscrollcontainer=document.querySelector(".new-card-container");

    const testimonyright=document.getElementById("testimony-right");
    const testimonyleft=document.getElementById("testimony-left");
    const testimonies=document.querySelector(".testimonies-wrapper");

// setInterval(function(){
//     let rnd= Math.floor(Math.random()*images.length);
//     background.src=images[rnd];
// }, 3000)




scrollright.addEventListener("click",() =>{
    scrollcontainer.scrollLeft += window.innerWidth;

})

scrollleft.addEventListener("click",() =>{
    scrollcontainer.scrollLeft -= window.innerWidth;

})

newscrollright.addEventListener("click",() =>{
    newscrollcontainer.scrollLeft += window.innerWidth;

})

newscrollleft.addEventListener("click",() =>{
    newscrollcontainer.scrollLeft -= window.innerWidth;

})

testimonyright.addEventListener("click",() =>{
    testimonies.scrollLeft += window.innerWidth;

})

testimonyleft.addEventListener("click",() =>{
    testimonies.scrollLeft -= window.innerWidth;

})







