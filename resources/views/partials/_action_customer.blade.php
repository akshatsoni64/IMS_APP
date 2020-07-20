<td><button onclick="$('#edit-form{{ $row['id'] }}').submit();" class="btn btn-light">&#128395</a></td>
<form id="edit-form{{ $row['id'] }}" action="{{ route('customer.edit',$row['id']) }}" style="display: none;">
</form>
<td><button onclick="$('#delete-form{{ $row['id'] }}').submit();" class="btn btn-light">&#10134</button></td>
<form id="delete-form{{ $row['id'] }}" action="{{ route('customer.destroy',$row['id']) }}" method="POST" style="display: none;">
    @method('DELETE')    
    @csrf
</form>