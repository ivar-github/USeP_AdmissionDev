import axios from 'axios';
window.axios = axios;

//TO TELL THE SERVER THAT REQUEST WAS MADE BY AJAX
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

//CSRF IS BUILTIN IF ROUTES IS WITHIN WEB.PHP ONLY , OTHERWISE NOT (LIKE API.PHP), UNLESS ADDED GLOBALLY LIKE BELOW
// CSRF TOKEN GLOBALLY - - NO NEED TO ADD CSRF TOKEN IN AXIOS INDIVIDUALLY
let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found');
}




//MAKE SURE THAT bootstrap.js IS IMPORTED IN resrouces/js/app.js
//import './bootstrap';
