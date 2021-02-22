<style>
	.main-div-expanded{
		max-height:50% !important;
		overflow-y: scroll;
	}

</style>
<template>
	<div class="container d-flex flex-column" style="max-height:90vh;">
		<div class="row">
			<div class="col">
				<p class="h1"> No of rows: {{ filteredData.length }}</p>
			</div>
		</div>
		<div class="row border border-primary main-div-expanded">
			<div v-for="d in filteredData" class="" @mouseover="setHover(d.id)" @mouseleave="unsetHover" :key="d.id">
				<cleaning-row :text="d.text" :id="d.id" :selected_rows="selected_rows" :showButtons='(current_hover === d.id)' :editData="edit_data === d.id"> </cleaning-row>
			</div>
		</div>
		<div class="row  mt-2">
			<div class="d-flex justify-content-around">
				<button class="col-3 btn btn-danger" v-if="delete_rows_btn" @click="deleteRows">Delete Selected Rows</button>
				<button class="col-3 btn btn-info" v-if="merge_rows_btn" @click="mergeRows">Merge Selected Rows</button>
				<button class="col-3 btn btn-primary" v-if="rows_with_0" @click="remove0rows">Remove all rows with no text</button>
			</div>
			<div class="d-flex justify-content-around">

					<button class="btn btn-lg btn-success" @click="saveData">Save to Database</button>
				<!-- <form method="POST" action="./documents/limbo_data" enctype="multipart/form-data">
				</form> -->
				<button class="btn btn-warning" @click="toggleChangelogHeight" v-text="toggleChangeLogButtonText">Toggle Change Log Area</button>
			</div>
		</div>

		<div class="row border border-success main-div-expanded p-0">
			<table class="table table-sm" v-if="changelog_area_toggle">
				<thead>
					<tr>
						<th>ID</th>
						<th>Type</th>
					</tr>
				</thead>
				<tbody>
					<cleaning-changelog v-for="(c,i) in changeLog" :key="i + '-' + c" :changelog="c"> </cleaning-changelog>
				</tbody>
			</table>
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
			current_hover:-1,
			edit_data: -1,
			changeLog: [],
			selected_rows:[],
			changelog_area_toggle: true
		}
	},
	created(){
		this.$on("clicked", (rowId, rowAction, editedData) =>{
			switch(rowAction){
				case("accept"): console.log("Accept");
								break;
				case("edit"): if(this.edit_data == rowId){
								this.edit_data = -1
							  } else {
								this.edit_data = rowId;
							  }
							  break;
				case("delete"): this.removeElement(rowId);
								break;
				case("merge_up"): this.mergeElements(rowId, "up");
								break;
				case("merge_down"): this.mergeElements(rowId, "down");
								break;
				case("edit_save"): this.data[rowId] = editedData;
								this.edit_data = -1;
								break;
				case("edit_cancel"): this.edit_data = -1;
								break;
				default: console.log(rowAction);
			}
		});
		this.filteredData = this.data;
	},
	computed: {
		toggleChangeLogButtonText: function(){
			var button_text = "";
			if(this.changelog_area_toggle)
				button_text = "Hide Change Log Area";
			else
				button_text = "Show Change Log Area";
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
				this.logChange(selected[0], "merge " + selected[i]);
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

			var doc_id = window.location.href.split("/")[4];
			console.log(doc_id);

			var page_no = new URL(location.href).searchParams.get('page');
			if(page_no == null){
				page_no = 0;
			}

			 let formData = new FormData();
			 formData.append("document_id", doc_id);
			 formData.append("page_no", page_no);
			 formData.append("data", data);
			 formData.append("changelog", changelog);
			 formData.append("_token", csrf);
			 console.log(formData);
			 console.log(csrf);
			 fetch("/documents/limbo_data", {
			 	method: 'POST',
			 	body: formData
			 }).then(() => console.log('success'));
			// var xhttp = new XMLHttpRequest();
			// xhttp.open("POST", "/documents/limbo_data" , true);
			// xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			// xhttp.setRequestHeader("X-CSRF-TOKEN", document.head.querySelector("[name=csrf-token]").content );
			// xhttp.send(params);
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
		mergeElements(rowId, direction){
			var op = [];
			var row_no = this.find_row_no(rowId);
			// console.log(rowId, row_no);
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
			this.logChange(rowId, "merge " + direction);
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

			this.logChange(rowId, "delete");
			this.unsetHover();
		},
		setHover(rowId){
			if(this.edit_data == -1)
				this.current_hover = rowId;
		},
		unsetHover(){
			this.current_hover = -1;
		},
		logChange(id, type){
			this.changeLog.push({
				"id": id,
				"type": type
			});
		}

	}

};
</script>
