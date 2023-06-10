const btnNext = document.querySelector('.next');
const btnPrev = document.querySelector('.prev');
const divAllSlider  = document.querySelectorAll('.fade')
const dotsAll = document.querySelectorAll('.dot')
const dotsWrapper = document.querySelector('.wrapper-dots')

let index = 0;
function handlerNextButton(){
    index = index + 1;
    if(index === divAllSlider.length){
        index = 0;
    }
    divAllSlider.forEach(element => element.classList.add('mySlides'))
    divAllSlider[index].classList.remove("mySlides")

    dotsAll.forEach(element => element.classList.remove('active'))
    dotsAll[index].classList.add("active")
}

function handlerPrevButton (){
    index = index - 1;
    if(index < 0){
        index = divAllSlider.length - 1;
    }

    divAllSlider.forEach(element => element.classList.add('mySlides'))
    divAllSlider[index].classList.remove("mySlides")

    dotsAll.forEach(element => element.classList.remove('active'))
    dotsAll[index].classList.add("active")
}

function handlerDotClick(event){
    const clicked = event.target;
    if(clicked.classList.contains('dot')){
       const indexClick = clicked.dataset.index;
        divAllSlider.forEach(element => element.classList.add('mySlides'))
        divAllSlider[indexClick].classList.remove("mySlides")

        dotsAll.forEach(element => element.classList.remove('active'))
        dotsAll[indexClick].classList.add("active")
    }
}
btnNext.addEventListener('click', handlerNextButton)
btnPrev.addEventListener('click', handlerPrevButton)
dotsWrapper.addEventListener('click', handlerDotClick)