@extends('layout.default')

@section('content')

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

@endsection 