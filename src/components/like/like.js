document.addEventListener("DOMContentLoaded", () => {
    const wishlistButtons = document.querySelectorAll(".add-to-favorites");
    

    wishlistButtons.forEach((button) => {
        button.addEventListener('click', async () => {
            const product_id = button.getAttribute("data-id");
            const action = button.classList.contains("liked") ? "unliked" : "liked"

            const payload = {
                product_id: product_id,
                action: action
            }
            try {
                const response = await fetch("../../components/like/like.php", {
                    method: "POST",
                    headers: {
                        "content-type": "application/json",
                    },
                    body: JSON.stringify(payload)
                })

                const data = await response.json();

                checkSignIn(data)

                console.log(data)
            } catch(err) {
                console.error(err);
                throw err;
            }
        })
    })
})

const checkSignIn = (data) => {
    const dataMessage = data.message

    if (dataMessage === 'log in first') {
        window.location.href = '../../authentication/account-sign-in.php'
    }
}