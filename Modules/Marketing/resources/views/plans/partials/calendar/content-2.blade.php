
                                    @foreach ($statuses as $status)
                                        <label class="filter-checkbox">
                                            <input type="checkbox" value="{{ $status }}" data-filter-type="status">
                                            <span>{{ ucwords(str_replace('-', ' ', $status)) }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="calendar-filter-group">
                                <div class="calendar-filter-title">
                                    Filter by Platform
                                </div>

                                <div class="filter-checkboxes" id="platform-filters">
