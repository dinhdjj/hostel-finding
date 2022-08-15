export function createHtmlMapMarker(google, option) {
    class HTMLMapMarker extends google.maps.OverlayView {
        position;
        div;

        constructor(option) {
            super();
            this.position = option.position;
            this.div = this.createDiv(option.html);
            this.setMap(option.map);
        }

        createDiv(html) {
            const div = document.createElement('div');
            div.style.position = 'absolute';
            div.innerHTML = html;

            div.addEventListener('click', (e) => {
                google.maps.event.trigger(this, 'click', e);
            });

            return div;
        }

        appendDivToOverlay() {
            const panes = this.getPanes();
            panes.overlayMouseTarget.appendChild(this.div);
        }

        positionDiv() {
            const point = this.getProjection().fromLatLngToDivPixel(
                this.position
            );
            this.div.style.left = `${point.x}px`;
            this.div.style.top = `${point.y}px`;
        }

        draw() {
            this.appendDivToOverlay();
            this.positionDiv();
        }

        remove() {
            this.div.parentNode?.removeChild(this.div);
        }

        getPosition() {
            return this.position;
        }

        getDraggable() {
            return false;
        }
    }

    return new HTMLMapMarker(option);
}
