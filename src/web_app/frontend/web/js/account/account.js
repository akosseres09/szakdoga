const userLink = document.querySelectorAll('.user-link');
const settingsContainer = document.getElementById('settings-container');

if (userLink) {
    userLink.forEach(link => {
        link.addEventListener('click', e => {
            const active = document.querySelector('.user-link.active');
            const activeIcon = document.querySelector('.user-link .active-icon');
            const next = e.target.closest('.user-link');
            const passiveIcon = next.querySelector('.passive-icon');
            if (next) {
                if (activeIcon) {
                    activeIcon.classList.remove('active-icon');
                    activeIcon.classList.add('passive-icon');
                }

                if (passiveIcon) {
                    passiveIcon.classList.remove('passive-icon');
                    passiveIcon.classList.add('active-icon');

                }
                active.classList.remove('active');
                next.classList.add('active');
                getAccountPage(next.dataset.href);
            }
        })
    })
}

function getAccountPage(href) {
    fetch(href, {
        headers : {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(res => res.json())
        .then(res => {
            settingsContainer.innerHTML = res.data;
        })
}
