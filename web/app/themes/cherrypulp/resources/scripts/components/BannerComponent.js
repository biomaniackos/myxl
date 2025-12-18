export default {
    when() {
        return document.querySelectorAll('.banner').length > 0;
    },

    mounted() {
        document.querySelectorAll('.banner').forEach((element) => {
            const $closeBtn = element.querySelector('.banner-close')

            if ($closeBtn) {
                $closeBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    element.parentNode.removeChild(element);
                }, false);
            }
        });
    },
};
