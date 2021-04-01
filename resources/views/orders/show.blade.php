@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Order Detail') }}</div>

                <div class="card-body">

                        <div class="form-group">
                            <label for="name">Name</label>
                            <p>{{ $order->name }}</p>
                        </div>

                        <div class="form-group">
                            <label for="name">Description</label>
                            <p{!!  $order->description !!}</p>
                        </div>

                        <div class="form-group">
                            <label for="name">Amount</label>
                            <p>{{ $order->amount }}</p>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
