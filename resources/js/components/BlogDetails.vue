<template>
    <v-card>
        <v-card-title class="text-capitalize font-weight-bold text-primary">
            <v-row class="pa-4">
                this is blog title: {{ route.fullPath }}
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
            <span class="mr-5">
                <v-icon>mdi-account</v-icon>
                John Doe
            </span>
            <span>
                <v-icon>mdi-calendar</v-icon>
                2021 Jan 12 14:32
            </span>
        </v-card-text>
        <v-container class="border">
            <v-row class="blog">
                <v-col class="h-100 overflow-y-auto" cols="2" md="3" xl="2">
                    <v-list v-model="selectedP">
                        <v-list-item
                            class="rounded-xl"
                            v-for="p in participants"
                            :key="p.username"
                            :value="p.username"
                            color="primary"
                            @click="chooseP(p)"
                            :active="selectedP === p.username"
                        >
                            <template #prepend>
                                <v-avatar class="mr-2" color="secondary" size="50" :image="p.avatar">
                                    <span class="text-h5 text-uppercase">{{ p.nameAbbr }}</span>
                                </v-avatar>
                            </template>
                            <div class="d-none d-md-block">
                                <v-list-item-title
                                    class="text-capitalize"
                                    :class="activeClasses(p)"
                                >
                                    {{ p.name }}
                                </v-list-item-title>
                                <v-list-item-subtitle :class="activeClasses(p)">
                                    {{ p.username }}
                                </v-list-item-subtitle>
                            </div>
                            <v-tooltip class="d-lg-none" activator="parent" location="right">
                                <span class="text-capitalize">{{ p.name }}</span>
                            </v-tooltip>
                        </v-list-item>
                    </v-list>
                </v-col>
                <v-col style="height: 500px" cols="10" md="9" xl="10">
                    <anno-viewer viewer-id="annoViewer"
                                 :img-url="xrayImg"
                                 :drawingTool="drawingTool"
                                 :isAnnoVisible="isAnnoVisible"
                    />
                </v-col>
                <v-col cols="12">
                    <v-row justify="center">
                        <v-col md="4" lg="3" xl="2"
                               class="d-flex align-center justify-space-around justify-md-space-between">
                            <v-btn variant="outlined" rounded color="primary">
                                <v-icon>mdi-arrow-left</v-icon>
                                <v-tooltip activator="parent" location="top">
                                    go back
                                </v-tooltip>
                            </v-btn>
                            <v-chip variant="elevated" color="primary">
                                {{ 1 }}
                            </v-chip>
                            <v-btn variant="outlined" rounded color="primary">
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
                <p>
                    Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut
                    labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores
                    et
                    ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem
                    ipsum
                    dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et
                    dolore
                    magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum.
                    Stet
                    clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit
                    amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna
                    aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet
                    clita
                    kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.

                    Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum
                    dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit
                    praesent
                    luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Lorem ipsum dolor sit amet,
                    consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna
                    aliquam
                    erat volutpat.
                </p>
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
                            v-if="AIModelResponse.accuracy < 60"
                            title="Model Accuracy"
                            :text="`Accuracy of the AI model is: ${AIModelResponse.accuracy}%`"
                            type="warning"
                            closable
                        />
                        <v-table hover>
                            <thead>
                            <tr class="text-capitalize bg-secondary">
                                <th class="font-weight-bold w-25">disease class</th>
                                <th class="font-weight-bold">ratio %</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(item,key) in AIModelResponse.predictions">
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
                            <v-col cols="12" class="d-flex align-center justify-space-between">
                                <span class="text-capitalize font-weight-bold text-primary">
                                    update feedback
                                </span>
                                <v-btn class="text-capitalize" color="primary" rounded>
                                    <v-icon>mdi-square-edit-outline</v-icon>
                                    update
                                    <blog-feedback-form
                                        @update-feedback="data => feedbackData = data"
                                    />
                                </v-btn>
                            </v-col>
                            <v-col cols="12">
                                <v-row class="feedback-header text-capitalize font-weight-bold bg-secondary rounded">
                                    <v-col cols="2">ICD class</v-col>
                                    <v-col>description</v-col>
                                    <v-col>votes %</v-col>
                                </v-row>
                                <v-row
                                    v-for="item in feedbackData"
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
                                                <strong>{{ Math.ceil(value) }}%</strong>
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
                                <v-btn class="text-capitalize"
                                       color="warning"
                                       rounded
                                       variant="outlined"
                                       @click="clearVote"
                                >
                                    <v-icon>mdi-cancel</v-icon>
                                    unvote
                                </v-btn>
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
                                    v-for="item in userComments"
                                    :comment="item"
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
import {computed, ref, watch} from "vue";
import AnnoViewer from "@/components/AnnoViewer.vue";
import BlogFeedbackForm from "@/components/BlogFeedbackForm.vue";
import UserCommentCard from "@/components/UserCommentCard.vue";

const xrayImg = 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/a1/Normal_posteroanterior_%28PA%29_chest_radiograph_%28X-ray%29.jpg/800px-Normal_posteroanterior_%28PA%29_chest_radiograph_%28X-ray%29.jpg'
const route = useRoute()
const isAnnoVisible = ref(true)
const drawingTool = ref('rect')
const participants = [
    {
        id: 45,
        username: 'ouahab98',
        name: 'abdelouahab radja',
        nameAbbr: 'ar',
        // avatar: 'https://i.pravatar.cc/50'
    },
    {
        id: 1,
        username: 'user01',
        name: 'john doe 1',
        nameAbbr: 'jd',
        avatar: 'https://i.pravatar.cc/50'
    },
    {
        id: 2,
        username: 'user02',
        name: 'john doe 2',
        nameAbbr: 'af',
        avatar: 'https://i.pravatar.cc/50'
    },
    {
        id: 3,
        username: 'user03',
        name: 'john doe 3',
        nameAbbr: 'er',
        avatar: 'https://i.pravatar.cc/50'
    }
]
const selectedP = ref(participants[0].username)
const activeClasses = (p) => {
    return p.username === selectedP.value ? 'font-weight-bold' : ''
}

function chooseP(p) {
    selectedP.value = p.username;
}

watch(selectedP, (newVal, oldValue) => {
    console.log(newVal, oldValue)
})

const AIModelResponse = {
    accuracy: 86,
    predictions: {
        class01: 15.6,
        class02: 24.6,
        class03: 15.6,
        class04: 54,
        class05: 40,
        class06: 33
    }
}
const feedbackData = ref([])
const feedbackVotes = []

function voteRatio(id) {
    return (feedbackVotes.filter(item => item.answer === id).length) / (feedbackData.value.length) * 100
}

const isVoted = ref('D701')
watch(isVoted, newVal => {
    console.log(newVal)
})

function clearVote() {
    isVoted.value = null
}

function saveVote() {
    if (isVoted.value) {
        console.log('you chose: ', isVoted.value)
    } else {
        console.log('plz vote now!')
    }
}

const userComments = ref([
    {
        id: 1,
        username:'ouahab98',
        abbreviatedName: 'AR',
        fullName: 'abdelouahab radja',
        avatar: 'https://i.pravatar.cc/50',
        datetime: new Date().toDateString() + '14:52',
        comment: 'Etiamefficitur electram oporteat dolor tempor definiebas qui posidonium venenatis aliquip dicta dico aliquet persequeris felis. Duoviverra tempor. Anteesse cum populo fringilla nobis populo.',
    },
    {
        id: 2,
        username:'amine31',
        abbreviatedName: 'AS',
        fullName: 'amine smahi',
        avatar: 'https://i.pravatar.cc/50',
        datetime: new Date().toDateString() + '14:52',
        comment: 'Etiamefficitur electram oporteat dolor tempor definiebas qui posidonium venenatis aliquip dicta dico aliquet persequeris felis. Duoviverra tempor. Anteesse cum populo fringilla nobis populo.',
    },
    {
        id: 3,
        username:'osmbonnor',
        abbreviatedName: 'ob',
        fullName: 'oussama bonnor',
        // avatar: 'https://i.pravatar.cc/50',
        datetime: new Date().toDateString() + '14:52',
        comment: 'Etiamefficitur electram oporteat dolor tempor definiebas qui posidonium venenatis aliquip dicta dico aliquet persequeris felis. Duoviverra tempor. Anteesse cum populo fringilla nobis populo.',
    }
])
const comment = ref(null)

function commentNow() {
    userComments.value.push(
        {
            id: 1,
            nameAbbr: 'NW',
            fullName: 'user now',
            avatar: 'https://i.pravatar.cc/50',
            commentDate: new Date().toDateString(),
            commentText: comment.value
        }
    )
}

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
