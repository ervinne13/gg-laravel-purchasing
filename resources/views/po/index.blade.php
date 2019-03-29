@extends('adminlte::page')

@section('title', 'Purchase Orders | Listing')

@section('js')
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
<script src="/vendor/datatables/buttons.server-side.js"></script>
{!! $dataTable->scripts() !!}

<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function () {
    initializeEvents();
});

function initializeEvents() {
    document.addEventListener('click',function(e){
        if(e.target && e.target.getAttribute('action') === 'delete-po'){
            const poId = e.target.getAttribute('data-id');
            deletePurchaseOrderWithId(poId);
        }
    });
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
@stop

@section('content')
{!! $dataTable->table() !!}
@endsection