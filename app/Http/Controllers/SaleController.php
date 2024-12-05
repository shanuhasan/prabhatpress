<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        $sales = OrderItem::latest()->where('type', '=', OrderItem::SALE);
        $totalSalesAmount = OrderItem::where('type', '=', OrderItem::SALE);

        if (!empty($request->get('date'))) {
            $sales = $sales->whereDate('created_at', $request->get('date'));
            $totalSalesAmount = OrderItem::whereDate('created_at', $request->get('date'));
        }

        if (!empty($request->get('year'))) {
            $sales = $sales->whereYear('created_at', $request->get('year'));
            $totalSalesAmount = OrderItem::whereYear('created_at', $request->get('year'));
        } else {
            $sales = $sales->whereYear('created_at', date('Y'));
            $totalSalesAmount = OrderItem::whereYear('created_at', date('Y'));
        }

        $totalSalesAmount = $totalSalesAmount->sum('amount');
        $sales = $sales->paginate(100);

        $data['sales'] = $sales;
        $data['totalSalesAmount'] = $totalSalesAmount;
        return view('sales.index', $data);
    }

    public function create()
    {
        return view('sales.create');
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'particular' => 'required',
            'amount' => 'required',
        ]);

        if ($validator->passes()) {
            $model = new OrderItem();
            $model->particular = $request->particular;
            $model->type = OrderItem::SALE;
            $model->amount = $request->amount;
            $model->payment_method = $request->payment_method;
            if ($request->payment_method == 'Online') {
                $model->in_account = $request->in_account;
            }

            $model->updated_by = Auth::user()->id;
            $model->save();

            return redirect()->route('sale.index')->with('success', 'Sale added successfully.');
        } else {
            return Redirect::back()->withErrors($validator);
        }
    }

    public function edit($id, Request $request)
    {

        $expense = OrderItem::find($id);
        if (empty($expense)) {
            return redirect()->route('sale.index');
        }

        $data['expense'] = $expense;
        return view('sales.edit', $data);
    }

    public function update($id, Request $request)
    {

        $model = OrderItem::find($id);
        if (empty($model)) {
            return redirect()->route('sale.index')->with('error', 'Order not found.');
        }

        $validator = Validator::make($request->all(), [
            'particular' => 'required',
            'amount' => 'required',
        ]);

        if ($validator->passes()) {

            $model->type = OrderItem::SALE;
            $model->particular = $request->particular;
            $model->amount = $request->amount;
            $model->payment_method = $request->payment_method;
            if ($request->payment_method == 'Online') {
                $model->in_account = $request->in_account;
            }
            $model->updated_by = Auth::user()->id;
            $model->save();

            return redirect()->route('sale.index')->with('success', 'Sale updated successfully.');
        } else {
            return Redirect::back()->withErrors($validator);
        }
    }

    public function delete($id, Request $request)
    {
        $model = OrderItem::find($id);

        if (empty($model)) {
            $request->session()->flash('error', 'Sale not found.');
            return response()->json([
                'status' => true,
                'message' => 'Sale not found.'
            ]);
        }
        $model->delete();

        $request->session()->flash('success', 'Sale deleted successfully.');

        return response()->json([
            'status' => true,
            'message' => 'Sale deleted successfully.'
        ]);
    }
}
