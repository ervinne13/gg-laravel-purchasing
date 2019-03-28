@extends('layout.default')

@section('content')
<form action="{{$action}}" method="POST">

    @if ($method === 'PUT')
    {{ method_field('PUT') }}
    @endif

    {{csrf_field()}}
    <div class="form-group">
        <label>Buyer</label>
        <input name="buyer" value="{{$po->buyer}}" type="text" class="form-control" placeholder="The name of the creator of this PO">        
    </div>
    <div class="form-group">
        <label>Supplier</label>
        <input name="supplier" value="{{$po->supplier}}" type="text" class="form-control" placeholder="The supplier we will buy from">        
    </div>
    <div class="form-group">
        <label>Total Cost</label>
        <input name="total_cost" value="{{$po->total_cost}}" type="text" class="form-control">        
    </div>
    <div class="form-group">
        <label>Breakdown</label>
        <textarea name="breakdown" type="text" class="form-control">{{$po->breakdown}}</textarea>
    </div>
    <div class="form-group">
        <label>Purpose</label>
        <textarea name="purpose" type="text" class="form-control">{{$po->breakdown}}</textarea>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection