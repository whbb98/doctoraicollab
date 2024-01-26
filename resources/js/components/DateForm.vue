<template>
    <v-text-field prepend-icon="mdi-calendar-clock-outline"
                  readonly
                  label="Period Date"
                  name="meetingDateTime"
                  v-model="selectedDateTime">
        <v-dialog v-model="dialogDateForm" activator="parent">
            <v-container class="w-auto">
                <v-card width="fit-content" class="overflow-y-auto" max-height="90vh">
                    <v-card-text>
                        <v-date-picker v-model="selectedDate"></v-date-picker>
                        <v-text-field v-model="selectedTime" type="time"/>
                    </v-card-text>
                    <v-card-actions class="text-capitalize">
                        <v-btn color="primary" variant="outlined"
                               @click="getPickedDateTime">
                            Ok
                        </v-btn>
                        <v-btn color="warning" variant="outlined"
                               @click="clearDateTime">Clear
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-container>
        </v-dialog>
    </v-text-field>
</template>

<script setup>
import {ref} from "vue";

const selectedDate = ref(null)
const selectedTime = ref(null)
const selectedDateTime = ref(null)
const dialogDateForm = ref(false)

function getPickedDateTime() {
    if (selectedDate.value && selectedTime.value) {
        dialogDateForm.value = false
    } else {
        return
    }
    const datetime = new Date(selectedDate.value?.toISOString())
    const [hours, minutes] = selectedTime.value?.split(':')
    datetime.setHours(parseInt(hours))
    datetime.setMinutes(parseInt(minutes))
    selectedDateTime.value = datetime
}

function clearDateTime() {
    dialogDateForm.value = false
    selectedTime.value = null
    selectedDate.value = null
    selectedDateTime.value = null
}
</script>

<style scoped>

</style>
