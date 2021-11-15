<form action="{{ isset($floor)? route('floors.update',$floor->id) : '' }}" class="" method="POST">
    @csrf
    <div class="form-row">
      <div class="form-group col-md-6">
        <label>Floor No</label>
      <div class="input-group">
      <div class="input-group-prepend">
      </div>
        <input type="text"  id="floor_number" value="{{ isset($floor)? $floor->number : '' }}" name="floor_number" class="form-control">
      </div>
    </div>

      <div class="form-group col-md-6">
        <label>Floor Type</label>
        <select class="form-control" name="floor_type">
            @foreach ($floor_types as $floor_type)
                <option value="{{ $floor_type->floor_type_code }} {{ (isset($floor) && ($floor_type->floor_type_code == $floor->floor_type_code)) ? 'selected' : '' }}">{{ $floor_type->floor_type_name }}</option>
            @endforeach
        </select>
    </div>
    </div>
    <button type="submit" class="btn btn-primary m-t-15 waves-effect">save</button>
</form>
