<style type="text/css">
	.doc-row{
		min-height: 40px !important;
	}
</style>
<template>
	<div class="row align-middle" :class="row_color">
		<div class="col-8 my-auto h-100 doc-row d-flex">
			<span class="py-1 px-2 text-secondary">{{ row_id }}. </span>
			<textarea class="form-control" v-if="editData" rows="2" v-model="data"></textarea>
			<span v-else class="p-1">{{ data }}</span>
		</div>
		<div class="col d-flex p-0">
			<div class="text-center bg-light p-2" :class="length_text_color">{{ data.length }}</div>
			<div class="col" v-if="editData">
				<div class="btn-group d-flex justify-content-between" >
					<button class="btn btn-success" @click='lineAction("edit_save")'><i class="fa fa-floppy-o"></i> Save</button>
					<button class="btn btn-danger" @click='lineAction("edit_cancel")'><i class="fa fa-ban"></i> Cancel</button>
				</div>
			</div>
			<div class="col" v-else >
				<div class="btn-group d-flex align-middle" v-if="showButtons">
					<button class="btn px-3 mx-1 btn-success" @click='lineAction("accept")'><i class="fa fa-check"></i></button>
					<button class="btn px-3 mx-1 btn-info" @click='lineAction("edit")'><i class="fa fa-pencil"></i></button>
					<button class="btn px-3 mx-1 btn-danger" @click='lineAction("delete")'><i class="fa fa-trash-o"></i></button>
					<button class="btn px-3 mx-1 btn-primary" @click='lineAction("merge_up")'><i class="fa fa-arrow-up"></i></button>
					<button class="btn px-3 mx-1 btn-primary" @click='lineAction("merge_down")'><i class="fa fa-arrow-down"></i></button>
				</div>
			</div class="col">
		</div>

		</div>
	</div>
</template>

<script>
export default {
	name:"cleaning-row",
	props: ["d", "row_id" ,"showButtons", "editData"],
	data() {
		return{
			text_color: "bg-light fw-bold",
			row_color: "bg-light",
			data:""
			// editData
		}
	},
	created(){
		this.data = this.d
	},
	watch:{
		showButtons: {
			immediate: true,
			handler(val, oldVal){
				if(val){
					this.row_color = "border border-success fw-bold bg-warning";
				}
				else{
					this.row_color = "bg-light";
				}
			}
		}
	},
	computed: {
		length_color: function (){
			if(this.d.length == 0)
				return "bg-danger";
			else if(this.d.length < 10)
				return "bg-warning";
			else
				return "bg-success";
		},
		length_text_color:function(){
			if(this.d.length == 0)
				return "text-danger";
			else if(this.d.length < 10)
				return "text-warning";
			else
				return "text-success";
		}
	},
	methods:{
		lineAction(verb){
			this.$parent.$emit('clicked', this.row_id, verb, this.data);
		}
	}

};
</script>
