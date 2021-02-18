@extends('layouts.app')

@section('style')
<style type="text/css">
	body{

	}
</style>
@endsection

@section('content')
	<div class="container">
		<section class="hero is-small is-success has-text-centered">
			<div class="hero-body">
				<p class="title is-size-1">
					Biodiversity Documents
				</p>
				<button class="button is-warning" id="addBtn">Add Biodiversity Document</button>
			</div>
		</section>
		@include("layouts.message")


		<div id="addModal" class="modal">
			<div class="modal-background"></div>
			<div class="modal-card">
				<header class="modal-card-head">
					<p class="modal-card-title">Add a PDF file</p>
					<button class="delete cancelModal" aria-label="close" ></button>
				</header>
				<form method="POST" action="./documents" enctype="multipart/form-data">
					 @csrf
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
						<button class="button cancelModal" aria-label="close" type="button" >Cancel</button>
					</footer>
				</form>
			</div>
		</div>

		<div id="app" class="has-text-centered pt-6">
			<documents-table :fields='@json($fields)' :data='@json($documents)'></documents-table>
		</div>

	</div>
@endsection

@section('js')
<script type="text/javascript">
	const addModal = document.querySelector('#addModal'); 
	var showModal = () =>  addModal.classList.add('is-active'); 
	var hideModal = () =>  addModal.classList.remove('is-active'); 
	
  
	document.querySelector('#addBtn') 
		.addEventListener('click', () => showModal() );


	document.querySelectorAll('.cancelModal')
		.forEach(item => item.addEventListener('click', () =>  hideModal() ) );
	
  
	window.addEventListener('click', event => { 
		if (event.target.className ===  'modal-background') { 
			hideModal();
		} 
	}) 

</script>
@endsection
