@extends('layout.layout')

@section('content')

<script src="https://cdn.tailwindcss.com"></script>

<style>
    body {
        font-family: 'Inter', sans-serif;
        background-color: #f3f6fb;
    }

    .asset-card:hover {
        transform: translateY(-6px);
        transition: 0.3s ease;
    }
</style>

<div class="p-6 md:p-10">

    <main class="bg-white rounded-3xl shadow-xl p-8">
        <h5 class="text-3xl font-bold text-gray-900 mb-8">
            IT Assets Overview
        </h5>
        <br>
        {{-- Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-8">

            @foreach ($assets as $asset)
            <div class="asset-card bg-white border border-gray-200 rounded-2xl shadow-md p-6 relative">

                {{-- Header --}}
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-xl font-bold text-gray-900 leading-tight">
                        {{ $asset->name }} ({{ $asset->total }})
                    </h3>
                </div>
                {{-- Stats List --}}
                <div class="space-y-4">
                    <a href="{{ route('asset.index', ['status' => 'in_use', 'search' => $asset->name]) }}"
                        class="flex items-center justify-between hover:bg-indigo-50 p-2 rounded-lg transition">
                        <div class="flex items-center space-x-2">
                            <span class="h-3 w-3 rounded-full bg-indigo-600"></span>
                            <span class="text-gray-700 font-medium">In Use</span>
                        </div>
                        <span class="font-bold text-indigo-700 text-lg">
                            {{ $asset->in_use }}
                        </span>
                    </a>

                    <a href="{{ route('asset.index', ['status' => 'in_store', 'search' => $asset->name]) }}"
                        class="flex items-center justify-between hover:bg-green-50 p-2 rounded-lg transition">
                        <div class="flex items-center space-x-2">
                            <span class="h-3 w-3 rounded-full bg-green-500"></span>
                            <span class="text-gray-700 font-medium">In Store</span>
                        </div>
                        <span class="font-bold text-green-700 text-lg">
                            {{ $asset->in_store }}
                        </span>
                    </a>

                    <a href="{{ route('asset.index', ['status' => 'in_repair', 'search' => $asset->name]) }}"
                        class="flex items-center justify-between hover:bg-yellow-50 p-2 rounded-lg transition">
                        <div class="flex items-center space-x-2">
                            <span class="h-3 w-3 rounded-full bg-yellow-500"></span>
                            <span class="text-gray-700 font-medium">In Repair</span>
                        </div>
                        <span class="font-bold text-yellow-700 text-lg">
                            {{ $asset->in_repair }}
                        </span>
                    </a>

                </div>

                {{-- Plus Icon Button --}}
                <button type="button" title="Add new item" class="absolute top-4 right-4 bg-indigo-50 text-indigo-600 hover:bg-indigo-100 rounded-full p-2 shadow-md transition"
                    onclick="window.location='{{ route('asset.create', ['name' => $asset->name]) }}'">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </button>

            </div>
            @endforeach

        </div>
    </main>

</div>

@endsection