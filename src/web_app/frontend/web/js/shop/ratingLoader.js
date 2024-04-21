const ratingUrl = urlLink;
const rating = document.getElementById('ratingObs');
const ratingContainer = document.querySelector('.rating-container');
const options = {
    root: null,
    rootMargin: '0px',
    threshold: 0.5
};
const observer = new IntersectionObserver(loadRating, options);
observer.observe(rating);

function loadRating(entries, observer) {
    entries.forEach(entry => {
        const elem = rating.querySelector('.star-rating-accordion');
        if (entry.isIntersecting && !elem) {
            getRating();
        }
    });
}

function getRating() {
    ratingContainer.replaceChildren(getLoader());
    fetchAjax(ratingUrl).then(res => res.json())
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
                ratingAccordion.innerHTML = res.reviews;
                ratingContainer.innerHTML = getRatingHtml(res.rating);
            }
        });
}


function parseRating(rating) {
    return new Intl.NumberFormat('en', {
        minimumFractionDigits: 2, maximumFractionDigits: 2
    }).format(rating);
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