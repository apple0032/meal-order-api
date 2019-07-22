@extends('main')

@section('title', '| Login')

@section('content')
	
	<div class="row login_form">
		<div class="col-md-6 col-md-offset-3 login_box">
			{!! Form::open() !!}

				{{ Form::label('email', 'Email:') }}
				{{ Form::email('email', null, ['class' => 'form-control']) }}

				{{ Form::label('password', "Password:") }}
				{{ Form::password('password', ['class' => 'form-control']) }}
				
				<br>
				{{ Form::checkbox('remember') }}{{ Form::label('remember', "Remember Me") }}
				
				<br>
				{{ Form::submit('Login', ['class' => 'btn btn-primary btn-block btn-login']) }}

				<p><a href="{{ url('password/reset') }}">Forgot My Password</a>


			{!! Form::close() !!}
		</div>
	</div>

@endsection
@section('scripts')

@endsection