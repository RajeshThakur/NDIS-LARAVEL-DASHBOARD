@extends('layouts.app')
@section('content')

<div class="content">
    
        

        {!! Form::open()->multipart(true)->method('get')->idPrefix('dm-')->route('home.form')->attrs(['class'=>'form-mt']) !!}

        <div class="row">

            {!! Form::label('emsfhshsrhrfhrhrh4eail') !!}

            {!! Form::text('username', 'Username')->size('col-sm-6') !!}
            
            {!! Form::text('email', 'Email')->size('col-sm-6')->placeholder("Your Email") !!}

            {!! Form::password('password', "Password")->size('col-sm-6') !!}

            {!! Form::location('address', 'Address')->size('col-sm-6') !!}

            {!! Form::datetime('datetime', 'Date Time')->size('col-sm-6') !!}

            {!! Form::date('date', 'Date')->size('col-sm-3') !!}

            {!! Form::time('time', 'Time')->size('col-sm-3') !!}

            {!! Form::file('image', 'Image')->size('col-sm-6')->help("asdasdad sd asdad adjkahkda") !!}

            {!! 
                Form::textarea('description', trans('global.task.fields.description'), 'My Old ' )
                ->help( trans('global.task.fields.description_helper') )
                ->attrs([ "rows"=>4, "class"=>"mytextarea" ])
            !!}

            {!! 
                Form::ajaxUpload('avatar', 'Profile Image (jQuery Required)', '/img/default-avatar.png', null, [ "input_text"=>"Browse", "button_text" => "Upload Photo" ])
                ->size('col-sm-6')
                ->help("Recommended Size 150px/150px") 
            !!}
            
            {!! Form::select('size2', 'Size2',  array('L' => 'Large', 'S' => 'Small'), 'S' )->size('col-sm-6') !!}

            {!! Form::select2('size', 'Select 2',  array('L' => 'Large', 'S' => 'Small'))->size('col-sm-6')->icon('fa fa-caret-down') !!}

            {!! Form::customSelect('size', 'Custom Select',  array('L' => 'Large', 'S' => 'Small'))->size('col-sm-6') !!}
            

            {!! Form::checkbox('name', 'value')->size('col-sm-3') !!}

            {!! Form::radio('name', 'value')->size('col-sm-3') !!}

            {!! Form::button('Button Normal', 'success', 'normal')->attrs(["class"=>"rounded"]) !!}
            {!! Form::button('Button Large', 'secondary', 'large')->attrs(["class"=>"rounded"]) !!}
            {!! Form::button('Button Flat', 'danger', 'flat') !!}

            

            {!! Form::submit('Submit')->attrs(["class"=>"rounded"]) !!}

        </div>

        {!! Form::close() !!}


    
</div>
@endsection


@section('scripts')
@parent

<script>
    $(document).ready(function() {
    
    });
</script>

@endsection