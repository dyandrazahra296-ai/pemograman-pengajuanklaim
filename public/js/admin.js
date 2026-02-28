document.addEventListener('DOMContentLoaded', () => {

    /* ===============================
       PAGE LOAD FADE
    =============================== */
    document.body.classList.add('page-loaded');

    /* ===============================
       COUNTER ANIMATION
    =============================== */
    document.querySelectorAll('[data-counter]').forEach(el => {
        const target = parseInt(el.dataset.counter);
        let startTime = null;

        function animateCounter(timestamp) {
            if (!startTime) startTime = timestamp;
            const progress = Math.min((timestamp - startTime) / 1200, 1);
            el.innerText = Math.floor(progress * target);

            if (progress < 1) {
                requestAnimationFrame(animateCounter);
            } else {
                el.innerText = target;
            }
        }
        requestAnimationFrame(animateCounter);
    });

    /* ===============================
       CARD 3D TILT EFFECT
    =============================== */
    document.querySelectorAll('.stat-card').forEach(card => {
        card.addEventListener('mousemove', e => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            const rotateX = ((y / rect.height) - 0.5) * 12;
            const rotateY = ((x / rect.width) - 0.5) * -12;

            card.style.transform = `
                perspective(1000px)
                rotateX(${rotateX}deg)
                rotateY(${rotateY}deg)
                translateY(-12px)
                scale(1.03)
            `;
            card.style.boxShadow = '0 40px 80px rgba(91,108,255,.2)';
        });

        card.addEventListener('mouseleave', () => {
            card.style.transform = 'translateY(0) scale(1)';
            card.style.boxShadow = '';
        });
    });

    /* ===============================
       SIDEBAR ACTIVE
    =============================== */
    document.querySelectorAll('.sidebar nav a').forEach(link => {
        if (link.href === window.location.href) {
            link.classList.add('active');
        }
    });

    /* ===============================
       SIDEBAR RIPPLE
    =============================== */
    document.querySelectorAll('.sidebar nav a').forEach(link => {
        link.addEventListener('click', e => {
            const ripple = document.createElement('span');
            ripple.className = 'ripple';

            const rect = link.getBoundingClientRect();
            ripple.style.left = `${e.clientX - rect.left}px`;
            ripple.style.top = `${e.clientY - rect.top}px`;

            link.appendChild(ripple);
            setTimeout(() => ripple.remove(), 600);
        });
    });

    /* ===============================
       SCROLL REVEAL
    =============================== */
    const revealItems = document.querySelectorAll('.stat-card, .chart-card');

    const reveal = () => {
        const trigger = window.innerHeight * 0.85;
        revealItems.forEach(item => {
            if (item.getBoundingClientRect().top < trigger) {
                item.classList.add('reveal');
            }
        });
    };

    window.addEventListener('scroll', reveal);
    reveal();

});

/* ===============================
   AUTO ACTIVE SIDEBAR (NO CLICK)
=============================== */
const currentPath = window.location.pathname;

document.querySelectorAll('.sidebar nav a').forEach(link => {
    if (currentPath.startsWith(link.getAttribute('href'))) {
        link.classList.add('active');
    }
});

/* ===============================
   STAT CARD HOVER COLOR DEPTH
=============================== */
document.querySelectorAll('.stat-card').forEach(card => {
    card.addEventListener('mouseenter', () => {
        card.style.boxShadow = '0 40px 80px rgba(0,0,0,.25)';
    });

    card.addEventListener('mouseleave', () => {
        card.style.boxShadow = '';
    });
});

/* ===============================
   LOGIN SUBMIT LOADER
=============================== */
const loginForm = document.querySelector('.login-card form');
const loginBtn = document.getElementById('loginBtn');
const pageLoader = document.getElementById('page-loader');

if (loginForm) {
    loginForm.addEventListener('submit', () => {
        const btnText = loginBtn.querySelector('.btn-text');
        const loginForm = document.querySelector('form.login-card'); // Cari form yang punya class login-card
        
        btnText.style.display = 'none';
        btnLoader.style.display = 'inline-block';

        setTimeout(() => {
            pageLoader.classList.add('active');
        }, 300);
    });
}

document.querySelectorAll('.sidebar-menu a').forEach(link => {
    if (link.href === window.location.href) {
        link.classList.add('active');
    }
});

document.querySelectorAll('.btn-delete').forEach(btn => {
    btn.addEventListener('click', function () {
        const userId = this.dataset.id;
        const username = this.dataset.name;

        Swal.fire({
            title: 'Yakin?',
            text: `User "${username}" akan dihapus permanen`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e74c3c',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `/users/delete/${userId}`;
            }
        });
    });
});

document.querySelectorAll('.btn-reset').forEach(btn => {
    btn.addEventListener('click', function () {
        const userId = this.dataset.id;
        const username = this.dataset.name;

        Swal.fire({
            title: 'Reset Password?',
            text: `Password user "${username}" akan direset`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Reset',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `/users/reset-password/${userId}`;
            }
        });
    });
});

function toggleStatus(el) {
    const userId = el.dataset.id;

    fetch('/users/toggle-status', {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'id=' + userId
    })
    .then(res => res.json())
    .then(data => {
        if (!data.status) {
            Swal.fire('Gagal', data.message, 'warning');
            return;
        }

        if (data.is_active == 1) {
            el.classList.remove('status-inactive');
            el.classList.add('status-active');
            el.innerText = 'Aktif';
        } else {
            el.classList.remove('status-active');
            el.classList.add('status-inactive');
            el.innerText = 'Nonaktif';
        }
    })
    .catch(() => {
        Swal.fire('Error', 'Gagal mengubah status', 'error');
    });
}
