@extends('layout.layout')

@php
    $title = 'Attendance';
    $subTitle = 'Check In / Out';
@endphp

@section('content')
    @include('components.alert')

    <div class="container-fluid app-bg">
        <div class="page-shell">
            <div class="d-flex flex-column gap-4">
                <x-page-title
                    title="Attendance"
                    description="Use the quick actions below to register check-in or check-out."
                />

                <div class="ui-card border-0 shadow-sm bg-white">
                    <div class="card-body p-5">
                        <div class="d-flex justify-content-center align-items-center" style="min-height: 320px;">
                            <form action="{{ route('checkinout.check') }}" method="POST"
                                class="d-flex flex-wrap justify-content-center gap-3">
                                @csrf

                                <button type="submit" name="type" value="checkin"
                                    class="asset-btn asset-btn--primary">
                                    Check In
                                </button>

                                <button type="submit" name="type" value="checkout"
                                    class="asset-btn asset-btn--secondary">
                                    Check Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
