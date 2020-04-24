<template>
    <div v-cloak>

        <!-- <details>
            <summary class="text-danger">Datatable-Info</summary>
            <div>
                <table>
                    <tr><td>items</td><td><details open="open"><summary>JSON</summary><pre class="text-info">{{dtItems}}</pre></details></td></tr>
                    <tr><td>columns</td><td><details open="open"><summary>JSON</summary><pre class="text-info">{{dtColumns}}</pre></details></td></tr>
                    <tr><td>options</td><td><details open="open"><summary>JSON</summary><pre class="text-info">{{dtOptions}}</pre></details></td></tr>
                </table>
            </div>
        </details> -->


        <table v-bind="dtOptions.dom_table_attributes">
            <thead v-bind="dtOptions.dom_table_thead_attributes">
                <tr>
                    <template v-for="(col, col_i) in dtColumns">
                        <th :key="col_i" v-if="col.enable_html" v-html="col.text" v-bind="col.attributes"></th>
                        <th :key="col_i" v-else v-bind="col.attributes">{{ col.text }}</th>
                    </template>
                </tr>
            </thead>
            <draggable tag="tbody"
                v-model="dtItems"
                :disabled="!dtOptions.draggable"
                v-bind="{...dtOptions.dom_table_tbody_attributes, ...dtOptions.draggable_attributes}"
                @start="dtOptions.draggable_start(...arguments, dtItems[arguments[0].oldIndex][dtOptions.key].text, dtItems)"
                @end="dtOptions.draggable_end(...arguments, dtItems[arguments[0].newIndex][dtOptions.key].text, dtItems)"
            >
                <template v-for="(row, row_i) in dtItems">
                    <tr :key="row_i">
                        <template v-for="(col, col_i) in dtColumns">
                            <td :key="col_i"
                                v-if="_.get(row, '['+col.name+'].enable_html', false)"
                                v-html="_.get(row, '['+col.name+'].text', '')"
                                v-bind="_.get(row, '['+col.name+'].attributes', [])"
                            >
                            </td>
                            <td :key="col_i"
                                v-else
                                v-bind="_.get(row, '['+col.name+'].attributes', [])"
                            >{{ _.get(row, '['+col.name+'].text', '') }}</td>
                        </template>
                    </tr>
                </template>
            </draggable>
        </table>

    </div>
</template>


<script>
export default {
    props: ['items', 'columns', 'options'],
    components: {
        draggable,

    },
    data: function(){
        return {
            dt_items: this.items,
            dt_columns: this.columns,
            dt_options: this.options,
        }
    },
    computed: {
        dtItems: {
            get: function() {
                //{idx:2, name:{text:'"Bobby"', value:'Bob'}, category:'Das'}
                for (let row_i in this.dt_items) {
                    let row = this.dt_items[row_i];
                    for (let col_i in row) {
                        let col = this.dt_items[row_i][col_i];

                        let column = {};
                        column.attributes = _.get(col, 'attributes') || {};
                        column.enable_html = !!_.get(col, 'enable_html');

                        if ( typeof col === 'object' ) {
                            column.text = col.text || '';
                            column.value = col.value || col.text;
                        }
                        else if ( typeof col === 'string' ) {
                            column.text = col;
                            column.value = col;
                        }
                        else if ( typeof col === 'number' ) {
                            column.text = col;
                            column.value = col;
                        }
                        this.dt_items[row_i][col_i] = column;
                    }
                }

                return this.dt_items;
            },
            set: function(newValue) {
                this.dt_items = newValue;
            }
        },
        dtColumns: function() {
            for (let col_i in this.dt_columns) {
                let col = this.dt_columns[col_i];
                let column = {};
                column.attributes = _.get(col, 'attributes') || {};
                column.enable_html = !!_.get(col, 'enable_html');
                if ( typeof col === 'string' ) {
                    column.name = col;
                    column.text = col;
                }
                else if ( typeof col === 'object' ) {
                    column.name = col.name;
                    column.text = col.text || '';
                }
                this.dt_columns[col_i] = column;
            }
            return this.dt_columns;
        },
        dtOptions: function() {
            this.dt_options.key = this.dt_options.key || 'id';
            this.dt_options.order = this.dt_options.order || ['id'];
            this.dt_options.draggable = !!this.dt_options.draggable;
            this.dt_options.draggable_start = this.dt_options.draggable_start || function(event, key, items){};
            this.dt_options.draggable_end = this.dt_options.draggable_end || function(event, key, items){};
            this.dt_options.draggable_attributes = this.dt_options.draggable_attributes || {}; // {handle:'.handle'}
            this.dt_options.dom_table_attributes = this.dt_options.dom_table_attributes || {};
            this.dt_options.dom_table_thead_attributes = this.dt_options.dom_table_thead_attributes || {};
            this.dt_options.dom_table_tbody_attributes = this.dt_options.dom_table_tbody_attributes || {};
            return this.dt_options;
        }
    },
    mounted() {

        // TODO: draggable entfernen und nur sortable verwenden?
        /* eslint-disable no-new */
        /* new Sortable(
            this.$refs.sortableTable.$el.getElementsByTagName('tbody')[0],
            {
            draggable: '.sortableRow',
            handle: '.sortHandle',
            onEnd: this.dragReorder
            }
        ) */


        this.order();
    },
    methods: {
        order: function() {
            let items = this.dt_items;
            items.sort((a, b) => {
                var isNumber = function(n) { return !isNaN(parseFloat(n)) && isFinite(n); };
                let order_keys = this.dt_options.order_by;//['order','id'];
                for (let i in order_keys) {
                    let order_key = order_keys[i];
                    let value_a = a[order_key].value;
                    let value_b = b[order_key].value;
                    let compared = isNumber(value_a) ? value_a - value_b : value_a.localeCompare(value_b);
                    if (compared) return compared;
                }
                return 0;
            });
            this.dt_items = items;
        }

    }
}
</script>
