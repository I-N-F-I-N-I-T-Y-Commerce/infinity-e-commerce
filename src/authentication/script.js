let savedFormData = {}

const hidePassword = () => {
    const passwordHideButton = document.getElementById('hide-btn')
    
    const passwordInputElement = document.getElementById('input-password');
    const confirmPasswordInputElement = document.getElementById('input-confirm-password')

    const eyeImageElement = document.getElementById('eye-image');

    passwordHideButton.addEventListener('click', () => {

        if (passwordInputElement.type === 'password' && confirmPasswordInputElement.type === 'password') {
            confirmPasswordInputElement.type = 'text';
            passwordInputElement.type = 'text';
            eyeImageElement.src = '../public/ICON-SHOW-VIEW-0003.png'

            confirmPasswordInputElement.classList.remove('correct')
            confirmPasswordInputElement.classList.add('wrong')

            passwordInputElement.classList.remove('correct')
            passwordInputElement.classList.add('wrong')
        } else {
            confirmPasswordInputElement.type = 'password';
            passwordInputElement.type = 'password';
            eyeImageElement.src = '../public/ICON-HIDE-VIEW-0004.png'

            confirmPasswordInputElement.classList.remove('wrong')
            confirmPasswordInputElement.classList.add('correct')

            passwordInputElement.classList.remove('wrong')
            passwordInputElement.classList.add('correct')
        }
    })
}

const notify = (formInputName, idName, message) => {
    const elementNotifierName = document.getElementById(`notify-${idName}`);
    const elementInputBox = document.getElementById(`input-${idName}`)
    
    if (!formInputName) {
        elementNotifierName.innerText = message;
        elementInputBox.classList.remove('correct')
        elementInputBox.classList.add('wrong')
    } else {
        elementNotifierName.innerText = '';
        elementInputBox.classList.remove('wrong')
        elementInputBox.classList.add('correct')
    }
}

const progressBarCheckpointsFirstStep = (signUpForm) => {
    const checkpoint2 = document.getElementById('point2');
    const checkpoint3 = document.getElementById('point3');

    checkpoint2.addEventListener('click', () => {
        if (checkInputCredentialsFirstStep()) {
            showSecondStep(signUpForm)
        }
    })

    checkpoint3.addEventListener('click', () => {
        if (checkInputCredentialsFirstStep()) {
            showSecondStep(signUpForm)
        }
    })
}

const progressBarCheckpointsSecondStep = (signUpForm) => {
    const checkpoint1 = document.getElementById('point1');
    const checkpoint3 = document.getElementById('point3');

    checkpoint1.addEventListener('click', () => {
        showFirstStep(signUpForm)
    })

    checkpoint3.addEventListener('click', () => {
        if (checkInputCredentialsSecondStep()) {
            showFinalStep(signUpForm)
        }
    })
}

const progressBarCheckpointsFinalStep = (signUpForm) => {
    const checkpoint1 = document.getElementById('point1');
    const checkpoint2 = document.getElementById('point2');

    checkpoint1.addEventListener('click', () => {
        showFirstStep(signUpForm)
    })

    checkpoint2.addEventListener('click', () => {
        showSecondStep(signUpForm)
    })
}

const showFirstStep = (signUpForm) => {
    console.log("Welcome to sign in")

    signUpForm.innerHTML = '';

    signUpForm.innerHTML += `
            <h1>Sign Up for your Account.</h1>
            <h3>Already have an account? <a href="./account-sign-in.php" class="highlight1">Sign In</a></h3>
    
            <form method="POST" action="./account-sign-up.php" onsubmit='return checkInputCredentialsFirstStep()' name='sign-up-form'>
                <label for="firstname">First Name</label><br>
                <input type="text" class="correct" name="firstname" id="input-first-name" value="${savedFormData.firstName || ''}"><br>
                <p id="notify-first-name"></p>

                <label for="last-name">Last Name</label><br>
                <input type="text" class="correct" name="last-name" id="input-last-name" value="${savedFormData.lastName || ''}"><br>
                <p id="notify-last-name"></p>

                <label for="contact-num">Contact Number</label><br>
                <input type="text" class="correct" name="contact-num" id="input-contact-num" value="${savedFormData.contactNum || ''}"><br>
                <p id="notify-contact-num"></p>

                <label for="loc-address">Location Address</label><br>
                <input type="text" class="correct" name="loc-address" id="input-loc-address" value="${savedFormData.locationAddress || ''}"><br>
                <p id="notify-loc-address"></p>

                <input type="submit" value="Next Step" id="submit-btn">
            </form>

            <hr>

            <div class="progress-bar">
                <div class="checkpoint1 on-progress" id="point1"></div>
                <hr class="no-progress">
                <p id="personal" class="on-progress-step">Personal</p>

                <div class="checkpoint2 not-done" id="point2"></div>
                <hr class="no-progress">
                <p id="account" class="not-done-step">Account</p>

                <div class="checkpoint3 not-done" id="point3"></div>
                <p id="submit" class="not-done-step">Submit</p>
            </div>`

    progressBarCheckpointsFirstStep(signUpForm);

    const form = document.forms['sign-up-form'];

    form.addEventListener('submit', (event) => {
        event.preventDefault();  // Prevent the default form submission

        if (checkInputCredentialsFirstStep()) {
            showSecondStep(signUpForm);  // Call the second step after passing validation
        }
    });
}

