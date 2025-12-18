export default {
    when() {
        return document.querySelector('#toggle-menu');
    },

    mounted() {
        const toggle = document.querySelector('#toggle-menu');
        const menu = document.querySelector('#menu-header-wrapper');

        if (!toggle || !menu) return;

        toggle.addEventListener('click', () => {
            toggle.classList.toggle('active');
            menu.classList.toggle('open');
        });
    },
};
