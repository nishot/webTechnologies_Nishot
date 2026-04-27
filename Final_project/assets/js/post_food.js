// assets/js/post_food.js
document.addEventListener('DOMContentLoaded', () => {
    const imageInput = document.getElementById('image-input');
    const getLocationBtn = document.getElementById('get-location-btn');

    if (imageInput) {
        imageInput.addEventListener('change', function(e) {
            if (this.files && this.files.length > 0) {
                document.getElementById('upload-text').innerHTML = `
                    <p class="font-headline font-bold text-primary tracking-tight leading-none mb-1">Image Selected</p>
                    <p class="font-body text-xs text-on-surface-variant">${this.files[0].name}</p>
                `;
            }
        });
    }

    if (getLocationBtn) {
        getLocationBtn.addEventListener('click', function() {
            const btn = this;
            const icon = btn.querySelector('span');
            const input = document.getElementById('location-input');
            
            if (!navigator.geolocation) {
                alert('Geolocation is not supported by your browser');
                return;
            }

            icon.textContent = 'hourglass_empty';
            icon.classList.add('animate-spin');

            navigator.geolocation.getCurrentPosition(async (position) => {
                try {
                    const lat = position.coords.latitude;
                    const lon = position.coords.longitude;
                    const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`);
                    const data = await response.json();
                    
                    if (data && data.display_name) {
                        input.value = data.display_name;
                    } else {
                        input.value = `${lat}, ${lon}`;
                    }
                } catch (err) {
                    alert('Could not fetch address details, filling coordinates instead.');
                    input.value = `${position.coords.latitude}, ${position.coords.longitude}`;
                } finally {
                    icon.textContent = 'my_location';
                    icon.classList.remove('animate-spin');
                }
            }, () => {
                alert('Unable to retrieve your location.');
                icon.textContent = 'my_location';
                icon.classList.remove('animate-spin');
            });
        });
    }
});
