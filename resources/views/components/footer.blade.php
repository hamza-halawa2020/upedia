@php
    $brandName = \Illuminate\Support\Str::headline(config('app.client_name') ?: config('app.name', 'Upedia'));
    $appYear = now()->year;
@endphp

<style>
    .app-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .app-footer-brand-title {
        font-size: 15px;
        font-weight: 700;
        color: #111827;
    }

    .app-footer-brand-copy {
        font-size: 13px;
        color: #6b7280;
    }

    .footer-label {
        font-size: 11px;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: .08em;
    }

    .footer-value {
        font-size: 13px;
        font-weight: 600;
        color: #111827;
    }

    @media(max-width:768px) {

        .app-footer {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>

<footer class="d-footer">
    <div class="app-footer">
        <div class="">
            <span class="app-footer-brand-title">
                {{ $brandName }}
            </span>
            <span class="app-footer-brand-copy">
                © {{ $appYear }} All Rights Reserved
            </span>
        </div>
        <div class="">
            <span class="footer-label">Support</span>
            <span class="footer-value"><a href="https://thetailorsdev.com" target="_blank">The Tailors Dev</a></span>
        </div>
    </div>
</footer>