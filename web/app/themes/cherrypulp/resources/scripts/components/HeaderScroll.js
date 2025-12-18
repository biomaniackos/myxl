export default {
    when() {
        return document.getElementById('app-header');
    },

    mounted() {
        const doc = document.documentElement;
        const w = window;

        let prevScroll = w.scrollY || doc.scrollTop;
        let curScroll;
        let direction = 0;
        let prevDirection = 0;

        const header = document.getElementById('app-header');

        const checkScroll = function() {

            /*
            ** Find the direction of scroll
            ** 0 - initial, 1 - up, 2 - down
            */

            curScroll = w.scrollY || doc.scrollTop;
            if (curScroll > prevScroll) { 
                //scrolled up
                direction = 2;
            }
            else if (curScroll < prevScroll) { 
                //scrolled down
                direction = 1;
            }

            if (direction !== prevDirection) {
                toggleHeader(direction, curScroll);
            }

            prevScroll = curScroll;
        };

        const toggleHeader = function(direction, curScroll) {

            //replace 96 with the height of your header in px

            if (direction === 2 && curScroll > 96) { 

                header.classList.add('hide');

                prevDirection = direction;
            }
            else if (direction === 1) {

                header.classList.remove('hide');

                prevDirection = direction;
            }
        };

        window.addEventListener('scroll', checkScroll);
    },
};
