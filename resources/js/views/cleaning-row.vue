<style type="text/css">
	.doc-row{
		min-height: 35px !important;
	}
	.danger{
		background-color: rgba(255,50,50,.25);
	}
	.warning{
		background-color: rgba(255,255,200,.25);
	}
	.success{
		background-color: rgba(150,250,200,.25);
	}
	.highlight{
		background-color: rgba(250,250,100,.66);
	}
	.number-col{
		max-width:50px !important;
		border: 1px solid #aaa;
		/*background-color: #ccc;*/
	}
</style>
<template>
	<div class="row border p-0" :class="row_color">
		<div class="number-col" :class="selectedRow" @click="toggle_select_row">
			<span class="py-1 px-2 text-secondary">{{ id }}. </span>
		</div>
		<div class="col-9 my-auto doc-row d-flex" :class="length_color">
			<textarea class="form-control" v-if="editData" rows="2" v-model="currentText"></textarea>
			<span v-else class="p-1">{{ currentText }}</span>
		</div>
		<div class="number-col text-center" :class="length_text_color">{{ currentText.length }}</div>
		<div class="col-2 d-flex p-0">
			<div class="col" v-if="editData">
				<div class="btn-group d-flex justify-content-between" >
					<button class="btn btn-success" @click='lineAction("edit_save")'><i class="fa fa-floppy-o"></i> Save</button>
					<button class="btn btn-danger" @click='lineAction("edit_cancel")'><i class="fa fa-ban"></i> Cancel</button>
				</div>
			</div>
			<div class="col" v-else >
				<div class="btn-group d-flex align-middle" v-if="showButtons">
					<button class="btn btn-sm mx-1 btn-success" @click='lineAction("accept")'><i class="fa fa-check"></i></button>
					<button class="btn btn-sm mx-1 btn-info" @click='lineAction("edit")'><i class="fa fa-pencil"></i></button>
					<button class="btn btn-sm mx-1 btn-danger" @click='lineAction("delete")'><i class="fa fa-trash-o"></i></button>
					<button class="btn btn-sm mx-1 btn-primary" @click='lineAction("merge_up")'><i class="fa fa-arrow-up"></i></button>
					<button class="btn btn-sm mx-1 btn-primary" @click='lineAction("merge_down")'><i class="fa fa-arrow-down"></i></button>
				</div>
			</div>
		</div>

		</div>
	</div>
</template>

<script>
export default {
	name:"cleaning-row",
	props: ["text","id", "showButtons", "editData", "selected_rows"],
	data() {
		return{
			currentText:"",
			text_color: "bg-light",
			row_color: "bg-light",
			rowSelected: false,
			selectedRow: ""
			// editData
		}
	},
	created(){
		this.currentText = this.text;
	},
	watch:{
		selected_rows:{
			immediate:true,
			handler(val, oldVal){
				if(val.includes(this.id)){
					this.rowSelected = true;
				} else {
					this.selectedRow = ""
					this.rowSelected = false;
				}
			}
		},
		showButtons: {
			immediate: true,
			handler(val, oldVal){
				if(val){
					this.row_color = "border border-success highlight";
				}
				else{
					this.row_color = "bg-light";
				}
			}
		}
	},
	computed: {
		length_color: function (){
			if(this.text.length == 0)
				return "danger";
			else if(this.text.length < 10)
				return "warning";
			else
				return "success";
		},
		length_text_color:function(){
			return "text-"+this.length_color;
		}
	},
	methods:{
		toggle_select_row(){
			this.rowSelected = !this.rowSelected;
			if(this.rowSelected){
				this.selectedRow = "bg-success text-light"
				this.$parent.selected_rows.push(this.id)
				// this.$parent.$emit('rowSelected', this.id);
			} else {
				this.selectedRow = ""
				this.$parent.selected_rows.splice(this.$parent.selected_rows.indexOf(this.id),1)
			}
		},
		lineAction(verb){
			this.$parent.$emit('clicked', this.id, verb, this.data);
		}
	}

};
</script>
