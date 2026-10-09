/**
 * UKM Toko Theme Main JavaScript
 * Handles navigation toggling, accessibility, mini-cart dropdown, and testimonial slider carousel.
 */
document.addEventListener('DOMContentLoaded', function () {
    // 1. Mobile Navigation Toggle
    var nav = document.getElementById('site-navigation');
    if (nav) {
        var button = nav.getElementsByTagName('button')[0];
        if (button) {
            var menu = nav.getElementsByTagName('ul')[0];
            if (menu) {
                if (!menu.classList.contains('nav-menu')) {
                    menu.classList.add('nav-menu');
                }
                button.addEventListener('click', function (e) {
                    e.stopPropagation();
                    if (nav.classList.contains('toggled')) {
                        nav.classList.remove('toggled');
                        button.setAttribute('aria-expanded', 'false');
                    } else {
                        nav.classList.add('toggled');
                        button.setAttribute('aria-expanded', 'true');
                    }
                });

                // Close mobile menu when clicking outside
                document.addEventListener('click', function (e) {
                    if (!nav.contains(e.target)) {
                        nav.classList.remove('toggled');
                        button.setAttribute('aria-expanded', 'false');
                    }
                });

                // Close mobile menu when clicking a link
                var navLinks = menu.querySelectorAll('a');
                for (var i = 0; i < navLinks.length; i++) {
                    navLinks[i].addEventListener('click', function () {
                        if (window.innerWidth <= 768) {
                            nav.classList.remove('toggled');
                            button.setAttribute('aria-expanded', 'false');
                        }
                    });
                }
            }
        }
    }

    // 2. Mini-cart Dropdown Toggle on Mobile / Touch
    var cartContainer = document.querySelector('.header-cart-container');
    if (cartContainer) {
        var cartTrigger = cartContainer.querySelector('.cart-contents');
        var cartDropdown = cartContainer.querySelector('.header-mini-cart-dropdown');
        if (cartTrigger && cartDropdown) {
            cartTrigger.addEventListener('click', function (e) {
                if (window.innerWidth <= 768) {
                    if (!cartDropdown.classList.contains('is-visible')) {
                        e.preventDefault();
                        cartDropdown.classList.add('is-visible');
                    }
                }
            });

            document.addEventListener('click', function (e) {
                if (!cartContainer.contains(e.target)) {
                    cartDropdown.classList.remove('is-visible');
                }
            });
        }
    }

    // 3. Testimonial Carousel Slider Logic (Requirement 23)
    var sliderContainers = document.querySelectorAll('.ukm-slider-container');
    sliderContainers.forEach(function (container) {
        var track = container.querySelector('.ukm-slider-track');
        var slides = container.querySelectorAll('.ukm-slide');
        var prevBtn = container.querySelector('.ukm-prev');
        var nextBtn = container.querySelector('.ukm-next');
        var dots = container.querySelectorAll('.ukm-dot');
        var currentIndex = 0;
        var totalSlides = slides.length;

        if (totalSlides <= 1) return;

        function updateSlider(index) {
            if (index < 0) index = totalSlides - 1;
            if (index >= totalSlides) index = 0;
            currentIndex = index;
            if (track) {
                track.style.transform = 'translateX(-' + (currentIndex * 100) + '%)';
            }
            dots.forEach(function (dot, i) {
                if (i === currentIndex) {
                    dot.style.background = 'var(--ukm-primary)';
                    dot.classList.add('is-active');
                } else {
                    dot.style.background = 'var(--ukm-border-dark)';
                    dot.classList.remove('is-active');
                }
            });
        }

        if (prevBtn) {
            prevBtn.addEventListener('click', function () {
                updateSlider(currentIndex - 1);
            });
        }
        if (nextBtn) {
            nextBtn.addEventListener('click', function () {
                updateSlider(currentIndex + 1);
            });
        }
        dots.forEach(function (dot) {
            dot.addEventListener('click', function () {
                var targetIndex = parseInt(this.getAttribute('data-slide'), 10);
                if (!isNaN(targetIndex)) {
                    updateSlider(targetIndex);
                }
            });
        });

        // Auto play every 5 seconds
        var autoPlay = setInterval(function () {
            updateSlider(currentIndex + 1);
        }, 5000);

        container.addEventListener('mouseenter', function () {
            clearInterval(autoPlay);
        });
        container.addEventListener('mouseleave', function () {
            autoPlay = setInterval(function () {
                updateSlider(currentIndex + 1);
            }, 5000);
        });
    });

    // 4. Auto-update WooCommerce Cart on quantity change (clean UX without manual update button)
    var cartUpdateTimer;
    document.addEventListener('change', function (e) {
        if (e.target && e.target.matches && e.target.matches('.woocommerce-cart-form input.qty, .woocommerce-cart-form input[name$="[qty]"]')) {
            clearTimeout(cartUpdateTimer);
            var form = e.target.closest('form.woocommerce-cart-form');
            if (!form) return;
            var updateBtn = form.querySelector('button[name="update_cart"], input[name="update_cart"]');
            cartUpdateTimer = setTimeout(function () {
                if (updateBtn) {
                    updateBtn.disabled = false;
                    updateBtn.removeAttribute('aria-disabled');
                    updateBtn.click();
                }
            }, 500);
        }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' && e.target && e.target.matches && e.target.matches('.woocommerce-cart-form input.qty, .woocommerce-cart-form input[name$="[qty]"]')) {
            e.preventDefault();
            e.target.dispatchEvent(new Event('change', { bubbles: true }));
        }
    });
});