const checkContactNumber = (formInputName, idName) => {
    const elementNotifierName = document.getElementById(`notify-${idName}`);
    const elementInputBox = document.getElementById(`input-${idName}`)
    
    const validAreaCode = (formInputName[0] === "6" && formInputName[1] === "3") || (formInputName[0] === "0" && formInputName[1] === "9")
    const validNumberLength = (formInputName.length === 11)

    if (!validAreaCode) {
        elementNotifierName.innerText = '* Invalid Area or Starting number code';
        elementInputBox.classList.remove('correct')
        elementInputBox.classList.add('wrong')
        return true
    } else {
        elementNotifierName.innerText = '';
        elementInputBox.classList.remove('wrong')
        elementInputBox.classList.add('correct')
    }

    if (!validNumberLength) {
        elementNotifierName.innerText = '* Contact Number should be in 11 Digits';
        elementInputBox.classList.remove('correct')
        elementInputBox.classList.add('wrong')
        return true
    } else {
        elementNotifierName.innerText = '';
        elementInputBox.classList.remove('wrong')
        elementInputBox.classList.add('correct')
    }

    return false
}

const checkInputCredentialsFirstStep = () => {
    let form = document.forms['sign-up-form']
    let firstName = form['firstname'].value
    let lastName = form['last-name'].value
    let contactNum = (form['contact-num'].value)
    let locationAddress = form['loc-address'].value

    notify(firstName, 'first-name','* First Name is needed')
    
    notify(lastName, 'last-name','* Last Name is needed')

    notify(contactNum, 'contact-num','* Contact Number is needed')

    notify(locationAddress, 'loc-address','* Location Address is needed')

    if (checkContactNumber(contactNum, 'contact-num')) return false
    
    if (!firstName || !lastName || !contactNum || !locationAddress) return false

    savedFormData = { ...savedFormData, firstName, lastName, contactNum, locationAddress };

    return true
}

const showSecondStep = (signUpForm) => {

    signUpForm.innerHTML = '';

    signUpForm.innerHTML += `
            <h1>Sign Up for your Account.</h1>
            <h3>Already have an account? <a href="./account-sign-in.php" class="highlight1">Sign In</a></h3>
    
            <form method="POST" onsubmit='return checkInputCredentialsSecondStep()' name='sign-up-form'>
                <label for="username">User Name</label><br>
                <input type="text" class="correct" name="username" id="input-user-name" value="${savedFormData.userName || ''}"><br>
                <p id="notify-user-name"></p>

                <label for="email">Email</label><br>
                <input type="text" class="correct" name="email" id="input-email" value="${savedFormData.email || ''}"><br>
                <p id="notify-email"></p>

                <label for="password">Password</label><br>
                <input type="password" class="correct" name="password" id="input-password" value="${savedFormData.password || ''}"><br>
                <p id="notify-password"></p>

                <label for="confirm-password">Confirm Password</label><br>
                <input type="password" class="correct" name="confirm-password" id="input-confirm-password" value="${savedFormData.confirmPassword || ''}"><br>
                <p id="notify-confirm-password"></p>

                <input type="submit" value="Next Step">
            </form>

            <div class="hide-password-container">
                <div class="hide-password-btn wrong" id="hide-btn">
                    <img src="../public/ICON-HIDE-VIEW-0004.png" alt="" id="eye-image">
                </div>
                <p>Show Password</p>
            </div>

            <hr>

            <div class="progress-bar">
                <div class="checkpoint1 done" id="point1"></div>
                <hr class="done-progress">
                <p id="personal" class="done-on-step">Personal</p>

                <div class="checkpoint2 on-progress"></div>
                <hr class="no-progress">
                <p id="account" class="on-progress-step" id="point2">Account</p>

                <div class="checkpoint3 not-done" id="point3"></div>
                <p id="submit" class="not-done-step">Submit</p>
            </div>`
    
    progressBarCheckpointsSecondStep(signUpForm)
    hidePassword()
    
    const form = document.forms['sign-up-form'];

    form.addEventListener('submit', (event) => {
        event.preventDefault();  // Prevent the default form submission

        if (checkInputCredentialsSecondStep()) {
            showFinalStep(signUpForm);  // Call the second step after passing validation
        }
    });
}

