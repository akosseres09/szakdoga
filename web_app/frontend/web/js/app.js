const sizeItems = document.querySelectorAll('.size-item');
const sizeInput = document.getElementById('cart-size');
const deleteModal = document.getElementById('deleteModal');
const deleteBtn = document.querySelectorAll('.btn-close');
const cartForm = document.getElementById('place-in-cart-form');
const cartModal = document.getElementById('addToCartModal');
const cartCount = document.getElementById('cartCount');

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


if (deleteModal && deleteBtn) {
    deleteBtn.forEach(btn => {
       btn.addEventListener('click', function (e) {
           e.preventDefault();
           getDataFromUrl(btn.href, deleteModal);
       });
    });
}

if (cartForm && cartModal) {
    cartForm.addEventListener('submit', function (e) {
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();
        const form = e.target;
        console.log(form);
        const formData = new FormData(form);

        sendDataToUrl(form.action, {method: 'POST', body: formData}, cartModal);

        return false;
    });
}

function getDataFromUrl(url, intoItem) {
    fetch(url).then(res => res.text())
        .then(res => intoItem.innerHTML = res)
        .catch(err => console.log(err));
}

function sendDataToUrl(url, formSendData = {}, intoItem){
    fetch(url, formSendData)
        .then(res => res.text())
        .then(res => {
            intoItem.innerHTML = res;
            let count= parseInt(cartCount.innerText) || 0;
            cartCount.innerText = count + 1;
        })
        .catch(err => console.log(err));
}

setTimeout(function() {
    $('.alert').fadeOut();
}, 5000);