<template>
  <Card class="flex flex-col items-center justify-center">
    <div class="px-3 py-3">
        <canvas @click="onClick" ref="canvas" style="width: 100%"></canvas>
    </div>
  </Card>
</template>

<script setup>
import {onMounted, reactive, ref, watch} from "vue";
import {Chart, registerables} from "chart.js";

const props = defineProps(['card']);

const canvas = ref();

const data = reactive({
    books: [],
    chart: null,
});

onMounted(() => {
    Chart.register(...registerables);

    Nova.request().get('/nova-vendor/popular-books-bar-chart/books').then(response => {
        data.books = response.data;
    });
});

watch(() => data.books, (books) => {
    data.chart = new Chart(canvas.value, {
        type: 'bar',
        data: {
            labels: books.map(book => book.title),
            datasets: [{
                label: '# of Loans',
                data: books.map(book => book.all_loans_count),
                borderWidth: 1
            }]
        },
        options: {
            indexAxis: 'y',
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});

const onClick = (evt) => {
    if (data.chart === null) {
        return;
    }

    const res = data.chart.getElementsAtEventForMode(
        evt,
        'nearest',
        { intersect: true },
        true
    );

    if (res.length === 0) {
        return;
    }

    Nova.visit(`/resources/books/${data.books[res[0].index].id}`);
};
</script>
