<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use View;
use Validator;
use Session;
use Redirect;
use Mail;
class OrderController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get all the orders
        $orders = Order::where([
            "created_by" => \Auth::user()->id
        ])
        ->get();

        // load the view and pass the orders
        return View::make('orders.index')
            ->with('orders', $orders);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View::make('orders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'name'       => 'required',
            'description'      => ['required', 'max:255'],
            'amount' => 'required|numeric'
        );
        $validator = Validator::make($request->all(), $rules);

        // process validation
        if ($validator->fails()) {
            return Redirect::to('orders/create')
                ->withErrors($validator);
        } else {
            // store
            $order = new Order;
            $order->name       = $request->get('name');
            $order->description      = $request->get('description');
            $order->amount = $request->get('amount');
            $order->is_active = $request->get('is_active');
            $order->created_by = \Auth::user()->id;
            $order->save();




            //Send Email
            $user = \Auth::user();
            Mail::send('emails.reminder', ['user' => $user ], function ($m) use ($user) {
                $m->from('hello@app.com', 'Order');
                $m->to(\Auth::user()->email, \Auth::user()->name)->subject('New Order Created!');
            });

            // redirect
            Session::flash('message', 'Successfully created order!');
            return Redirect::to('orders');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
          // get the order
          $order = Order::where([
            "created_by" => \Auth::user()->id
          ])->find($id);
          // show the view and pass the shark to it
          return View::make('orders.show')->with('order', $order);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
            // get the order
            $order = Order::find($id);

            // show the edit form and pass the order
            return View::make('orders.edit')
                ->with('order', $order);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'name'       => 'required',
            'description'      => 'required',
            'amount' => 'required|numeric'
        );
        $validator = Validator::make($request->all(), $rules);

        // process the validation
        if ($validator->fails()) {
            return Redirect::to('orders/' . $id . '/edit')
                ->withErrors($validator);
        } else {
            // store
            $order = Order::where([
                "created_by" => \Auth::user()->id
              ])->find($id);
            $order->name       = $request->get('name');
            $order->description      = $request->get('description');
            $order->amount = $request->get('amount');
            $order->is_active = $request->get('is_active');
            $order->created_by = \Auth::user()->id;
            $order->save();

            // redirect
            Session::flash('message', 'Successfully updated order!');
            return Redirect::to('orders');
        }
    }

 
    public function destroy($id)
    {
        // delete
        $order = Order::find($id);
        $order->delete();

        // redirect
        Session::flash('message', 'Successfully deleted the order!');
        return Redirect::to('orders');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteOrder($id)
    {
        $order = Order::where([
            "created_by" => \Auth::user()->id
        ])->findOrFail($id);
        if($order){
            $order->delete(); 
        }
        else{
            return response()->json([
                "status_code" => 1,
                "message" > "Unable to find the order!"
            ]);
        }
        return response()->json([
            "status_code" => 0,
            "message" => "Successfully deleted the order!"
        ]); 
    }
}
