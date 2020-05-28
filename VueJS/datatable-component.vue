<template>
    <div v-cloak>

        <table v-bind="get_option('dom_table_attributes')" ref="table">
            <thead v-bind="get_option('dom_table_thead_attributes')">
                <tr>
                    <template v-for="(col, col_i) in get_columns()">
                        <template v-if="col.show">
                        <th :key="col_i" v-if="col.enable_html" v-bind="col.attributes" v-html="col.text"></th>
                        <th :key="col_i" v-else v-bind="col.attributes" v-text="col.text"></th>
                        </template>
                    </template>
                </tr>
            </thead>
            <tbody v-bind="get_option('dom_table_tbody_attributes')">
                <template v-for="(row, row_i) in current_items">
                    <tr :key="row_i" v-show="row.show">
                        <template v-for="(col, col_i) in get_columns()">
                            <template v-if="col.show">
                                <td :key="col_i"
                                    v-if="row.cols[col.name].enable_html"
                                    v-bind="row.cols[col.name].attributes"
                                    v-html="row.cols[col.name].text"
                                ></td>
                                <td :key="col_i"
                                    v-else
                                    v-bind="row.cols[col.name].attributes"
                                    v-text="row.cols[col.name].text"
                                ></td>
                            </template>
                        </template>
                    </tr>
                </template>
            </tbody>
        </table>

    </div>
</template>



