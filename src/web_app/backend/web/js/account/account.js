const userLink = document.querySelectorAll('.user-link');
const productContainer = document.getElementById('product-container');
const scrollable = document.querySelector('.user-profile-tabs');
let isDown = false;
let startX, scrollLeft;


if (userLink && productContainer) {
    userLink.forEach(link => {
        link.addEventListener('click', e => {
            const active = document.querySelector('.user-link.active');
            if (e.target !== active) {
                active.classList.remove('active');
                e.target.classList.add('active');

                getProductPage(e.target.dataset.href);
                history.pushState({},'',e.target.dataset.href);
            }
        })
    })
}

if (scrollable) {
    scrollable.addEventListener('mousedown', (e) => {
          isDown = true;
          startX = e.pageX - scrollable.offsetLeft;
          scrollLeft = scrollable.scrollLeft;
    });

    scrollable.addEventListener('mouseleave', () => {
       isDown = false;
    });

    scrollable.addEventListener('mouseup', () => {
        isDown = false;
    })

    scrollable.addEventListener('mousemove', (e) => {
        if (!isDown) return;
        e.preventDefault();
        const x = e.pageX - scrollable.offsetLeft;
        const walk = x - startX;
        scrollable.scrollLeft = scrollLeft - walk;
    });
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

function triggerFileSelect() {
    const input = document.querySelector('input[type="file"]').click();
}

function showFiles(event) {
    const files = event.target.files;
    const container = document.getElementById('uploadedImagesContainer');
    container.innerHTML = '';

    for (const file of files) {
        const reader = new FileReader();
        const width = container.clientWidth;
        reader.onloadend = function (e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.alt = file.name;
            img.style.width = (1 / files.length) * 100 + '%';
            img.style.height = 'auto';
            container.appendChild(img);
        }
        reader.readAsDataURL(file);
    }
}
