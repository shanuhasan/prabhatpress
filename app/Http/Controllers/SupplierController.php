<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\SupplierItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $suppliers = Supplier::where('status', 1)->latest();

        if (!empty($request->get('keyword'))) {
            $suppliers = $suppliers->where('name', 'like', '%' . $request->get('keyword') . '%');
        }

        $suppliers = $suppliers->paginate(100);

        return view('supplier.index', [
            'suppliers' => $suppliers
        ]);
    }

    public function create()
    {
        return view('supplier.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'phone' => 'required|numeric|min:10|unique:suppliers',
        ]);

        if ($validator->passes()) {
            $model = new Supplier();
            $model->guid = GUIDv4();
            $model->name = $request->name;
            $model->email = $request->email;
            $model->phone = $request->phone;
            $model->company = $request->company;
            $model->address = $request->address;
            $model->status = 1;
            $model->save();

            return redirect()->route('supplier.index')->with('success', 'Supplier added successfully.');
        } else {
            return Redirect::back()->withErrors($validator);
        }
    }

    public function edit($guid, Request $request)
    {
        $supplier = Supplier::findByGuid($guid);
        if (empty($supplier)) {
            return redirect()->route('supplier.index');
        }

        return view('supplier.edit', compact('supplier'));
    }

    public function update($guid, Request $request)
    {

        $model = Supplier::findByGuid($guid);
        if (empty($model)) {
            return redirect()->back()->with('error', 'Supplier not found.');
        }

        $validator = Validator::make($request->all(), [
            // 'email'=>'required|email|unique:users,email,'.$id.',id',
            'name' => 'required|min:3',
            'phone' => 'required|numeric|min:10|unique:suppliers,phone,' . $guid . ',guid',
        ]);

        if ($validator->passes()) {

            $model->name = $request->name;
            $model->phone = $request->phone;
            $model->email = $request->email;
            $model->company = $request->company;
            $model->address = $request->address;
            $model->save();
            return redirect()->route('supplier.index')->with('success', 'Supplier updated successfully.');
        } else {
            return Redirect::back()->withErrors($validator);
        }
    }

    public function destroy($guid, Request $request)
    {
        $model = Supplier::findByGuid($guid);

        if (empty($model)) {
            $request->session()->flash('error', 'Supplier not found.');
            return response()->json([
                'status' => true,
                'message' => 'Supplier not found.'
            ]);
        }

        $model->status = 0;
        $model->save();
        // $model->delete();

        $request->session()->flash('success', 'Supplier deleted successfully.');

        return response()->json([
            'status' => true,
            'message' => 'Supplier deleted successfully.'
        ]);
    }

    public function items($guid)
    {
        $supplier = Supplier::findByGuid($guid);
        if (empty($supplier)) {
            return Redirect::back();
        }
        $items = SupplierItem::where('supplier_id', $supplier->id)->paginate(50);
        $data['items'] = $items;
        $data['supplierId'] = $supplier->id;
        $data['supplier'] = $supplier;
        return view('supplier.item', $data);
    }

    public function itemCreate($guid)
    {
        $supplier = Supplier::findByGuid($guid);
        if (empty($supplier)) {
            return redirect()->back();
        }
        return view('supplier.item-create', compact('supplier'));
    }

    public function itemStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'supplier_id' => 'required',
            'type' => 'required',
            'particular' => 'required',
            'qty' => 'required',
            'size_1' => 'required',
            'size_2' => 'required',
            'size_3' => 'required',
            'rate' => 'required',
            'amount' => 'required',
        ]);

        if ($validator->passes()) {
            $model = new SupplierItem();
            $model->guid = GUIDv4();
            $model->supplier_id = $request->supplier_id;
            $model->type = $request->type;
            $model->particular = $request->particular;
            $model->qty = $request->qty;
            $model->size_1 = $request->size_1;
            $model->size_2 = $request->size_2;
            $model->size_3 = $request->size_3;
            $model->rate = $request->rate;
            $model->amount = $request->amount;
            $model->save();

            return redirect()->route('supplier.item', $request->guid)->with('success', 'Item has been created successfully.');
        } else {
            return Redirect::back()->withErrors($validator);
        }
    }

    public function itemEdit($guid, $itemGuid)
    {
        if (empty($guid) || empty($itemGuid)) {
            return redirect()->back();
        }

        $supplier = Supplier::findByGuid($guid);
        if (empty($supplier)) {
            return redirect()->back();
        }

        $item = SupplierItem::where('guid', $itemGuid)
            ->where('supplier_id', $supplier->id)
            ->first();

        if (empty($item)) {
            return redirect()->route('supplier.index');
        }

        $data['item'] = $item;
        $data['supplier'] = $supplier;

        return view('supplier.item-edit', $data);
    }

    public function itemUpdate($guid, Request $request)
    {
        $model = SupplierItem::findByGuid($guid);

        if (empty($model)) {
            return redirect()->route('supplier.index')->with('error', 'Item not found.');
        }

        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'particular' => 'required',
            'qty' => 'required',
            'size_1' => 'required',
            'size_2' => 'required',
            'size_3' => 'required',
            'rate' => 'required',
            'amount' => 'required',
        ]);

        if ($validator->passes()) {

            $model->type = $request->type;
            $model->particular = $request->particular;
            $model->qty = $request->qty;
            $model->size_1 = $request->size_1;
            $model->size_2 = $request->size_2;
            $model->size_3 = $request->size_3;
            $model->rate = $request->rate;
            $model->amount = $request->amount;
            $model->save();

            return redirect()->route('supplier.item', $request->guid)->with('success', 'Item updated successfully.');
        } else {
            return Redirect::back()->withErrors($validator);
        }
    }

    public function itemDelete($guid, Request $request)
    {
        $model = SupplierItem::findByGuid($guid);

        if (empty($model)) {
            $request->session()->flash('error', 'Item not found.');
            return response()->json([
                'status' => true,
                'message' => 'Order not found.'
            ]);
        }

        $model->delete();

        $request->session()->flash('success', 'Item deleted successfully.');

        return response()->json([
            'status' => true,
            'message' => 'Item deleted successfully.'
        ]);
    }
}
