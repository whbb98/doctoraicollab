<template>
    <v-overlay :model-value="isBlogLoading" class="align-center justify-center">
        <p class="text-white text-capitalize">loading blog data...</p>
        <v-progress-linear
            height="5"
            rounded
            color="primary"
            indeterminate
        />
    </v-overlay>
    <v-card :class="{'d-none':isBlogLoading}">
        <v-card-title class="text-capitalize font-weight-bold text-primary">
            <v-row class="pa-4">
                {{ blog.title }}
                <v-spacer/>
                <v-btn rounded
                       color="primary"
                       @click="$router.back()"
                >
                    <v-icon>mdi-arrow-left</v-icon>
                    back
                </v-btn>
            </v-row>
        </v-card-title>
        <v-card-text>
            <span class="mr-5 text-capitalize">
                <v-icon>mdi-account</v-icon>
                {{ blog?.author?.firstName + ' ' + blog?.author?.lastName }}
            </span>
            <span>
                <v-icon>mdi-calendar</v-icon>
                {{ blog.created_on }}
            </span>
        </v-card-text>
        <v-container class="border">
            <v-row class="blog">
                <v-col class="h-100 overflow-y-auto" cols="2" md="3" xl="2">
                    <v-list v-model="selectedParticipant">
                        <v-list-item
                            class="rounded-xl"
                            v-for="p in blog.participants"
                            :key="p.username"
                            :value="p.username"
                            color="primary"
                            @click="chooseP(p)"
                            :active="selectedParticipant === p.username"
                        >
                            <template #prepend>
                                <v-avatar class="mr-2" color="secondary" size="50" :image="p.avatar">
                                    <span class="text-h5 text-uppercase">{{ p.abbreviatedName }}</span>
                                </v-avatar>
                            </template>
                            <div class="d-none d-md-block">
                                <v-list-item-title
                                    class="text-capitalize"
                                    :class="activeClasses(p)"
                                >
                                    {{ p.firstName + ' ' + p.lastName }}
                                </v-list-item-title>
                                <v-list-item-subtitle :class="activeClasses(p)">
                                    {{ p.username }}
                                </v-list-item-subtitle>
                            </div>
                            <v-tooltip class="d-lg-none" activator="parent" location="right">
                                <span class="text-capitalize">{{ p.firstName + ' ' + p.lastName }}</span>
                            </v-tooltip>
                        </v-list-item>
                    </v-list>
                </v-col>
                <v-col style="height: 500px" cols="10" md="9" xl="10">
                    <anno-viewer v-if="currentImage"
                                 viewer-id="annoViewer"
                                 :blogID="blog.id"
                                 :image="currentImage"
                                 :user="selectedParticipantObj"
                                 :drawingTool="drawingTool"
                                 :isAnnoVisible="isAnnoVisible"
                                 @create-annotation="updateImageAnnotationsHandler"
                                 @delete-annotation="updateImageAnnotationsHandler"
                                 @update-annotation="updateImageAnnotationsHandler"
                    />
                </v-col>
                <v-col cols="12">
                    <v-row justify="center">
                        <v-col md="4" lg="3" xl="2"
                               class="d-flex align-center justify-space-around justify-md-space-between">
                            <v-btn @click="currentImageIdx--" variant="outlined" rounded color="primary">
                                <v-icon>mdi-arrow-left</v-icon>
                                <v-tooltip activator="parent" location="top">
                                    go back
                                </v-tooltip>
                            </v-btn>
                            <v-chip variant="elevated" color="primary">
                                {{ currentImageIdx + 1 }} / {{ blogImagesCount }}
                            </v-chip>
                            <v-btn @click="currentImageIdx++" variant="outlined" rounded color="primary">
                                <v-icon>mdi-arrow-right</v-icon>
                                <v-tooltip activator="parent" location="top">
                                    go next
                                </v-tooltip>
                            </v-btn>
                        </v-col>
                        <v-col md="4" lg="3" xl="2"
                               class="d-flex align-center justify-space-around justify-md-space-between">
                            <v-btn color="primary"
                                   @click="drawingTool = 'rect'"
                                   :active="drawingTool === 'rect'"
                                   :variant="drawingTool==='rect'?'elevated':'outlined'"
                            >
                                <v-icon>mdi-vector-rectangle</v-icon>
                                <v-tooltip activator="parent" location="top">
                                    Rectangle Shape
                                </v-tooltip>
                            </v-btn>
                            <v-btn color="primary"
                                   @click="drawingTool = 'polygon'"
                                   :active="drawingTool === 'polygon'"
                                   :variant="drawingTool==='polygon'?'elevated':'outlined'"
                            >
                                <v-icon>mdi-shape-polygon-plus</v-icon>
                                <v-tooltip activator="parent" location="top">
                                    Polygon Shape
                                </v-tooltip>
                            </v-btn>
                            <v-btn :active="!isAnnoVisible"
                                   @click="isAnnoVisible=!isAnnoVisible"
                                   :variant="isAnnoVisible?'outlined':'elevated'"
                                   color="primary">
                                <v-icon v-if="isAnnoVisible">mdi-eye</v-icon>
                                <v-icon v-else>mdi-eye-off</v-icon>
                                <v-tooltip activator="parent" location="top">
                                    {{ isAnnoVisible ? 'Hide' : 'Unhide' }} Annotations
                                </v-tooltip>
                            </v-btn>
                        </v-col>
                        <v-col cols="12">
                            <v-alert
                                closable
                                icon="mdi-draw"
                                title="To start drawing !"
                                type="info"
                                border="start"
                                border-color="primary"
                                color="secondary"
                            >
                                <template #text>
                                    <ul class="mt-4">
                                        <li class="mb-1">
                                            Press the <b>shift-key</b>
                                            <v-icon>mdi-apple-keyboard-shift</v-icon>
                                            then <b>left click</b> using your mouse
                                            <v-icon>mdi-mouse</v-icon>
                                        </li>
                                        <li>
                                            For polygon drawing
                                            <v-icon>mdi-vector-polygon</v-icon>
                                            <b>double click</b> mouse left to finish your drawing
                                        </li>
                                    </ul>
                                </template>
                            </v-alert>
                        </v-col>
                    </v-row>
                </v-col>
            </v-row>
        </v-container>
        <v-card-text>
            <v-card-title class="text-capitalize text-primary">
                description
            </v-card-title>
            <v-card-text>
                <p>{{ blog.description }}</p>
            </v-card-text>
        </v-card-text>
        <v-card-text>
            <v-expansion-panels>
                <v-expansion-panel>
                    <v-expansion-panel-title
                        collapse-icon="mdi-minus"
                        expand-icon="mdi-plus"
                        class="text-capitalize text-primary font-weight-bold">
                        <span class="d-flex align-end"><v-icon>mdi-robot</v-icon>&nbsp;AI predictions</span>
                    </v-expansion-panel-title>
                    <v-expansion-panel-text>
                        <!--                        <v-progress-linear indeterminate rounded color="primary"/>-->
                        <v-alert
                            v-if="AIModelsData.accuracy < 50"
                            title="Model Accuracy"
                            :text="`Accuracy of the AI model is: ${AIModelsData.accuracy}%`"
                            type="warning"
                            closable
                        />
                        <v-select prepend-icon="mdi-robot"
                                  label="Choose Prediction Model"
                                  :items="Object.keys(AIModelsData)"
                                  v-model="selectedAIModel"
                                  :loading="isPredictionsLoading"
                        />
                        <v-table hover>
                            <thead>
                            <tr class="text-capitalize bg-secondary">
                                <th class="font-weight-bold w-25">disease class</th>
                                <th class="font-weight-bold">ratio %</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(item,key) in AIPredictions">
                                <td>{{ key }}</td>
                                <td>
                                    <v-progress-linear
                                        :model-value="item"
                                        color="primary"
                                        height="15"
                                        rounded
                                    >
                                        <template #default="{value}">
                                            <strong>{{ Math.ceil(value) }}%</strong>
                                        </template>
                                    </v-progress-linear>
                                </td>
                            </tr>
                            </tbody>
                        </v-table>
                    </v-expansion-panel-text>
                </v-expansion-panel>
            </v-expansion-panels>
            <!--      feedback votes      -->
            <v-expansion-panels class="mt-5">
                <v-expansion-panel>
                    <v-expansion-panel-title
                        collapse-icon="mdi-minus"
                        expand-icon="mdi-plus"
                        class="text-capitalize text-primary font-weight-bold">
                        <span class="d-flex align-end"><v-icon>mdi-poll</v-icon>&nbsp;doctors feedback</span>
                    </v-expansion-panel-title>
                    <v-expansion-panel-text>
                        <v-row>
                            <v-col v-if="blog?.author.id === authStore.getUser?.id" cols="12"
                                   class="d-flex align-center justify-space-between">
                                <span class="text-capitalize font-weight-bold text-primary">
                                    update feedback
                                </span>
                                <v-btn class="text-capitalize" color="primary" rounded>
                                    <v-icon>mdi-square-edit-outline</v-icon>
                                    update
                                    <blog-feedback-form
                                        @update-feedback="updateFeedbackHandler"
                                    />
                                </v-btn>
                            </v-col>
                            <v-col cols="12" class="mt-5">
                                <v-row class="feedback-header text-capitalize font-weight-bold bg-secondary rounded">
                                    <v-col cols="2">ICD class</v-col>
                                    <v-col>description</v-col>
                                    <v-col>votes %</v-col>
                                </v-row>
                                <v-row
                                    v-for="item in feedbackLabels"
                                    class="vote-row text-capitalize d-flex align-center rounded"
                                    :class="isVoted === item.id? 'bg-dark':''"
                                    v-model="isVoted"
                                    @click="isVoted = item.id"
                                >
                                    <v-col cols="2">{{ item.id }}</v-col>
                                    <v-col>
                                        <p>
                                            {{ item.description }}
                                        </p>
                                    </v-col>
                                    <v-col>
                                        <v-progress-linear
                                            :model-value="voteRatio(item.id)"
                                            color="primary"
                                            height="15"
                                            rounded
                                        >
                                            <template #default="{value}">
                                                <strong>{{ value }}%</strong>
                                            </template>
                                        </v-progress-linear>
                                    </v-col>
                                </v-row>
                            </v-col>
                            <v-col>
                                <v-btn class="text-capitalize mr-5"
                                       color="primary"
                                       rounded
                                       @click="saveVote"
                                >
                                    <v-icon>mdi-content-save</v-icon>
                                    vote
                                </v-btn>
                                <!--                                <v-btn class="text-capitalize"-->
                                <!--                                       color="warning"-->
                                <!--                                       rounded-->
                                <!--                                       variant="outlined"-->
                                <!--                                       @click="clearVote"-->
                                <!--                                >-->
                                <!--                                    <v-icon>mdi-cancel</v-icon>-->
                                <!--                                    unvote-->
                                <!--                                </v-btn>-->
                            </v-col>
                        </v-row>
                    </v-expansion-panel-text>
                </v-expansion-panel>
            </v-expansion-panels>
        </v-card-text>
        <v-card-text>
            <v-card-title class="text-capitalize text-primary">comments</v-card-title>
            <v-container>
                <v-row>
                    <v-col cols="12">
                        <v-form @submit.prevent="commentNow" class="text-capitalize">
                            <v-text-field
                                name="comment"
                                label="leave a comment"
                                v-model="comment"
                                clearable
                                @click:clear="clearComment"
                            />
                            <v-btn type="submit" color="primary" rounded>
                                comment
                            </v-btn>
                        </v-form>
                    </v-col>
                    <v-col cols="12">
                        <v-row class="comments">
                            <v-col cols="12">
                                <user-comment-card
                                    v-for="comment in blogComments"
                                    :comment="comment"
                                    @update-comment="updateComment"
                                    @delete-comment="deleteComment"
                                />
                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>
            </v-container>
        </v-card-text>
    </v-card>
