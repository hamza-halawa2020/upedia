<div id="loadingSpinner" class="spinner-overlay" style="display: flex;">
    <div class="spinner-container">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p class="mt-3 text-primary fw-semibold">Loading data...</p>
    </div>
</div>


<style>
    #loadingSpinner {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: none;
        z-index: 9999;
        justify-content: center;
        align-items: center;
    }

    .spinner-overlay {
        display: flex;
    }

    .spinner-container {
        /* background: white; */
        padding: 3rem 2rem;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        text-align: center;
        min-width: 200px;
    }

    .spinner-border {
        width: 3rem !important;
        height: 3rem !important;
        margin: 0 auto;
    }

    .spinner-container p {
        margin: 0 !important;
    }

    @media (max-width: 576px) {
        .spinner-container {
            padding: 2rem 1rem;
            min-width: 150px;
        }

        .spinner-border {
            width: 2rem !important;
            height: 2rem !important;
        }

        .spinner-container p {
            font-size: 0.875rem;
        }
    }
</style>
