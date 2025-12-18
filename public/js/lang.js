window.translations = {
    en: {
        // Navbar
        nav_news: 'News',
        nav_services: 'Services',
        nav_events: 'Events',
        nav_rating: 'Rating & Review',
        nav_admin: 'Admin',

        // Hero
        hero_subtitle: 'Geology Visit',
        hero_description: 'Explore the Geology Museum of Bandung with ease. Book tickets, attend events, and enjoy the ultimate virtual tour experience.',
        hero_button: 'Get Started',

        // Services
        services_title: 'Our Services',
        service1_title: 'Submit Ticket',
        service1_desc: 'Create a new support ticket for your geological inquiries',
        service1_button: 'Create Ticket',

        service2_title: 'Reschedule',
        service2_desc: 'Change your visit date or event for existing tickets',
        service2_button: 'Reschedule Ticket',

        service3_title: 'Mini Games',
        service3_desc: 'Check out the mini games available at the museum!',
        service3_button: 'Play Games',

        // Events
        events_title: 'Upcoming Events',

        // Rating & Review
        rating_title: 'Rate Your Experience',
        rating_question: 'How was your experience?',
        review_title: 'Write Your Review',
        review_button: 'Submit Review',
        reviews_title: 'Customer Reviews',
        reviews_empty: 'No reviews yet. Be the first to review!',

        review_name: 'Your Name',
        review_email: 'Your Email',
        review_text: 'Share your experience...'
    },
    id: {
        // Navbar
        nav_news: 'Berita',
        nav_services: 'Layanan',
        nav_events: 'Acara',
        nav_rating: 'Rating & Ulasan',
        nav_admin: 'Admin',

        // Hero
        hero_subtitle: 'Geology Visit',
        hero_description: 'Jelajahi Museum Geologi Bandung dengan mudah. Pesan tiket, ikuti acara, dan nikmati pengalaman tur virtual terbaik.',
        hero_button: 'Mulai Sekarang',

        // Services
        services_title: 'Layanan Kami',
        service1_title: 'Kirim Tiket',
        service1_desc: 'Buat tiket dukungan baru untuk pertanyaan geologi Anda',
        service1_button: 'Buat Tiket',

        service2_title: 'Reschedule',
        service2_desc: 'Ubah tanggal kunjungan atau acara untuk tiket yang sudah ada',
        service2_button: 'Reschedule Tiket',

        service3_title: 'Permainan Mini',
        service3_desc: 'Lihat permainan mini menarik yang tersedia di museum!',
        service3_button: 'Main Sekarang',

        // Events
        events_title: 'Acara Mendatang',

        // Rating & Review
        rating_title: 'Beri Penilaian Pengalaman Anda',
        rating_question: 'Bagaimana pengalaman Anda?',
        review_title: 'Tulis Ulasan Anda',
        review_button: 'Kirim Ulasan',
        reviews_title: 'Ulasan Pengunjung',
        reviews_empty: 'Belum ada ulasan. Jadilah yang pertama memberikan ulasan!',

        review_name: 'Nama Anda',
        review_email: 'Email Anda',
        review_text: 'Bagikan pengalaman Anda...'
    }
};

document.addEventListener('DOMContentLoaded', function () {
    const langToggle = document.getElementById('language-toggle');
    const langFlag = document.getElementById('lang-flag');
    let currentLang = localStorage.getItem('language') || 'en';
    setLanguage(currentLang);

    if (langToggle) {
        langToggle.addEventListener('click', function (e) {
            e.preventDefault();
            langFlag.classList.add('lang-switching');

            currentLang = (currentLang === 'en') ? 'id' : 'en';
            localStorage.setItem('language', currentLang);

            setTimeout(() => {
                setLanguage(currentLang);
                langFlag.classList.remove('lang-switching');
                window.dispatchEvent(new CustomEvent('languageChanged', { detail: { language: currentLang } }));
            }, 250);
        });
    }

    function setLanguage(lang) {
        const trans = window.translations[lang];
        document.querySelectorAll('[data-lang-key]').forEach(el => {
            const key = el.getAttribute('data-lang-key');
            if (trans[key]) el.textContent = trans[key];
        });

        // Placeholder translation
        document.querySelectorAll('[data-lang-placeholder]').forEach(el => {
            const key = el.getAttribute('data-lang-placeholder');
            if (trans[key]) el.setAttribute('placeholder', trans[key]);
        });

        // Update flag
        if (lang === 'id') {
            langFlag.src = "https://flagcdn.com/w40/id.png";
            langFlag.alt = "ID";
            langToggle.setAttribute('title', 'Switch to English');
        } else {
            langFlag.src = "https://flagcdn.com/w40/us.png";
            langFlag.alt = "EN";
            langToggle.setAttribute('title', 'Ganti ke Bahasa Indonesia');
        }

        document.documentElement.lang = lang;
    }
});
