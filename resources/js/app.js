import './bootstrap';
import axios from 'axios';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.baseURL = '/api';


