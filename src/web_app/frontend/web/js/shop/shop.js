const cartForm = document.getElementById('place-in-cart-form');
const wishlistBtn = document.querySelector('.wishlist-btn');
const sizeItems = document.querySelectorAll('.size-item');
const sizeInput = document.getElementById('cart-size');
const ratingUrl = urlLink;
const options = {
    root: null,
    rootMargin: '0px',
    threshold: 0.5
};
const observer = new IntersectionObserver(loadRating, options);
const rating = document.getElementById('ratingObs');
const ratingContainer = document.querySelector('.rating-container');
const ratingForm = document.getElementById('rating-form');
observer.observe(rating);

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
        fetch(wishlistLink.href)
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

if (ratingForm) {
    ratingForm.addEventListener('submit', e => {
        e.preventDefault();
        e.stopImmediatePropagation();

        const formData = new FormData(ratingForm);
        fetch(ratingForm.action, {
            method: 'post',
            body: formData
        }).then(res => res.json())
            .then(res => {
                $('.modal').modal('hide');
                getRating();
            })
    })
}

function getRating() {
    ratingContainer.replaceChildren(getLoader());
    fetch(ratingUrl).then(res => res.json())
        .then(res => {
            const loader = ratingContainer.querySelector('.loader');
            const oldRating = ratingContainer.querySelector('.star-rating-accordion');
            if (loader) {
                loader.remove();
            }
            if (res.success) {
                if (oldRating) {
                    oldRating.remove();
                }
                ratingContainer.innerHTML = getRatingHtml(res.rating);
            }
        });
}

function loadRating(entries, observer) {
    entries.forEach(entry => {
        const elem = rating.querySelector('.star-rating-accordion');
        if (entry.isIntersecting && !elem) {
            getRating();
        }
    })
}

function parseRating(rating) {
    return  new Intl.NumberFormat('en', {
        minimumFractionDigits: 2, maximumFractionDigits: 2
    }).format(rating)
}

function getRatingHtml(rating) {
    return '<div class="star-rating-accordion"> ' +
            '<span class="ms-2">' +
                '<i class="star fa-regular fa-star"></i>' +
                '<i class="star fa-regular fa-star"></i>' +
                '<i class="star fa-regular fa-star"></i>' +
                '<i class="star fa-regular fa-star"></i>' +
                '<i class="star fa-regular fa-star"></i>' +
            '</span> ' +
            '<span class="ms-2" id="ratingNumber">' +
                parseRating(rating) +
            '</span>' +
        '</div>';
}
