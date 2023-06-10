const overlay = document.querySelector('.overlay');
const loader = document.querySelector('.loader');
const btnAdd = document.querySelector('.btnAdd');
const popup = document.querySelector('.form-add-edit')
const cancel = document.querySelector("#cancel")
const inputEmail = document.querySelector('#mail')
const inputDes = document.querySelector('#des')
const inputAuthor = document.querySelector('#author')
const buttonSubmitForm = document.querySelector('#complete')
const bodyTableWrapper = document.querySelector('#bodyTable')

let currAction = ""
let arrayTable = [
    {
        author: "adsasd",
        des: "123",
        email: "adssadsd123213",
        id: "o5ias",
    }
];

function hidePopup() {
    popup.classList.remove('active');
    overlay.classList.remove('active');
}

function showPopup() {
    popup.classList.add('active');
    overlay.classList.add('active');
}

function renderItem(item){
    return `<tr class="item">
    <td class="id">${item.id}</td>
    <td class="title">${item.email}</td>
    <td class="des">${item.des}</td>
    <td class="author">${item.author}</td>
    <td class="edit" ><i class="fas fa-edit" data-index=${item.id}></i></td>
    <td class="trash" ><i class="fas fa-trash-alt" data-index=${item.id}></i></td>
    </tr>`
}
function render(){
    console.log('123');
    arrayTable.map((element, index) => {
        return bodyTableWrapper.insertAdjacentHTML('beforeend', renderItem(element, index))
    })
}
function onAddItem(){
    const object = {};
    const email = inputEmail.value;
    const des  = inputDes.value;
    const author = inputAuthor.value;
    object['id'] =  (Math.random() + 1).toString(36).substring(7)
    object['email'] = email
    object['des'] = des
    object['author'] = author
    arrayTable.push({...object});
    console.log('arrayTable', arrayTable);
    hidePopup()
    resetForm()
    render()
}
function resetForm(){
    inputEmail.value = ''
    inputDes.value = ''
    inputAuthor.value = ''
}
function handlerAction(event){
    const clickedItem = event.target;
    if(clickedItem.classList.contains('fa-trash-alt')){
        const idDelete = clickedItem.getAttribute('data-index');
        clickedItem.closest(".item").remove() 
        arrayTable = arrayTable.filter(element => element.id !== idDelete)
    }
    if(clickedItem.classList.contains('fa-edit')){
        console.log('clickedItem', clickedItem);
    }
}
buttonSubmitForm.addEventListener('click', onAddItem)
btnAdd.addEventListener('click', () => {
    currAction = 'create'
    showPopup()
})
cancel.addEventListener('click', hidePopup)
bodyTableWrapper.addEventListener('click', handlerAction)
render()