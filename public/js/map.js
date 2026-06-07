const svg = document.getElementById('map-svg');
const markersLayer = document.getElementById('markers-layer');

function renderMarkers() {
    markersLayer.innerHTML = '';
    SPOTS.forEach(spot => {
        const g = document.createElementNS('http://www.w3.org/2000/svg', 'g');
        g.setAttribute('data-id', spot.id);
        g.style.cursor = 'grab';

        const rect = document.createElementNS('http://www.w3.org/2000/svg', 'rect');
        rect.setAttribute('x', spot.map_x - 12);
        rect.setAttribute('y', spot.map_y - 12);
        rect.setAttribute('width', 24);
        rect.setAttribute('height', 24);
        rect.setAttribute('rx', 4);
        rect.setAttribute('fill', spot.status === 'occupied' ? '#ef4444' : spot.status === 'reserved' ? '#f59e0b' : '#22c55e');
        rect.setAttribute('stroke', '#fff');
        rect.setAttribute('stroke-width', 2);

        const text = document.createElementNS('http://www.w3.org/2000/svg', 'text');
        text.setAttribute('x', spot.map_x);
        text.setAttribute('y', spot.map_y - 16);
        text.setAttribute('text-anchor', 'middle');
        text.setAttribute('font-size', '10');
        text.setAttribute('fill', '#374151');
        text.setAttribute('font-weight', 'bold');
        text.textContent = spot.plot_number;

        const title = document.createElementNS('http://www.w3.org/2000/svg', 'title');
        title.textContent = `${spot.name} (${spot.plot_number}) - ${spot.status}`;

        g.appendChild(rect);
        g.appendChild(text);
        g.appendChild(title);

        makeDraggable(g, spot);

        markersLayer.appendChild(g);
    });
}

function makeDraggable(element, spot) {
    let offsetX, offsetY, isDragging = false;

    element.addEventListener('mousedown', startDrag);
    element.addEventListener('touchstart', startDragTouch, { passive: false });

    function startDrag(e) {
        isDragging = true;
        element.style.cursor = 'grabbing';
        const rect = svg.getBoundingClientRect();
        const scaleX = 520 / rect.width;
        const scaleY = 380 / rect.height;
        offsetX = (e.clientX - rect.left) * scaleX - spot.map_x;
        offsetY = (e.clientY - rect.top) * scaleY - spot.map_y;
        document.addEventListener('mousemove', onDrag);
        document.addEventListener('mouseup', stopDrag);
    }

    function startDragTouch(e) {
        e.preventDefault();
        isDragging = true;
        const touch = e.touches[0];
        const rect = svg.getBoundingClientRect();
        const scaleX = 520 / rect.width;
        const scaleY = 380 / rect.height;
        offsetX = (touch.clientX - rect.left) * scaleX - spot.map_x;
        offsetY = (touch.clientY - rect.top) * scaleY - spot.map_y;
        document.addEventListener('touchmove', onDragTouch, { passive: false });
        document.addEventListener('touchend', stopDragTouch);
    }

    function onDrag(e) {
        if (!isDragging) return;
        const rect = svg.getBoundingClientRect();
        const scaleX = 520 / rect.width;
        const scaleY = 380 / rect.height;
        let x = (e.clientX - rect.left) * scaleX - offsetX;
        let y = (e.clientY - rect.top) * scaleY - offsetY;
        x = Math.max(12, Math.min(508, x));
        y = Math.max(12, Math.min(368, y));
        spot.map_x = x;
        spot.map_y = y;
        renderMarkers();
    }

    function onDragTouch(e) {
        e.preventDefault();
        if (!isDragging) return;
        const touch = e.touches[0];
        const rect = svg.getBoundingClientRect();
        const scaleX = 520 / rect.width;
        const scaleY = 380 / rect.height;
        let x = (touch.clientX - rect.left) * scaleX - offsetX;
        let y = (touch.clientY - rect.top) * scaleY - offsetY;
        x = Math.max(12, Math.min(508, x));
        y = Math.max(12, Math.min(368, y));
        spot.map_x = x;
        spot.map_y = y;
        renderMarkers();
    }

    function stopDrag() {
        isDragging = false;
        element.style.cursor = 'grab';
        document.removeEventListener('mousemove', onDrag);
        document.removeEventListener('mouseup', stopDrag);
        savePosition(spot.id, Math.round(spot.map_x), Math.round(spot.map_y));
    }

    function stopDragTouch() {
        isDragging = false;
        document.removeEventListener('touchmove', onDragTouch);
        document.removeEventListener('touchend', stopDragTouch);
        savePosition(spot.id, Math.round(spot.map_x), Math.round(spot.map_y));
    }
}

async function savePosition(id, x, y) {
    const url = UPDATE_POSITION_URL.replace(':id', id);
    try {
        await fetch(url, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF_TOKEN,
            },
            body: JSON.stringify({ x, y }),
        });
    } catch (err) {
        console.error('Failed to save position:', err);
    }
}

// Search filtering
document.getElementById('search-input')?.addEventListener('input', function () {
    const q = this.value.toLowerCase();
    document.querySelectorAll('.entry').forEach(el => {
        const text = el.textContent.toLowerCase();
        el.style.display = text.includes(q) ? '' : 'none';
    });
});

// Click sidebar entry to highlight on map
document.querySelectorAll('.entry').forEach(el => {
    el.addEventListener('click', function () {
        const id = parseInt(this.dataset.id);
        const spot = SPOTS.find(s => s.id === id);
        if (spot) {
            const svgRect = svg.getBoundingClientRect();
            window.scrollTo({ top: 0, behavior: 'smooth' });
            svg.parentElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });
});

renderMarkers();