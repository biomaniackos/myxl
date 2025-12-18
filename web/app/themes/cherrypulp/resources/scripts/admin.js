// @see https://www.advancedcustomfields.com/resources/javascript-api/
// @see https://codex.wordpress.org/Javascript_Reference/wp
const { acf, wp } = window;
let initialized = false;

if (acf) {
    acf.add_action('load', initialize);
    acf.add_action('append', initialize);
}

wp.domReady(() => {
    initialize($(document.body));
});

function initialize($el) {
    if (initialized) {
        return;
    }

    // ex. category form: generate slug from name
    $('#addtag').addClass('input-slugify');

    $el.find('.input-slugify').each(function () {
        const $parent = $(this);

        if ($parent.hasClass('js-iniailized')) {
            return;
        }

        const $input = $parent.addClass('js-iniailized').find('input[type="text"]');
        $input.keyup(function () {
            const $this = $(this);
            const timeout = $this.data('timeout');

            if (timeout) {
                clearTimeout(timeout);
            }

            $this.data('timeout', setTimeout(() => {
                const value = $this.val().trim();
                // @note Slugify only if it is not an url
                if (!/(https?:\/\/(?:www\.|(?!www))[^\s\.]+\.[^\s]{2,}|www\.[^\s]+\.[^\s]{2,})/.test(value)) {
                    $parent.find('input[name="slug"]').val(slugify(value));
                }
            }));
        });
    });

    initialized = true;
}

function slugify(text)
{
    return text.toString().toLowerCase().trim()
        .replace(/&/g, '-and-')
        .replace(/[\s\W-]+/g, '-')
}
