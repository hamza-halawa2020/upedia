@push('styles')
    <style>
        .form-section__head { margin-bottom: 1rem; padding-bottom: .9rem; border-bottom: 1px solid #eef2f7; }
        .form-section__title { font-size: 1rem !important; font-weight: 700; color: #111827; }
        .form-section__sub { color: #6b7280; font-size: .92rem !important; }
        .quick-links-list { display: flex; flex-direction: column; gap: 1rem; }
        .quick-link-item {
            border: 1px solid #e8edf5; border-radius: 20px; background: #fff; padding: 1.15rem;
            box-shadow: 0 10px 28px rgba(15, 23, 42, .05); transition: .2s ease;
        }
        .quick-link-item:hover { box-shadow: 0 14px 34px rgba(15, 23, 42, .08); border-color: #dbe2ea; }
        .quick-link-item__head { display: flex; align-items: flex-start; justify-content: space-between; gap: 1rem; margin-bottom: 1rem; }
        .quick-link-item__title { font-size: 1rem !important; font-weight: 700; color: #111827; line-height: 1.3; }
        .quick-link-item__sub { color: #6b7280; font-size: .86rem !important; margin-top: .2rem; }
        .quick-link-item__badge { border-radius: 999px; padding: .42rem .8rem; font-weight: 700; font-size: .78rem !important; white-space: nowrap; }
        .quick-link-item__badge.is-active { background: #ecfdf3; color: #047857; border: 1px solid #a7f3d0; }
        .quick-link-item__badge.is-inactive { background: #f8fafc; color: #64748b; border: 1px solid #dbe2ea; }
        .quick-link-grid { display: grid; grid-template-columns: 1fr 1.3fr 1.4fr; gap: 1rem; align-items: start; }
        .quick-link-field { min-width: 0; }
        .quick-link-field--departments { min-width: 240px; }
        .asset-label { display: inline-block; margin-bottom: .45rem; font-weight: 600; color: #374151; font-size: .92rem !important; }
        .asset-input, .asset-select {
            width: 100%; min-height: 46px; border: 1px solid #dbe2ea; border-radius: 14px;
            padding: .72rem .9rem; background: #fff; color: #111827; font-size: .95rem !important;
        }
        .quick-link-footer { display: flex; justify-content: space-between; align-items: end; gap: 1rem; margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #eef2f7; }
        .quick-link-status-block { display: flex; flex-direction: column; gap: .45rem; }
        .quick-link-switch { min-height: 46px; padding: .4rem .8rem; border: 1px solid #dbe2ea; border-radius: 14px; background: #fff; display: inline-flex; align-items: center; gap: .65rem; }
        .quick-link-actions { display: flex; justify-content: flex-end; align-items: center; gap: .65rem; flex-wrap: wrap; }
        .quick-link-actions .asset-btn { min-height: 40px; min-width: 96px; justify-content: center; font-size: .86rem !important; }
        .select2-container { width: 100% !important; display: block !important; }
        .select2-selection--multiple { width: 100% !important; min-height: 46px !important; border: 1px solid #dbe2ea !important; border-radius: 14px !important; }
        .empty-state-box { display: flex; align-items: center; gap: 1rem; padding: 1.25rem; border: 1px dashed #dbe2ea; border-radius: 16px; background: #f8fafc; margin-top: 1rem; }
        .empty-state-box__icon { width: 52px; height: 52px; border-radius: 16px; display: inline-flex; align-items: center; justify-content: center; background: #fff; color: #64748b; font-size: 1.6rem !important; flex-shrink: 0; }
        .empty-state-box__title { font-weight: 700; color: #111827; margin-bottom: .2rem; font-size: 1rem !important; }
        .empty-state-box__text { color: #6b7280; font-size: .92rem !important; }
        @media (max-width: 1200px) { .quick-link-grid { grid-template-columns: 1fr 1fr; } .quick-link-field--departments { grid-column: 1 / -1; } }
        @media (max-width: 768px) { .quick-link-item__head, .quick-link-footer { flex-direction: column; align-items: stretch; } .quick-link-grid { grid-template-columns: 1fr; } .quick-link-actions { flex-direction: column; align-items: stretch; } }
    </style>
@endpush
