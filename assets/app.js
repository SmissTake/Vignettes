/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';


//Theme switcher
document.getElementById('themeSwitch').addEventListener('change', function(event){
    (event.target.checked) ? setTheme('blossom-dark') : setTheme('blossom-light');
  });

function storeTheme(theme) {
    window.localStorage.setItem('theme', theme);
    console.log(window.localStorage.getItem('theme'));
}

function setTheme(theme) {
    switch (theme) {
        case 'blossom-dark':
            document.documentElement.setAttribute('data-theme', 'blossom-dark');
            storeTheme('blossom-dark');
            break;
        case 'blossom-light':
            document.documentElement.setAttribute('data-theme', 'blossom-light');
            storeTheme('blossom-light');
            break;
    }
}

//onload theme
(function () {
    if (window.localStorage.getItem('theme') === 'blossom-dark') {
        document.getElementById('themeSwitch').checked = true;
        setTheme('blossom-dark');
    } else {
        setTheme('blossom-light');
    }
})();