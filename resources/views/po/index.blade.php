@extends('layout.default')

@section('content')
<table class="table">
    <thead>
        <tr>
            <th>Buyer</th>
            <th>Supplier</th>
            <th>Purpose</th>
            <th>Actions</th>
        <tr>
    </thead>
    <tbody>
        @foreach($poList as $po)
        <tr>
            <td>{{$po->buyer}}</td>
            <td>{{$po->supplier}}</td>
            <td>{{$po->purpose}}</td>
            <td>View Edit Delete</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection