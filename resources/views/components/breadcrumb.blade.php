<style>
.dashboard-breadcrumb .breadcrumb {
    font-size: 21px;
}
</style>

@php
    $routeName = Route::currentRouteName();
    $breadcrumbsExist = $routeName && \Diglactic\Breadcrumbs\Breadcrumbs::exists($routeName);
    $currentTitle = $title ?? $subTitle ?? '';
    $currentSubTitle = $subTitle ?? '';
@endphp

<div class="app-breadcrumb {{ $routeName == 'dashboard' ? 'dashboard-breadcrumb' : '' }}">
    @if(!empty($currentTitle))
        <div class="app-breadcrumb__title">
            {{ $currentTitle }}
        </div>
    @endif

    @if($breadcrumbsExist)
        <div class="app-breadcrumb__trail">
            {{ \Diglactic\Breadcrumbs\Breadcrumbs::render() }}
        </div>
    @else
        <nav aria-label="breadcrumb" class="app-breadcrumb__trail">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">
                        Dashboard
                    </a>
                </li>

                @if(!empty($subTitle) || !empty($title))
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ $subTitle ?? $title }}
                    </li>
                @endif
            </ol>
        </nav>
    @endif
</div>