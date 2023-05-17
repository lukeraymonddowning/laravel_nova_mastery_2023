<script setup>
import {StarIcon} from "@heroicons/vue/24/outline/index.js";
import {StarIcon as StarIconSolid} from "@heroicons/vue/24/solid/index.js"
import {computed} from "vue";

const props = defineProps({
    modelValue: {
        type: Number,
        required: true,
    },
    readonly: {
        type: Boolean,
        default: false,
    },
    starClassSizing: {
        type: String,
        default: "h-4 w-4",
    },
});

const emptyStars = computed(() => 5 - props.modelValue);

const emit = defineEmits(["update:modelValue"]);

const handleClick = (stars) => {
    if (props.readonly) {
        return;
    }

    emit("update:modelValue", stars);
};
</script>

<template>
    <ul class="relative flex space-x-0.5">
        <li v-for="index in props.modelValue" :key="`filled_${index}`">
            <button @click="() => handleClick(index)" type="button">
                <StarIconSolid class="text-yellow-400" :class="props.starClassSizing"/>
            </button>
        </li>
        <li v-for="index in emptyStars" :key="`empty_${index}`">
            <button @click="() => handleClick(index + props.modelValue)" type="button" class="group" :disabled="props.readonly">
                <StarIcon class="text-yellow-400" :class="props.starClassSizing"/>
            </button>
        </li>
    </ul>
</template>
