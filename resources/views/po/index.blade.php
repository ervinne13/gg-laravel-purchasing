@extends('layout.default')

@section('content')
<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function () {
    initializeEvents();
});

function initializeEvents() {
    const deleteActions = document.querySelector('[action=delete-po]')

    if (deleteActions) {
        deleteActions.addEventListener('click', function(el) {
            const poId = this.getAttribute('data-id');
            deletePurchaseOrderWithId(poId);
        });
    }
}

function deletePurchaseOrderWithId(poId) {
    const url = `/po/${poId}`;
    axios.delete(url)
        .then((response) => {
            console.log(response);
            window.location.reload();
        });
}
</script>
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
            <td>
                <a action="view-po" data-id="{{$po->id}}" href="{{route('po.show', $po->id)}}">View</a>
                <a action="edit-po" data-id="{{$po->id}}" href="{{route('po.edit', $po->id)}}">Edit</a>
                <a action="delete-po" data-id="{{$po->id}}" href="javascript:;">Delete</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection