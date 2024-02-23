<template>
    <div :id="viewerId" ref="annoViewer"
         class="openseadragon-viewer rounded border w-100 h-100"
         @mousemove="handleMouseMove" @keydown.shift="handleShiftKey" @keyup.shift="resetCursor"
    />
</template>

<script setup>
import OpenSeadragon from 'openseadragon';
import * as Annotorious from '@recogito/annotorious-openseadragon';
import '@recogito/annotorious-openseadragon/dist/annotorious.min.css';
import {onMounted, ref, watch} from "vue";

const annoViewer = ref(null)
let anno = null

const props = defineProps({
    viewerId: String,
    imgUrl: String,
    drawingTool: String,
    isAnnoVisible: Boolean
})

onMounted(() => {
    const viewer = OpenSeadragon({
        id: props.viewerId,
        prefixUrl: 'https://cdn.jsdelivr.net/npm/openseadragon@4.1/build/openseadragon/images/',
        tileSources: {
            type: "image",
            url: props.imgUrl
        }
    });
    const config = {}; // Optional plugin config options
    anno = Annotorious(viewer, config);
    anno.setDrawingTool(props.drawingTool)
    anno.setVisible(props.isAnnoVisible)
})

watch(() => props.drawingTool, (newVal) => {
    anno.setDrawingTool(newVal)
})
watch(() => props.isAnnoVisible, (newVal) => {
    anno.setVisible(newVal)
})

function handleMouseMove(event) {
    if (event.shiftKey) {
        annoViewer.value.style.cursor = 'crosshair';
    } else {
        annoViewer.value.style.cursor = 'grab';
    }
}

function handleShiftKey() {
    annoViewer.value.style.cursor = 'crosshair';
}

function resetCursor() {
    annoViewer.value.style.cursor = 'grab';
}

</script>

<style scoped>
.openseadragon-viewer {
}
</style>
