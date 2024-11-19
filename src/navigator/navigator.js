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

    document.addEventListener('click', (e) => {
        if (!popper.contains(e.target)) {
            if (popper.classList.contains('visible')) {
                popper.classList.remove('visible');
                popper.classList.add('not-visible');
            }
        }
    });
};

popper();
