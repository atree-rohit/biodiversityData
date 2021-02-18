require('./bootstrap.js');

import Vue from 'vue'

//Main pages
import CleaningBoard from './views/cleaning-board'
import DocumentsTable from './views/documents-table.vue'


const app = new Vue({
    el: '#app',
    components: {CleaningBoard, DocumentsTable},
    data: {
    	showModal:true
    },
    methods: {
    	add_pdf_button(){
    		console.log("ADD Button Pressed");
    	}
    }
});