</template>

<script setup>
import {useRoute} from "vue-router";
import {computed, inject, onBeforeMount, onMounted, reactive, ref, watch} from "vue";
import AnnoViewer from "@/components/AnnoViewer.vue";
import BlogFeedbackForm from "@/components/BlogFeedbackForm.vue";
import UserCommentCard from "@/components/UserCommentCard.vue";
import {useBlogsStore} from "@/stores/blogsStore.js";
import router from "@/router.js";
import {useAuthStore} from "@/stores/authStore.js";
import {useNotificationsStore} from "@/stores/notificationsStore.js";

const isBlogLoading = ref(false)
const blogsStore = useBlogsStore()
const authStore = useAuthStore()
const route = useRoute()
const ENV = inject('ENV')
const blog = ref({})
const currentImageIdx = ref(0)
let blogImagesCount = 0
const currentImage = ref(null)
const selectedParticipant = ref(null)
const selectedParticipantObj = ref(null)
const isAnnoVisible = ref(true)
const drawingTool = ref('rect')
const activeClasses = (p) => {
    return p.username === selectedParticipant.value ? 'font-weight-bold' : ''
}
onBeforeMount(async () => {
    isBlogLoading.value = true
    const data = await blogsStore.fetchBlogData(ENV.APP_API_URL, route.params.blogID)
    if (data === false) {
        router.push('/blogs')
        return
    }
    blog.value = data
    isBlogLoading.value = false
    initBlog()
    await fetchAIModelsInfo()
})

