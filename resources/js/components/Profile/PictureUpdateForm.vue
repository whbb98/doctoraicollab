<template>
    <v-form class="d-flex flex-column flex-sm-row align-center justify-space-between">
        <div style="width: 20%" v-if="photo" class="d-flex justify-center">
            <v-avatar class="mb-2" color="secondary" size="100" :image="imgUrl">
                <span class="text-h5 text-uppercase">{{ profileStore.getAuthUserProfile.abbreviatedName }}</span>
            </v-avatar>
        </div>
        <div style="width: 20%" v-else-if="cover" class="d-flex justify-center">
            <v-img width="150" height="100" :src="imgUrl"/>
        </div>
        <div class="description mb-2 d-flex flex-column justify-center">
            <h3 class="text-primary text-capitalize mb-2">
                <slot name="heading"/>
            </h3>
            <p class="text-dark text-capitalize mb-2">
                <slot name="uploadDescription"/>
            </p>
            <input type="file" @change="renderImage">
        </div>
        <div class="actions d-flex flex-column">
            <v-btn class="mb-2"
                   color="primary"
                   :loading="isLoading"
                   @click="handleUpload">
                upload
            </v-btn>
            <v-btn color="primary"
                   variant="tonal"
                   @click="handleDelete"
            >
                remove
            </v-btn>
        </div>
    </v-form>
</template>

<script setup>
import {inject, ref} from "vue";
import {useProfileStore} from "@/stores/profileStore.js";

const props = defineProps({
    photo: Boolean,
    cover: Boolean
})
const ENV = inject('ENV')
const isLoading = ref(false)
const profileStore = useProfileStore()
const imgUrl = ref(
    props.photo ? profileStore.getAuthUserProfile.avatar : profileStore.getAuthUserProfile.cover
)
const imgFile = ref(null)

function renderImage(ev) {
    imgFile.value = ev.target.files[0]
    if (imgFile) {
        const reader = new FileReader()
        reader.readAsDataURL(imgFile.value)
        reader.onload = () => {
            imgUrl.value = reader.result
        }
    }
}

async function handleUpload() {
    isLoading.value = true
    const uploadData = {}
    if (imgFile) {
        if (props.photo) {
            uploadData.photo = imgFile.value
        } else if (props.cover) {
            uploadData.cover = imgFile.value
        }
        const status = await profileStore.updateProfileData(ENV.APP_API_URL, uploadData)
    }
    isLoading.value = false
}

async function handleDelete() {
    console.log('delete profile images will be implemented soon!')
}
</script>

<style scoped>
.description {
    width: 50%;
}
</style>
