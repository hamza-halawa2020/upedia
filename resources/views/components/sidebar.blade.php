<style>
    #app-sidebar.sidebar--dark {
        transition: transform .25s ease !important;
        will-change: transform;
        z-index: 60;
    }

    @media (min-width: 901px) {
        #app-sidebar.sidebar--dark {
            transform: translateX(0) !important;
        }

        .sidebar-overlay {
            display: none !important;
        }

        .sidebar-open-btn {
            display: none !important;
        }
    }

    @media (max-width: 900px) {
        #app-sidebar.sidebar--dark {
            transform: translateX(-100%) !important;
        }

        #app-sidebar.sidebar--dark[data-state="open"] {
            transform: translateX(0) !important;
        }
    }

    .sidebar-overlay {
        position: fixed;
        inset: 0;
        background: rgba(2, 6, 23, .45);
        backdrop-filter: blur(2px);
        -webkit-backdrop-filter: blur(2px);
        z-index: 55;
        opacity: 0;
        pointer-events: none;
        transition: opacity .25s ease;
    }

    @media (max-width: 900px) {
        #app-sidebar.sidebar--dark[data-state="open"]+.sidebar-overlay {
            opacity: 1;
            pointer-events: auto;
        }
    }

    #app-sidebar .sidebar-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 0px 14px;
        border-bottom: 1px solid rgba(255, 255, 255, .08);
    }

    #app-sidebar .sidebar-close-btn {
        display: none;
    }

    #app-sidebar .sidebar-close-btn:hover {
        background: rgba(255, 255, 255, .09);
    }

    #app-sidebar .sidebar-close-btn:active {
        transform: translateY(.5px);
    }

    .sidebar-open-btn {
        position: fixed;
        left: 14px;
        top: 14px;
        z-index: 70;
        width: 44px;
        height: 44px;
        border-radius: 14px;
        border: 1px solid rgba(15, 23, 42, .10);
        background: rgba(241, 245, 249, .9);
        color: rgba(15, 23, 42, .92);
        display: none;
        align-items: center;
        justify-content: center;
        box-shadow: 0 10px 25px rgba(2, 6, 23, .12);
        cursor: pointer;
    }

    @media (max-width: 900px) {
        .sidebar-open-btn {
            display: inline-flex;
            font-size: 20px;
        }

        .sidebar-open-btn:hover {
            background: rgba(241, 245, 249, .95);
            cursor: pointer;
        }

        .sidebar-open-btn:active {
            transform: translateY(.5px);
        }
    }

    @media (max-width:900px) {
        #app-sidebar .sidebar-close-btn {
            display: flex;
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: rgba(255, 255, 255, .08);
            align-items: center;
            justify-content: center;
            transition: .2s;
        }

        #app-sidebar .sidebar-close-btn:hover {
            background: rgba(255, 255, 255, .12);
        }
    }
</style>

<button type="button" class="sidebar-open-btn" aria-label="Open sidebar">
    ☰
</button>

