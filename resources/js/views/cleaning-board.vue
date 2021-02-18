<style>
	#main-cleaning-board{
		max-height:50vh !important;
		overflow-y: scroll;
	}
</style>
<template>
	<div>
		<div class="is-size-3">No of rows: {{ rowCount }}</div>
		<div class="box" id="main-cleaning-board">
			<div v-for="(d,i) in data" class="" @mouseover="setHover(i)" @mouseleave="unsetHover" :key="i + '-' + d">
				<cleaning-row :d="d" :row_id="i" :showButtons='(current_hover === i)' :editData="edit_data === i"> </cleaning-row>
			</div>
		</div>
		<div class="has-text-centered">
			<button class="button is-success" @click="saveData">Save to Database</button>
		</div>
	</div>
</template>

<script>
import CleaningRow from './cleaning-row'

export default {
	props: ["data"],
	components: {CleaningRow},
	data() {
		return{
			cleaned_data: JSON.stringify(this.data),
			original_data:[],
			current_hover:-1,
			edit_data: -1
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
	computed: {
		rowCount: function (){
			return this.data.length;
		}
	},
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
			this.unsetHover();
		},
		removeElement(rowId){
			this.data.splice(rowId,1);
			this.unsetHover();
		},
		setHover(i){
			if(this.edit_data == -1)
				this.current_hover = i;
		},
		unsetHover(){
			this.current_hover = -1;
		}

	}

};
</script>
