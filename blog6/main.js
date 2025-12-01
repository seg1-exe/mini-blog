document.addEventListener('DOMContentLoaded', function () {
    var revealElements = document.querySelectorAll('article, form, table, h1, h2');

    var observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1
    });

    revealElements.forEach(function (el, index) {
        el.classList.add('reveal');
        if (index === 1) {
            el.classList.add('reveal-delay-1');
        } else if (index === 2) {
            el.classList.add('reveal-delay-2');
        } else if (index === 3) {
            el.classList.add('reveal-delay-3');
        }
        observer.observe(el);
    });

    var searchForm = document.querySelector('form[action="lister.php"]');
    var searchInput = searchForm ? searchForm.querySelector('input[name="q"]') : null;

    if (searchInput && window.location.pathname.endsWith('index.php')) {
        setTimeout(function () {
            searchInput.focus();
        }, 200);
    }

    document.addEventListener('keydown', function (event) {
        var isMac = navigator.platform.toUpperCase().indexOf('MAC') >= 0;
        var isModifier = isMac ? event.metaKey : event.ctrlKey;

        if (isModifier && event.key.toLowerCase() === 'k') {
            if (searchInput) {
                event.preventDefault();
                searchInput.focus();
                searchInput.select();
            }
        }
    });
});
