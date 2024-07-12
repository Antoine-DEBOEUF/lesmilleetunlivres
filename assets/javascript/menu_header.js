let buttonMenu = document.querySelector('#buttonMenu')
let menu = document.querySelector('#menu_header')

function popmenu(){
menu.classList.toggle('show')
}

buttonMenu.addEventListener('click', popmenu)