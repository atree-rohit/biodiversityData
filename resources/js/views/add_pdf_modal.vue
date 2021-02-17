<template>
	<div class="modal is-active">
		<div class="modal-background"></div>
		<div class="modal-card">
			<header class="modal-card-head">
				<p class="modal-card-title">Add a PDF file</p>
				<button class="delete" aria-label="close" @click="$emit('close')"></button>
			</header>
			<section class="modal-card-body has-text-left">

				<div class="file is-flex is-justify-content-center">
					<label class="file-label">
						<input class="file-input" type="file" id="file" ref="file" @change="filesSelected">
						<span class="file-cta">
							<span class="file-icon">
								<i class="fas fa-upload"></i>
							</span>
							<span class="file-label">
								Select a PDF file…
							</span>
						</span>
					</label>
				</div>

				<div class="field mt-4">
					<div class="control">
						<textarea class="textarea" placeholder="Enter file description" v-model="form.description"></textarea>
					</div>
				</div>

			</section>
			<footer class="modal-card-foot">
				<button class="button is-success" @click="submitForm()">Save changes</button>
				<button class="button" @click="$emit('close')">Cancel</button>
			</footer>
		</div>
	</div>
</template>

<script>

const default_layout = "default";
export default {
	name: "add-modal",
	computed: {},
	data() {
		return {
			form:{
				file:"",
				description:""
			},
		}
	},
	methods: {
		filesSelected(event){
			// console.log(event.target.files[0]);
			this.form.file = this.$refs.file.files[0];
		},
		submitForm(){
			let formData = new FormData();
			formData.append('file', this.form.file);
			axios.post( '/pdf',
				formData,
				{
					headers: {
						'Content-Type': 'multipart/form-data'
					}
				}
				).then(function(){
					console.log('SUCCESS!!');
				})
				.catch(function(){
					console.log('FAILURE!!');
				});

			}
	}
};
</script>
