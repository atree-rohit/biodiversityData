<style>
	.main-div{
		height:40vh !important;
		overflow-y: scroll;
	}
</style>
<template>
	<div>
		<div class="h1">No of rows: {{ data.length }}</div>
		<div class="border border-primary main-div">
			<div v-for="d in data" class="" @mouseover="setHover(i)" @mouseleave="unsetHover" :key="d.id">
				<cleaning-row :d="d" :row_id="d.id" :showButtons='(current_hover === d.id)' :editData="edit_data === d.id"> </cleaning-row>
			</div>
		</div>
		<div class="d-flex justify-content-center mt-2">
			<button class="btn btn-lg btn-success" @click="saveData">Save to Database</button>
		</div>
		<div class="border border-success main-div" >
			<table class="table">
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
			original_data:[],
			current_hover:-1,
			edit_data: -1,
			changeLog: []
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
	},
	computed: {},
	methods:{
		saveData(){
			alert("saving data to database");
		},
		mergeElements(rowId, direction){
			if(direction == "up"){
				var element = this.data.splice(rowId,1);
				this.data[rowId-1] += " " + element;
			} else if(direction == "down"){
				var element = this.data.splice(rowId+1,1);
				this.data[rowId] += " " + element;
			}
			this.logChange(rowId, "merge " + direction);
			this.unsetHover();
		},
		removeElement(rowId){
			this.data.splice(rowId,1);
			this.logChange(rowId, "delete");
			this.unsetHover();
		},
		setHover(i){
			if(this.edit_data == -1)
				this.current_hover = i;
		},
		unsetHover(){
			this.current_hover = -1;
		},
		logChange(id, type){
			this.changeLog.push(
				{"row_id": id,
								"change_type": type}
				);
		}

	}

};
</script>
