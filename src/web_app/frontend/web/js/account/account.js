const updateUserBtn = document.getElementById('updateUserBtn');
const editUserModal = document.getElementById('userEditModal');

if (updateUserBtn && editUserModal) {
    updateUserBtn.addEventListener('click', (e) => {
        e.preventDefault();
        getDataFromUrl(updateUserBtn.href, editUserModal);
    });
}
