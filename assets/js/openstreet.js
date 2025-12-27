// Debounce function to limit API calls
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Extract just the city name from the display_name
function extractCityName(displayName) {
    return displayName.split(',')[0].trim();
}

// Fetch cities from OpenStreetMap Nominatim API WITH CORS PROXY
async function fetchCities(searchTerm) {
    if (!searchTerm || searchTerm.length < 2) {
        return [];
    }

    try {
        // Using CORS proxy to bypass CORS restrictions
        const apiUrl = `https://nominatim.openstreetmap.org/search?` +
            `format=json&` +
            `q=${encodeURIComponent(searchTerm)}&` +
            `featureType=city&` +
            `addressdetails=1&` +
            `limit=10&` +
            `accept-language=en`;
        
        // Using corsproxy.io service
        const proxyUrl = `https://corsproxy.io/?` + encodeURIComponent(apiUrl);
        
        const response = await fetch(proxyUrl);

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Error fetching cities:', error);
        
        // Fallback to alternative proxy if first one fails
        try {
            const apiUrl = `https://nominatim.openstreetmap.org/search?` +
                `format=json&` +
                `q=${encodeURIComponent(searchTerm)}&` +
                `featureType=city&` +
                `addressdetails=1&` +
                `limit=10&` +
                `accept-language=en`;
            
            // Try allorigins.win as fallback
            const fallbackUrl = `https://api.allorigins.win/get?url=` + encodeURIComponent(apiUrl);
            const fallbackResponse = await fetch(fallbackUrl);
            const fallbackData = await fallbackResponse.json();
            
            // allorigins returns data in a different format
            return JSON.parse(fallbackData.contents);
        } catch (fallbackError) {
            console.error('Fallback also failed:', fallbackError);
            throw error;
        }
    }
}


        // Show loading state in dropdown
        function showLoading() {
            const dropdown = document.getElementById('cityDropdown');
            dropdown.innerHTML = `
                <div class="loading-spinner">
                    <div class="spinner-border spinner-border-sm" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <span class="ms-2">Searching cities...</span>
                </div>
            `;
            dropdown.style.display = 'block';
        }

        // Show cities in dropdown
        function displayCities(cities) {
            const dropdown = document.getElementById('cityDropdown');
            
            if (!cities || cities.length === 0) {
                dropdown.innerHTML = '<div class="no-results">No cities found</div>';
                dropdown.style.display = 'block';
                return;
            }

            dropdown.innerHTML = '';
            
            cities.forEach(city => {
                const cityElement = document.createElement('div');
                cityElement.className = 'city-item';
                
                // Get just the city name
                const cityName = extractCityName(city.display_name);
                
                // Get location details for display
                const state = city.address.state || city.address.county || '';
                const country = city.address.country || '';
                const locationText = state && country ? `${state}, ${country}` : (state || country);
                
                cityElement.innerHTML = `
                    <div class="city-name">${cityName}</div>
                    ${locationText ? `<div class="city-details">${locationText}</div>` : ''}
                `;
                
                // Handle click - set only city name to input
                cityElement.addEventListener('click', () => {
                    const cityInput = document.getElementById('cityInput');
                    cityInput.value = cityName;
                    dropdown.style.display = 'none';
                });
                
                // Hover effects
                cityElement.addEventListener('mouseenter', () => {
                    cityElement.classList.add('active');
                });
                
                cityElement.addEventListener('mouseleave', () => {
                    cityElement.classList.remove('active');
                });
                
                dropdown.appendChild(cityElement);
            });
            
            dropdown.style.display = 'block';
        }

        // Show error message
        function showError(message) {
            const dropdown = document.getElementById('cityDropdown');
            dropdown.innerHTML = `<div class="error-message">${message}</div>`;
            dropdown.style.display = 'block';
        }

        // Main search handler with debouncing
        const handleSearch = debounce(async (event) => {
            const searchTerm = event.target.value.trim();
            
            if (searchTerm.length < 2) {
                document.getElementById('cityDropdown').style.display = 'none';
                return;
            }
            
            showLoading();
            
            try {
                const cities = await fetchCities(searchTerm);
                displayCities(cities);
            } catch (error) {
                showError('Failed to fetch cities. Please try again.');
            }
        }, 300);

        // Initialize the functionality
        document.addEventListener('DOMContentLoaded', () => {
            const cityInput = document.getElementById('cityInput');
            const dropdown = document.getElementById('cityDropdown');
            
            // Event listeners
            cityInput.addEventListener('input', handleSearch);
            
            // Focus event to show dropdown again if there's text
            cityInput.addEventListener('focus', () => {
                if (cityInput.value.trim().length >= 2 && dropdown.children.length > 0) {
                    dropdown.style.display = 'block';
                }
            });
            
            // Close dropdown when clicking outside
            document.addEventListener('click', (event) => {
                if (!event.target.closest('.position-relative')) {
                    dropdown.style.display = 'none';
                }
            });
            
            // Handle keyboard navigation
            cityInput.addEventListener('keydown', (event) => {
                const dropdownItems = document.querySelectorAll('.city-item');
                const activeItem = document.querySelector('.city-item.active');
                let currentIndex = activeItem ? Array.from(dropdownItems).indexOf(activeItem) : -1;
                
                switch(event.key) {
                    case 'ArrowDown':
                        event.preventDefault();
                        if (dropdownItems.length === 0) return;
                        
                        // Remove active class from all items
                        dropdownItems.forEach(item => item.classList.remove('active'));
                        
                        // Calculate next index
                        if (currentIndex < dropdownItems.length - 1) {
                            currentIndex++;
                        } else {
                            currentIndex = 0;
                        }
                        
                        // Set active class and scroll into view
                        dropdownItems[currentIndex].classList.add('active');
                        dropdownItems[currentIndex].scrollIntoView({ block: 'nearest' });
                        break;
                        
                    case 'ArrowUp':
                        event.preventDefault();
                        if (dropdownItems.length === 0) return;
                        
                        // Remove active class from all items
                        dropdownItems.forEach(item => item.classList.remove('active'));
                        
                        // Calculate previous index
                        if (currentIndex > 0) {
                            currentIndex--;
                        } else if (currentIndex === -1) {
                            currentIndex = dropdownItems.length - 1;
                        } else {
                            currentIndex = dropdownItems.length - 1;
                        }
                        
                        // Set active class and scroll into view
                        dropdownItems[currentIndex].classList.add('active');
                        dropdownItems[currentIndex].scrollIntoView({ block: 'nearest' });
                        break;
                        
                    case 'Enter':
                        if (activeItem) {
                            event.preventDefault();
                            activeItem.click();
                        }
                        break;
                        
                    case 'Escape':
                        dropdown.style.display = 'none';
                        break;
                }
            });
        });