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

//Display character count of textarea in span #char-count
if(document.getElementById('form_description')){
    document.getElementById('form_description').addEventListener('input', function(event){
        document.getElementById('char-count').innerHTML = document.getElementById('form_description').value.length + '/255';
    
        if (document.getElementById('form_description').value.length >= 255) {
            document.getElementById('char-count').classList.add('text-rose-600');
        }
        else {
            document.getElementById('char-count').classList.remove('text-rose-600');
        }
    });
}