<script>
export default {
//module.exports = {
    props: ['items', 'columns', 'options', 'search'],
    components: {
        //draggable,
    },
    data: function(){
        return {
            default_options: {
                key: 'id',
                order_by: ['id'],
                pagination: {items_per_page:'*', page:1},
                draggable: false, //use where you need a handle: attributes:{class:'.handle'}}
                dom_table_attributes: {},
                dom_table_thead_attributes: {},
                dom_table_tbody_attributes: {}
            }
        }
    },
    mounted () {
        //console.log('mounted');

        this.init_sortable();

    },
    computed: {
        current_items: {
            get: function() {
                return this.get_items();
            },
            set: function(newValue) {
                this.items = newValue;
            }
        }
    },
    methods: {
        init_sortable: function() {
            var that = this;
            var sortableTbody = this.$refs.table.getElementsByTagName('tbody')[0];
            new window.Sortable(
                sortableTbody,
                {
                    draggable: 'tr',
                    handle: '.handle',
                    onEnd: this.dragReorder,
                    onStart: function (/**Event*/evt) {
                        evt.oldIndex;  // element index within parent

                        // Enhance with item row data
                        evt.data = {};
                        evt.data.items = that.current_items;
                        evt.data.item = evt.data.items[evt.oldIndex];

                        that.$emit('draggablestart', ...arguments);
                    },
                    onEnd: function (/**Event*/evt) {
                        var itemEl = evt.item;  // dragged HTMLElement
                        evt.to;    // target list
                        evt.from;  // previous list
                        evt.oldIndex;  // element's old index within old parent
                        evt.newIndex;  // element's new index within new parent
                        evt.oldDraggableIndex; // element's old index within old parent, only counting draggable elements
                        evt.newDraggableIndex; // element's new index within new parent, only counting draggable elements
                        evt.clone // the clone element
                        evt.pullMode;  // when item is in another sortable: `"clone"` if cloning, `true` if moving

                        // Move to new position
                        function arraymove(arr, fromIndex, toIndex) {
                            var element = arr[fromIndex];
                            arr.splice(fromIndex, 1);
                            arr.splice(toIndex, 0, element);
                        }
                        arraymove(that.current_items, evt.oldIndex, evt.newIndex);

                        // Enhance with item row data
                        evt.data = {};
                        evt.data.items = that.current_items;
                        evt.data.item = evt.data.items[evt.oldIndex];

                        that.$emit('draggableend', ...arguments);
                    }
                }
            );
        },
        get_option: function(option) {
            let val = this.vald(()=>{return this.options[option];}, this.default_options[option]);
            return val;
        },
        get_columns: function() {
            let columns = [];

            for (let col_i in this.columns) {
                let col = this.columns[col_i];

                let column = {
                    attributes: {},
                    enable_html: false,
                    name: '',
                    text: '',
                    show: true
                };

                if ( typeof col === 'string' ) {
                    column.name = col;
                    column.text = col;
                }
                else if ( typeof col === 'object' && col !== null ) {
                    if ( typeof col.attributes === 'object' && col.attributes !== null ) column.attributes = this.json_sp(col.attributes);
                    if ( typeof col.enable_html !== 'undefined' ) column.enable_html = !!col.enable_html;
                    if ( typeof col.show !== 'undefined' ) column.show = !!col.show;
                    column.name = col.name;
                    column.text = col.text || '';
                }

                columns[col_i] = column;
            }

            return columns;
        },
        get_items: function() {
            //{idx:2, name:{text:'"Bobby"', value:'Bob'}, category:'Das'}
            let items = [];

            for (let row_i in this.items) {
                let row = this.items[row_i];

                items[row_i] = {
                    cols: {},
                    show: true
                };

                let columns = this.get_columns();
                for (let col_i in columns) {
                    let col_name = columns[col_i].name;
                    let col = typeof row[col_name] !== 'undefined' ? this.json_sp(row[col_name]) : '';

                    items[row_i].cols[col_name] = {};

                    let column = {
                        attributes: {},
                        enable_html: false,
                        text: '',
                        value: ''
                    };

                    if ( typeof col === 'object' && col !== null ) {
                        if ( typeof col.attributes === 'object' && col.attributes !== null ) column.attributes = this.json_sp(col.attributes);
                        if ( typeof col.enable_html !== 'undefined' ) column.enable_html = !!col.enable_html;
                        column.text = col.text || '';
                        column.value = typeof col.value !== 'undefined' && col.value !== null ? col.value : col.text;
                    }
                    else if ( typeof col === 'string' ) {
                        column.text = col;
                        column.value = col;
                    }
                    else if ( typeof col === 'number' ) {
                        column.text = col;
                        column.value = col;
                    }

                    items[row_i].cols[col_name] = column;
                }

                items[row_i].show = this.do_filter(items[row_i]);
            }

            items = this.do_order(items);

            let show_count = items.filter(item => item.show).length;

            items = this.do_pagination(items);

            let count = items.filter(item => item.show).length;


            let items_per_page = typeof this.get_option('pagination').items_per_page !== 'undefined' && this.get_option('pagination').items_per_page != '*' ? this.get_option('pagination').items_per_page : show_count;

            let page_count = Math.ceil(show_count / items_per_page);

            this.$emit('pagecountchange', page_count); // Expose/Emit

            //console.log('current_items', items);
            return items;
        },

        // Datatable functions
        do_order: function(items) {
            items.sort((a, b) => {
                var isNumber = function(n) { return !isNaN(parseFloat(n)) && isFinite(n); };
                let order_keys = this.get_option('order_by');//['order','id'];
                for (let i in order_keys) {
                    let order_key = order_keys[i];
                    let value_a = a.cols[order_key].value;
                    let value_b = b.cols[order_key].value;
                    let compared = isNumber(value_a) ? value_a - value_b : value_a.localeCompare(value_b);
                    if (compared) return compared;
                }
                return 0;
            });
            return items;
        },
        do_filter: function(row) {
            let filter = true;
            let search = this.do_search(row);
            return filter && search;
        },
        do_search: function(row) {
            if ( !this.search ) return true;
            let q = this.search.split(' ');
            let fulltext = '';
            for (let col of this.get_columns()) {
                let val = row.cols[col.name].value.toString();
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
        do_pagination: function(items) {
            let items_per_page = this.get_option('pagination').items_per_page;
            let page = this.get_option('pagination').page;
            if ( items_per_page == '*' ) return items; // => No pagination
            let start = (page - 1) * items_per_page;
            let end = start + items_per_page;
            let i = 0;
            for (let item_i in items) {
                let item = items[item_i];
                if ( item.show ) {
                    if ( i >= start && i < end ) {
                        item.show = true;
                    }
                    else item.show = false;
                    i++;
                }
            }
            return items;
        },

        // Helper
        isset: function(fn) {
            var value;
            try { value = fn(); } catch (e) {}
            return value !== undefined;
        },
        val: function(fn) {
            var value;
            try { value = fn(); } catch (e) {}
            return value;
        },
        vald: function(fn, d) { // value with default
            return this.val(fn) || d;
        },
        json_sp: function(json) {
            return JSON.parse(JSON.stringify(json));
        }
    }
}
</script>
