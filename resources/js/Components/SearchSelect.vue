<template>
    <div>
        <input type="text" v-model="searchTerm" @input="search" placeholder="Search..." />
        <ul v-if="results.length">
            <li v-for="result in results" :key="result.id" @click="select(result)"
                class="cursor-pointer hover:bg-gray-200">
                {{ result.name }}
            </li>
        </ul>
        <p v-if="!results.length && searchTerm">No results found.</p>
    </div>
</template>

<script>
import { ref, watch } from 'vue'
import { router } from '@inertiajs/vue3'


export default {
    props: {
        selected: Object,
    },
    setup(props, { emit }) {
        const searchTerm = ref('')
        const results = ref([])

        const search = () => {
            if (searchTerm.value.length < 3) return // Minimum characters to search

            router.get(route('order.create.search'), { query: searchTerm.value }, { preserveState: true })
                .then(response => {
                    results.value = response.data
                })
                .catch(error => console.error(error))
        }

        const select = (item) => {
            emit('update:selected', item)
            results.value = []
            searchTerm.value = item.name
        }

        return { searchTerm, results, search, select }
    },
}
</script>
