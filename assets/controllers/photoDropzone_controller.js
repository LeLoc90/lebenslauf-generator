import {Controller} from '@hotwired/stimulus';

export default class extends Controller {
    connect() {
        this.element.addEventListener('dropzone:change', this._onChange);
    }

    disconnect() {
        // You should always remove listeners when the controller is disconnected to avoid side-effects
        this.element.removeEventListener('dropzone:change', this._onChange);
    }

    _onChange(event) {
        // The dropzone just changed
        const previewEL = event.currentTarget.querySelector('.dropzone-preview-image')
        const duplicate = previewEL.cloneNode(true);
        previewEL.parentNode.replaceChild(duplicate, previewEL);
    }
}