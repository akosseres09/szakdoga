document.querySelectorAll('.carousel-item img').forEach(image => {
    let x, y, width, height;
    image.addEventListener('mouseenter', () => {
        const size = image.getBoundingClientRect();

        x = size.x;
        y = size.y;
        width = size.width;
        height = size.height;
    });

    image.addEventListener('mousemove', e => {
        const horizontal = (e.clientX - x) / width * 100;
        const vertical = (e.clientY - y) / height * 100;

        image.style.setProperty('--x', horizontal + '%');
        image.style.setProperty('--y', vertical + '%');
    });
});