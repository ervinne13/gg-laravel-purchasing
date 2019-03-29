<a action="view-po" data-id="{{$po->id}}" href="{{route('po.show', $po->id)}}">View</a>
<a action="edit-po" data-id="{{$po->id}}" href="{{route('po.edit', $po->id)}}">Edit</a>
<a action="delete-po" data-id="{{$po->id}}" href="javascript:;">Delete</a>