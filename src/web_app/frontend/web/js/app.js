const cartCount = document.getElementById('cartCount'); // number of items in cart
const wishlistCount = document.getElementById('wishListCount'); // number of items in wishlist
const loader = document.getElementById('loader-overlay');


function getDataFromUrl(url, intoItem, data = {}) {
    fetch(url, data).then(res => res.text())
        .then(res => intoItem.innerHTML = res)
        .catch(err => console.log(err));
}

function updateCartCounter() {
    let count= parseInt(cartCount.innerText) || 0;
    cartCount.innerText = count + 1;
}

function updateWishlistCounter(success) {
    let count = parseInt(wishlistCount.innerText) || 0;
    success ? count-- : count++
    wishlistCount.innerText = count;
}

function parseLink(link) {
    let splitted = link.split('/');
    splitted[4] = splitted[4] === 'add-to-wishlist' ? 'remove-from-wishlist' : 'add-to-wishlist';
    return splitted.join('/');
}

function sendDataToUrl(url, formSendData = {}){
    return fetch(url, formSendData)
}

function showLoader(){
    if (loader) {
        loader.classList.remove('d-none');
        loader.style.opacity = '1';
    }
}

function hideLoader(){
    if (loader) {
        loader.style.opacity = '0';
        loader.classList.add('d-none')
    }
}

setTimeout(function() {
    $('.alert').fadeOut();
}, 5000);

function showCartSwal() {
    swalWithCustomButtons.fire({
        title: 'Something went wrong!',
        text: 'Your cart is empty!',
        icon: 'error'
    })
}