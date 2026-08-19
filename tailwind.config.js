import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                academic: {
                    DEFAULT: '#6495ED',
                    dim: '#4A7AC0',
                    dark: '#3B6099',
                },
                music: {
                    DEFAULT: '#722F37',
                    neon: '#00F0FF',
                    magenta: '#FF00AA',
                    sulfur: '#CCFF00',
                }
            },
            boxShadow: {
                'neon-cyan': '0 0 15px rgba(0, 240, 255, 0.4)',
                'neon-magenta': '0 0 15px rgba(255, 0, 170, 0.4)',
                'neon-sulfur': '0 0 15px rgba(204, 255, 0, 0.4)',
            },
            textShadow: {
                'neon-cyan': '0 0 10px rgba(0, 240, 255, 0.5)',
                'neon-magenta': '0 0 10px rgba(255, 0, 170, 0.5)',
            }
        },
    },

    plugins: [
        forms,
        function ({ addUtilities }) {
            addUtilities({
                '.text-shadow-neon-cyan': {
                    textShadow: '0 0 10px rgba(0, 240, 255, 0.5)',
                },
                '.text-shadow-neon-magenta': {
                    textShadow: '0 0 10px rgba(255, 0, 170, 0.5)',
                },
                '.text-shadow-neon-sulfur': {
                    textShadow: '0 0 10px rgba(204, 255, 0, 0.5)',
                },
            });
        }
    ],
};
