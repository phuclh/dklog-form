const mix = require('laravel-mix');
const tailwind = require('tailwindcss');

mix.js("resources/js/plugin.js", "resources/dist/js")
    .postCss("resources/css/plugin.css", "dist/css/plugin.css", [
        require("tailwindcss"),
    ]);

mix.js("resources/js/admin/plugin.js", "resources/dist/js/admin")
    .postCss("resources/css/admin/plugin.css", "dist/css/admin/plugin.css", {
    }, [
        tailwind("./tailwind-admin.config.js")
    ]);
