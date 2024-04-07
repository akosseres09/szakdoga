const editIcons = document.querySelectorAll('.editIcon');
const paySummary = document.querySelector('.pay-summary');
const spreadDiv = paySummary.querySelector('.summary-click-spread');
const form = document.getElementById('payment-form');
const cardNumber = document.getElementById('cardNumber');
const cardHolderName = document.getElementById('cardHolderName');
const cardExpiry = document.getElementById('expiryDate');
const cardCVC = document.getElementById('cardCVC');
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

form.addEventListener('submit', e => {
    const button = form.querySelector('.payment-button button[type="submit"]');
    button.setAttribute('type', 'button');
    button.innerHTML = '';
    const loader = getLoader();
    button.appendChild(loader);
});

if (cardHolderName && cardNumber && cardExpiry && cardCVC) {
    const expiryMask = IMask(cardExpiry, {
        mask: '00/00',
        groups: {
           '00': /^\d{1,2}$/,
           '00/': /^([0-1]|0[1-9]|1[0-2])$/,
           '/': '/'
        },
        pattern: 'mm/yy',
        format: function (value) {
            return value.replace(/(\d{2})\/(\d{2})/, '$1/$2');
        },
        parse: function (value) {
            return value.replace('/', ' ');
        }
    });

    const cardNumberMask = IMask(cardNumber, {
       mask: '0000 0000 0000 0000'
    });
}