async function initBlog() {
    selectedParticipant.value = blog.value.participants[0].username
    selectedParticipantObj.value = blog.value.participants[0]
    currentImage.value = blog.value.images[currentImageIdx.value]
    blogImagesCount = blog.value.images.length
    blogComments.value = await blogsStore.fetchComments(ENV.APP_API_URL, route.params.blogID)
    await refreshFeedback()
}

watch(currentImageIdx, async (value, oldValue) => {
    if (value < 0 || value >= blogImagesCount) {
        currentImageIdx.value = oldValue
        return
    }
    currentImage.value = blog.value.images[currentImageIdx.value]
    await fetchAIPredictions()
})

function chooseP(p) {
    selectedParticipant.value = p.username
    selectedParticipantObj.value = p
}

async function updateImageAnnotationsHandler(annotation) {
    await blogsStore.storeAnnotation(ENV.APP_API_URL, blog.value.id, currentImage.value.id, annotation)
}

const blogComments = ref([])
const comment = ref(null)
const selectedCommentID = ref(null)

async function commentNow() {
    const status = await blogsStore.storeComment(ENV.APP_API_URL, route.params.blogID, selectedCommentID.value, comment.value)
    if (status) {
        blogComments.value = await blogsStore.fetchComments(ENV.APP_API_URL, route.params.blogID)
        selectedCommentID.value = null
        comment.value = null
    }
}

