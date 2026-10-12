<style>
    /* Navbar */

    .navbar-header {
        padding: 12px 20px;
    }

    .navbar-actions {
        flex-shrink: 0;
    }

    /* avatar */

    .navbar-avatar {
        width: 40px;
        height: 40px;
        object-fit: cover;
    }

    /* icon buttons */

    .navbar-icon-btn {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* responsive */

    @media (max-width:992px) {

        .navbar-actions {
            gap: 10px;
        }

        .navbar-avatar {
            width: 36px;
            height: 36px;
        }

    }

    /* mobile */

    @media (max-width:576px) {

        .back-text {
            display: none;
        }

        .navbar-breadcrumb h1,
        .navbar-breadcrumb h2 {
            font-size: 16px;
        }

    }
</style>