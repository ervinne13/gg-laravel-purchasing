<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use Illuminate\Support\Facades\Log;
use App\DataTables\PurchaseOrderDataTable;
use App\Http\Requests\SavePurchaseOrderRequest;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PurchaseOrderDataTable $dataTable)
    {
        return $dataTable->render('po.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('po.form', [
            'po'        => new PurchaseOrder(),
            'action'    => route('po.store'),
            'method'    => 'POST',
            'title'     => 'Create'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SavePurchaseOrderRequest $request)
    {
        $po = new PurchaseOrder();
        $po->fill($request->toArray());
        $po->save();

        return redirect()->route('po.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $po = PurchaseOrder::findOrFail($id);
        return view('po.view', ['po' => $po]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $po = PurchaseOrder::findOrFail($id);
        return view('po.form', [
            'po'        => $po,
            'action'    => route('po.update', $id),
            'method'    => 'PUT',
            'title'     => 'Edit'
        ]);
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
        Log::info('updating');
        $po = PurchaseOrder::findOrFail($id);
        $po->fill($request->toArray());
        $po->save();

        Log::info('updated');
        Log::info($po);

        return redirect()->route('po.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $po = PurchaseOrder::findOrFail($id);
        $po->delete();
    }
}
