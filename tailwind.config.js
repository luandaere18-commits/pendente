/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Plus Jakarta Sans', 'system-ui', '-apple-system', 'sans-serif'],
        display: ['Outfit', 'system-ui', '-apple-system', 'sans-serif'],
      },
      colors: {
        brand: {
          50:  'hsl(210 100% 97%)',
          100: 'hsl(210 100% 93%)',
          200: 'hsl(210 98% 85%)',
          300: 'hsl(210 95% 74%)',
          400: 'hsl(210 92% 62%)',
          500: 'hsl(210 88% 52%)',
          600: 'hsl(215 82% 46%)',
          700: 'hsl(220 74% 40%)',
          800: 'hsl(222 68% 32%)',
          900: 'hsl(224 58% 26%)',
          950: 'hsl(226 50% 18%)',
        },
        warm: {
          50: 'hsl(36 100% 97%)',
          100: 'hsl(36 90% 92%)',
          200: 'hsl(34 85% 82%)',
          300: 'hsl(32 80% 68%)',
          400: 'hsl(28 78% 56%)',
          500: 'hsl(24 75% 48%)',
        },
        success: {
          50: 'hsl(152 76% 96%)',
          500: 'hsl(152 60% 42%)',
          600: 'hsl(152 65% 36%)',
        },
      },
      borderRadius: {
        'xl': '1rem',
        '2xl': '1.25rem',
        '3xl': '1.5rem',
      },
      boxShadow: {
        'soft': '0 2px 8px -2px rgb(0 0 0 / 0.06)',
        'card': '0 4px 16px -4px rgb(0 0 0 / 0.08)',
        'elevated': '0 12px 32px -8px rgb(0 0 0 / 0.12)',
        'glow': '0 0 48px hsl(210 88% 52% / 0.18)',
      },
      animation: {
        'float': 'float 5s ease-in-out infinite',
        'fade-up': 'fade-up 0.6s ease forwards',
        'slide-up': 'slide-up 0.5s ease forwards',
        'scale-in': 'scale-in 0.4s ease forwards',
        'shimmer': 'shimmer 2s infinite',
        'pulse-soft': 'pulse-soft 3s ease-in-out infinite',
      },
      keyframes: {
        float: {
          '0%, 100%': { transform: 'translateY(0)' },
          '50%': { transform: 'translateY(-10px)' },
        },
        'fade-up': {
          from: { opacity: '0', transform: 'translateY(20px)' },
          to: { opacity: '1', transform: 'translateY(0)' },
        },
        'slide-up': {
          from: { opacity: '0', transform: 'translateY(40px)' },
          to: { opacity: '1', transform: 'translateY(0)' },
        },
        'scale-in': {
          from: { opacity: '0', transform: 'scale(0.9)' },
          to: { opacity: '1', transform: 'scale(1)' },
        },
        shimmer: {
          '0%': { backgroundPosition: '-200% 0' },
          '100%': { backgroundPosition: '200% 0' },
        },
        'pulse-soft': {
          '0%, 100%': { opacity: '1' },
          '50%': { opacity: '0.7' },
        },
      },
    },
  },
  plugins: [],
};
