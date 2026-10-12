@include('marketing::complaints.partials.form.content-1')
@include('marketing::complaints.partials.form.content-2')
    @php
        $user = auth()->user();
        $jobSlug = $user?->staff?->jobTitle?->slug;
        $deptSlug = optional($user?->staff?->department)->slug;
        $isSuperAdmin = $user?->hasRole('Super admin');
    @endphp
@include('marketing::complaints.partials.form.content-3')
@push('styles')
@include('marketing::complaints.partials.form.styles-4')
@include('marketing::complaints.partials.form.content-5')
@endpush

@push('scripts')
@include('marketing::complaints.partials.form.scripts-6')
@include('marketing::complaints.partials.form.content-7')
@endpush
