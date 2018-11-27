<template>
    <div class="bg-white">
        <div class="flex flex-wrap"
            v-if="filledItems.length > 0">
          <div
            class="w-full flex flex-wrap"
            @dblclick="$emit('remove', item.id)"
            :class="{
                'bg-grey-light': key % 2 == 1
            }"
            v-for="(item, key) in filledItems">
                <div class="w-1/2 p-4 text-right">
                    {{ item.id }}
                </div>
                <div class="w-1/2 p-4 text-left flex items-center">
                    <p>{{ item.computedPosition }}</p>
                    <p class="text-grey-dark text-sm ml-4">{{ relativeTime(item.created_at) }}</p>
                </div>
            </div>
        </div>
        <div v-else class="text-center pb-4">
            <empty-icon class="max-w-full h-32"/>
            <p class="text-center text-grey-dark text-xl">No entries found</p>
        </div>
    </div>
</template>
<script>
    export default {
        props: {
            items: {
                required: true,
                type: Array
            },
            columns: {
                required: true,
                type: Number
            },
            rows: {
                required: true,
                type: Number
            }
        },
        computed: {
            filledItems() {
                return this.items.filter(item => item.id);
            }
        },
        methods: {
            relativeTime(timestamp) {
                return moment.tz(timestamp, "UTC").fromNow()
            }
        }
    }
</script>
