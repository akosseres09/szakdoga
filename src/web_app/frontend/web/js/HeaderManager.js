const mobileNavs = document.querySelectorAll('.mobile-nav');
let click = true;

mobileNavs.forEach((nav) => {
    nav.addEventListener('click', () => {
        const toggleDiv = nav.querySelector('div');
        toggleDiv.classList.toggle('active');
    });
});
