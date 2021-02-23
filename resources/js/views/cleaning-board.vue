<style>
	.main-div-expanded{
		max-height:90vh !important;
		min-height:30vh !important;
		overflow-y: scroll;
	}

</style>
<template>
	<div class="container d-flex flex-column" style="max-height:95vh;">
		<div class="row bg-success" v-if="displayMessage">
			<div class="col-11 text-center p-3">
				<span class="h3 text-light">
					{{ messageText }}
				</span>
			</div>
			<div class="col text-end p-1">
				<button type="button" class="close btn btn-sm btn-outline-light" @click="displayMessage = false">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		</div>
		<div class="row">
			<div class="col d-flex justify-content-around">
				<div class="h5 p-2 border border-success rounded"> Page No: {{ page_no }}</div>
				<div class="h5 p-2 border border-success rounded"> No of rows: {{ filteredData.length }}</div>
			</div>
		</div>
		<div class="row mb-3">
			<div class="col d-flex justify-content-center">
				<button class="btn btn-outline-dark mx-3" v-if="page_no > 0" @click="gotoPage('prev')">&lt; &lt; Previous Page</button>
				<button class="btn btn-outline-dark mx-3" @click="gotoPage('next')">Next Page &gt; &gt;</button>
			</div>
		</div>
		<div class="row border border-primary main-div-expanded">
			<div v-for="d in filteredData" @mouseover="setHover(d.id)" @mouseleave="unsetHover" :key="d.id">
				<cleaning-row :text="d.text" :id="d.id" :selected_rows="selected_rows" :showButtons='(current_hover === d.id)' :editData="edit_data === d.id"> </cleaning-row>
			</div>
		</div>
		<div class="row  mt-2">
			<div v-if="selected_rows.length" class="text-center">
				{{selected_rows.length}} rows selected

			</div>
			<div class="d-flex justify-content-around">
				<button class="col-3 btn btn-primary" v-if="rows_with_0" @click="remove0rows">Remove all rows without text</button>
				<button class="col-3 btn btn-info" v-if="merge_rows_btn" @click="mergeRows">Merge Selected Rows</button>
				<button class="col-3 btn btn-danger" v-if="delete_rows_btn" @click="deleteRows">Delete Selected Rows</button>
				<button class="col-3 btn btn-success" v-if="selected_rows.length" @click="selected_rows = []">Unselect All</button>
			</div>
			<div class="d-flex justify-content-around">

					<button class="btn btn-lg btn-success" @click="saveData">Save to Database</button>
				<!-- <form method="POST" action="./documents/limbo_data" enctype="multipart/form-data">
				</form> -->
				<button class="btn btn-warning" @click="toggleChangelogHeight" v-text="toggleChangeLogButtonText"></button>
			</div>
		</div>

		<div class="row main-div-expanded" v-if="changelog_area_toggle">
			<div class="d-flex flex-row flex-wrap bd-highlight">
				<cleaning-changelog v-for="(c,i) in changeLog" :key="i" :changelog="c" > </cleaning-changelog>
			</div>

		</div>
	</div>
</template>

<script>
import CleaningRow from './cleaning-row';
import CleaningChangelog from './cleaning-changelog';

