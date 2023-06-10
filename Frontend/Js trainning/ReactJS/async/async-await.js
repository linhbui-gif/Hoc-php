
const user = document.querySelector('.user')
const container = document.querySelector('.container')
const post = document.querySelector('.post')
const containerPost = document.querySelector('.container-post')

function callApiCore(url){
    return new Promise(function (reslove, reject){
        let xhttp = new XMLHttpRequest();
        xhttp.open("GET", url, true);
        xhttp.send();
        xhttp.onreadystatechange = function() {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                const data = xhttp.responseText;
                const datObejct = JSON.parse(data)
                reslove(datObejct)
            }
        };
    })
}
async function getListUser(){
    const url = "https://jsonplaceholder.typicode.com/users";
    const dataUser = await callApiCore(url);
    await console.log('dataUser', dataUser);
}

function renderData(data){
   let html = '';
   data.forEach(element => {
      html += `<p>${element.title}</p>`
   });
   container.insertAdjacentHTML('afterbegin', html)
}

user.addEventListener('click', getListUser)