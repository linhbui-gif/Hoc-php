// b1. get input value
const inputElement = document.querySelector('#myInput');
const buttonAdd = document.querySelector('.addBtn');
const containetList = document.getElementById('myUL');
const liElementAll = document.querySelectorAll('ul > li');


function renderLiItem(inputValue) {
    return `<li data-text="${inputValue}">
        ${inputValue}
        <span class="close">×</span>
        <button class="edit">Edit</button>
    </li>`;
}

function handleClickAdd() {
    // lay value input
    const inputValue = inputElement.value;

    if (this.classList.contains('edit')) {
        const liEditting = document.querySelector('ul li.editElement');
        console.log(liEditting);

    } else {
        // them vao danh sach
        const liElementAdd = renderLiItem(inputValue);
        containetList.insertAdjacentHTML('afterbegin', liElementAdd);
        // reset value
        inputElement.value = '';
    }

}

function toogleChecked(elementClick) {
    elementClick.classList.toggle('checked');
}

function deleteElement(elementClick) {
    elementClick.parentElement.remove();
}
function editElement(elementClick) {
    // bind value again
    const valueTextEdit = elementClick.parentElement.getAttribute('data-text');
    inputElement.value = valueTextEdit;
    // update text
    buttonAdd.textContent = 'Update';
    buttonAdd.classList.add('edit');

    // xác định được li hiện đang edit và chỉ có 1
    // 1. xóa tất cả các li có class 'editElement'
    // 2. add class editElement đến element edit
    document.querySelectorAll('ul > li').forEach(function (liElement) {
        liElement.classList.remove('editElement');
    });
    elementClick.parentElement.classList.add('editElement');
}

function handleToogleChecked(event) {
    const elementClick = event.target;

    if (elementClick.tagName === 'LI') {
        toogleChecked(elementClick);
    } else if (elementClick.tagName === 'SPAN' &&
        elementClick.classList.contains('close')) {
        deleteElement(elementClick);
    } else if (elementClick.tagName === 'BUTTON') {
        editElement(elementClick);
    }

}

// b2 click button add can lay data input
buttonAdd.addEventListener('click', handleClickAdd);
containetList.addEventListener('click', handleToogleChecked);

