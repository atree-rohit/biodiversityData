require('./bootstrap.js');

import Vue from 'vue'

//Main pages
import CleaningBoard from './views/cleaning-board'
import CleaningRow from './views/cleaning-row'
import CleaningChangelog from './views/cleaning-changelog'
import DocumentsTable from './views/documents-table.vue'
import LimboTable from './views/limbo-table.vue'


const app = new Vue({
    el: '#app',
    components: {CleaningBoard, CleaningRow, CleaningChangelog, DocumentsTable, LimboTable},
    data: {
    	showModal:true
    },
    methods: {
    	add_pdf_button(){
    		console.log("ADD Button Pressed");
    	}
    }
});

