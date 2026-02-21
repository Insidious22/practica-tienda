<div class="turbo-loader" id="turbo-loader-bar"></div>

<style>
    .turbo-loader {
        position: fixed;
        top: 0;
        left: 0;
        z-index: 9999;
        height: 3px;
        width: 0;
        opacity: 0;
        background: linear-gradient(to right, #0d6efd, #20c997);
        transition: width 0.25s ease, opacity 0.25s ease;
    }
</style>

<script>
    (() => {
        const loader = document.getElementById('turbo-loader-bar');
        if (!loader) {
            return;
        }

        let activeRequests = 0;
        let showTimeout = null;
        const SHOW_DELAY_MS = 120;

        const show = () => {
            loader.style.opacity = '1';
            loader.style.width = '35%';
        };

        const hide = () => {
            loader.style.width = '100%';
            setTimeout(() => {
                loader.style.opacity = '0';
                loader.style.width = '0';
            }, 180);
        };

        const start = () => {
            activeRequests += 1;
            if (showTimeout !== null) {
                return;
            }

            showTimeout = setTimeout(() => {
                if (activeRequests > 0) {
                    show();
                }
            }, SHOW_DELAY_MS);
        };

        const finish = () => {
            activeRequests = Math.max(0, activeRequests - 1);
            if (activeRequests > 0) {
                return;
            }

            if (showTimeout !== null) {
                clearTimeout(showTimeout);
                showTimeout = null;
            }

            hide();
        };

        document.addEventListener('turbo:before-visit', start);
        document.addEventListener('turbo:submit-start', start);
        document.addEventListener('turbo:load', finish);
        document.addEventListener('turbo:fetch-request-error', finish);
        document.addEventListener('turbo:submit-finish', finish);
    })();
</script>
