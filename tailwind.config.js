/** @type {import('tailwindcss').Config} */
import colors from 'tailwindcss/colors'
import forms from '@tailwindcss/forms'
import typography from '@tailwindcss/typography'

export default {
    content: [
        './resources/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
    ],
    darkMode: 'class',
    theme: {
        extend: {
            colors: {
                danger: colors.red,
                primary: colors.blue,
                success: colors.green,
                warning: colors.orange,
                gray: colors.gray,
                info: colors.purple,
            },
        },
    },
    plugins: [
        forms,
        typography,
    ],
}
