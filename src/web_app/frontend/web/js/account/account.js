const updateUserBtn = document.getElementById('updateUserBtn');
const editUserModal = document.getElementById('userEditModal');
const userLink = document.querySelectorAll('.user-link');
const settingsContainer = document.getElementById('settings-container');

if (updateUserBtn && editUserModal) {
    updateUserBtn.addEventListener('click', (e) => {
        e.preventDefault();
        getDataFromUrl(updateUserBtn.href, editUserModal);
    });
}

if (userLink) {
    userLink.forEach(link => {
        link.addEventListener('click', e => {
            const active = document.querySelector('.user-link.active');
            const activeIcon = document.querySelector('.user-link .active-icon');
            const passiveIcon = e.target.querySelector('.passive-icon');

            if (e.target !== active) {
                if (activeIcon) {
                    activeIcon.classList.remove('active-icon');
                    activeIcon.classList.add('passive-icon');
                }

                if (passiveIcon) {
                    passiveIcon.classList.remove('passive-icon');
                    passiveIcon.classList.add('active-icon');

                }
                active.classList.remove('active');
                e.target.classList.add('active');

                getAccountPage(e.target.dataset.href);
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
