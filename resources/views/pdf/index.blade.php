@extends('layouts.app')

@section('style')
<style type="text/css">
	body{

	}
</style>
@endsection

@section('content')
	<div class="container">
		<section class="hero is-small is-success">
			<div class="hero-body">
				<p class="title is-size-1 has-text-centered">
					Biodiversity Data : PDF Files
				</p>
			</div>
		</section>

		<div id="app" class="has-text-centered pt-6">
			<button class="button" @click="showModal = true">Add PDF File</button>
			<add-modal v-if="showModal" @close="showModal = false"></add-modal>
	    </div>

	</div>
@endsection

@section('js')
<script type="text/javascript">

</script>
@endsection
