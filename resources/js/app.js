import './bootstrap';
import * as Turbo from '@hotwired/turbo';
import './turbo-state';
import * as bootstrap from 'bootstrap';

window.Turbo = Turbo;
window.bootstrap = bootstrap;
if (typeof Turbo.start === 'function') {
    try {
        Turbo.start();
    } catch (error) {
        // Turbo might already be started by the module side-effects.
    }
}
Turbo.config.drive.progressBarDelay = 100;

const bootstrapAvailable = () => typeof window.bootstrap !== 'undefined';

const initializeBootstrapWidgets = () => {
    if (!bootstrapAvailable()) {
        return;
    }

    document
        .querySelectorAll('[data-bs-toggle="popover"]')
        .forEach((el) => new window.bootstrap.Popover(el));

    document
        .querySelectorAll('[data-bs-toggle="tooltip"]')
        .forEach((el) => new window.bootstrap.Tooltip(el));
};

const setupFilterAutoSubmit = () => {
    const form = document.getElementById('filter-form');
    if (!form || form.dataset.autoSubmitReady === 'true') {
        return;
    }
    form.dataset.autoSubmitReady = 'true';

    const controls = form.querySelectorAll('input, select');
    let timeoutId;

    controls.forEach((control) => {
        control.addEventListener('change', () => {
            clearTimeout(timeoutId);
            timeoutId = setTimeout(() => {
                form.requestSubmit();
            }, 250);
        });
    });
};

const initializeComponents = () => {
    initializeBootstrapWidgets();
    setupFilterAutoSubmit();
};

document.addEventListener('turbo:load', initializeComponents);

document.addEventListener('turbo:submit-start', (event) => {
    const submitter = event.detail?.formSubmission?.submitter;
    if (!submitter) {
        return;
    }

    submitter.disabled = true;
    submitter.setAttribute('data-loading', 'true');
});

document.addEventListener('turbo:submit-finish', (event) => {
    const submitter = event.detail?.formSubmission?.submitter;
    if (!submitter) {
        return;
    }

    submitter.disabled = false;
    submitter.removeAttribute('data-loading');
});

document.addEventListener('turbo:fetch-request-error', (event) => {
    // eslint-disable-next-line no-console
    console.error('Turbo request error', event.detail);
});

document.addEventListener('DOMContentLoaded', initializeComponents);

