const mobileNavs = document.querySelectorAll('.mobile-nav');


mobileNavs.forEach((nav) => {
    nav.addEventListener('click', () => {
        const toggleDiv = nav.querySelector('div');
        toggleDiv.classList.toggle('active');
    });
});
