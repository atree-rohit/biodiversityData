<style type="text/css">
	.column{
		display: flex !important;
	}
	button.button{
		margin-bottom: 0px !important;
	}
</style>
<template>
	<div class="columns" :class="row_color">
		<div class="column is-two-thirds pt-1 pb-4" :class="text_color">
			<textarea class="textarea" v-if="editData" rows="2" v-model="data"></textarea>
			<div v-else class="box p-1 is-vcentered">{{ data }}</div>
		</div>
		<div class="column  has-text-centered is-vcentered is-justify-content-space-between pt-0">
			<div class="px-4 is-size-6 has-text-centered has-background-light" :class="length_text_color">{{ data.length }}</div>
			<div>
				<div class="buttons py-3" v-if="editData">
					<button class="button is-success" @click='lineAction("edit_save")'><i class="fa fa-floppy-o"></i> Save</button>
					<button class="button is-danger" @click='lineAction("edit_cancel")'><i class="fa fa-ban"></i> Cancel</button>
				</div>
				<div v-else>
					<div class="buttons py-4" v-if="showButtons">
						<button class="button is-success is-small" @click='lineAction("accept")'><i class="fa fa-check"></i></button>
						<button class="button is-info is-small" @click='lineAction("edit")'><i class="fa fa-pencil"></i></button>
						<button class="button is-danger is-small" @click='lineAction("delete")'><i class="fa fa-trash-o"></i></button>
						<button class="button is-primary is-small" @click='lineAction("merge_up")'><i class="fa fa-arrow-up"></i></button>
						<button class="button is-primary is-small" @click='lineAction("merge_down")'><i class="fa fa-arrow-down"></i></button>
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
			text_color: "has-background-light has-text-weight-normal",
			row_color: "has-background-light",
			data:"",
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
					this.text_color = "has-background-success has-text-weight-bold";
					this.row_color = "has-background-grey-light";
				}
				else{
					this.row_color = "has-background-light";
					this.text_color = "has-background-light has-text-weight-normal"
				}
			}
		}
	},
	computed: {
		length_color: function (){
			if(this.d.length == 0)
				return "has-background-danger";
			else if(this.d.length < 10)
				return "has-background-warning";
			else
				return "has-background-success";
		},
		length_text_color:function(){
			if(this.d.length == 0)
				return "has-text-danger";
			else if(this.d.length < 10)
				return "has-text-warning";
			else
				return "has-text-success";
		}
	},
	methods:{
		lineAction(verb){
			this.$parent.$emit('clicked', this.row_id, verb, this.data);
		}
	}

};
</script>
