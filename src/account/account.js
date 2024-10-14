const hoveredImage = (imageContainer, imageElement, imagePath) => {
    imageContainer.addEventListener('mouseenter', () => {
        imageElement.src = imagePath;
    })
}

const originalImage = (imageContainer, imageElement, imagePath) => {
    imageContainer.addEventListener('mouseleave', () => {
        imageElement.src = imagePath;
    })
}

const handleImageHovers = () => {

    const myAccount = (elementIdName) => {
        const imageContainer = document.getElementById(elementIdName);

        if (imageContainer.classList.contains('current')) {
            return
        }

        const imageElement =  document.getElementById(`${elementIdName}-btn`);
        hoveredImage(imageContainer, imageElement, '../../public/user-profile/account-b.png');
        originalImage(imageContainer, imageElement, '../../public/user-profile/account.png');
    }

    const myInbox = (elementIdName) => {
        const imageContainer = document.getElementById(elementIdName);

        if (imageContainer.classList.contains('current')) {
            return
        }

        const imageElement =  document.getElementById(`${elementIdName}-btn`);
        hoveredImage(imageContainer, imageElement, '../../public/user-profile/inbox-b.png');
        originalImage(imageContainer, imageElement, '../../public/user-profile/inbox.png');
    }

    const myWishList = (elementIdName) => {
        const imageContainer = document.getElementById(elementIdName);

        if (imageContainer.classList.contains('current')) {
            return
        }

        const imageElement =  document.getElementById(`${elementIdName}-btn`);
        hoveredImage(imageContainer, imageElement, '../../public/user-profile/wishlist-b.png');
        originalImage(imageContainer, imageElement, '../../public/user-profile/wishlist.png');
    }

    const myOrders = (elementIdName) => {
        const imageContainer = document.getElementById(elementIdName);

        if (imageContainer.classList.contains('current')) {
            return
        }
        
        const imageElement =  document.getElementById(`${elementIdName}-btn`);
        hoveredImage(imageContainer, imageElement, '../../public/user-profile/orders-b.png');
        originalImage(imageContainer, imageElement, '../../public/user-profile/orders.png');
    }

    myAccount('my-account');
    myOrders('my-orders');
    myWishList('my-wishlist');
    myInbox('my-inbox');
}

const main = () => {
    handleImageHovers()
}

main()