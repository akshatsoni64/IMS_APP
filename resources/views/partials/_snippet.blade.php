<form action="#">
    <div class="form-row mt-5">
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="customFile">
            <label class="custom-file-label" for="customFile">Choose file</label>
        </div>
    </div>
</form>

<div class="mb-3 card bg-dark text-white text-center">
    <h5 class="pt-2">
        <a class="text-white" href="{{ route('report') }}">Report</a>
    </h5>
</div>

<!-- <table class="mt-4 table table-bordered">
    <thead data-toggle="collapse" data-target="#data-sec">
        <tr class="text-center">
            @if(count($data)>0)
                @foreach($data as $row)
                    @foreach(json_decode($row, true) as $key => $value)
                        @if ($loop->first) @continue @endif
                        <th>{{ Str::title($key) }}</th>
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
        <tr class="text-center">
            @if(count($data)>0)
                @foreach($data as $row)
                    @foreach(json_decode($row, true) as $key => $value)
                        @if ($loop->first) @continue @endif
                        <th>{{ Str::title($key) }}</th>
                    @endforeach
                    @break
                @endforeach
            @else
                <th>Column Name</th>
            @endif
            <th colspan=2>Action</th>
        </tr>
    </tbody>
</table> -->