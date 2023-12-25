const sizeItems = document.querySelectorAll('.size-item');
const sizeInput = document.getElementById('cart-size');
const deleteModal = document.getElementById('deleteModal');
const deleteBtn = document.querySelectorAll('.btn-close');
const cartForm = document.getElementById('place-in-cart-form');
const viewModal = document.getElementById('viewModal');
const cartCount = document.getElementById('cartCount');
const loader = document.getElementById('loader-overlay');
const wishlistBtn = document.querySelector('.wishlist-btn');
const updateUserBtn = document.getElementById('updateUserBtn');
const editUserModal = document.getElementById('userEditModal');


// Handles Picking a size on the View page
if (sizeItems && sizeInput) {
    sizeItems.forEach(item => {
       item.addEventListener('click', () => {
           const active = document.querySelector('.size-picker .size-item.active');
           if(active !== null) {
               active.classList.remove('active');
           }
           item.classList.add('active');
           sizeInput.value = item.innerText;
       });
    });
}

// handles deleting an item from the cart
if (deleteModal && deleteBtn) {
    deleteBtn.forEach(btn => {
       btn.addEventListener('click', function (e) {
           e.preventDefault();
           getDataFromUrl(btn.href, deleteModal);
       });
    });
}

// handles the submission of the view page form
if (cartForm && viewModal) {
    cartForm.addEventListener('submit', function (e) {
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();
        const form = e.target;
        const formData = new FormData(form);

        sendDataToUrl(form.action, {method: 'POST', body: formData}, viewModal);

        return false;
    });
}

if (wishlistBtn) {
    wishlistBtn.addEventListener('click', () => {
       wishlistBtn.classList.toggle('active');
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

function sendDataToUrl(url, formSendData = {}, intoItem){
    // showLoader();
    fetch(url, formSendData)
        .then(res => res.json())
        .then(res => {
            intoItem.innerHTML = res.html;
            if (res.success) {
                updateCartCounter();
            }
            hideLoader();
        })
        .catch(err => console.log(err));
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