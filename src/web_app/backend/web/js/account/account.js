const userLink = document.querySelectorAll('.user-link');
const productContainer = document.getElementById('product-container');

if (userLink && productContainer) {
    userLink.forEach(link => {
        link.addEventListener('click', e => {
            const active = document.querySelector('.user-link.active');
            if (e.target !== active) {
                active.classList.remove('active');
                e.target.classList.add('active');

                getProductPage(e.target.dataset.href);
            }
        })
    })
}

function getProductPage(href) {
    fetch(href, {
        headers : {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(res => res.json())
        .then(res => {
            productContainer.innerHTML = res.data;
        })
}
