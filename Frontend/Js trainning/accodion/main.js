const wrapper = document.querySelector('.wrapper')
const buttonAll = document.querySelectorAll('.accordion')
const panelAll = document.querySelectorAll('.panel')

function handlerClickPanel(event){
   const clicked = event.target;
   if(clicked.classList.contains('accordion')){
    buttonAll.forEach(element => {
        element.nextElementSibling.classList.remove('active')
    });
    const dataButton = clicked.dataset.acc;
    const panel = document.querySelector('#' + dataButton)
    panel.classList.add('active')
   }
}

wrapper.addEventListener('click', handlerClickPanel)