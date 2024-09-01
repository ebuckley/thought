import './bootstrap';

import Trix from "trix";
import 'trix/dist/trix.css';
import 'flowbite';
import $ from 'jquery';
import 'formBuilder';

import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';

Alpine.plugin(focus);

document.addEventListener("trix-before-initialize", () => {
    console.log('jquery version:', $.version);
    // Trix
    // Change Trix.config if you need
})
