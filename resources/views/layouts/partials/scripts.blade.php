<script>
    document.addEventListener('click', function(e) {
        const btnOpen = e.target.closest('[data-toggle="modal"]');
        if (btnOpen) {
            e.preventDefault();
            const modal = document.querySelector(btnOpen.getAttribute('data-target'));
            if (modal) modal.classList.add('show');
        }
        if (e.target.closest('[data-dismiss="modal"]') || e.target.classList.contains('modal')) {
            const modal = e.target.closest('.modal');
            if (modal) modal.classList.remove('show');
        }
    });
</script>
@stack('scripts')
