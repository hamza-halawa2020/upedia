<style>
    #page-loader {
        position: fixed;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.78);
        z-index: 99999;
        opacity: 1;
        visibility: visible;
        transition: opacity 0.15s linear, visibility 0.15s linear;
    }

    #page-loader.is-hidden {
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
    }

    #page-loader .page-loader-spinner {
        width: 44px;
        height: 44px;
        display: block;
        animation: page-loader-spin 0.75s linear infinite;
        will-change: transform;
        transform-origin: center center;
    }

    #page-loader .page-loader-track {
        stroke: #d1d5db;
        stroke-width: 4;
        fill: none;
    }

    #page-loader .page-loader-head {
        stroke: #2563eb;
        stroke-width: 4;
        stroke-linecap: round;
        fill: none;
    }

    @keyframes page-loader-spin {
        to {
            transform: rotate(360deg);
        }
    }
</style>

<div id="page-loader" aria-hidden="true">
    <svg class="page-loader-spinner" viewBox="0 0 48 48" aria-hidden="true">
        <circle class="page-loader-track" cx="24" cy="24" r="18"></circle>
        <circle class="page-loader-head" cx="24" cy="24" r="18" stroke-dasharray="85 120"></circle>
    </svg>
</div>

<script>
    (function() {
        var loader = document.getElementById('page-loader');
        if (!loader) return;
        var startedAt = Date.now();
        var minVisibleMs = 220;

        function hideLoader() {
            var elapsed = Date.now() - startedAt;
            var wait = Math.max(0, minVisibleMs - elapsed);

            window.setTimeout(function() {
                loader.classList.add('is-hidden');
            }, wait);
        }

        function showLoader() {
            loader.classList.remove('is-hidden');
        }

        window.addEventListener('load', hideLoader, {
            once: true
        });

        document.addEventListener('click', function(event) {
            var link = event.target.closest('a[href]');
            if (!link) return;

            var href = link.getAttribute('href') || '';
            if (
                href.startsWith('#') ||
                href.startsWith('javascript:') ||
                href.startsWith('mailto:') ||
                href.startsWith('tel:') ||
                link.target === '_blank' ||
                link.hasAttribute('download')
            ) {
                return;
            }

            showLoader();
        }, {
            passive: true
        });

        document.addEventListener('submit', function() {
            showLoader();
        }, {
            passive: true
        });

        window.addEventListener('pageshow', hideLoader, {
            passive: true
        });
    })();
</script>