<aside class="sidebar sidebar--dark" id="app-sidebar" data-state="closed" aria-hidden="true">
    <div class="sidebar-header">
        <a href="{{ config('app.HR_URL') }}" class="sidebar-logo">
            @if (config('app.client_name') == 'Alkarim')
                <img src="{{ asset('assets/images/alkarim.png') }}" alt="logo" style="height:40px;">
            @elseif(config('app.client_name') == 'Upedia')
                <img src="{{ asset('assets/images/logo-light.png') }}" alt="logo" style="height:40px;">
            @else
                <img src="{{ asset('assets/images/tailors.png') }}" alt="logo" style="height:40px;">
            @endif
        </a>

        <button type="button" class="sidebar-close-btn" aria-label="Close sidebar">
            <iconify-icon icon="iconoir:arrow-left" class="icon"></iconify-icon>
        </button>
    </div>

    <div class="sidebar-menu-area">
        <ul class="sidebar-menu" id="sidebar-menu">
            @php
                $currentHost = request()->getHost();
                $menuTabs = collect(session('menuTabs_' . $currentHost, []));
                $system = 'settings';

                if (auth()->user()->hasRole('Super admin')) {
                    $menuTabs = $menuTabs->map(function ($tab) use ($system) {
                        if ($tab->relationLoaded('children')) {
                            $tab->children = $tab->children->filter(function ($child) use ($system) {
                                return in_array($system, $child->systems ?? []);
                            });
                        }

                        return in_array($system, $tab->systems ?? []) ? $tab : null;
                    })->filter();
                }

                $currentPath = trim(request()->path(), '/');
                $isUrlActive = function ($url) use ($currentPath) {
                    if (empty($url) || $url == '#') {
                        return false;
                    }

                    if (str_contains($url, 'javascript:void(0)')) {
                        return false;
                    }

                    $parsedUrl = parse_url($url);
                    $targetPath = trim($parsedUrl['path'] ?? '', '/');

                    $isExactPath = $targetPath === $currentPath;
                    $isSubPath = $targetPath !== '' && str_starts_with($currentPath, $targetPath . '/');

                    if (!$isExactPath && !$isSubPath) {
                        return false;
                    }

                    $targetParams = [];
                    if (!empty($parsedUrl['query'])) {
                        parse_str($parsedUrl['query'], $targetParams);
                    }

                    $currentParams = request()->query();

                    if ($isExactPath) {
                        if (empty($targetParams) && !empty($currentParams)) {
                            return false;
                        }

                        foreach ($targetParams as $key => $value) {
                            if (!isset($currentParams[$key]) || $currentParams[$key] != $value) {
                                return false;
                            }
                        }
                    }

                    return true;
                };
            @endphp

            @foreach ($menuTabs as $tab)
                @php
                    $iconName = !empty($tab->icon) ? $tab->icon : 'mdi:folder-outline';
                    $isParentActive = $tab->children->count() > 0 && $tab->children->contains(fn($child) => $isUrlActive($child->url));
                    $isTabActive = $isUrlActive($tab->url);
                    $isDropdownOpen = $isTabActive || $isParentActive;
                @endphp

                @if ($tab->children->count() > 0)
                    <li class="dropdown {{ $isDropdownOpen ? 'open dropdown-open' : '' }}">
                        <a href="javascript:void(0)"
                            class="{{ $isDropdownOpen ? 'active-page' : '' }}"
                            aria-expanded="{{ $isDropdownOpen ? 'true' : 'false' }}">
                            <iconify-icon icon="{{ $iconName }}" class="menu-icon"></iconify-icon>
                            <span class="titles">{{ $tab->label }}</span>
                            <span class="sidebar-caret">
                                <iconify-icon icon="mdi:chevron-down"></iconify-icon>
                            </span>
                        </a>

                        <ul class="sidebar-submenu {{ $isDropdownOpen ? 'show' : '' }}"
                            @if ($isDropdownOpen) style="display: block;" @endif>
                            @foreach ($tab->children as $child)
                                @php $isChildActive = $isUrlActive($child->url); @endphp
                                <li class="{{ $isChildActive ? 'active-page' : '' }}">
                                    <a href="{{ $child->url }}" class="{{ $isChildActive ? 'active-page' : '' }}">
                                        <iconify-icon icon="{{ $child->icon }}" class="me-2"></iconify-icon>
                                        <span class="childTitles">{{ $child->label }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @elseif(!$tab->parent_id && !empty($tab->url))
                    <li class="{{ $isTabActive ? 'active-page' : '' }}">
                        <a href="{{ $tab->url }}" class="{{ $isTabActive ? 'active-page' : '' }}">
                            <iconify-icon icon="{{ $iconName }}" class="menu-icon"></iconify-icon>
                            <span>{{ $tab->label }}</span>
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</aside>

<div class="sidebar-overlay"></div>

<script>
    (function() {
        const sidebar = document.getElementById('app-sidebar');
        const overlay = document.querySelector('.sidebar-overlay');

        if (!sidebar) return;

        function isOpen() {
            return sidebar.getAttribute('data-state') === 'open';
        }

        function setState(open) {
            sidebar.setAttribute('data-state', open ? 'open' : 'closed');
            sidebar.setAttribute('aria-hidden', open ? 'false' : 'true');

            if (overlay) {
                overlay.classList.toggle('show', open);
                overlay.toggleAttribute('hidden', !open);
            }
        }

        function toggleSidebar() {
            setState(!isOpen());
        }

        if (!sidebar.hasAttribute('data-state')) {
            setState(false);
        } else {
            setState(isOpen());
        }

        document.addEventListener('click', (e) => {
            if (e.target.closest('.sidebar-open-btn')) {
                e.preventDefault();
                toggleSidebar();
                return;
            }

            if (e.target.closest('#app-sidebar .sidebar-close-btn')) {
                e.preventDefault();
                setState(false);
                return;
            }

            if (e.target.closest('.sidebar-overlay')) {
                setState(false);
            }
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                setState(false);
            }
        });
    })();
</script>
