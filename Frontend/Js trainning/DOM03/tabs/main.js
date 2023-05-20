//Cach lam 1

const tabContainer = document.querySelector('#tabs')
const tabElementButton = document.querySelectorAll('.tab')
const tabContentElement = document.querySelectorAll('.tabcontent')

function hanlderClickTab(event){
   const clicked = event.target; //lấy ra phần tử đang click vào
   //event.currentTarget ==> lấy ra thằng đang add event listener
   if(clicked.classList.contains('tab')){
      //Logic tab
      //reset active
      tabElementButton.forEach(tabItem => tabItem.classList.remove('active'))
      //add class active to element click
      clicked.classList.add('active')
      //Tìm content tương ứng
      tabContentElement.forEach(tabContentItem => tabContentItem.classList.remove('active'))
      const refContent = clicked.dataset.ref;
      // const refContent = clicked.getAttribute('data-ref');
      const tabContent = document.querySelector(refContent)
      tabContent.classList.add('active')
   }
}

tabContainer.addEventListener('click', hanlderClickTab)