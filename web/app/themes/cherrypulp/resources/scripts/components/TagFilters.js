export default {
    when() {
        return document.querySelector('#tag-filter');
    },

    mounted() {
        const form = document.querySelector('#tag-filter');
        const tags = form.querySelectorAll('input[type="checkbox"]');

        tags.forEach(tag => {
            tag.addEventListener('click', rewritUrl);
        });

        function rewritUrl(e) {
            const checked = e.target.checked;

            if (checked) {
                window.location.href = addFromUrl(e.target.value);
            }
            else {
                window.location.href = removeFromUrl(e.target.value);
            }
        }
        
        function addFromUrl(value) {
            const params = new URLSearchParams(window.location.search);

            if (params.has('filters')) {
                const old = params.get('filters');
                
                // check if value is not allready in url
                if (!existInUrl(old.split(','), value)) {
                    return window.location.origin + window.location.pathname + `?filters=${old},${value}`;
                }
            }
            return window.location.origin + window.location.pathname + `?filters=${value}`;
        }

        function removeFromUrl(value) {
            const url = window.location.href;
            const params = new URLSearchParams(window.location.search);

            if (params.has('filters')) {
                let old = params.get('filters');
                old = old.split(',');
                
                // check if value is in url
                if (existInUrl(old, value)) {
                    let newValues = old.filter(e => e !== value);
                    if (newValues.length <= 0) {
                        return window.location.origin + window.location.pathname;
                    }
                    newValues = newValues.toString();
                    return window.location.origin + window.location.pathname + `?filters=${newValues}`;
                }
            }
            return url;
        }

        function existInUrl(old, value) {
            // old = old.split(',');
            return old.includes(value);
        }
    },
};
