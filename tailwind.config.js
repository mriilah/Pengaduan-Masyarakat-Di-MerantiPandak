import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', 'Roboto', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Mock UI Palette (White, Black, Gold, Grays)
                lambo: {
                    gold: '#FFC000',
                    'gold-dark': '#917300',
                    'gold-text': '#B38600',
                },
                abyss: '#FFFFFF',
                charcoal: '#FAFAFA',
                iron: '#F3F4F6',
                // Accent colors for badges
                'cyan-pulse': '#29ABE2',
                'link-blue': '#3860BE',
                'teal-action': '#10B981', // green for Active
                'urgent-red': '#EF4444',  // red for Urgent
            },
            borderRadius: {
                // Rounded corners as seen in the mockup (approx rounded-xl/rounded-2xl)
                none: '0px',
                sm: '0.125rem',
                DEFAULT: '0.5rem',
                md: '0.375rem',
                lg: '0.5rem',
                xl: '0.75rem',
                '2xl': '1rem',
                '3xl': '1.5rem',
                full: '9999px',
            },
        },
    },

    plugins: [forms],
};
