const OPEN_BTN = document.getElementById('menu-btn');
const CLOSE_BTN = document.getElementById('menu-close-btn');
const MENU = document.getElementById('menu');

OPEN_BTN.addEventListener('click', ()=>{
    MENU.classList.remove('hidden');
});

CLOSE_BTN.addEventListener('click', ()=>{
    MENU.classList.add('hidden');
});