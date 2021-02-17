require('./bootstrap.js');

import Vue from 'vue'

//Main pages
import App from './views/app'
import AddModal from './views/add_pdf_modal.vue'


const app = new Vue({
    el: '#app',
    components: {App, AddModal},
    data: {
    	showModal:true
    },
    methods: {
    	add_pdf_button(){
    		console.log("ADD Button Pressed");
    	}
    }
});

