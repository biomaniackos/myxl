import Parallax from 'parallax-js'; // https://github.com/wagerfield/parallax

export default {
    when() {
        return document.querySelectorAll('.elem-scene').length > 0;
    },

    mounted() {
        document.querySelectorAll('.elem-scene').forEach((element) => {
            const parallaxInstance = new Parallax(element, {
                relativeInput: true,
                clipRelativeInput: true,
                hoverOnly: true,
            });
            parallaxInstance.friction(0.2, 0.2);
        });
    },
};
