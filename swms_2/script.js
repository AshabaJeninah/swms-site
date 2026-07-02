
    const mobileMenu = document.getElementById('mobile-menu');
    const navList = document.getElementById('nav-list');

    if (mobileMenu) {
        mobileMenu.addEventListener('click', function() {
            navList.classList.toggle('active');
            console.log("Button clicked! Menu status: " + navList.classList.contains('active'));
        });
    }
