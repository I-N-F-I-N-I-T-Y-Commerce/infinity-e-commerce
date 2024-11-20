
const addToCardFunctionality = async () => {
    const quantityElement = document.getElementById('num-get');
    const quantityAmount = quantityElement.innerHTML;
    const productKey = quantityElement.dataset.productId;

    await fetchProductCart(productKey, quantityAmount);
}

const fetchProductCart = async (productKey, quantityAmount) => {
    let url = '../../components/add-to-cart/cart.php';

    if (window.location.pathname === '/src/product-overview/product-overview.php') {
        url = '../components/add-to-cart/cart.php'
    }
    
    try {
        const payload = {
            product_id: productKey,
            quantity: quantityAmount,
            action: "add"
        }

        const response = await fetch(url, {
            method: 'POST',
            headers: {
                "content-type": "application/json",
            }, 
            body: JSON.stringify(payload)
        })

        const data = await response.json();

        if (data.message === 'Successfully Inserted New product to the database') {
            addDom(data, productKey);
            quantityCart()
            deleteCartProductDOM()
        } else {
            document.getElementById(`product-${productKey}-quantity`).innerHTML = data.data.product_quantity
        }
        
        document.getElementById('cart-total-price').innerHTML = `Total Price: ₱ ${data.data.updated_total_price} `
       
        console.log(data)
    } catch(err) {
        console.error(err);
        throw err
    }
}

const addDom = (data, productId) => {
    const cartItemContainer = document.querySelector('.cart-items');
    const productStock = document.getElementById('product-quantity').innerHTML;

    cartItemContainer.innerHTML += `
            <div class="cart-item" data-product-id=${productId} data-product-stock=${productStock}>
                <div class="item-quantity">
                    <button class="left" id="add-product-${productId}">+</button>
                    <span id="product-${productId}-quantity">${data.data.product_quantity}</span>
                    <button class="right" id="subtract-product-${productId}">-</button>
                </div>
                <img src=${data.data.product_image} alt="Shoe Image">
                <div class="item-details">
                    <h3>${data.data.product_name}</h3>
                    <p>₱ ${data.data.product_price}</p>
                </div>
                <div class="trash-btn-container"  data-product-id=${productId}>
                    <span alt="" data-product-id=${productId} class="trash-button">X</span>
                </div>
            </div>
    `;
    

}

const addToCartActivate = () => {
    const cartBtn = document.getElementById('add-to-cart-btn');
    const leftSideContainerBtn = document.getElementById('buy-item-button');
    const popper = document.querySelector('.popper');

    cartBtn.addEventListener('click', () => {
        if (leftSideContainerBtn.classList.contains('buy-item')) {
            leftSideContainerBtn.classList.remove('buy-item');
            leftSideContainerBtn.classList.add('add-to-cart-span');

           
            addToCard('add')

            popper.classList.remove('not-visible');
            popper.classList.add('visible');

            leftSideContainerBtn.innerHTML = "Add to Cart";
        } else {
            addToCard('remove')
            leftSideContainerBtn.classList.remove('add-to-cart-span');
            leftSideContainerBtn.classList.add('buy-item');

            

            popper.classList.remove('visible');
            popper.classList.add('not-visible');

            leftSideContainerBtn.innerHTML = "Buy Item";
        }
    })
}

const quantity = () => {
    const quantityAmount = document.getElementById('num-get')

    incrementQuantity(quantityAmount);
    decrementQuantity(quantityAmount);
}

const incrementQuantity = (quantityAmount) => {
    const incrementBtn = document.querySelector('.container-decrement');
    const productQuantity = document.getElementById('product-quantity').textContent;

    incrementBtn.addEventListener('click', () => {
       
        let currentQuantity = parseInt(quantityAmount.innerHTML, 10);

        if (currentQuantity < productQuantity) {
            currentQuantity += 1;
            quantityAmount.innerHTML = currentQuantity; 
        }
    })
}

const decrementQuantity = (quantityAmount) => {
    const decrementBtn =document.querySelector('.container-increment')

    decrementBtn.addEventListener('click', () => {
        let currentQuantity = parseInt(quantityAmount.innerHTML, 10);
        let prediction = currentQuantity - 1;

        if (currentQuantity > 0 && prediction !== 0) { // * To Avoid niggative numbers
            currentQuantity -= 1;
            quantityAmount.innerHTML = currentQuantity; 
        }
        
    })
}

const addToCard = (message) => {
    const addToCardBtn = document.querySelector('.add-to-cart-span');

    if (message === 'add') {
        addToCardBtn.addEventListener('click', addToCardFunctionality);
        return
    }

    if (message === 'remove') {
        addToCardBtn.removeEventListener('click', addToCardFunctionality)
    }
}


quantity()
addToCartActivate()