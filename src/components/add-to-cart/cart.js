document.addEventListener('DOMContentLoaded', async () => {
    let url = '../../components/add-to-cart/cart.php';

    if (window.location.pathname === '/src/product-overview/product-overview.php') {
        url = '../components/add-to-cart/cart.php'
    }

    try {
        const payload = {
            product_id: 9,
            quantity: 0,
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

        console.log(data)
    } catch(err) {
        console.error(err);
        throw err
    }
})