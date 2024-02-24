const deleteBtn = document.querySelectorAll('.delete-from-cart');
const moveToWishlistBtn = document.querySelectorAll('.move-to-wishlist');
let price = document.getElementById('official-price');
let subTotal = document.getElementById('subtotal');
const goToPaymentInfoBtn = document.querySelector('.go-to-payment-info');


// handles deleting an item from the cart via fetch
if (deleteBtn) {
    deleteBtn.forEach(btn => {
        btn.addEventListener('click', function (e) {
            const link = e.target.dataset.href;
            swalWithCustomButtons.fire({
                title: "Delete This Item From Your cart?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, Delete!",
                cancelButtonText: "No, Rather Not!",
            }).then(res => {
                if (res.isConfirmed) {
                    fetch(link)
                        .then(() => {
                            window.location.reload();
                        }).catch(err => console.log(err))
                }
            });
        });
    });
}

// handles adding
if (moveToWishlistBtn) {
    moveToWishlistBtn.forEach(btn => {
        btn.addEventListener('click', e => {
            fetch(e.target.dataset.href)
                .then(res => res.json())
                .then(res => {
                    if (!res.success) {
                        let message = '';
                        for (let error in res.errors) {
                            message += res.errors[error];
                        }
                        swalWithCustomButtons.fire({
                            title: 'Something Went Wrong!',
                            text: message,
                            icon: 'error'
                        })
                    } else {
                        window.location.reload();
                    }
                })
            console.log(e.target.dataset.href);
        });
    })
}