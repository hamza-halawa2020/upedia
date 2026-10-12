@extends('layout.layout')

@section('content')
<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white fw-bold">
        New Lead
    </div>

    <div class="card-body">

        <div class="row g-4">

            {{-- LEFT SIDE --}}
            <div class="col-md-6">

                {{-- Lead Name --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Lead Name</label>
                    <input type="text" name="lead_name" class="form-control">
                </div>

                {{-- Source --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Source</label>
                    <select name="source" class="form-select">
                        <option selected disabled>Select</option>
                    </select>
                </div>

                {{-- Subcategory --}}
                <div class="mb-3 position-relative">
                    <label class="form-label fw-bold">Subcategory</label>
                    <select name="subcategory" class="form-select">
                        <option selected disabled>Select</option>
                    </select>

                </div>

                {{-- Interested For --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Interested For</label>
                    <select name="interested" class="form-select">
                        <option selected disabled>Select</option>
                    </select>
                </div>

                {{-- Country --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Country</label>
                    <select name="country" class="form-select">
                        <option selected disabled>Select</option>
                    </select>
                </div>

                {{-- Zone --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Zone</label>
                    <select name="zone" class="form-select">
                        <option selected disabled>Select</option>
                    </select>
                </div>

                {{-- Student Note --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Student Note</label>
                    <textarea name="student_note" class="form-control" rows="3"></textarea>
                </div>

                {{-- Hot Lead --}}
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="hot_lead">
                    <label class="form-check-label fw-bold">Hot Lead</label>
                </div>


            </div>

            {{-- RIGHT SIDE --}}
            <div class="col-md-6">

                {{-- Status --}}
                <div class="mb-3">
                    <label class="form-label fw-bold d-block">Status</label>
                    <button class="btn btn-light border px-4" type="button">New</button>
                </div>

                {{-- Category --}}
                <div class="mb-3 position-relative">
                    <label class="form-label fw-bold">Category</label>
                    <select name="category" class="form-select">
                        <option selected disabled>Select</option>
                    </select>

                    {{-- Tooltip --}}
                    <div class="position-absolute bg-warning p-3 rounded small" style="right:-220px; top:0;">
                        <strong>Category >></strong><br>
                        Individual<br>
                        Family<br>
                        Corporate
                    </div>
                </div>

                {{-- Ad Type --}}
                <div class="mb-3 position-relative">
                    <label class="form-label fw-bold">Ad Type</label>
                    <select name="ad_type" class="form-select">
                        <option selected disabled>Select</option>
                    </select>

                    {{-- Tooltip --}}
                    <div class="position-absolute bg-warning p-3 rounded small" style="right:-220px; top:0;">
                        <strong>Ad Type >></strong><br>
                        Lead Gen<br>
                        Messages<br>
                        Other
                    </div>
                </div>

                {{-- Mobile --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Mobile</label>
                    <input type="text" name="mobile" class="form-control">
                </div>

                {{-- Status --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Status</label>
                    <select name="status" class="form-select">
                        <option selected disabled>Select</option>
                    </select>
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Email</label>
                    <input type="email" name="email" class="form-control">
                </div>

                {{-- Moderator Note --}}
                {{-- Moderator Note --}}
                <div class="mb-3">
                    <label class="form-label fw-bold">Moderator Note</label>
                    <textarea name="moderator_note" class="form-control" rows="3"></textarea>
                </div>


            </div>
        </div>
    </div>
</div>

{{-- Action Buttons --}}
<div class="d-flex justify-content-end mb-5">
    <button type="submit" class="btn btn-outline-success me-2">
        <i class="fas fa-save me-1"></i> Add Request
    </button>

    <button type="reset" class="btn btn-secondary me-2">Reset</button>

    <a href="#" class="btn btn-outline-danger">Cancel</a>
</div>



@endsection