/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
  ],
  darkMode: 'class',
  theme: {
    extend: {
      fontFamily: {
        heading: ['"Plus Jakarta Sans"', 'sans-serif'],
        body: ['Inter', 'sans-serif'],
      },
      colors: {
        primary: {
          DEFAULT: '#2C5BFF',
          light: '#EEF2FF',
          dark: '#1A3FCC',
        },
        accent: {
          DEFAULT: '#FF6B35',
          light: '#FFF0EB',
        },
        surface: '#F8F9FB',
        border: '#E5E7EB',
        success: '#10B981',
        warning: '#F59E0B',
        danger: '#EF4444',
        unread: '#EFF6FF',
      },
      borderRadius: {
        'card': '12px',
        'input': '8px',
        'pill': '999px',
      },
      boxShadow: {
        'card': '0 1px 3px 0 rgba(0, 0, 0, 0.06)',
        'fab': '0 4px 16px rgba(255, 107, 53, 0.4)',
        'focus': '0 0 0 3px rgba(44, 91, 255, 0.12)',
      },
      spacing: {
        '1.8': '0.45rem',
        '4.5': '1.125rem',
        '5.5': '1.375rem',
        '8.5': '2.125rem',
        '10.5': '2.625rem',
        '11': '2.75rem',
        '18': '4.5rem',
      },
      transitionTimingFunction: {
        'fast': '150ms ease',
        'normal': '250ms ease',
        'slow': '350ms ease-out',
      },
    },
  },
  plugins: [],
}
