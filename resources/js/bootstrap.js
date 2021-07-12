window._ = require('lodash');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

const token = document.getElementsByName("csrf-token")[0].getAttribute("content")

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
window.axios.defaults.headers.common['Content-Type'] = 'application/json';
window.axios.defaults.headers.common['Accept'] = 'application/json';
window.axios.defaults.headers.common['Access-Control-Allow-Origin'] = '*';


window.dateOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }



