import {getComponent} from '@symfony/ux-live-component';
import {Controller} from '@hotwired/stimulus';

export default class extends Controller {
    async connect() {
        await this.initializeComponent();
        this.handleComponentFirstRender(this.element);
    }

    async initializeComponent() {
        this.component = await getComponent(this.element);

        this.component.on('render:finished', (component) => {
            const el = component.element;
        });
    }

    handleComponentFirstRender(component) {
        handleLoadingStateOfConvertButton(component);
    }

}

/* ============================= FUNCTIONS =================================== */
function handleLoadingStateOfConvertButton(component) {
    const convertButton = component.querySelector('.convert-pdf-button');
    const loadingSpinner = component.querySelector('.loading-spinner');

    convertButton.addEventListener('click', () => {
        console.log(convertButton, loadingSpinner)
        convertButton.classList.add('isConverting')
        loadingSpinner.classList.add('isConverting')
        setTimeout(
            () => {
                convertButton.classList.remove('isConverting');
                loadingSpinner.classList.remove('isConverting');
            },
            2000
        )
    });
}