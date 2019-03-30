@extends('adminlte::page')

@section('title', 'Purchase Orders | View')

@section('content')

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Monthly Recap Report</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <p>
            <b>Buyer:</b> <label>{{$po->buyer}}</label>
        </p>
        <p>
            <b>Supplier:</b> <label>{{$po->supplier}}</label>
        </p>
        <p>
            <b>Total Cost:</b> <label>P{{number_format($po->total_cost)}}</label>
        </p>

        <hr />

        <b>Breakdown:</b>
        <br />
        {{$po->breakdown}}

        <hr />

        <b>Purpose:</b>
        <br />
        {{$po->purpose}}
    </div>
</div>

@endsection 