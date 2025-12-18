export default {
    when() {
        return document.querySelectorAll('.alert').length > 0;
    },

    mounted() {
        document.querySelectorAll('.alert').forEach((element) => {
            const $closeBtn = element.querySelector('.alert-close');

            if ($closeBtn) {
                $closeBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    element.parentNode.removeChild(element);
                }, false);
            }
        });
    },
};
