<template>
    <div :id="viewerId"
         class="openseadragon-viewer rounded border w-100 h-100"
         @mousemove="handleMouseMove" @keydown.shift="handleShiftKey" @keyup.shift="resetCursor"
    />
</template>

<script>
import OpenSeadragon from 'openseadragon';
import * as Annotorious from '@recogito/annotorious-openseadragon';
import '@recogito/annotorious-openseadragon/dist/annotorious.min.css';

export default {
    props: {
        viewerId: String,
        imgUrl: String,
        drawingTool: String,
        isAnnoVisible: Boolean
    },
    data() {
        return {
            anno: null,
        };
    },
    mounted() {
        const viewer = OpenSeadragon({
            id: this.viewerId,
            prefixUrl: 'https://cdn.jsdelivr.net/npm/openseadragon@4.1/build/openseadragon/images/',
            tileSources: {
                type: "image",
                url: this.imgUrl
            }
        });
        const config = {}; // Optional plugin config options
        this.anno = Annotorious(viewer, config);
        this.anno.setDrawingTool(this.drawingTool)
        this.anno.setVisible(this.isAnnoVisible)
    },
    watch: {
        drawingTool(newVal) {
            this.anno.setDrawingTool(newVal)
        },
        isAnnoVisible(newVal) {
            this.anno.setVisible(newVal)
        }
    },
    methods: {
        handleMouseMove(event) {
            if (event.shiftKey) {
                this.$el.style.cursor = 'crosshair';
            } else {
                this.$el.style.cursor = 'grab';
            }
        },
        handleShiftKey() {
            this.$el.style.cursor = 'crosshair';
        },
        resetCursor() {
            this.$el.style.cursor = 'grab';
        },
    }
};
</script>

<style scoped>
.openseadragon-viewer {
}
</style>
