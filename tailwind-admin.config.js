module.exports = {
    important: '#phuclh-dklog-form',
    mode: 'jit',
    purge: {
        content: [
            './resources/views/admin/*.blade.php',
            './resources/admin/js/*.js',
        ]
    },
    darkMode: 'media', // or 'media' or 'class'
    theme: {
        extend: {},
    },
    variants: {
        extend: {},
    }
}
