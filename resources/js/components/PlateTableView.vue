<template>
    <div class="max-w-full overflow-scroll">
            <table class="plate">
                <tr>
                    <th></th>
                    <th :style="width" v-for="column in columns" v-text="column"></th>
                </tr>
                <tr v-for="row in rows">
                    <th>{{ row | num2char }}</th>
                    <td :style="width" v-for="column in columns" @dblclick="$emit('remove', items[column - 1 + ((row - 1) * columns)].id)">
                        {{ items[column - 1 + ((row - 1) * columns)].id }}
                    </td>
                </tr>
            </table>
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
            width() {
                return {
                    width: 'calc(100% / ' + this.columns + ")"
                }
            }
        }
    }
</script>
