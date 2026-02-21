class TurboStateManager {
    constructor() {
        this.currentState = this.snapshot();
        this.bindEvents();
    }

    bindEvents() {
        document.addEventListener('turbo:before-visit', () => {
            this.currentState = this.snapshot();
        });

        document.addEventListener('turbo:load', () => {
            this.restore();
        });
    }

    snapshot() {
        const forms = {};

        document.querySelectorAll('form[id]').forEach((form) => {
            forms[form.id] = Object.fromEntries(new FormData(form).entries());
        });

        return {
            scrollY: window.scrollY,
            forms,
        };
    }

    restore() {
        if (typeof this.currentState.scrollY === 'number') {
            window.scrollTo(0, this.currentState.scrollY);
        }

        Object.entries(this.currentState.forms).forEach(([formId, values]) => {
            const form = document.getElementById(formId);
            if (!form) {
                return;
            }

            Object.entries(values).forEach(([name, value]) => {
                const input = form.querySelector(`[name="${name}"]`);
                if (!input) {
                    return;
                }

                if (input.type === 'checkbox' || input.type === 'radio') {
                    input.checked = true;
                    return;
                }

                input.value = value;
            });
        });
    }
}

window.TurboStateManager = new TurboStateManager();