async function updateComment(id, text) {
    selectedCommentID.value = id
    comment.value = text
}

async function deleteComment(id) {
    const status = await blogsStore.deleteComment(ENV.APP_API_URL, route.params.blogID, id)
    if (status) {
        blogComments.value = await blogsStore.fetchComments(ENV.APP_API_URL, route.params.blogID)
    }
}

function clearComment() {
    selectedCommentID.value = null
    comment.value = null
}

const feedbackLabels = ref([])
const feedbackVotes = ref([])

async function refreshFeedback() {
    const data = await blogsStore.fetchBlogFeedback(ENV.APP_API_URL, route.params.blogID)
    if (data) {
        feedbackLabels.value = JSON.parse(data.labels)
        feedbackVotes.value = await blogsStore.getFeedbackVotes(ENV.APP_API_URL, route.params.blogID)
        isVoted.value = feedbackVotes.value.find(item => item.voted_by === authStore.getUser.id).answer
    }
}

async function updateFeedbackHandler(data) {
    const status = await blogsStore.storeBlogFeedback(ENV.APP_API_URL, route.params.blogID, data)
    if (status) {
        await refreshFeedback()
    }
}

function voteRatio(id) {
    const votesPerID = feedbackVotes.value.filter(item => item.answer === id).length
    // const totalChoises = feedbackLabels.value.length
    const totalChoises = feedbackVotes.value.length
    return Math.floor((votesPerID / totalChoises) * 100)
}

const isVoted = ref(null)

async function saveVote() {
    if (isVoted.value) {
        await blogsStore.storeFeedbackVote(ENV.APP_API_URL, route.params.blogID, isVoted.value)
        await refreshFeedback()
    } else {
        const notificationsStore = useNotificationsStore()
        notificationsStore.setPopupNotification({
            open: true,
            type: 'error',
            title: 'Feedback vote!',
            message: 'please choose a label!'
        })
    }
}

const AIModelsData = ref({})
const AIPredictions = ref({})
const selectedAIModel = ref(null)
const isPredictionsLoading = ref(false)

async function fetchAIModelsInfo() {
    isPredictionsLoading.value = true
    AIModelsData.value = await blogsStore.fetchAIModelsInfo(ENV.AI_API_URL)
    isPredictionsLoading.value = false
}

async function fetchAIPredictions() {
    const data = await blogsStore.fetchAIPredictions(
        ENV.AI_API_URL,
        AIModelsData.value[selectedAIModel.value].predict,
        currentImage.value.base64)
    if (data) {
        AIPredictions.value = data
    } else {
        AIPredictions.value = {}
    }
}

watch(selectedAIModel, async (selectedModel) => {
    await fetchAIPredictions()
})
</script>

<style scoped>
.vote-row {
    cursor: pointer;
}

.vote-row:hover {
    background-color: #ccc;
}

.comments {
    max-height: 50vh;
    overflow-y: auto;
}
</style>
