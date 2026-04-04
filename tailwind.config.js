/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Inter', 'system-ui', '-apple-system', 'sans-serif'],
        display: ['Inter', 'system-ui', '-apple-system', 'sans-serif'],
      },
      colors: {
        brand: {
          50:  'hsl(214 100% 97%)',
          100: 'hsl(214 95% 93%)',
          200: 'hsl(213 97% 87%)',
          300: 'hsl(212 96% 78%)',
          400: 'hsl(213 94% 68%)',
          500: 'hsl(217 91% 60%)',
          600: 'hsl(221 83% 53%)',
          700: 'hsl(224 76% 48%)',
          800: 'hsl(226 71% 40%)',
          900: 'hsl(224 64% 33%)',
          950: 'hsl(226 57% 21%)',
        },
        slate: {
          50:  'hsl(210 20% 98%)',
          100: 'hsl(210 18% 96%)',
          200: 'hsl(214 16% 91%)',
          300: 'hsl(213 14% 82%)',
          400: 'hsl(215 12% 62%)',
          500: 'hsl(216 14% 46%)',
          600: 'hsl(218 16% 34%)',
          700: 'hsl(220 18% 24%)',
          800: 'hsl(222 22% 16%)',
          900: 'hsl(224 30% 10%)',
          950: 'hsl(228 40% 6%)',
        },
      },
      borderRadius: {
        'xl': '1rem',
        '2xl': '1.25rem',
        '3xl': '1.5rem',
      },
      boxShadow: {
        'soft': '0 1px 3px 0 rgb(0 0 0 / 0.04), 0 1px 2px -1px rgb(0 0 0 / 0.04)',
        'medium': '0 4px 6px -1px rgb(0 0 0 / 0.05), 0 2px 4px -2px rgb(0 0 0 / 0.04)',
        'large': '0 10px 15px -3px rgb(0 0 0 / 0.06), 0 4px 6px -4px rgb(0 0 0 / 0.04)',
        'glow-blue': '0 0 40px hsl(217 91% 60% / 0.2)',
      },
    },
  },
  plugins: [],
};
