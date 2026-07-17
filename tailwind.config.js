import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    darkMode: 'class',

    theme: {
        extend: {
            colors: {
                primary: {
                    50: '#eff6ff',
                    100: '#dbeafe',
                    200: '#bfdbfe',
                    300: '#93c5fd',
                    400: '#60a5fa',
                    500: '#2563EB',
                    600: '#1d4ed8',
                    700: '#1e40af',
                    800: '#1e3a8a',
                    900: '#1e3a8a',
                    DEFAULT: '#2563EB',
                },
                secondary: {
                    50: '#f8fafc',
                    100: '#f1f5f9',
                    200: '#e2e8f0',
                    300: '#cbd5e1',
                    400: '#94a3b8',
                    500: '#64748b',
                    600: '#475569',
                    700: '#334155',
                    800: '#1e293b',
                    900: '#0F172A',
                    DEFAULT: '#0F172A',
                },
                accent: {
                    50: '#f5f3ff',
                    100: '#ede9fe',
                    200: '#ddd6fe',
                    300: '#c4b5fd',
                    400: '#a78bfa',
                    500: '#7C3AED',
                    600: '#6d28d9',
                    700: '#5b21b6',
                    800: '#4c1d95',
                    900: '#3b0764',
                    DEFAULT: '#7C3AED',
                },
            },
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                serif: ['Cormorant Garamond', 'Georgia', ...defaultTheme.fontFamily.serif],
            },
            animation: {
                'fade-in': 'fadeIn 0.6s ease-out forwards',
                'fade-in-up': 'fadeInUp 0.7s ease-out forwards',
                'slide-in-right': 'slideInRight 0.5s ease-out forwards',
                'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                'float': 'float 6s ease-in-out infinite',
                'hero-zoom': 'heroZoom 20s ease-in-out infinite alternate',
                'data-flow': 'dataFlow 3s linear infinite',
                'shimmer': 'shimmer 2s linear infinite',
                'spin-slow': 'spin 3s linear infinite',
            },
            keyframes: {
                fadeIn: {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                fadeInUp: {
                    '0%': { opacity: '0', transform: 'translateY(24px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                slideInRight: {
                    '0%': { opacity: '0', transform: 'translateX(-20px)' },
                    '100%': { opacity: '1', transform: 'translateX(0)' },
                },
                float: {
                    '0%, 100%': { transform: 'translateY(0)' },
                    '50%': { transform: 'translateY(-12px)' },
                },
                heroZoom: {
                    '0%': { transform: 'scale(1)' },
                    '100%': { transform: 'scale(1.08)' },
                },
                dataFlow: {
                    '0%': { transform: 'translateX(-100%)' },
                    '100%': { transform: 'translateX(100%)' },
                },
                shimmer: {
                    '0%': { backgroundPosition: '-200% 0' },
                    '100%': { backgroundPosition: '200% 0' },
                },
            },
            backgroundImage: {
                'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
                'gradient-enterprise': 'linear-gradient(135deg, #2563EB 0%, #7C3AED 50%, #0F172A 100%)',
                'gradient-glass': 'linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%)',
            },
            boxShadow: {
                'glass': '0 8px 32px rgba(0, 0, 0, 0.12)',
                'glass-lg': '0 16px 48px rgba(0, 0, 0, 0.18)',
                'glow-primary': '0 0 40px rgba(37, 99, 235, 0.3)',
                'glow-accent': '0 0 40px rgba(124, 58, 237, 0.3)',
            },
        },
    },

    plugins: [forms],
};
