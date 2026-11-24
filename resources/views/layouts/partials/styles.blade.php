<style>
    * { box-sizing: border-box; }
    body { background-color: #f8f7f2; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #2d3748; margin: 0; }
    .sidebar { width: 240px; min-height: 100vh; background: #fff; border-right: 1px solid #e2e8f0; position: fixed; top: 0; left: 0; overflow-y: auto; }
    .bg-active-row { background-color: #f0fdf4; }
    .text-teal { color: #1a736e; }
    .text-profit { color: #22543d; font-weight: 600; }
    .sidebar-brand { height: 64px; display: flex; align-items: center; padding: 0 24px; font-weight: 700; font-size: 1.2rem; color: #1a736e; border-bottom: 1px solid #edf2f7; }
    .sidebar-menu { padding: 16px 12px; }
    .menu-header { font-size: 0.7rem; font-weight: 700; letter-spacing: 0.08em; color: #a0aec0; padding: 16px 12px 6px; text-transform: uppercase; }
    .nav-link-custom { display: block; padding: 10px 14px; color: #4a5568; border-radius: 8px; font-size: 0.9rem; font-weight: 500; margin-bottom: 4px; text-decoration: none; }
    .nav-link-custom:hover { background-color: #f1f0ea; color: #1a736e; }
    .nav-link-custom.active { background-color: #1a736e; color: #fff; font-weight: 600; }
    .main-wrapper { margin-left: 240px; min-height: 100vh; display: flex; flex-direction: column; }
    .topbar { height: 64px; background: #fff; border-bottom: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between; padding: 0 32px; }
    .content-area { padding: 28px 32px; flex: 1; }
    .user-badge-icon { width: 32px; height: 32px; background: #1a736e; color: #fff; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 0.85rem; margin: 0 10px; }
    .row { display: flex; flex-wrap: wrap; margin: 0 -10px; }
    .col-md-4 { width: 33.333%; padding: 0 10px; margin-bottom: 16px; }
    .col-md-6 { width: 50%; padding: 0 10px; margin-bottom: 16px; }
    .stat-card, .card { background: #fff; border: 1px solid #edf2f7; border-radius: 12px; padding: 20px 24px; box-shadow: 0 2px 6px rgba(0,0,0,0.02); margin-bottom: 20px; }
    .stat-title { font-size: 0.75rem; font-weight: 700; color: #718096; text-transform: uppercase; }
    .stat-value { font-size: 1.75rem; font-weight: 700; color: #1a202c; margin: 8px 0 4px; }
    .stat-sub, .text-muted { font-size: 0.85rem; color: #718096; }
    .table-card { background: #fff; border-radius: 12px; border: 1px solid #edf2f7; overflow: hidden; }
    .table { width: 100%; border-collapse: collapse; }
    .table th, .table td { padding: 12px 16px; border-bottom: 1px solid #edf2f7; text-align: left; font-size: 0.9rem; }
    .table th { background: #f8f9fa; font-size: 0.75rem; color: #718096; text-transform: uppercase; }
    .btn { padding: 7px 14px; border-radius: 6px; border: none; cursor: pointer; font-size: 0.85rem; text-decoration: none; display: inline-block; font-weight: 500; }
    .btn-sm { padding: 5px 10px; font-size: 0.8rem; }
    .btn-primary, .btn-info, .btn-success { background: #1a736e; color: #fff; }
    .btn-warning { background: #d69e2e; color: #fff; }
    .btn-danger { background: #e53e3e; color: #fff; }
    .btn-secondary, .btn-outline-secondary { background: #edf2f7; color: #4a5568; border: 1px solid #cbd5e0; }
    .badge { padding: 3px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: 600; }
    .badge-success { background: #c6f6d5; color: #22543d; }
    .badge-danger { background: #fed7d7; color: #742a2a; }
    .badge-secondary, .badge-info { background: #e2e8f0; color: #2d3748; }
    .form-group { margin-bottom: 14px; }
    .form-group label { display: block; margin-bottom: 6px; font-weight: 600; font-size: 0.85rem; }
    .form-control { width: 100%; padding: 8px 12px; border: 1px solid #cbd5e0; border-radius: 6px; font-size: 0.9rem; }
    .alert { padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 0.9rem; }
    .alert-success { background: #c6f6d5; color: #22543d; }
    .alert-danger { background: #fed7d7; color: #742a2a; }
    .d-flex { display: flex; }
    .justify-content-between { justify-content: space-between; }
    .align-items-center { align-items: center; }
    .d-inline { display: inline; }
    .text-right { text-align: right; }
    .mb-4 { margin-bottom: 1.5rem; }
    .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.45); z-index: 1050; overflow-y: auto; }
    .modal.show { display: block; }
    .modal-dialog { max-width: 480px; margin: 70px auto; background: #fff; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.15); overflow: hidden; }
    .modal-header { display: flex; justify-content: space-between; align-items: center; padding: 16px 20px; border-bottom: 1px solid #edf2f7; font-weight: 700; }
    .modal-body { padding: 20px; }
    .modal-footer { padding: 14px 20px; border-top: 1px solid #edf2f7; text-align: right; }
    .close { background: none; border: none; font-size: 1.3rem; cursor: pointer; color: #718096; }
</style>
@stack('styles')
