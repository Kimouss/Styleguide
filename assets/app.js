import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';
import './styles/sidebar.scss';

import hljs from 'highlight.js';
import Swup from 'swup';
const swup = new Swup({
    cache: true,
    animateHistoryBrowsing: false,
});

// Theme snippet code
// import 'highlight.js/styles/github-dark.css';
import 'highlight.js/styles/monokai-sublime.css';
// import 'highlight.js/styles/vs2015.css';
// import 'highlight.js/styles/stackoverflow-dark.css';

document.addEventListener('DOMContentLoaded', () => {
    init();
});
document.addEventListener('swup:contentReplaced', () => {
    init();
});
swup.on('pageView', () => {
    init();
});

function init() {
    hljs.highlightAll();

    displayDropdown();
    activeSidebarItems();
}

function displayDropdown()
{
    let dropdown = document.getElementsByClassName('dropdown-btn');
    for (let i = 0; i < dropdown.length; i++) {
        dropdown[i].addEventListener('click', function() {
            this.classList.toggle('active');
            let dropdownContent = this.nextElementSibling;
            if (dropdownContent.style.display === 'block') {
                dropdownContent.style.display = 'none';
            } else {
                dropdownContent.style.display = 'block';
            }
        });
    }
}

function activeSidebarItems()
{
    let pathName = window.location.pathname;
    let items = document.getElementsByClassName('km-sidebar_item  ');
    for (let j = 0; j < items.length; j++) {
        if (pathName === items[j].children[0].getAttribute('href')) {
            items[j].className += ' active'
        } else {
            items[j].className = items[j].className.replace('active', '').trim();
        }
    }
}
