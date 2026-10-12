@extends('layout.layout')

@php
    $title = 'Departments';
    $subTitle = $department->name;
@endphp

@section('content')
    @include('components.alert')

    <div class="container-fluid app-bg">
        <div class="page-shell">
            <div class="d-flex flex-column gap-4">
                <x-page-title
                    title="{{ $department->name }}"
                    description="Assign tabs to the department and control the display order for each assigned item."
                >
                        <button type="button" class="asset-btn asset-btn--primary" id="globalSelectAllBtn">
                            Select All
                        </button>
                        <button type="button" class="asset-btn asset-btn--secondary" id="globalUnselectAllBtn">
                            Unselect All
                        </button>
                </x-page-title>

                <form action="{{ route('departments.update', $department->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="ui-card border shadow-sm bg-white">
                        <div class="card-body p-3 p-lg-5">
                            <div class="mb-3">
                                <label class="form-label fw-bold fs-5">Assign Tabs</label>
                                <div class="accordion" id="tabsAccordion">
                                    @foreach ($tabs->where('children', '!=', null)->filter(fn($tab) => $tab->children->count() > 0) as $parent)
                                        <div class="accordion-item section-group border mb-3 rounded-3">
                                            <div class="accordion-header" id="heading-{{ $parent->id }}">
                                                <div class="d-flex align-items-center gap-2 flex-grow-1 px-3 py-3">
                                                    <input class="form-check-input tab-checkbox" type="checkbox"
                                                        name="tabs[]" value="{{ $parent->id }}"
                                                        id="tab-{{ $parent->id }}"
                                                        aria-label="Select {{ $parent->label }} (Parent)"
                                                        {{ $department->tabs->contains($parent->id) ? 'checked' : '' }}>

                                                    <div class="input-group input-group-sm" style="width: 120px;">
                                                        <span class="input-group-text">Order</span>
                                                        <input type="number" name="orders[{{ $parent->id }}]"
                                                            class="form-control"
                                                            value="{{ $department->tabs->find($parent->id)->pivot->order ?? 0 }}"
                                                            min="0">
                                                    </div>

                                                    <span class="badge bg-secondary ms-2 rounded-pill">
                                                        {{ $parent->children->count() + 1 }}
                                                    </span>

                                                    <button class="accordion-button collapsed fw-medium" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#collapse-{{ $parent->id }}"
                                                        aria-expanded="false"
                                                        aria-controls="collapse-{{ $parent->id }}">
                                                        {{ $parent->label }}
                                                    </button>
                                                </div>
                                            </div>

                                            <div id="collapse-{{ $parent->id }}" class="accordion-collapse collapse"
                                                aria-labelledby="heading-{{ $parent->id }}"
                                                data-bs-parent="#tabsAccordion">
                                                <div class="accordion-body">
                                                    <div class="d-flex justify-content-end mb-3 gap-2">
                                                        <button type="button"
                                                            class="btn btn-light btn-sm d-flex align-items-center section-select-all"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Select all in this section">
                                                            Select All
                                                        </button>
                                                        <button type="button"
                                                            class="btn btn-outline-secondary btn-sm d-flex align-items-center section-unselect-all"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Unselect all in this section">
                                                            Unselect All
                                                        </button>
                                                    </div>

                                                    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-3">
                                                        @foreach ($parent->children as $child)
                                                            <div class="col">
                                                                <div class="form-check mb-2 d-flex align-items-center gap-2">
                                                                    <input class="form-check-input tab-checkbox"
                                                                        type="checkbox" name="tabs[]"
                                                                        value="{{ $child->id }}"
                                                                        id="tab-{{ $child->id }}"
                                                                        aria-label="Select {{ $child->label }}"
                                                                        {{ $department->tabs->contains($child->id) ? 'checked' : '' }}>
                                                                    <input type="number" min="0"
                                                                        name="orders[{{ $child->id }}]"
                                                                        style="width:70px;"
                                                                        class="form-control form-control-sm"
                                                                        value="{{ $department->tabs->find($child->id)->pivot->order ?? 0 }}"
                                                                        placeholder="Order">
                                                                    <label class="form-check-label"
                                                                        for="tab-{{ $child->id }}">
                                                                        {{ $child->label }}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    @php
                                        $noChildrenTabs = $tabs->filter(fn($tab) => $tab->children->count() == 0);
                                    @endphp

                                    @if ($noChildrenTabs->count() > 0)
                                        <div class="accordion-item section-group border mb-3 rounded-3">
                                            <div class="accordion-header" id="heading-no-children">
                                                <div class="d-flex align-items-center gap-2 px-3 py-3">
                                                    <span class="badge bg-secondary ms-2 rounded-pill">
                                                        {{ $noChildrenTabs->count() }}
                                                    </span>
                                                    <button class="accordion-button collapsed fw-medium" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#collapse-no-children"
                                                        aria-expanded="false"
                                                        aria-controls="collapse-no-children">
                                                        Other Tabs
                                                    </button>
                                                </div>
                                            </div>

                                            <div id="collapse-no-children" class="accordion-collapse collapse"
                                                aria-labelledby="heading-no-children" data-bs-parent="#tabsAccordion">
                                                <div class="accordion-body">
                                                    <div class="d-flex justify-content-end mb-3 gap-2">
                                                        <button type="button"
                                                            class="btn btn-light btn-sm d-flex align-items-center section-select-all"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Select all in this section">
                                                            Select All
                                                        </button>
                                                        <button type="button"
                                                            class="btn btn-outline-secondary btn-sm d-flex align-items-center section-unselect-all"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Unselect all in this section">
                                                            Unselect All
                                                        </button>
                                                    </div>

                                                    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-3">
                                                        @foreach ($noChildrenTabs as $tab)
                                                            <div class="col">
                                                                <div class="form-check mb-2 d-flex align-items-center gap-2">
                                                                    <input class="form-check-input tab-checkbox"
                                                                        type="checkbox" name="tabs[]"
                                                                        value="{{ $tab->id }}"
                                                                        id="tab-{{ $tab->id }}"
                                                                        aria-label="Select {{ $tab->label }}"
                                                                        {{ $department->tabs->contains($tab->id) ? 'checked' : '' }}>
                                                                    <input type="number" min="0"
                                                                        name="orders[{{ $tab->id }}]"
                                                                        style="width:70px;"
                                                                        class="form-control form-control-sm"
                                                                        value="{{ $department->tabs->find($tab->id)->pivot->order ?? 0 }}"
                                                                        placeholder="Order">
                                                                    <label class="form-check-label fw-semibold"
                                                                        for="tab-{{ $tab->id }}">
                                                                        {{ $tab->label }}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-3">
                                <button type="submit" class="btn btn-outline-primary">
                                    Save Changes
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            [...tooltipTriggerList].map((tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl));

            $("#globalSelectAllBtn").on("click", function() {
                $(".tab-checkbox").prop("checked", true).trigger("change");
            });

            $("#globalUnselectAllBtn").on("click", function() {
                $(".tab-checkbox").prop("checked", false).trigger("change");
            });

            $(".section-select-all").on("click", function() {
                $(this).closest(".section-group").find(".tab-checkbox").prop("checked", true).trigger("change");
            });

            $(".section-unselect-all").on("click", function() {
                $(this).closest(".section-group").find(".tab-checkbox").prop("checked", false).trigger("change");
            });

            $(".tab-checkbox").on("change", function() {
                const label = $(this).nextAll("label");
                const orderInput = $(this).closest(".d-flex").find('input[type="number"]');

                if ($(this).is(":checked")) {
                    label.addClass("text-primary fw-bold").removeClass("text-muted");
                    orderInput.prop('disabled', false);
                } else {
                    label.addClass("text-muted").removeClass("text-primary fw-bold");
                    orderInput.prop('disabled', true);
                }
            }).trigger("change");
        });
    </script>
@endpush
