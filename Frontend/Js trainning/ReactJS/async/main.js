// 1, async và sync khác nhau thế nào
// 1.1 sync hay còn gọi là thuật ngữ blocking tuwsc là thằng 1 đang chạy thằng khác ko được vào

//1.2 async hay còn gọi là non blocking
// 1, setimmer function  
// 2 event cũng là async
// 3 call api
//Khi stack rỗng và ở callback queue có tồn tại callback chờ được chạy
// Khi chạy hết số thời gian trong setimout thì nó sẽ được đưa xuống hàng đợi queue thì lúc này stack rỗng nó sẽ được chạy trước 

// Quy tắc bất đồng bộ đưa xuống queeue
// 1, setimout thì khi chạy hết số time thì xuống trước
// 2, Event thì khi người dùng click thì xuống trước 
// 3, Call api thì khi load xong api thì xuống queue trước 
// Demo tại web sau http://latentflip.com/

// callback
// 1 một call back là 1 hàm truyền đến 1 function khác dưới dạng agument
// 2. Sau đó được gọi trong hàm đó để thực thi 1 việc gì đấy


// API
//call back sinh ra để control kết quả trả về
const user = document.querySelector('.user')
const container = document.querySelector('.container')
const post = document.querySelector('.post')
const containerPost = document.querySelector('.container-post')

function callApiCore(url,callback){
    let xhttp = new XMLHttpRequest();
    xhttp.open("GET", url, true);
    xhttp.send();
    xhttp.onreadystatechange = function() {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
            const data = xhttp.responseText;
            const datObejct = JSON.parse(data)
            callback(datObejct)
        }
    };
}
function getListUser(){
    const url = "https://jsonplaceholder.typicode.com/users";
    callApiCore(url, function(datObejct){
        let userIdFirst = datObejct[0].id;
        const urlPostByUserId = "https://jsonplaceholder.typicode.com/posts?userId=" + userIdFirst;
        callApiCore(
            urlPostByUserId,
            function(dataPost){
               renderData(dataPost)
            }
        )
    })
}
function getListPost(){
    const url = "https://jsonplaceholder.typicode.com/posts";
    callApiCore(url, function(datObejct){
        
        renderData(datObejct)
    })
}
function renderData(data){
   let html = '';
   data.forEach(element => {
      html += `<p>${element.title}</p>`
   });
   container.insertAdjacentHTML('afterbegin', html)
}

user.addEventListener('click', getListUser)
post.addEventListener('click', getListPost)