<div class="flex gap-3 border-b mb-4">
    @foreach ($tabs->getTabs() as $tab)
        <a href="{{ request()->fullUrlWithQuery(['tab' => $tab->key]) }}"
            @class([
                 'px-4 py-2 border-b-2 transition',
                 'border-blue-600 text-blue-600 font-semibold' => $tabs->getActiveTab(request()) === $tab->key,
                 'border-transparent text-gray-500 hover:text-gray-700' => $tabs->getActiveTab(request()) !== $tab->key,
            ])>
            {{ $tab->label }}
        </a>
    @endforeach
</div>
