<td><button class="btn btn-light">&#128395</button></td>
<td><a href="{{ route('transaction.destroy',$row['id']) }}" onclick="event.preventDefault();
                    document.getElementById('delete-form').submit();" class="btn btn-light">&#10134</a></td>
<form id="delete-form" action="{{ route('transaction.destroy',$row['id']) }}" method="POST" style="display: none;">
    @method('DELETE')    
    @csrf
    <input type="hidden" name="id" value="{{ $row['id'] }}">
</form>