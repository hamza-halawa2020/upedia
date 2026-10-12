
            <div id="client_lookup_results" class="phone-lookup-results d-none"></div>
        </div>

        <div class="invalid-feedback d-block {{ $errors->has('client_number') ? '' : 'd-none' }}" data-error-for="client_number">
            @error('client_number'){{ $message }}@enderror
        </div>
    </div>

    <div class="asset-col-6">
        <label class="asset-label">
            Inside / Outside <span class="text-danger">*</span>
        </label>

        <select name="inside_outside" data-field="inside_outside" class="asset-select @error('inside_outside') asset-invalid @enderror" required>
            <option value="">Select</option>
            <option value="inside"
                {{ old('inside_outside', $complain->inside_outside ?? '') == 'inside' ? 'selected' : '' }}>
                Inside
            </option>
            <option value="outside"
                {{ old('inside_outside', $complain->inside_outside ?? '') == 'outside' ? 'selected' : '' }}>
                Outside
            </option>
        </select>

        <div class="invalid-feedback d-block {{ $errors->has('inside_outside') ? '' : 'd-none' }}" data-error-for="inside_outside">
            @error('inside_outside'){{ $message }}@enderror
        </div>
    </div>

