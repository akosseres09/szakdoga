const sizeItems = document.querySelectorAll('.size-item'); // size-picker on view
const sizeInput = document.getElementById('cart-size'); // cart-size number
const deleteBtn = document.querySelectorAll('.deleteFromCart'); // delete from cart button
const cartForm = document.getElementById('place-in-cart-form');
const cartCount = document.getElementById('cartCount'); // number of items in cart
const wishlistCount = document.getElementById('wishListCount'); // number of items in wishlist
const loader = document.getElementById('loader-overlay');
const wishlistBtn = document.querySelector('.wishlist-btn');
const updateUserBtn = document.getElementById('updateUserBtn');
const editUserModal = document.getElementById('userEditModal');


// Handles Picking a size on the View page
if (sizeItems && sizeInput) {
    sizeItems.forEach(item => {
       item.addEventListener('click', () => {
           const active = document.querySelector('.size-picker .size-item.active');
           if (active !== null) {
               active.classList.remove('active');
           }
           item.classList.add('active');
           sizeInput.value = item.innerText;
       });
    });
}

// handles deleting an item from the cart via fetch
if (deleteBtn) {
    deleteBtn.forEach(btn => {
       btn.addEventListener('click', function (e) {
           e.preventDefault();
           e.stopPropagation();
           e.stopImmediatePropagation();

           const form = document.getElementById('deleteCartForm');
           const data = new FormData(form);
           Swal.fire({
               title: "Delete This Item From Your cart?",
               icon: "warning",
               showCancelButton: true,
               confirmButtonText: "Yes, Delete!",
               cancelButtonText: "No, Rather Not!",
           }).then(res => {
               if (res.isConfirmed) {
                   fetch(form.action, {
                       method: "POST",
                       body: data
                   }).then(() => {
                       window.location.reload();
                   }).catch(err => console.log(err))
               }
           });
       });
    });
}

// handles the submission of the view page form
if (cartForm) {
    cartForm.addEventListener('submit', function (e) {
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();
        const form = e.target;
        const formData = new FormData(form);

        sendDataToUrl(form.action, {
            method: 'POST', body: formData
        }).then(res => res.json())
            .then(res => {
                const Toast = Swal.mixin({
                    showConfirmButton: false,
                    toast: true,
                    position: 'bottom-start',
                    timer: 3500,
                    timerProgressBar: true
                });
                if (res.success) {
                    updateCartCounter();
                    Toast.fire({
                        icon: 'success',
                        title: 'Product Added To Cart'
                    });
                } else {
                    let errorText = '';
                    for (let error in res.errors) {
                        errorText += res.errors[error];
                    }
                    Swal.fire({
                        icon: "error",
                        titleText: 'Oops!',
                        text: errorText
                    })
                }
            })
            .catch(err => {
                console.log(err)
            });

    });
}

if (wishlistBtn) {
    wishlistBtn.addEventListener('click', (e) => {
        wishlistBtn.classList.toggle('active');
        e.preventDefault();
        let wishlistLink = document.querySelector('.wishlist-link');
        fetch(wishlistLink.href)
            .then(res => res.json())
            .then(res => {
                if (res.success) {
                    updateWishlistCounter(res.down);
                    wishlistLink.href = parseLink(wishlistLink.href);
                    Swal.fire({
                        titleText: res.title,
                        text: res.text,
                        icon: "success"
                    });
                } else {
                    Swal.fire({
                        titleText: res.title,
                        text: res.text,
                        icon: "error"
                    })
                }
            })
            .catch(err => console.log(err));
    });
}

if (updateUserBtn && editUserModal) {
    updateUserBtn.addEventListener('click', (e) => {
        e.preventDefault();
        getDataFromUrl(updateUserBtn.href, editUserModal);
    });
}

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