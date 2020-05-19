
See: http://tools.bitfertig.de/JustDatatableVue






<script>
export default {
    props: ['items', 'columns', 'options', 'search'],
    components: {
        draggable,

    },
    data: function(){
        return {
            prop_items: this.items,
            prop_columns: this.columns,
            prop_options: this.options,

            //search: this.search,
        }
    },
    computed: {
        //
        dtItems: {
            get: function() {
                //{idx:2, name:{text:'"Bobby"', value:'Bob'}, category:'Das'}
                for (let row_i in this.prop_items) {
                    let row = this.prop_items[row_i];
                    for (let col_i in row) {
                        let col = this.prop_items[row_i][col_i];

                        let column = {};
                        column.attributes = _.get(col, 'attributes') || {};
                        column.enable_html = !!_.get(col, 'enable_html');

                        if ( typeof col === 'object' ) {
                            column.text = col.text || '';
                            column.value = typeof col.value != 'undefined' ? col.value : col.text;
                        }
                        else if ( typeof col === 'string' ) {
                            column.text = col;
                            column.value = col;
                        }
                        else if ( typeof col === 'number' ) {
                            column.text = col;
                            column.value = col;
                        }
                        this.prop_items[row_i][col_i] = column;
                    }
                }

                return this.prop_items;
            },
            set: function(newValue) {
                this.prop_items = newValue;
            }
        },
        dtColumns: function() {
            for (let col_i in this.prop_columns) {
                let col = this.prop_columns[col_i];
                let column = {};
                column.attributes = _.get(col, 'attributes') || {};
                column.enable_html = !!_.get(col, 'enable_html');
                if ( typeof col === 'string' ) {
                    column.name = col;
                    column.text = col;
                    column.visible = true;
                }
                else if ( typeof col === 'object' ) {
                    column.name = col.name;
                    column.text = col.text || '';
                    column.visible = typeof col.visible !== 'undefined' ? !!col.visible : true;
                }
                this.prop_columns[col_i] = column;
            }
            return this.prop_columns;
        },
        dtOptions: function() {
            this.prop_options.key = this.prop_options.key || 'id';
            this.prop_options.order = this.prop_options.order || ['id'];
            this.prop_options.draggable = !!this.prop_options.draggable;
            this.prop_options.draggable_start = this.prop_options.draggable_start || function(event, key, items){};
            this.prop_options.draggable_end = this.prop_options.draggable_end || function(event, key, items){};
            this.prop_options.draggable_attributes = this.prop_options.draggable_attributes || {}; // {handle:'.handle'}
            this.prop_options.dom_table_attributes = this.prop_options.dom_table_attributes || {};
            this.prop_options.dom_table_thead_attributes = this.prop_options.dom_table_thead_attributes || {};
            this.prop_options.dom_table_tbody_attributes = this.prop_options.dom_table_tbody_attributes || {};
            return this.prop_options;
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
        //this.filter();
    },
    methods: {
        /* columns: function() {

        }, */
        filter: function(row) {
            if ( !this.search ) return true;
            let q = this.search.split(' ');
            let fulltext = '';
            for (let col of this.dtColumns) {
                let val = row[col.name].value.toString();
                fulltext += ' ' + val;
            }
            //console.log(fulltext);
            let found = 0; // all must be true
            for (let i in q) {
                if ( fulltext.toLowerCase().includes(q[i].toLowerCase()) ) found++;
            }
            if ( found == q.length ) return true;
            return false;
        },
        order: function() {
            let items = this.prop_items;
            items.sort((a, b) => {
                var isNumber = function(n) { return !isNaN(parseFloat(n)) && isFinite(n); };
                let order_keys = this.prop_options.order_by;//['order','id'];
                for (let i in order_keys) {
                    let order_key = order_keys[i];
                    let value_a = a[order_key].value;
                    let value_b = b[order_key].value;
                    let compared = isNumber(value_a) ? value_a - value_b : value_a.localeCompare(value_b);
                    if (compared) return compared;
                }
                return 0;
            });
            this.prop_items = items;
        }

    }
}
</script>





<datatable-component :items="items" :columns="columns" :options="options" :search="search"></datatable-component>

<script>
const app = new Vue({
    el: '#app',
    mounted () {

    },
    methods: {

    },
    data () {
        return {
            items: items,
            /*items: [
                {id:1, name:'Jim'},
                {id:2, name:{text:'"Bobby"', value:'Bob'}, category:'Das'}
            ], */
            columns:[
                {name:'drag', text:''},
                {name:'id', text:'ID'},
                //{name:'order', text:'R'},
                {name:'name', text:'Name'},
                {name:'short_name', text:'Kurzname'},
                {name:'price', text:'Preis', attributes:{class:'text-right'}},
                {name:'gear', text:'<span class="mdi mdi-settings-outline" title="Steuerung"></span>', enable_html:true, attributes:{class:'text-right'}}
            ],
            options: {
                key: 'id',
                dom_table_attributes: {class:'table table-striped w-100'},
                dom_table_thead_attributes: {class:'table-dark'},
                dom_table_tbody_attributes: {},
                order_by: ['order'],
                draggable: true,
                draggable_attributes: {handle:'.handle'},
                //draggable_start: function(evt, key, items){},
                //draggable_end: function(evt, key, items){},
            }
        }
    }
});


</script>



this.prop_options.pagination = this.prop_options.pagination || {items_per_page: '*', page: 1};


pagination: function() {
    if ( this.prop_options.pagination.items_per_page == '*' ) return;

    let items = this.prop_items;

    let items_per_page = this.prop_options.pagination.items_per_page;
    let page = this.prop_options.pagination.page;
    let start = (page - 1) * items_per_page;
    let end = start + items_per_page;
    items = items.slice(start, end);

    this.prop_items = items;
}


        {{-- <select v-model="options.pagination.items_per_page" title="Anzahl pro Seite">
            <option value="3">3</option>
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
            <option value="*">Alle</option>
        </select> --}}

        <select v-model="options.pagination.page">
            <option v-for="(page, page_index) in new Array(pagination_pages)" :value="page_index + 1">Seite @{{ page_index + 1 }}</option>
        </select>
