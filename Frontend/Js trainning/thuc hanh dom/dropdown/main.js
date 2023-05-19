const button = document.querySelector('.buttonDropdown');
button.addEventListener('click', function(){
    const nextElementSibling = this.nextElementSibling;
    const attr = nextElementSibling.getAttribute('data-position')
    if(attr !==  null){
        nextElementSibling.classList.toggle(attr)
    } else {
        nextElementSibling.classList.toggle('default')
    }
})