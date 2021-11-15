<tr>
  <td>
    <div class="input-group input-group-sm">
      <span class="input-group-text col-4">
        {{ $field->name }}
        @if($field->required === true)
          <span class="fw-bold text-danger mx-1">*</span>
        @endif
      </span>
      @if(!$field->read_only)
        {{ Form::text($field->slug, $field->value, ['class' => 'form-control', 'readonly' => (!empty($pirep) && $pirep->read_only)]) }}
      @else
        {{ $field->value }}
      @endif
    </div>
  </td>
</tr>
