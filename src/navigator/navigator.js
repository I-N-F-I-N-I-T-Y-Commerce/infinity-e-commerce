/**
 * Almighty popper 🦖✨
 */
const popper = () => {
    const cartButtons = document.querySelectorAll('.cart-button');
    const popper = document.querySelector('.popper');

    cartButtons.forEach(button => {
        button.addEventListener('click', (e) => {
            e.stopPropagation(); 
            
            if (popper.classList.contains('not-visible')) {
                popper.classList.remove('not-visible');
                popper.classList.add('visible');
            } else {
                popper.classList.remove('visible');
                popper.classList.add('not-visible');
            }
        });
    });

    // document.addEventListener('click', (e) => {
    //     if (!popper.contains(e.target)) {
    //         if (popper.classList.contains('visible')) {
    //             popper.classList.remove('visible');
    //             popper.classList.add('not-visible');
    //         }
    //     }
    // });
};

const deleteCartProductDOM = () => {
    const cartPriceStatus = document.getElementById('cart-total-price');

    document.querySelectorAll('.trash-button').forEach(button => {
        button.addEventListener('click', async function () {
            const cartItem = this.closest('.cart-item');
    
            if (cartItem) {
                
                const productId = cartItem.dataset.productId;
    
                const data = await fetchDeleteProductCart(productId, 1);
                cartPriceStatus.innerHTML = `Total Price: ₱ ${data.data.updated_total_price}`;

                console.log('Removing product with ID:', productId);
    
                
                cartItem.remove();
            }
        });
    });
}

const fetchDeleteProductCart = async (productKey, quantityAmount) => {
    let url = '../../components/add-to-cart/cart.php';

    if (window.location.pathname === '/src/product-overview/product-overview.php' || window.location.pathname === '/src/home/index.php') {
        url = '../components/add-to-cart/cart.php'
    }

    try {
        const payload = {
            product_id: productKey,
            quantity: quantityAmount,
            action: "remove"
        }

        const response = await fetch(url, {
            method: 'POST',
            headers: {
                "content-type": "application/json",
            }, 
            body: JSON.stringify(payload)
        })

        const data = await response.json();

        return data
    } catch(err) {
        console.error(err);
        throw err
    }
}


const quantityCart = () => {
    const cartItem = document.querySelectorAll('.cart-item');

    cartItem.forEach(button => {
        const productId = button.dataset.productId;
        const productStock = button.dataset.productStock;
       
        incrementCartQuantity(productId, productStock);
        decrementCartQuantity(productId, productStock, button);
    })
}

const incrementCartQuantity = (productId, productStock) => {
    const incrementBtn = document.getElementById(`add-product-${productId}`);
    const quantityAmount = document.getElementById(`product-${productId}-quantity`);
    const cartPriceStatus = document.getElementById('cart-total-price');
    
    incrementBtn.addEventListener('click', async() => {
        let currentQuantity = parseInt(quantityAmount.innerHTML, 10);

        if (currentQuantity < productStock) {
            currentQuantity += 1;
            const data = await fetchAddProduct(productId);
            cartPriceStatus.innerHTML = `Total Price: ₱ ${data.data.updated_total_price}`;
            quantityAmount.innerHTML = currentQuantity; 
        }
    })
}

const decrementCartQuantity = (productId, productStock, button) => {
    const decrementBtn =document.getElementById(`subtract-product-${productId}`);
    const quantityAmount = document.getElementById(`product-${productId}-quantity`);
    const cartPriceStatus = document.getElementById('cart-total-price');

    decrementBtn.addEventListener('click', async () => {
        let currentQuantity = parseInt(quantityAmount.innerHTML, 10);

        let prediction = currentQuantity - 1;

        if (prediction === 0) {
            const cartItem = button;
    
            if (cartItem) {
                
                const productId = cartItem.dataset.productId;
    
                const data = await fetchDeleteProductCart(productId, 1);
                cartPriceStatus.innerHTML = `Total Price: ₱ ${data.data.updated_total_price}`;

                console.log('Removing product with ID:', productId);
    
                cartItem.remove();
            }
        }
        
        if (currentQuantity > 0 && prediction !== 0) { // * To Avoid niggative numbers
            currentQuantity -= 1;
            const data = await fetchSubtractProduct(productId);
            cartPriceStatus.innerHTML = `Total Price: ₱ ${data.data.updated_total_price}`;

            quantityAmount.innerHTML = currentQuantity; 
        }

        
    })
}


const fetchAddProduct = async (productKey) => {
    let url = '../../components/add-to-cart/cart.php';

    if (window.location.pathname === '/src/product-overview/product-overview.php' || window.location.pathname === '/src/home/index.php') {
        url = '../components/add-to-cart/cart.php'
    }

    try {
        const payload = {
            product_id: productKey,
            quantity: 1,
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

       return data
    } catch(err) {
        console.error(err);
        throw err
    }
}


const fetchSubtractProduct = async (productKey) => {
    let url = '../../components/add-to-cart/cart.php';

    if (window.location.pathname === '/src/product-overview/product-overview.php' || window.location.pathname === '/src/home/index.php') {
        url = '../components/add-to-cart/cart.php'
    }

    try {
        const payload = {
            product_id: productKey,
            quantity: 1,
            action: "subtract"
        }

        const response = await fetch(url, {
            method: 'POST',
            headers: {
                "content-type": "application/json",
            }, 
            body: JSON.stringify(payload)
        })

        const data = await response.json();

       return data
    } catch(err) {
        console.error(err);
        throw err
    }
}

quantityCart();
deleteCartProductDOM()
popper();