// resources/js/app.js
import './bootstrap';
import '../css/app.css';

import Alpine from 'alpinejs';
window.Alpine = Alpine;

// ===== Mood Toggle Alpine Data =====
document.addEventListener('alpine:init', () => {
    Alpine.data('moodToggle', (mode, defaultMood = 'normal') => ({
        mood: defaultMood,
        init() {
            const cookieMatch = document.cookie.match(new RegExp('(^| )mood_' + mode + '=([^;]+)'));
            if (cookieMatch) {
                this.mood = cookieMatch[2];
            } else {
                const stored = localStorage.getItem('mood_' + mode);
                if (stored) this.mood = stored;
            }
            this.applyMood();
        },
        toggle() {
            if (mode === 'academic') {
                this.mood = this.mood === 'day' ? 'dim' : 'day';
            } else {
                this.mood = this.mood === 'studio' ? 'neon' : 'studio';
            }
            this.applyMood();
            this.persist();
        },
        applyMood() {
            const body = document.body;
            if (this.mood === 'day' || this.mood === 'studio') {
                body.removeAttribute('data-mood');
            } else {
                body.setAttribute('data-mood', this.mood);
            }
        },
        persist() {
            const expiry = new Date();
            expiry.setTime(expiry.getTime() + (30 * 24 * 60 * 60 * 1000));
            document.cookie = `mood_${mode}=${this.mood};expires=${expiry.toUTCString()};path=/;SameSite=Lax`;
            localStorage.setItem('mood_' + mode, this.mood);
        }
    }));

    // ===== Mobile Menu =====
    Alpine.data('mobileMenu', () => ({
        open: false,
        toggle() {
            this.open = !this.open;
        }
    }));

    // ===== Admin Sidebar Mobile =====
    Alpine.data('adminSidebar', () => ({
        open: false,
        toggle() {
            this.open = !this.open;
        }
    }));

    // ===== Image Upload Preview =====
    Alpine.data('imageUpload', () => ({
        preview: null,
        filename: '',
        handleFile(event) {
            const file = event.target.files[0];
            if (file) {
                this.filename = file.name;
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.preview = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        },
        clear(event) {
            this.preview = null;
            this.filename = '';
            if (event && event.target) {
                const fileInput = event.target.closest('form').querySelector('input[type="file"]');
                if (fileInput) fileInput.value = '';
            }
        }
    }));

    // ===== Delete Confirmation =====
    Alpine.data('deleteConfirm', () => ({
        confirming: false,
        ask() {
            this.confirming = true;
        },
        cancel() {
            this.confirming = false;
        }
    }));

    // ===== Flash Message Auto-Dismiss =====
    Alpine.data('flashMessage', () => ({
        show: true,
        init() {
            setTimeout(() => {
                this.show = false;
            }, 5000);
        }
    }));
});

Alpine.start();
