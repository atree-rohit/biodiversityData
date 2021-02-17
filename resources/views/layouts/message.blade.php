@if(count($errors))
	<article class="message has-text-centered is-danger m-0 p-1">
		<div class="message-body">
			<ul class="h5">
				@foreach($errors->all() as $error)
				<li>{{$error}}</li>
				@endforeach
			</ul>
		</div>
	</article>
@elseif(\Session::has('success'))
	<article class="message has-text-centered is-success">
		<div class="message-body">
			{!! \Session::get('success') !!}
		</div>
	</article>
@elseif(\Session::has('warning'))
	<article class="message has-text-centered is-warning">
		<div class="message-body">
			{!! \Session::get('warning') !!}
		</div>
	</article>
@elseif(\Session::has('error'))
	<article class="message has-text-centered is-danger">
		<div class="message-body">
			{!! \Session::get('error') !!}
		</div>
	</article>
@endif
