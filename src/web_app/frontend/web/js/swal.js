const swalWithCustomButtons = Swal.mixin({
    customClass: {
        confirmButton: 'btn btn-primary',
        cancelButton: 'btn btn-outline-dark',
        actions: 'gap-3'
    },
    buttonsStyling: false,
    allowEnterKey: false
});

const Toast = swalWithCustomButtons.mixin({
    showConfirmButton: false,
    toast: true,
    position: 'bottom-start',
    timer: 3500,
    timerProgressBar: true
});