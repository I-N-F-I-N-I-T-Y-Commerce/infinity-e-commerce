let savedCheckoutData = {};

const notify = (formInputName, idName, message) => {
    const elementNotifierName = document.getElementById(`notify-${idName}`);
    const elementInputBox = document.getElementById(`input-${idName}`);
    
    if (!formInputName) {
        elementNotifierName.innerText = message;
        elementInputBox.classList.remove('correct');
        elementInputBox.classList.add('wrong');
    } else {
        elementNotifierName.innerText = '';
        elementInputBox.classList.remove('wrong');
        elementInputBox.classList.add('correct');
    }
};

const progressBarCheckpointsFirstStep = (checkoutForm) => {
    const checkpoint2 = document.getElementById('point2');
    const nextButton = document.querySelector('#delivery-form input[type="submit"]');

    nextButton.addEventListener('click', (event) => {
        event.preventDefault();
        if (validateInfo()) {
            showShippingMethodStep(checkoutForm);
        }
    });

    checkpoint2.addEventListener('click', () => {
        if (validateInfo()) {
            showShippingMethodStep(checkoutForm);
        }
    });
};

const progressBarCheckpointsSecondStep = (checkoutForm) => {
    const checkpoint1 = document.getElementById('point1');
    const checkpoint3 = document.getElementById('point3');
    const nextButton = document.querySelector('#shipping-form input[type="submit"]');

    checkpoint1.addEventListener('click', () => {
        

        showDeliveryInfoStep(checkoutForm);
    });

    nextButton.addEventListener('click', (event) => {
        event.preventDefault();
        console.log('Shipping form submitted');
        showPaymentStep(checkoutForm);  
    });

    checkpoint3.addEventListener('click', () => {
        showPaymentStep(checkoutForm); 
    });
};

const progressBarCheckpointsThirdStep = (checkoutForm) => {
    const checkpoint4 = document.getElementById('point4');
    const nextButton = document.querySelector('#payment-form input[type="submit"]');

   
    nextButton.addEventListener('click', (event) => {
        event.preventDefault();
        showDoneStep(checkoutForm);  // Show the final step
    });

    checkpoint4.addEventListener('click', () => {
        showDoneStep(checkoutForm); // Show the final step
    });
};


const validateInfo = () => {
    const form = document.forms['checkout-form'];
    const loc1 = form['loc1'].value.trim();
    const postal = form['postal'].value.trim();
    const loc2 = form['loc2'].value.trim();

    let isValid = true;

    if (!loc1) {
        notify(false, 'loc1', '* Location is required');
        isValid = false;
    } else {
        notify(true, 'loc1', '');
    }

    if (!postal) {
        notify(false, 'postal', '* Postal code is required');
        isValid = false;
    } else {
        notify(true, 'postal', '');
    }

    if (!loc2) {
        notify(false, 'loc2', '* Location is required');
        isValid = false;
    } else {
        notify(true, 'loc2', '');
    }

    if (isValid) {
        savedCheckoutData = { ...savedCheckoutData, loc1, postal, loc2 };
    }

    return isValid;
};

const showDeliveryInfoStep = (checkoutForm) => {
    checkoutForm.innerHTML = `
        <h1>Delivery Location.</h1>
        <h2>Let us know where to <span>drop off</span> the <span>package</span>.</h2>
        <form id="delivery-form" name="checkout-form">
            <label for="loc1">Street Name, Building, House No.</label><br>
            <input type="text" id="input-loc1" name="loc1" value="${savedCheckoutData.loc1 || ''}"><br>
            <p id="notify-loc1"></p>

            <label for="postal">Postal Code</label><br>
            <input type="text" id="input-postal" name="postal" value="${savedCheckoutData.postal || ''}"><br>
            <p id="notify-postal"></p>

            <label for="loc2">Barangay, City, Province, Region</label><br>
            <input type="text" id="input-loc2" name="loc2" value="${savedCheckoutData.loc2 || ''}"><br>
            <p id="notify-loc2"></p>

            <input type="submit" value="Next Step">
        </form>

        <hr class="line">

        <div class="progress-bar">
            <div class="checkpoint1 on-progress" id="point1"></div>
            <hr class="no-progress">
            <p id="delivery" class="on-progress-step">Delivery</p>

            <div class="checkpoint2 not-done" id="point2"></div>
            <hr class="no-progress">
            <p id="shipping" class="not-done-step">Shipping</p>

            <div class="checkpoint3 not-done" id="point3"></div>
            <p id="payment" class="not-done-step">Payment</p>
    `;

    progressBarCheckpointsFirstStep(checkoutForm);
};

const showShippingMethodStep = (checkoutForm) => {
    checkoutForm.innerHTML = `
        <h1>Shipping Info.</h1>
        <h2>We will need your information to enable to <span>notify you</span>.</h2>
        <form id="shipping-form" name="checkout-form">
            <label for="first-name">First Name</label><br>
            <input type="text" id="input-first-name" name="first-name" value="${savedCheckoutData.firstname || ''}"><br>
            <p id="notify-first-name"></p>

            <label for="last-name">Last Name</label><br>
            <input type="text" id="input-last-name" name="last-name" value="${savedCheckoutData.lastname || ''}"><br>
            <p id="notify-last-name"></p>

            <label for="contact">Contact Number</label><br>
            <input type="text" id="input-contact" name="contact" value="${savedCheckoutData.contact || ''}"><br>
            <p id="notify-contact"></p>

            <label for="email">Email Address</label><br>
            <input type="text" id="input-email" name="email" value="${savedCheckoutData.email || ''}"><br>
            <p id="notify-email"></p>

            <input type="submit" value="Next Step">
        </form>

        <hr class="line">

        <div class="progress-bar">
            <div class="checkpoint1 done" id="point1"></div>
            <hr class="done-progress">
            <p id="delvery" class="done-step">Delivery</p>

            <div class="checkpoint2 on-progress" id="point2"></div>
            <hr class="no-progress">
            <p id="shipping" class="on-progress-step">Shipping</p>

            <div class="checkpoint3 not-done" id="point3"></div>
            <p id="payment" class="not-done-step">Payment</p>
        </div>
    `;

    progressBarCheckpointsSecondStep(checkoutForm);
};

