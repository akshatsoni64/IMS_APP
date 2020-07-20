<table class="mt-4 table table-bordered">
    <thead>
    <!-- <thead data-toggle="collapse" data-target="#data-sec" style="cursor:pointer"> -->
        <tr class="text-center">
            @if(count($data)>0)
                @foreach($data as $row)
                    @foreach(json_decode($row, true) as $key => $value)
                        @if ($loop->first) @continue @endif
                        <th>{{ $key }}</th>
                    @endforeach
                    @break
                @endforeach
            @else
                <th>Column Name</th>
            @endif
            <th colspan=2>Action</th>
        </tr>
    </thead>
    <tbody>
    <!-- <tbody id="data-sec" class="collapse"> -->
        @foreach($data as $row)
            <tr class="text-center">
                @foreach(json_decode($row, true) as $key => $value)
                    @if ($loop->first) @continue @endif
                    <td>{{ $value }}</td>
                @endforeach

                @php($route=Request::route()->getName())
                @php( $value=explode('.',$route)[0] )                             
                <td>
                    <button onclick="$('#edit-form{{ $row['id'] }}').submit();" class="btn btn-light">
                        <i class="fa fa-edit text-primary" style="font-size:24px"></i>
                        <!-- &#128395 -->
                    </button>
                </td>
                <form id="edit-form{{ $row['id'] }}" action="{{ route($value.'.edit',$row['id']) }}" style="display: none;">
                </form>
                <td>
                    <button id="{{ 'delete-'.$value.'-'.$row['id'] }}" class="delete_button btn btn-light" class="btn btn-light">
                        <!-- data-toggle="modal" data-target="#confirmation-form"  -->
                        <i class="fa fa-trash-o text-danger" style="font-size:24px"></i>
                        <!-- &#10134 -->
                    </button>                    
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="modal fade" id="confirmation-form">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body">
                <form id="" class="delete_form" method="POST">
                    @method('DELETE')    
                    @csrf
                    <center><p>Are you sure?</p></center>
                    <div class="form-group d-flex justify-content-center">
                        <input type="submit" class="btn btn-success" value="Yes">
                        <button type="button" onclick="$('#confirmation-form').modal('toggle')" class=" ml-4 btn btn-danger">No</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>