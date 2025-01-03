<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $expenses = Expense::latest();
        $totalExpensesAmount = Expense::latest();

        if (!empty($request->get('date'))) {
            $expenses = $expenses->whereDate('created_at', $request->get('date'));
            $totalExpensesAmount = Expense::whereDate('created_at', $request->get('date'));
        }

        if (!empty($request->get('year'))) {
            $expenses = $expenses->whereYear('created_at', $request->get('year'));
            $totalExpensesAmount = Expense::whereYear('created_at', $request->get('year'));
        } else {
            $expenses = $expenses->whereYear('created_at', date('Y'));
            $totalExpensesAmount = Expense::whereYear('created_at', date('Y'));
        }

        if (!empty($request->get('type'))) {
            $expenses = $expenses->where('type', $request->get('type'));
            $totalExpensesAmount = Expense::where('type', $request->get('type'));
        }

        $totalExpensesAmount = $totalExpensesAmount->sum('amount');

        $expenses = $expenses->paginate(100);

        $data['expenses'] = $expenses;
        $data['totalExpensesAmount'] = $totalExpensesAmount;
        return view('expenses.index', $data);
    }

    public function create()
    {
        return view('expenses.create');
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'particular' => 'required',
            'amount' => 'required',
        ]);

        if ($validator->passes()) {
            $model = new Expense();
            $model->particular = $request->particular;
            $model->amount = $request->amount;
            $model->type = $request->type;
            $model->payment_method = $request->payment_method;
            if ($request->payment_method == 'Online') {
                $model->from_account = $request->from_account;
            }

            $model->created_by = Auth::user()->id;
            $model->save();

            return redirect()->route('expenses.index')->with('success', 'Expense added successfully.');
        } else {
            return Redirect::back()->withErrors($validator);
        }
    }

    public function edit($id, Request $request)
    {

        $expense = Expense::find($id);
        if (empty($expense)) {
            return redirect()->route('expenses.index');
        }

        $data['expense'] = $expense;
        return view('expenses.edit', $data);
    }

    public function update($id, Request $request)
    {

        $model = Expense::find($id);
        if (empty($model)) {
            return redirect()->route('expenses.index')->with('error', 'Order not found.');
        }

        $validator = Validator::make($request->all(), [
            'particular' => 'required',
            'amount' => 'required',
        ]);

        if ($validator->passes()) {

            $model->particular = $request->particular;
            $model->amount = $request->amount;
            $model->type = $request->type;
            $model->payment_method = $request->payment_method;
            if ($request->payment_method == 'Online') {
                $model->from_account = $request->from_account;
            }
            $model->created_by = Auth::user()->id;
            $model->save();

            return redirect()->route('expenses.index')->with('success', 'Expense updated successfully.');
        } else {
            return Redirect::back()->withErrors($validator);
        }
    }

    public function delete($id, Request $request)
    {
        $model = Expense::find($id);

        if (empty($model)) {
            $request->session()->flash('error', 'Expense not found.');
            return response()->json([
                'status' => true,
                'message' => 'Expense not found.'
            ]);
        }
        $model->delete();

        $request->session()->flash('success', 'Expense deleted successfully.');

        return response()->json([
            'status' => true,
            'message' => 'Expense deleted successfully.'
        ]);
    }
}
