document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.card');
    let expandedCard = null;

    cards.forEach(card => {
        card.addEventListener('click', function(event) {
            if (event.target.classList.contains('bx-exit')) {
                // Clicked on the exit icon, collapse the card
                this.classList.remove('expanded');
                expandedCard = null;
            } else if (event.target.classList.contains('learn-more')) {
                if (this !== expandedCard) {
                    if (expandedCard) {
                        expandedCard.classList.remove('expanded');
                    }
                    this.classList.add('expanded');
                    expandedCard = this;
                }
            }

            cards.forEach(otherCard => {
                if (otherCard !== this) {
                    otherCard.style.display = (expandedCard === null) ? 'block' : 'none';
                }
            });

            const learnMoreBtn = this.querySelector('.learn-more');
            if (learnMoreBtn) {
                learnMoreBtn.style.display = (expandedCard === null) ? 'block' : 'none';
            }

            const infoBox = this.querySelector('.info-box');
            if (infoBox) {
                infoBox.style.display = (expandedCard === null) ? 'block' : 'none';
            }

            const additionalInfo = this.querySelector('.additional-info');
            if (additionalInfo) {
                additionalInfo.style.display = (expandedCard !== null) ? 'flex' : 'none';
            }
        });
    });
});

    function initMap() {
        const maps = document.querySelectorAll('.company-map');

        maps.forEach(mapElement => {
            const address = mapElement.dataset.address;
            const geocoder = new google.maps.Geocoder();

            geocoder.geocode({
                'address': address
            }, function(results, status) {
                if (status === 'OK') {
                    const map = new google.maps.Map(mapElement, {
                        center: results[0].geometry.location,
                        zoom: 15,
                    });

                    const marker = new google.maps.Marker({
                        map: map,
                        position: results[0].geometry.location,
                    });
                } else {
                    console.error('Geocode was not successful for the following reason: ' + status);
                }
            });
        });
    };

