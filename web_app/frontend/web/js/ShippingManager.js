let writer = document.querySelector('.write');
let inputs = document.querySelectorAll('.shipping');
let readOnly = true;
writer.addEventListener('click', () =>{
    readOnly = !readOnly;
   inputs.forEach((input) => {
       input.readOnly = readOnly;
   })
});
