//DOM event
//keyword : js event bubling ;Kích vào child thì parent cũng chạy
// event delegation được sinh ra từ js event bubling : design pattern
//https://developer.mozilla.org/en-US/docs/Learn/JavaScript/Building_blocks/Events?retiredLocale=vi#event_delegation

//Luôn add event cho div cha
const child = document.querySelector('.child');
const parent = document.querySelector('.parent');

parent.addEventListener('click', function(){
    console.log('parent');
})