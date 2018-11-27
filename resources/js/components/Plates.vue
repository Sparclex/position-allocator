<template>
    <div>
        <portal to="buttons">
            <div class="flex">
                <router-link
                    :to="{name: 'overview-page', params: {view: 'table', plate}}"
                    class="no-underline text-black block p-1 focus:outline-none rounded flex items-center justify-center mr-1 flex-1"
                    :class="{
                        'bg-orange text-white': view == 'table',
                        'bg-orange-lightest text-black': view != 'table'
                    }">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                </router-link>
                <router-link
                :to="{name: 'overview-page', params: {view: 'list', plate}}"
                class="no-underline text-black p-1 focus:outline-none rounded flex items-center justify-center flex-1 mr-1"
                :class="{
                    'bg-orange text-white': view == 'list',
                    'bg-orange-lightest text-black': view != 'list'
                }">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3" y2="6"></line><line x1="3" y1="12" x2="3" y2="12"></line><line x1="3" y1="18" x2="3" y2="18"></line></svg>
                </router-link>
                <button @click.prevent="requestDelete"
                    class="appearance-none no-underline p-1 focus:outline-none rounded flex items-center justify-center text-red border border-red">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                </button>
            </div>
        </portal>
        <div class="relative">
            <component
                :is="viewComponent"
                :items="items"
                :columns="columns"
                :rows="rows"
                @remove="remove"
                v-if="!isLoading || items.length"/>
                <div v-if="isLoading" class="py-10 flex items-center justify-center"
                    :class="{
                        'absolute w-full h-full bg-transparent-black pin-t': items.length > 0,
                        'bg-white': items.length == 0
                    }"
                    >
                    <loader />
                </div>
        </div>
    </div>
</template>
<script>
    export default {
        props: ['plate', 'view'],
        data() {
            return {
                isLoading: true,
                items: [],
                columns: 0,
                rows: 0
            }
        },
        computed: {
            viewComponent() {
                return this.view == 'list' ? 'PlateListView' : 'PlateTableView';
            }
        },
        methods: {
            async fetchPlate() {
                this.isLoading = true;
                let {data: samples} = await axios.get(`/api/samples?page=${this.plate}`);
                this.items = samples.data;
                this.columns = samples.columns;
                this.rows = samples.rows;
                this.isLoading = false;
            },
            remove(sampleId) {
                if(!sampleId) return;
                axios.delete(`/api/samples/${sampleId}`)
                .catch(() => {})
                .then(() => this.fetchPlate())
            },
            requestDelete() {
                if(confirm("Are you sure you want to delete all entries?")) {
                    axios.delete('/api/samples/all')
                    .catch(() => {})
                    .then(() => this.fetchPlate());
                }
            }
        },
        watch: {
            plate: function (newQuestion) {
                this.fetchPlate();
            }
        },
        mounted() {
            this.fetchPlate();
        }
    }
</script>
