@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Orders') }}</div>

                <div class="card-body">
                    @if (session('message'))
                        <div class="alert alert-success" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif

                    <div class="col-md-12" style="float:right; bottom:12px;">
                        <a href="{{ URL::to('orders/create') }}" class="btn btn-lg btn-primary" style="float:right;">New Order</a>
                    </div>

                    <table class="table table-striped table-bordered" id="myTable">
                            <thead>
                                <tr>
                                    <td>ID</td>
                                    <td>Name</td>
                                    <td>Description</td>
                                    <td>Amount</td>
                                    <td>Actions</td>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $key => $value)
                                <tr id="order_{{ $value->id }}">
                                    <td>{{ $value->id }}</td>
                                    <td>{{ $value->name }}</td>
                                    <td>{!!  $value->description !!}</td>
                                    <td>{{ $value->amount }}</td>

                                    <td>
                                        <a class="btn btn-small btn-success" href="{{ URL::to('orders/' . $value->id) }}">View</a>              
                                        <a class="btn btn-small btn-info" href="{{ URL::to('orders/' . $value->id . '/edit') }}">Edit</a>
                                        <a href="" class="button button-delete btn btn-small btn-danger" data-id="{{$value->id}}">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
