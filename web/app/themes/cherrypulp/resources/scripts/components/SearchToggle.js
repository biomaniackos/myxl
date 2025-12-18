export default {
    when() {
        return document.querySelector('#toggle-search');
    },

    mounted() {
        const open = document.querySelector('#toggle-search');
        const close = document.querySelector('#close-search-form');
        const form = document.querySelector('#search-form');

        if (!open || !form || !close) return;

        open.addEventListener('click', () => {
            form.classList.add('open');
        });

        close.addEventListener('click', () => {
            form.classList.remove('open');
        });
    },
};
