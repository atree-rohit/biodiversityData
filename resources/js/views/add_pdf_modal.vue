<template>
	<div class="modal is-active">
		<div class="modal-background"></div>
		<div class="modal-card">
			<header class="modal-card-head">
				<p class="modal-card-title">Add a PDF file</p>
				<button class="delete" aria-label="close" @click="$emit('close')"></button>
			</header>
			<form method="POST" action="./pdf" enctype="multipart/form-data">
				 <input type="hidden" name="_token" :value="csrf">
				<section class="modal-card-body has-text-left">
					<div class="file is-flex is-justify-content-center">
						<label class="file-label">
							<input class="file-input" type="file" name="file" enctype="multipart/form-data">
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
							<textarea class="textarea" name="description" placeholder="Enter file description"></textarea>
						</div>
					</div>

				</section>
				<footer class="modal-card-foot">
					<button class="button is-success" type="submit">Save changes</button>
					<button class="button" @click="$emit('close')">Cancel</button>
				</footer>
			</form>
		</div>
	</div>
</template>

<script>

const default_layout = "default";
export default {
	name: "add-modal",
	data() {
		return {
			csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
		}
	}
};
</script>
