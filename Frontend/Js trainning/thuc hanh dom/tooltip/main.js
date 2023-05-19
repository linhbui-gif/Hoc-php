const buttonClick = document.querySelector('.buttonClick');
buttonClick.addEventListener('click', function(e) {
   const dataButton = this.getAttribute('data-position')
   console.log(dataButton);
   if(dataButton !== null){
     this.classList.toggle(dataButton)
   } else {
    this.classList.toggle('default')
   }
})