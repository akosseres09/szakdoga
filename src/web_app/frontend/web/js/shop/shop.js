const cartForm = document.getElementById('place-in-cart-form');
const wishlistBtn = document.querySelector('.wishlist-btn');
const sizeItems = document.querySelectorAll('.size-item');
const sizeInput = document.getElementById('cart-size');
const ratingForm = document.getElementById('rating-form');
const ratingAccordion = document.querySelector('#ratingsAcc > .accordion-body');
const btn = document.getElementById('add-rating-btn');


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
                    swalWithCustomButtons.fire({
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

// handles adding product to the wishlist
if (wishlistBtn) {
    wishlistBtn.addEventListener('click', (e) => {
        e.preventDefault();
        let wishlistLink = document.querySelector('.wishlist-link');
        fetchAjax(wishlistLink.href)
            .then(res => res.json())
            .then(res => {
                if (res.success) {
                    updateWishlistCounter(res.down);
                    wishlistBtn.classList.toggle('active');
                    wishlistLink.href = parseLink(wishlistLink.href);
                    swalWithCustomButtons.fire({
                        titleText: res.title,
                        text: res.text,
                        icon: "success"
                    });
                } else {
                    swalWithCustomButtons.fire({
                        titleText: res.title,
                        text: res.text,
                        icon: "error"
                    })
                }
            })
            .catch(err => console.log(err));
    });
}

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

if (ratingForm && btn) {
    ratingForm.addEventListener('submit', e => {
        e.preventDefault();
        e.stopImmediatePropagation();
        btn.replaceChildren(getLoader());
        const formData = new FormData(ratingForm);
        fetch(ratingForm.action, {
            method: 'post',
            body: formData
        }).then(res => res.json())
        .then(res => {
            if (res.success) {
                $('.modal').modal('hide');
                getRating();
            }
            btn.replaceChildren('Save changes');
        });
    });
}

