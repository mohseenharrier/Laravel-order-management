@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Order Detail') }}</div>

                <div class="card-body">
                    <!-- if there are creation errors, they will show here -->
                    {{ HTML::ul($errors->all()) }}

                    {{ Form::model($order, array('route' => array('orders.update', $order->id), 'method' => 'PUT')) }}

                        <div class="form-group">
                            {{ Form::label('name', 'Name') }}
                            {{ Form::text('name', Request::old('name'), array('class' => 'form-control')) }}
                        </div>

                        <div class="form-group">
                            {{ Form::label('description', 'Description') }}
                            {{ Form::textarea('description', Request::old('description'), array('class' => 'form-control')) }}
                        </div>

                        <div class="form-group">
                            {{ Form::label('amount', 'Amount') }}
                            {{ Form::text('amount', Request::old('amount'), array('class' => 'form-control')) }}
                        </div>

                        <div class="form-group">
                            {{ Form::label('is_active', 'Status') }}
                            {{ Form::select('is_active', array('0' => 'Active', '1' => 'Inactive'), Request::old('is_active'), array('class' => 'form-control')) }}
                        </div>


                        {{ Form::submit('Update', array('class' => 'btn btn-primary')) }}

                    {{ Form::close() }}
            
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