export default {
	props: ["data"],
	components: {CleaningRow, CleaningChangelog},
	data() {
		return{
			cleaned_data: JSON.stringify(this.data),
			filteredData: [],
			base_url:"",
			doc_id:-1,
			page_no: -1,
			per_page: -1,
			current_hover:-1,
			edit_data: -1,
			changeLog: [],
			selected_rows:[],
			changelog_area_toggle: false,
			displayMessage:false,
			messageText: "",
		}
	},
	created(){
		this.$on("clicked", (rowId, rowAction, editedData) =>{
			switch(rowAction){
				case("accept"): console.log("Accept");
								break;
				case("edit"): this.edit_data = rowId;
							  break;
				case("delete"): this.removeElement(rowId);
								break;
				case("merge_up"): this.mergeElements(rowId, "up");
								break;
				case("merge_down"): this.mergeElements(rowId, "down");
								break;
				case("edit_save"): this.saveEditData(rowId, editedData);
				case("edit_cancel"): this.edit_data = -1;
								break;
				default: console.log(rowAction);
			}
		});
		this.filteredData = this.data;
		var url_array = window.location.href.split("/");
		this.doc_id = url_array.pop();
		this.base_url = url_array.join("/");
		this.page_no = new URL(location.href).searchParams.get('page');
		if(this.page_no == null){
			this.page_no = 0;
		} else {
			this.doc_id = this.doc_id.split("?")[0]
		}
		this.per_page = new URL(location.href).searchParams.get('per_page');
		if(this.per_page == null){
			this.per_page = 250;
		}
	},
	computed: {
		toggleChangeLogButtonText: function(){
			var button_text = "";
			if(this.changelog_area_toggle)
				button_text = "Hide Change Log";
			else
				button_text = "Show Change Log";
			return button_text
		},
		delete_rows_btn: function(){
			var showDeleteRowsButton = false;
			if(this.selected_rows.length > 0)
				showDeleteRowsButton = true;
			return showDeleteRowsButton;
		},
		merge_rows_btn: function(){
			var showMergeRowsButton = false;
			if(this.selected_rows.length > 1)
				showMergeRowsButton = true;
			return showMergeRowsButton;
		},
		rows_with_0: function(){
			var zero_rows = false;
			for(var i = 0 ; i< this.filteredData.length ; i++){
				if(this.filteredData[i].text.length == 0){
					zero_rows = true;
					break;
				}
			}
			return zero_rows;
		}
	},
	methods:{
		gotoPage(direction){
			var page_no = parseInt(this.page_no);

			if(direction == "prev")
				page_no -= 1;
			else
				page_no += 1;
			window.location.href = this.base_url + "/" + this.doc_id + "?page="+page_no;
		},
		toggleChangelogHeight(){
			this.changelog_area_toggle = !this.changelog_area_toggle;
			// return(this.changelog_area_toggle)
		},
		deleteRows(){
			var selected = this.selected_rows.sort();
			selected.forEach(r => {
				this.removeElement(r);
			});
			this.selected_rows = [];

		},
		mergeRows(){
			var selected = this.selected_rows.sort();
			var min_id = this.find_row_no(selected[0]);
			var op = [];
			for(var i = 1 ; i<selected.length ; i++){
				var element_id = this.find_row_no(selected[i])
				var element = this.filteredData.splice(element_id,1);
				op = this.filteredData;
				op[min_id].text += " " + element[0].text;
				this.logChange(selected[0], "merge", selected[i]);
			}
			this.selected_rows = [];
			this.filteredData = op;

		},
		remove0rows(){
			var op = [];
			this.filteredData.forEach(d => {
				if(d.text.length == 0)
					this.removeElement(d.id);
			});
		},
		saveData(){
			const data = JSON.stringify(this.filteredData);
			const changelog = JSON.stringify(this.changeLog);
			const csrf = document.head.querySelector("[name=csrf-token]").content

			 let formData = new FormData();
			 formData.append("document_id", this.doc_id);
			 formData.append("page_no", this.page_no);
			 formData.append("per_page", this.per_page);
			 formData.append("data", data);
			 formData.append("changelog", changelog);
			 formData.append("_token", csrf);

			 fetch("/limbo_data", {
			 	method: 'POST',
			 	body: formData
			 })
			 .then(response => response.json())
			 .then(data => {

			 	this.displayMessage = true;
			 	this.messageText = data;
			 	// window.location.href = this.base_url;
			 });

		},
		find_row_no(rowId){
			var match_id = -1;
			for(var i = 0 ; i < this.filteredData.length ; i++ ){
				if(this.filteredData[i].id == rowId){
					match_id = i;
					break;
				}
			}
			return match_id;
		},
		saveEditData(rowId, updatedData){
			var row_no = this.find_row_no(rowId);
			this.filteredData[row_no].text = updatedData;
			this.logChange(rowId, "edit ", updatedData);
		},
		mergeElements(rowId, direction){
			var op = [];
			var row_no = this.find_row_no(rowId);

			if(direction == "up"){
				var element = this.filteredData.splice(row_no,1);
				op = this.filteredData;
				op[row_no-1].text += " " + element[0].text;
			} else if(direction == "down"){
				var element = this.filteredData.splice(row_no+1,1);
				op = this.filteredData;
				op[row_no].text += " " + element[0].text;
			}
			this.filteredData = op;

			this.logChange(rowId, "merge", direction);
			this.unsetHover();
		},
		removeElement(rowId){
			var op = [];
			this.filteredData.forEach(d => {
				if(d.id != rowId){
					op.push(d)
				}
			});
			this.filteredData = op;

			this.logChange(rowId, "delete", null);
			this.unsetHover();
		},
		setHover(rowId){
			if(this.edit_data == -1)
				this.current_hover = rowId;
		},
		unsetHover(){
			this.current_hover = -1;
		},
		logChange(id, type, data){
			this.changeLog.push({
				"id": id,
				"type": type,
				"data": data
			});
		}

	}

};
</script>
