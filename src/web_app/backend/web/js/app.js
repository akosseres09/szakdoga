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

function triggerFileSelect() {
    document.querySelector('input[type="file"]').click();
}

function showFiles(event) {
    const files = event.target.files;
    const container = document.getElementById('uploadedImagesContainer');
    container.innerHTML = '';
    const gap = files.length * 10;
    const padding = 2 * 24 * 0.5;
    const width = container.clientWidth - gap - padding;

    for (const file of files) {
        const reader = new FileReader();
        reader.onloadend = function (e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.alt = file.name;
            img.style.minWidth = width/6 + 'px';
            img.style.width = width / files.length + 'px';
            img.style.height = 'auto';
            container.appendChild(img);
        }
        reader.readAsDataURL(file);
    }
}