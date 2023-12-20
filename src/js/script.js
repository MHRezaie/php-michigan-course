let letter=document.querySelector(".letter");
let sections=document.querySelectorAll("div[class^='section-']");
let buttons=document.querySelectorAll("button");
console.log(sections);


let calScrollLetterSpec=function(){
    console.clear();
    console.log("Letter Scrool spec:");
    console.log("contentWidth: "+ (letter.contentWidth));
    console.log("clientWidth: "+ (letter.clientWidth));
    console.log("clientHeight: "+ (letter.clientHeight));
    console.log("scroll height: "+letter.scrollHeight);
    console.log("scroll top: "+ letter.scrollTop);
    console.log("scroll bottom: "+(letter.scrollHeight-letter.scrollTop-letter.clientHeight));
}
let addSecH=function(){
    let h=document.documentElement.scrollHeight;
    sections.forEach(function(ele){
        console.log(h);
        ele.style.height=h+"px";
    });
}

let scrollCal=function(){
    calScrollLetterSpec();
};

buttons.forEach(function(b){
    b.addEventListener('click',function(event){
        let dest=document.querySelector(`.section-${event.target.innerText}`);
        //console.log();
        window.scrollTo(0,dest.offsetTop);
    });
});

addSecH();