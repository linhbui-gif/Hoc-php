function Tabs(options){
    const tabContainer = document.getElementById(options.tabContainer)
    const tabElementButton = tabContainer.querySelectorAll('.' + options.tabItem)
    const tabContentElement = tabContainer.querySelectorAll('.' + options.tabContent)
    const length = tabElementButton.length;
    function dynamicCreateDataIndex(){
        tabContainer.querySelectorAll('.tab').forEach((tabElement, index) => {
            tabElement.setAttribute('data-index', index)
        })
    }
    function resetActive(){
        //Remove all class active
        tabElementButton.forEach(tabItem => tabItem.classList.remove('active'))
        //Get lại all khi dom cập nhật thêm phần tử mới
        tabContainer.querySelectorAll('.' + options.tabContent).forEach(tabContentItem => tabContentItem.classList.remove('active'))
    }
    function handleClickTab(event){
        const clicked = event.target; //lấy ra phần tử đang click vào
        //event.currentTarget ==> lấy ra thằng đang add event listener
        if(clicked.classList.contains('tab')){
            //Logic tab
            //reset active
            resetActive();
            //add class active to element click
            clicked.classList.add('active')
            //Tìm content tương ứng
            const refContent = clicked.dataset.index;
            tabContainer.querySelectorAll('.' + options.tabContent)[refContent].classList.add('active')
        }
    }
    function createIndexInit(){
        tabElementButton.forEach((element, index) => {
            element.setAttribute('data-index', index)
        })
    }
    function initEvent(){
        tabContainer.addEventListener('click', handleClickTab)
    }
    function defaultActiveTab(numberIndex){
        if(numberIndex >= length || numberIndex < 0){
            numberIndex = 0;
        }
        //Remove all class active
        resetActive();
        //Set Index
        tabElementButton[numberIndex].classList.add('active')
        //Conect content
        tabContentElement[numberIndex].classList.add('active')
    }
    createIndexInit()
    initEvent()
    //Public function ra ngoài để gọi được
    return {
        activeTabDefault: defaultActiveTab,
        dynamicCreateDataIndex: dynamicCreateDataIndex
    }
}

const tabComponent = new Tabs(
    {
       tabContainer: 'tabs',
       tabItem: 'tab',
       tabContent: 'tabcontent',
    }
)
tabComponent.activeTabDefault(1);


function renderTabList(){
    return `<a class="tab">SolidJS</a>`;
}
function renderTabContent(){
    return (
        `<div class="tabcontent">
            <p>
                <b>Solid</b> is a development platform, built on TypeScrip
                With Angular, you're taking advantage of a platform that can scale
                from single-developer projects to enterprise-level applications. Angular is designed to make
                updating as straightforward as possible, so take advantage of the latest developments with a
                minimum of effort. Best of all, the Angular ecosystem consists of a diverse group of over
                1.7 million developers, library authors, and content creators
            </p>
        </div>`
    );
}
function handleAddMore(){
    //C1: Node Element sử dụng append child
    //C2: 
    const tabButton = document.querySelector('.tabs')
    tabButton.insertAdjacentHTML('beforeend', renderTabList())

    const tabContent = document.querySelector('.content');
    tabContent.insertAdjacentHTML('beforeend', renderTabContent())
    //Update index khi thêm tab mới
    tabComponent.dynamicCreateDataIndex()
}
const buttonAddMore = document.querySelector('.addTab');
buttonAddMore.addEventListener('click', handleAddMore);
