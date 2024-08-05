import './bootstrap';

import Trix from "trix";
import 'trix/dist/trix.css';
import 'flowbite';
import $ from 'jquery';
import 'formBuilder';

document.addEventListener("trix-before-initialize", () => {
    console.log('jquery version:', $.version);
    // Trix
    // Change Trix.config if you need
})
