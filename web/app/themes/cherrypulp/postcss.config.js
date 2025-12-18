module.exports = {
    parser: require('postcss-scss'),
    plugins: [
        require('@postcss-plugins/text-transform'),
        require('autoprefixer'),
        require('postcss-assets')({
            loadPaths: [
                './public/fonts/',
                './public/images/',
                './public/scripts/',
                './public/styles/',
            ],
        }),
        require('postcss-custom-properties'),
        require('postcss-color-function'),
        require('postcss-each'),
        require('postcss-for'),
        require('postcss-mixins'),
        require('tailwindcss'),
        require('tailwindcss/nesting')(require('postcss-nested')),
    ],
};