const showPaymentStep = (checkoutForm) => {

    const checkoutContainer = document.querySelector('.checkout-container');
    checkoutContainer.innerHTML =`
    <div class="cart-header">
                    <h2>Total Price: ₱ 768,324.00 </h2>
                    <div class="block"></div>
                </div>
                <div class="cart-items">
                    <!-- Cart Item 1 -->
                    <div class="cart-item">
                        <div class="item-quantity">
                            <button class="left">+</button>
                            <span>2</span>
                            <button class="right">-</button>
                        </div>
                        <img src="https://via.placeholder.com/80" alt="Shoe Image">
                        <div class="item-details">
                            <h3>The Berry Good Days</h3>
                            <p>₱ 2,978</p>
                        </div>
                    </div>
                    <!-- Cart Item 2 -->
                    <div class="cart-item">
                        <div class="item-quantity">
                            <button class="left">+</button>
                            <span>3</span>
                            <button class="right">-</button>
                        </div>
                        <img src="https://via.placeholder.com/80" alt="Shoe Image">
                        <div class="item-details">
                            <h3>The Berry Good Days</h3>
                            <p>₱ 2,978</p>
                        </div>
                    </div>
                    <!-- Cart Item 3 -->
                    <div class="cart-item">
                        <div class="item-quantity">
                            <button class="left">+</button>
                            <span>4</span>
                            <button class="right">-</button>
                        </div>
                        <img src="https://via.placeholder.com/80" alt="Shoe Image">
                        <div class="item-details">
                            <h3>The Berry Good Days</h3>
                            <p>₱ 2,978</p>
                        </div>
                    </div>
                </div>`; 
    checkoutForm.innerHTML = `
        <h1>Finalize Order.</h1>
        <h2>for now as <span>cash on delivery</span> will be <span>on work</span>.</h2>
        <p class="peso">₱ <span class=total>12334324</span></p>
        <form id="payment-form" name="checkout-form">
            <label for="card-number">Card Number</label><br>
            <input type="text" id="input-card-number" name="card-number"}"><br>
            <p id="notify-card-number"></p>
            <div class="container1">

                <div class=exiry-container>
                    <label for="expiry-date">Expiry Date (MM/YY)</label><br>
                    <input type="text" id="input-expiry-date" name="expiry-date"}"><br>
                    <p id="notify-expiry-date"></p>
                    <button class="buttons" id=cashin value="${savedCheckoutData.cashin || ''}" >Cash In</button>
                </div>

                <div class="cvv-container">
                    <label for="cvv">CVV</label><br>
                    <input type="text" id="input-cvv" name="cvv"}"><br>
                    <p id="notify-cvv"></p>
                    <button class="buttons" id=card >Card</button>
                </div>
            </div>

            <input type="submit" value="Make Payment">
        </form>

        <hr class="line">

        <div class="progress-bar">
            <div class="checkpoint1 done" id="point1"></div>
            <hr class="done-progress">
            <p id="delivery" class="done-step">Delivery</p>

            <div class="checkpoint2 done" id="point2"></div>
            <hr class="done-progress">
            <p id="shipping" class="done-step">Shipping</p>

            <div class="checkpoint3 on-progress" id="point3"></div>
            <p id="payment" class="on-progress-step">Payment</p>

        </div>

        
    `;

    progressBarCheckpointsThirdStep(checkoutForm);
};

// New Done Step
const showDoneStep = (checkoutForm) => {
    const checkoutContainer = document.querySelector('.checkout-container');
    checkoutContainer.innerHTML =`
    <div class="toppicture">
                    <img class="ket" src="../public/logo_infinity-removebg-preview.png" alt="ket">
                    <h2 class="infinity"> I N F I N I T Y</h2>
                </div>
                <img class="bas" src="../public/nigger.jfif" alt="bas">
                <h3 class="comingsoon">Coming Soon.</h2>
                `;


    checkoutForm.innerHTML = `
        <img src="../public/bag 1.png" alt="Search icon">
        <p class=done-speech><span class=green>Thank you for our purchase!</span>🎉
        Your order is being processed, and we'll notify you once it's shipped.
        Get ready to <span> step into your dreams!</p>

        <input type="submit" value="Alright">
        <div class="progress-bar">
            <div class="checkpoint1 done" id="point1"></div>
            <hr class="done-progress">
            <p id="delivery" class="done-step">Delivery</p>

            <div class="checkpoint2 done" id="point2"></div>
            <hr class="done-progress">
            <p id="shipping" class="done-step">Shipping</p>

            <div class="checkpoint3 done" id="point3"></div>
            <p id="payment" class="done-step-step">Payment</p>

        </div>
    `;
    progressBarCheckpointsFirstStep(checkoutForm);
};

const checkoutForm = () => {
    const checkoutFormElement = document.getElementById('checkout-form');
    showDeliveryInfoStep(checkoutFormElement);
};

const main = () => {
    checkoutForm();
};

main();
