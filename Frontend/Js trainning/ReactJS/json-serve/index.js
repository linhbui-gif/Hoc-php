const btnAdd = document.querySelector('.addBtn');
const input = document.querySelector('#myInput')
const ulList = document.querySelector("#myUL")

function handlerAddData(){
   // 1 lay value
   const inputValue = input.value
   //call api insert data to database
   axios.post('http://localhost:3000/posts', {title:inputValue}).then(data => {
    console.log(data);
   })
}

function renderData(data){
    let html = '';
    data.forEach(element => {
        html += `<li>${element.title}<span class="close">X</span></li> `
    });
    ulList.insertAdjacentHTML('afterbegin', html)
}

//1 load data tu databasen server
function showDataLoaded(){
    axios.get('http://localhost:3000/posts').then(res => {
        const data = res.data;
        renderData(data);
    })
}
showDataLoaded()
btnAdd.addEventListener('click', handlerAddData)
