<tr>
  <td>
    <div class="input-group input-group-sm">
      <span class="input-group-text col-lg-4">
        {{ $field->name }}
        @if($field->required === true)
          <span class="fw-bold text-danger mx-1">*</span>
        @endif
      </span>
      @if(!$field->read_only)
        <input class="form-control" type="text" name="{{ $field->slug }}" value="{{ $field->value }}" @if(!empty($pirep) && $pirep->read_only) readonly @endif >
      @else
        {{ $field->value }}
      @endif
    </div>
  </td>
</tr>
