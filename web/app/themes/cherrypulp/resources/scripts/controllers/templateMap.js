import L from 'leaflet';
import axios from 'axios';

export default {
    when: 'template-map, page-template-template-map',

    async mounted(args) {
        const elementMap = document.querySelector('#map');
        if (!elementMap) return;

        const searchMap = document.getElementById('search-map');
        const activitiesMap = document.getElementById('activities-map');
        const list = document.querySelectorAll('[data-post-id]');

        let data = [];
        let map;
        let bounds = [];
        let markers = [];
        const myIcon = L.icon({
            iconUrl: `${window.__app.theme_url}/public/images/marker.svg`,
            iconSize: [31, 45],
            // iconAnchor: [22, 94],
            popupAnchor: [0, 0],
            // shadowSize: [68, 95],
            // shadowAnchor: [22, 94]
        });

        searchMapItems();
        handleListItems();

        if(window.location.origin) {
            try {
                const response = await axios.get(`${window.location.origin}/wp-json/wp/v2/places?_embed`);
                const activities = await axios.get(`${window.location.origin}/wp-json/wp/v2/activities?_embed`);
                if ((response.status >= 200 && response.status < 300) && 
                    (activities.status >= 200 && activities.status < 300)) {
                    data = [...response.data, ...activities.data];
                    await initMap();
                }
                else if ((response.status >= 200 && response.status < 300)) {
                    data = [...response.data];
                    await initMap();
                }
                else if ((activities.status >= 200 && activities.status < 300)) {
                    data = [...activities.data];
                    await initMap();
                }

                if (map) {
                    mimicPopup();
                }
            }
            catch (error) {
                console.log(error);
                throw error;
            }
        }


        async function initMap() {
            map = L.map(elementMap);
    
            L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
            }).addTo(map);

            map.setView(new L.LatLng(50.832578, 4.367686), 8);

            createMarkers();
        }

        function createMarkers() {
            data.forEach(item => {
                if (!item.acf || !item.acf.lat || !item.acf.lgt) return;

                let popup = "";
                // Create popup content
                if (item._embedded) {
                    if (item._embedded['wp:featuredmedia']) popup += `<img class="info-logo" src="${item._embedded['wp:featuredmedia'][0].link}" />`;
                    if (item._embedded['wp:term']) {
                        popup += `<ul class="info-cat-wrapper">`;
                        item._embedded['wp:term'][0].forEach(element => {
                            popup += `<a class="btn btn-primary info-cat" href="${element.link}">${element.name}</a>`;
                        });
                        popup += `</ul>`;
                    }
                }
                popup += `<div class="info-wrapper">`;
                popup += `<h3>Infos générales</h3>`;
                if (item.acf.mail) popup += `<a class="info-mail" href="mailto:${item.acf.mail}">${item.acf.mail}</a>`;
                if (item.acf.phone) popup += `<a class="info-phone" href="tel:${item.acf.phone}">${item.acf.phone}</a>`;
                popup += `</div>`;
                
                popup += `<div class="info-description-wrapper">`;
                popup += `<h3>Description</h3>`;
                if (item.content.rendered) popup += `<p>${item.content.rendered}</p>`;
                popup += `</div>`;

                // set map coords
                const coords = [item.acf.lat, item.acf.lgt];
                const marker = L.marker(coords, {
                    icon: myIcon,
                    title: `marker_${item.id}`,
                })
                .bindPopup(popup)
                .addTo(map);
                markers.push(marker);
                bounds.push(coords);
            });

            if (bounds.length > 0) {
                // center map with all markers coords points
                map.fitBounds(bounds);
            }
        }

        function mimicPopup() {
            map.on('popupopen', function(event){
                const el = document.getElementById('map-infos');
                const content = document.getElementById('map-infos-content');
                el.classList.add('visible');
                content.innerHTML = event.popup.getContent();
                map.closePopup();
                
                const close = document.getElementById('close-map-infos');
                close.addEventListener('click', () => {
                    el.classList.remove('visible');
                    close.removeEventListener('click', this);
                });
            });
            map.on('popupclose', function(event){
                // ...
            });
        }

        function searchMapItems() {
            if (!list) return;

            if (searchMap) {
                searchMap.addEventListener('input', e => {
                    const value = e.target.value.toLowerCase().replace(/ /g,'');

                    list.forEach(element => {
                        if(element.innerHTML.toLowerCase().replace(/ /g,'').indexOf(value) !== -1) {
                            element.classList.add('visible');
                        } else {
                            element.classList.remove('visible');
                        }
                    });
                });
            }

            if (activitiesMap) {
                activitiesMap.addEventListener('change', e => {
                    const value = e.target.value;
                    if (value) {
                        list.forEach(element => {
                            const termsID = element.getAttribute('data-search');
    
                            termsID.replace(/ /g,'').split(',').includes(value)
                            if(termsID.replace(/ /g,'').split(',').includes(value)) {
                                element.classList.add('visible');
                            } else {
                                element.classList.remove('visible');
                            }
                        });

                    } else {
                        list.forEach(element => {
                            element.classList.add('visible');
                        });
                    }
                });
            }
        }

        function handleListItems() {
            if(markers.length < 0 && !list || list.length < 0) return;

            list.forEach(element => {
                const click = element.querySelectorAll('[data-item-id]')[0];

                if (click) {
                    click.addEventListener('click', () => {
                        const id = click.getAttribute('data-item-id');

                        markers.forEach(marker => {
                            console.log(marker);
                            if (marker.options.title === id) {
                                marker.openPopup();
                            }
                        });
                    });
                }
            });
        }
    },
};
