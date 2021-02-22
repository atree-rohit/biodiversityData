<style type="text/css">
	.doc-row{
		min-height: 40px !important;
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
</style>
<template>
	<div class="row align-middle border m-0" :class="row_color">
		<div class="col-9 my-auto doc-row d-flex" :class="length_color">
			<span class="py-1 px-2 text-secondary">{{ id }}. </span>
			<textarea class="form-control" v-if="editData" rows="2" v-model="text"></textarea>
			<span v-else class="p-1">{{ text }}</span>
		</div>
		<div class="col-1 bg-light text-center" :class="length_text_color">{{ text.length }}</div>
		<div class="col d-flex p-0">
			<div class="col" v-if="editData">
				<div class="btn-group d-flex justify-content-between" >
					<button class="btn btn-success" @click='lineAction("edit_save")'><i class="fa fa-floppy-o"></i> Save</button>
					<button class="btn btn-danger" @click='lineAction("edit_cancel")'><i class="fa fa-ban"></i> Cancel</button>
				</div>
			</div>
			<div class="col" v-else >
				<div class="btn-group d-flex align-middle" v-if="showButtons">
					<button class="btn px-1 mx-1 btn-success" @click='lineAction("accept")'><i class="fa fa-check"></i></button>
					<button class="btn px-1 mx-1 btn-info" @click='lineAction("edit")'><i class="fa fa-pencil"></i></button>
					<button class="btn px-1 mx-1 btn-danger" @click='lineAction("delete")'><i class="fa fa-trash-o"></i></button>
					<button class="btn px-1 mx-1 btn-primary" @click='lineAction("merge_up")'><i class="fa fa-arrow-up"></i></button>
					<button class="btn px-1 mx-1 btn-primary" @click='lineAction("merge_down")'><i class="fa fa-arrow-down"></i></button>
				</div>
			</div>
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
			text_color: "bg-light",
			row_color: "bg-light",
			id:-1,
			text:""
			// editData
		}
	},
	created(){
		this.id = this.d.id;
		this.text = this.d.text;
	},
	watch:{
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
			if(this.d.length == 0)
				return "danger";
			else if(this.d.length < 10)
				return "warning";
			else
				return "success";
		},
		length_text_color:function(){
			return "text-"+this.length_color;
		}
	},
	methods:{
		lineAction(verb){
			this.$parent.$emit('clicked', this.id, verb, this.data);
		}
	}

};
</script>
