document.addEventListener("DOMContentLoaded", () => {
    const parent = document.querySelector('.star-container')

    const starButtons = document.querySelectorAll('.star');
    const productId = parent.dataset.productId;


    starButtons.forEach(button => {
        button.addEventListener('click', async () => {
            const starId = parseInt(button.dataset.id);

            try {
                const response = await fetch('../components/rating/rating.php', {
                    method: 'POST',
                    headers: {
                        "content-type": 'application/json',
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        rating: starId
                    })
                });

                const data = await response.json();

                checkSignIn(data)
                console.log(button,starId)
                if (data.success) {
                    await automaticRatingFill(starId, starButtons);
                    await updateHTML(data, starButtons)
                    console.log(data)
                } else {
                    console.log(data.message);
                    console.log(data)
                }
            } catch(err) {
                console.error(err);
                throw err
            }
        })
    });
})

const automaticRatingFill = (ratingNum, starButtons) => {
    for (let i = 0; i < starButtons.length; i++) {
        const rating = i < ratingNum ? starButtons[i].src = '../public/star.png' : starButtons[i].src = '../public/star (3).png';
    }
}

const updateHTML = (data, starButtons) => {
    const numOfRatings = data.num_rating;
    const overallRating = data.overall_rating;
    const userRating = data.rating;

    const htmlRating = document.getElementById('rating');
    const htmlOverallRating = document.getElementById('rating-info');
    const htmlUserRating = document.getElementById('num-review')

    starButtons.forEach(button => button.style.pointerEvents = 'none');
    htmlRating.classList.add('roll-out');
    
    setTimeout(() => {
        htmlRating.innerHTML = overallRating;
        htmlOverallRating.innerHTML = `Overall ratings based on ${numOfRatings} reviews in Total`;
        htmlUserRating.innerHTML = `Your ${userRating} Rating`;

        
        htmlRating.classList.add('roll-in');
       

        setTimeout(() => {
            htmlRating.classList.remove('roll-out', 'roll-in');
            htmlOverallRating.classList.remove('roll-out', 'roll-in');
            htmlUserRating.classList.remove('roll-out', 'roll-in');
            starButtons.forEach(button => button.style.pointerEvents = 'auto');
        }, 1000); 
    }, 600); 
}