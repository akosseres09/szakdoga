const editIcons = document.querySelectorAll('.editIcon');
const paySummary = document.querySelector('.pay-summary');
const spreadDiv = paySummary.querySelector('.summary-click-spread');
const form = document.getElementById('payment-form');

paySummary.addEventListener('click', e => {
    const summaryItems = paySummary.querySelector('.summary .items');
    if (summaryItems.classList.contains('deploy')) {
        summaryItems.classList.remove('deploy');
        spreadDiv.innerText = 'Click To Spread';
    } else {
        summaryItems.classList.add('deploy');
        spreadDiv.innerText = 'Click To Hide';
    }
});

editIcons.forEach(icon => {
    icon.addEventListener('click', e => {
        const mainParent = e.target.parentElement.parentElement;
        const sibling = mainParent.nextElementSibling;
        mainParent.classList.add('d-none');
        sibling.classList.remove('d-none');
    });
});