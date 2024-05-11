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
                ratingContainer.innerHTML = '';
                ratingContainer.appendChild(getRatingHtml(res.rating));
            }
        });
}

/**
 * Parses the rating to desired format
 *
 * @param rating
 * @returns {string}
 */
function parseRating(rating) {
    return new Intl.NumberFormat('en', {
        minimumFractionDigits: 2, maximumFractionDigits: 2
    }).format(rating);
}

/**
 *
 * Creates the desired amount of filled, partially filled and not filled stars based on the given rating.
 * For partially filled stars to work, you need to set the --width style property of the .partially-filled class
 *
 * @param rating
 * @returns {HTMLDivElement}
 */

function getRatingHtml(rating) {
    const floor = Math.floor(rating);
    const div = document.createElement('div');
    const mainSpan = document.createElement('span');

    mainSpan.classList.add('ms-2');
    div.classList.add('star-rating-accordion');

    for (let i = 1; i <= floor; i++) {
        const span = document.createElement('span');
        span.classList.add('star', 'fa-regular', 'fa-star', 'full-star');
        mainSpan.appendChild(span);
    }

    if (parseInt(rating) !== 5) {
        const partialStar = document.createElement('span');
        partialStar.classList.add('star', 'fa-regular', 'fa-star', 'partial-star');
        partialStar.style.setProperty('--width', (rating-floor));
        mainSpan.appendChild(partialStar);
    }

    for (let i = 1; i < (5-rating); i++) {
        const span = document.createElement('span');
        span.classList.add('star', 'fa-regular', 'fa-star');
        mainSpan.appendChild(span);
    }

    const ratingSpan = document.createElement('span');
    ratingSpan.classList.add('ms-2');
    ratingSpan.setAttribute('id', 'ratingNumber');
    ratingSpan.innerText = parseRating(rating);

    div.appendChild(mainSpan);
    div.appendChild(ratingSpan);

    return div;
}