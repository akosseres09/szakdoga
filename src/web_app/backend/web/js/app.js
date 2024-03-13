const addModal = document.getElementById('addModal');
const addModalTogglerBtn = document.getElementById('addModalToggler');
const editUserModal = document.getElementById('editUserModal');
const editUserBtn = document.querySelectorAll('.editUserBtn');

setTimeout(function() {
    $('.alert').fadeOut();
}, 4000);


function getDataFromUrl(url, intoItem) {
    fetch(url)
        .then(r => r.text())
        .then(res => intoItem.innerHTML = res)
        .catch(err => console.log(err));
}

if (addModal && addModalTogglerBtn) {
    addModalTogglerBtn.addEventListener('click', function (e) {
        getDataFromUrl('/product/add', addModal);
    });
}

if (editUserModal && editUserBtn){
    editUserBtn.forEach(btn => {
       btn.addEventListener('click', function (e) {
           e.preventDefault();
           getDataFromUrl(btn.href, editUserModal);
       });
    });
}