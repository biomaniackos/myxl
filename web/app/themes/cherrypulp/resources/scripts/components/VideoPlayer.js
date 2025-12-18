export default {
    when() {
        return document.querySelectorAll('[data-videoplayer]').length > 0;
    },

    async mounted() {
        const widgets_video = document.querySelectorAll('.widget-video');

        for (const element of widgets_video) {
            const iframe = element.querySelector('iframe');
            const videoplayer = element.querySelector('[data-videoplayer]');
            const id = iframe.getAttribute('id');

            window.focus();
            window.addEventListener("blur", e => {
                setTimeout(() => {
                    if(document.activeElement.tagName === "IFRAME" &&
                       document.activeElement.getAttribute('id') == id) {
                        iframe.classList.add('show');
                        videoplayer.classList.remove('show');
                    }
                });
            }, { once: true });
        }
    },
};
