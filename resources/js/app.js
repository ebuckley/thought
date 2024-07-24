import './bootstrap';

import Trix from "trix";
import 'trix/dist/trix.css';

document.addEventListener("trix-before-initialize", () => {
    console.log(Trix);
    // Change Trix.config if you need
})
