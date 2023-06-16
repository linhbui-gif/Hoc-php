const btnAdd = document.querySelector(".btnAdd");
const overlay = document.querySelector(".overlay");
const formAddEdit = document.querySelector(".form-add-edit");
const form = document.querySelector(".form");
const btnComplete = document.querySelector("#complete");
const btnCancel = document.querySelector("#cancel");
const mail = document.querySelector("#mail");
const des = document.querySelector("#des");
const author = document.querySelector("#author");
const tbody = document.querySelector("tbody");
const searchInput = document.querySelector("#search");

let arr = []
let data = [];
let searchTimeoutId = null;
let searchTerm = ''
let currentPage = 1;
const postsPerPage = 10;
btnComplete.classList.add("add");

const renderData = function (data) {
  let html = ``;
  data.forEach(function(element) {
    html += `
    <tr>
      <td class="id">${element.id}</td>
      <td class="title">${element.mail}</td>
      <td class="des">${element.des}</td>
      <td class="author">${element.author}</td>
      <td class="edit"><i class="fas fa-edit"></i></td>
      <td class="trash"><i class="fas fa-trash-alt"></i></td>
    </tr>`
  })
  tbody.insertAdjacentHTML("beforeend", html);
};

const showPopup = function () {
  overlay.classList.add("active");
  formAddEdit.classList.add("active");
  form.style.transform = "scale(1)";
};

const hidePopup = function () {
  btnComplete.className = "add";
  deleteInputValue();
  overlay.classList.remove("active");
  formAddEdit.classList.remove("active");
  form.style.transform = "scale(0)";
};

const deleteInputValue = function () {
  mail.value = "";
  des.value = "";
  author.value = "";
};

const handleEdit = function (e) {
  showPopup();
  btnComplete.className = "update";
  const clicked = e.target;
  const trClosest = clicked.closest("tr");
  const currentMail = trClosest.querySelector(".title").textContent;
  const currentDes = trClosest.querySelector(".des").textContent;
  const currentAuthor = trClosest.querySelector(".author").textContent;
  mail.value = currentMail;
  des.value = currentDes;
  author.value = currentAuthor;
  clicked.closest("tr").classList.add("updateUser");
};

const handleDelete = function (e) {
  const clicked = e.target;
  const id = clicked.closest("tr").querySelector(".id").textContent;
  
  axios.delete(`http://localhost:3000/todos/${id}`)
    .then(function () {
      clicked.closest("tr").remove();
    })
};

const handleClickComplete = function (event) {
  event.preventDefault();
  if (btnComplete.classList.contains("add")) {
    addNewUser();
  } else if (btnComplete.classList.contains("update")) {
    updateCurrentUser();
  }
};

const addNewUser = function () {
  const valueMail = mail.value;
  const valueDes = des.value;
  const valueAuthor = author.value;
  const body = {
    mail: valueMail,
    des: valueDes,
    author: valueAuthor
  }
  axios.post('http://localhost:3000/todos',body).then((res) => {
      const newUser = res.data; 
      arr.push(newUser);
      renderData([newUser]);
      hidePopup();
      deleteInputValue();
  })
};

const updateCurrentUser = function () {
  const trUpdate = tbody.querySelector(".updateUser");
  trUpdate.querySelector(".title").textContent = mail.value;
  trUpdate.querySelector(".des").textContent = des.value;
  trUpdate.querySelector(".author").textContent = author.value;

  const id = trUpdate.querySelector(".id").textContent;
  const updatedData = {
    mail: mail.value,
    des: des.value,
    author: author.value
  };

  axios.put(`http://localhost:3000/todos/${id}`, updatedData)
    .then(function () {
      const userIndex = data.findIndex(user => user.id === id);
      if (userIndex !== -1) {
        data[userIndex] = {
          id: id,
          ...updatedData
        };
      }
      trUpdate.classList.remove("updateUser");
      btnComplete.className = "add";
      hidePopup();
      deleteInputValue();
    });
};

function searchPosts(event) {
  const clicked = event.target;
  clearTimeout(searchTimeoutId);
  searchTimeoutId = setTimeout(function () {
      searchTerm = clicked.value.toLowerCase();
      fetchData()
  }, 300);
}
const handleButton = function (e) {
  const clicked = e.target;
  if (clicked.classList.contains("fa-edit")) {
    handleEdit(e);
  } else if (clicked.classList.contains("fa-trash-alt")) {
    handleDelete(e);
  }
};

function fetchData() {
  axios.get(`http://localhost:3000/todos?q=${searchTerm}&_page=${currentPage}&_limit=${postsPerPage}`)
      .then(function(response) {
        arr = response.data;
        renderData(arr);
  });
}
const getTotalData = function () {
  const url = `http://localhost:3000/todos`;
  return axios
    .get(url)
    .then(function (response) {
      const totalPosts = response.data.length;
      return totalPosts;
    })
    .catch(function (error) {
      console.log(error);
    });
};

const handlePagination = function (page) {
  currentPage = page;
  fetchData();
};

const renderPagination = function (totalPosts) {
  const totalPages = Math.ceil(totalPosts / postsPerPage);

  let html = "";
  for (let i = 1; i <= totalPages; i++) {
    html += `<button class="page-btn ${i === currentPage ? "active" : ""}" data-page="${i}">${i}</button>`;
  }

  const paginationContainer = document.querySelector(".pagination");
  paginationContainer.innerHTML = html;

  paginationContainer.addEventListener("click", function (event) {
    const clicked = event.target;
    if(clicked.classList.contains('page-btn')){
      const page = parseInt(clicked.dataset.page);
      handlePagination(page);
    }
    
  });
};
fetchData();
getTotalData().then(function (total) {
  renderPagination(total);
});
btnAdd.addEventListener("click", showPopup);
btnCancel.addEventListener("click", hidePopup);
btnComplete.addEventListener("click", handleClickComplete);
tbody.addEventListener("click", handleButton);
searchInput.addEventListener("input", searchPosts);