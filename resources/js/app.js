import './bootstrap';
import 'flowbite';
import { Notyf } from 'notyf';
import 'notyf/notyf.min.css';

window.Notyf = new Notyf({
    duration: 3000,
    position: {
        x: 'right',
        y: 'top',
    },
});

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
