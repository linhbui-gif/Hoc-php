let carts = [
    {
        id: 1,
        title: 'Samsung Galaxy S7',
        price: 10,
        img: 'https://res.cloudinary.com/diqqf3eq2/image/upload/v1583368215/phone-2_ohtt5s.png',
        amount: 2,
    },

    {
        id: 2,
        title: 'google pixel ',
        price: 20,
        img: 'https://res.cloudinary.com/diqqf3eq2/image/upload/v1583371867/phone-1_gvesln.png',
        amount: 1,
    },

    {
        id: 3,
        title: 'Xiaomi Redmi Note 2',
        price: 50,
        img: 'https://res.cloudinary.com/diqqf3eq2/image/upload/v1583368224/phone-3_h2s6fo.png',
        amount: 3,
    }
];
const cartWrapper = document.querySelector('.cart-wrapper')
const sumPrice = sum(carts);
const sumAmount = sum(carts, true)
const cartTotal = document.querySelector('.cart-total h4 span')
const totalAmountElement = document.querySelector('.total-amount')


function renderItem(data){
    return `<article class="cart-item">
    <img src=${data.img}
        alt="" />
    <div>
        <h4>${data.title}</h4>
        <h4 class="item-price">${data.price}</h4>
        <button class="remove-btn" data-id=${data.id}>remove</button>
    </div>
    <div>

        <!-- {/* increase amount */} -->
        <button class="amount-btn">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path d="M10.707 7.05L10 6.343 4.343 12l1.414 1.414L10 9.172l4.243 4.242L15.657 12z" />
            </svg>
        </button>

        <!-- {/* amount */} -->
        <p class="amount">${data.amount}</p>

        <!-- {/* decrease amount */} -->

        <button class="amount-btn">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
            </svg>
        </button>

    </div>
</article>`
 
}

function sum(carts, isQuantity){
    return carts.reduce((curr,acc) => {
       if(isQuantity){
         return curr + acc.amount;
       } else{
         return curr + (acc.price * acc.amount);
       }
    }, 0)
 }
function renderCart(){
    carts.map(element => {
        return cartWrapper.insertAdjacentHTML('beforeend', renderItem(element))
    })
}
function renderTotal(){
    const totalPrice = sum(carts)
    const totalAmount = sum(carts, true)
    cartTotal.textContent = totalPrice
    totalAmountElement.textContent = totalAmount
}

//Event click removeItem 
function onRemoveItem(event){
    const clickedItem = event.target;
    if(clickedItem.classList.contains('remove-btn')){
        const idCart = clickedItem.getAttribute('data-id');
        clickedItem.closest(".cart-item").remove() //Tìm lên phần tử cha
        carts = carts.filter(element => element.id !== Number(idCart))
        renderTotal()
    }
}

cartWrapper.addEventListener('click', onRemoveItem);
renderCart()
renderTotal()
