import {Controller} from '@hotwired/stimulus';

export default class extends Controller {
    connect() {
        this.element.addEventListener('dropzone:change', this._onChange);
        this.element.addEventListener('dropzone:clear', this._onClear);
    }

    disconnect() {
        // You should always remove listeners when the controller is disconnected to avoid side-effects
        this.element.removeEventListener('dropzone:change', this._onChange);
        this.element.removeEventListener('dropzone:clear', this._onClear);
    }

    _onChange(event) {
        // The dropzone just changed
        const dropzone = event.currentTarget;
        const previewEL = dropzone.querySelector('.dropzone-preview-image')
        const duplicate = previewEL.cloneNode(true);
        const uploadBtn = dropzone.parentElement.querySelector('.button-upload')

        previewEL.parentNode.replaceChild(duplicate, previewEL);

        if (event.detail.name) {
            uploadBtn.classList.remove('disabled');
        }
    }

    _onClear(event) {
        // The dropzone has just been cleared
        const dropzone = event.currentTarget;
        const uploadBtn = dropzone.parentElement.querySelector('.button-upload')

        uploadBtn.classList.add('disabled');
    }
}