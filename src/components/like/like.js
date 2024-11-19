document.addEventListener("DOMContentLoaded", () => {
    const wishlistButtons = document.querySelectorAll(".add-to-favorites");
    
    wishlistButtons.forEach((button) => {
        button.addEventListener('click', async () => {
            let url = '../../components/like/like.php';

            if (window.location.pathname === '/src/product-overview/product-overview.php') {
                url = '../components/like/like.php'
            }

            const product_id = button.getAttribute("data-id");

            const payload = {
                product_id: product_id
            }

            try {
                const response = await fetch(url, {
                    method: "POST",
                    headers: {
                        "content-type": "application/json",
                    },
                    body: JSON.stringify(payload)
                })

                const data = await response.json();

                checkSignIn(data)

                console.log(data)

                if (data.success && url === '../../components/like/like.php') {
                    changeHeartStatusShop(data, button)
                } else {
                    changeHeartStatusProductOverview(data, button)
                }
            } catch(err) {
                console.error(err);
                throw err;
            }
        })
    })
})

const checkSignIn = (data) => {
    const dataMessage = data.message

    if (dataMessage === 'log in first' && window.location.pathname === '/src/product-overview/product-overview.php') {
        window.location.href = '../authentication/account-sign-in.php';
    } else if (dataMessage === 'log in first' && window.location.pathname !== '/src/product-overview/product-overview.php') {
        window.location.href = '../../authentication/account-sign-in.php';
    }
}



const changeHeartStatusShop = (data, button) => {
    if (data.action === 'liked') {
        button.setAttribute('src', '../../public/heart (7).png'); 
        button.classList.add("liked");
    } else {
        button.setAttribute('src', '../../public/heart (6).png');
        button.classList.remove("liked");
    }
}


const changeHeartStatusProductOverview = (data, button) => {
    if (data.action === 'liked') {
        button.setAttribute('src', '../public/heart (7).png'); 
        button.classList.add("liked");
    } else {
        button.setAttribute('src', '../public/heart (6).png');
        button.classList.remove("liked");
    }
}


