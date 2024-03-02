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
import {inject, onMounted, ref, watch} from "vue";
import {useRoute} from "vue-router";
import {useBlogsStore} from "@/stores/blogsStore.js";
import {useAuthStore} from "@/stores/authStore.js";

const emit = defineEmits(['createAnnotation', 'deleteAnnotation', 'updateAnnotation'])
const props = defineProps({
    viewerId: String,
    image: Object,
    user: Object,
    drawingTool: String,
    isAnnoVisible: Boolean,
    blogID: Number
})
const annoViewer = ref(null)
let anno = null
let viewer = null
const blogsStore = useBlogsStore()
const ENV = inject('ENV')
onMounted(() => {
    viewer = OpenSeadragon({
        id: props.viewerId,
        prefixUrl: 'https://cdn.jsdelivr.net/npm/openseadragon@4.1/build/openseadragon/images/',
        tileSources: {
            type: "image",
            url: props.image.base64
        }
    });
    const config = {}; // Optional plugin config options
    anno = Annotorious(viewer, config);
    anno.setDrawingTool(props.drawingTool)
    anno.setVisible(props.isAnnoVisible)
    anno.on('createAnnotation', function (annotation, overrideId) {
        emit('createAnnotation', anno.getAnnotations())
    });
    anno.on('deleteAnnotation', function (annotation) {
        emit('deleteAnnotation', anno.getAnnotations())
    });
    anno.on('updateAnnotation', function (annotation, previous) {
        emit('updateAnnotation', anno.getAnnotations())
    });
    initAnnotations()
})

watch(() => props.drawingTool, (newVal) => {
    anno.setDrawingTool(newVal)
})
watch(() => props.isAnnoVisible, (newVal) => {
    anno.setVisible(newVal)
})
watch(() => props.image, (newVal) => {
    viewer.open({
        type: 'image',
        url: newVal.base64
    })
    initAnnotations()
})
watch(() => props.user, (newVal) => {
    initAnnotations()
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

async function initAnnotations() {
    anno.setAnnotations(null)
    const data = await blogsStore.getAnnotations(ENV.APP_API_URL, props.blogID, props.user.id, props.image.id)
    anno.setAnnotations(data)
    anno.readOnly = !(props.user.username === useAuthStore().getUser.username)
}
</script>

<style scoped>
.openseadragon-viewer {
}
</style>
