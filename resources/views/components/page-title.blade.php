<div class="page-title flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3">

    <div>
        <h1 class="dashTitle">{{ $title }}</h1>

        @isset($description)
            <p class="dashText">{{ $description }}</p>
        @endisset
    </div>

    
        {{ $slot }}
    

</div>

{{--  how to user in pages --}} 

{{-- 
<x-page-title 
    title="Assets Management"
    description="Track assets, status, and ownership across departments."
>

    <a href="{{ route('asset.create') }}" class="asset-btn asset-btn--primary">
        + Add New Asset
    </a>

</x-page-title>
--}} 