const checkPassword = (password, confirmPassword, passwordElementId, confirmPasswordElementId) => {
    const passwordNotifyElement = document.getElementById(`notify-${passwordElementId}`);
    const passwordInputElement = document.getElementById(`input-${passwordElementId}`);

    const confirmPasswordNotifyElement = document.getElementById(`notify-${confirmPasswordElementId}`);
    const confirmPasswordInputElement = document.getElementById(`input-${confirmPasswordElementId}`);

    if (password !== confirmPassword) {
        passwordNotifyElement.innerText = "* Password didnt match";
        confirmPasswordNotifyElement.innerText =  "* Password didnt match";

        passwordInputElement.classList.remove('correct')
        passwordInputElement.classList.add('wrong')

        confirmPasswordInputElement.classList.remove('correct')
        confirmPasswordInputElement.classList.add('wrong')
        
        console.log(password, confirmPassword)
        return true
    } else {
        passwordNotifyElement.innerText = '';
        confirmPasswordNotifyElement.innerText = '';
        passwordInputElement.classList.remove('wrong')
        passwordInputElement.classList.add('correct')

        confirmPasswordInputElement.classList.remove('wrong')
        confirmPasswordInputElement.classList.add('correct')
    }

    return false
}

const checkEmail = (formInputName, idName) => {
    const elementNotifierName = document.getElementById(`notify-${idName}`);
    const elementInputBox = document.getElementById(`input-${idName}`)

    const validEmails = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(formInputName);

    if (!validEmails) {
        elementNotifierName.innerText = "Invalid Email Address";
        elementInputBox.classList.remove('correct')
        elementInputBox.classList.add('wrong')

        return true
    } else {
        elementNotifierName.innerText = '';
        elementInputBox.classList.remove('wrong')
        elementInputBox.classList.add('correct')
    }

    return false
}

const checkInputCredentialsSecondStep = () => {
    let form = document.forms['sign-up-form']
    let userName = form['username'].value
    let email = form['email'].value
    let password = form['password'].value
    let confirmPassword = form['confirm-password'].value

    notify(userName, 'user-name','* Username is needed')
    
    notify(email, 'email','* Email is needed')

    notify(password, 'password','* Password is needed')

    notify(confirmPassword, 'confirm-password','* Confirmation of Password is needed')

    if (checkPassword(password, confirmPassword, 'password', 'confirm-password')) return false

    if (checkEmail(email, 'email')) return false

    if (!userName || !email || !password || !confirmPassword ) return false

    savedFormData = { ...savedFormData, userName, email, password};
    return true
}

const showFinalStep = (signUpForm) => {
        signUpForm.innerHTML = ''

        signUpForm.innerHTML += `
                <h1>Sign Up for your Account.</h1>
                <h3>Already have an account? <a href="./account-sign-in.php" class="highlight1">Sign In</a></h3>
        
                <!-- * Put the php file here in ' action ' attribute -->
                <form action="./account-sign-up.php" method="POST">
                    <input type="hidden" name="formData" value='${JSON.stringify(savedFormData)}'>
                    <div class="terms-image-container">
                        <img src="../public/IMG-TERMS-0001.png" alt="">
                        <div class="circle-shoe-highlight1"></div>
                        <div class="circle-shoe-highlight2"></div>
                    </div>  
                    <label for="submit" id="terms-conditions">
                        To Proceed, please accept our <span class="highlight-terms"> Terms and Conditions. </span><br>

                        <br>
                        Its Important that you read and understand then before continuing to buy our Products
                    </label>

                    <input type="submit" value="Submit" name="submit">
                </form>

                <hr>

                <div class="progress-bar">
                    <div class="checkpoint1 done" id="point1"></div>
                    <hr class="done-progress">
                    <p id="personal" class="done-on-step">Personal</p>

                    <div class="checkpoint2 done" id="point2"></div>
                    <hr class="done-progress">
                    <p id="account" class="done-on-step">Account</p>

                    <div class="checkpoint3 on-progress" id="point3"></div>
                    <p id="submit" class="on-progress-step">Submit</p>
                </div>`
        progressBarCheckpointsFinalStep(signUpForm)
        console.log(savedFormData);
}

const signUpForm = () => {
    const signUpForm = document.getElementById('sign-up-form')
    console.log('lol')
    showFirstStep(signUpForm)
}

const main = () => {
    console.log("Lmao")
    signUpForm()
}

main()
