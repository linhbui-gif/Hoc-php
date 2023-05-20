class Tabs {
    constructor(container){
        this.container = container;
        this.handleClickTab = this.handleClickTab.bind(this)
    }
    init() {
        this.container.addEventListener('click', this.handleClickTab)
    }
    handleClickTab(event){
        const clicked = event.target; //lấy ra phần tử đang click vào
        //event.currentTarget ==> lấy ra thằng đang add event listener
        if(clicked.classList.contains('tab')){
            //Logic tab
            this.resetActive()
            //add class active to element click
            clicked.classList.add('active')
            //Tìm content tương ứng
            const refContent = clicked.dataset.index;
            this.container.querySelectorAll('.tabcontent')[refContent].classList.add('active')
        }
    }
    resetActive(){
        this.container.querySelectorAll('.tab').forEach(tabItem => tabItem.classList.remove('active'))
        //Get lại all khi dom cập nhật thêm phần tử mới
        this.container.querySelectorAll('.tabcontent').forEach(tabContentItem => tabContentItem.classList.remove('active'))
    }
}
const tabInstance = new Tabs(document.getElementById('tabs'));
tabInstance.init()