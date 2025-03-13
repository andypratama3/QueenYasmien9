(function() {
    document.querySelectorAll('.sidebar-link[data-bs-toggle="collapse"]').forEach(function (toggle) {
        toggle.addEventListener('click', function () {
            const chevron = this.querySelector('[data-feather="chevron-right"]');
            chevron.classList.toggle('rotate');
        });

        // Handle initial state for pre-expanded items
        const targetId = toggle.getAttribute('href').replace('#', '');
        const targetElement = document.getElementById(targetId);
        if (targetElement && targetElement.classList.contains('show')) {
            const chevron = toggle.querySelector('[data-feather="chevron-right"]');
            chevron.classList.add('rotate');
        }
    });
    
});
