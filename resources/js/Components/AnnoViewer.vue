<template>
    <div :id="viewerId" class="openseadragon-viewer"></div>
</template>

<script>
import OpenSeadragon from 'openseadragon';
import * as Annotorious from '@recogito/annotorious-openseadragon';
import '@recogito/annotorious-openseadragon/dist/annotorious.min.css';

export default {
    props: {
        viewerId: String,
        imgUrl: String
    },
    data() {
        return {
            anno: null
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
        this.anno.setDrawingTool('polygon')
    },
    methods: {}
};
</script>

<style scoped>
.openseadragon-viewer {
    width: 100%;
    height: calc(100vh - 150px);
    border: 1px solid #000;
    margin: 20px auto;
    cursor: grab;
}
</style>
