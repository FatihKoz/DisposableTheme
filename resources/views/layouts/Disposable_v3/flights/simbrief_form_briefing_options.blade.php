<div class="card mb-2">
  <div class="card-header p-1">
    <h5 class="m-1">
      Briefing Package Options
      <i class="fas fa-file-pdf float-end"></i>
    </h5>
  </div>
  <div class="card-body p-1 form-group">
    <div class="input-group input-group-sm">
      <span class="input-group-text col-md-5">OFP Units</span>
      <select id="ofp_weights" name="units" class="form-select" onchange="ConvertWeights()">
        @if($units['weight'] === 'kg')
          <option value="KGS" selected>KGS</option>
          <option value="LBS">LBS</option>
        @else
          <option value="KGS">KGS</option>
          <option value="LBS" selected>LBS</option>
        @endif
      </select>
    </div>
    @if($layouts)
      <div class="input-group input-group-sm">
        <span class="input-group-text col-md-5">OFP Format</span>
        <select name="planformat" class="form-select">
          @foreach($layouts as $ofp)
            <option value="{{ $ofp->id }}" @if(strtoupper($ofp->id) == $flight->airline->icao) selected @elseif($ofp->id === 'lido') selected @endif>{{ $ofp->name_long }}</option>
          @endforeach
        </select>
      </div>
    @endif
    <div class="input-group input-group-sm">
      <span class="input-group-text col-md-5">Navigation Log</span>
      <select name="navlog" class="form-select" readonly>
        <option value="0">Disabled</option>
        <option value="1" selected>Enabled</option>
      </select>
    </div>
    <div class="input-group input-group-sm">
      <span class="input-group-text col-md-5">Runway Analysis (TLR)</span>
      <select name="tlr" class="form-select">
        <option value="0">Disabled</option>
        <option value="1" selected>Enabled</option>
      </select>
    </div>
    <div class="input-group input-group-sm">
      <span class="input-group-text col-md-5">NOTAMs (Airport)</span>
      <select name="notams" class="form-select">
        <option value="0">Disabled</option>
        <option value="1" selected>Enabled</option>
      </select>
    </div>
    <div class="input-group input-group-sm">
      <span class="input-group-text col-md-5">NOTAMs (FIR)</span>
      <select name="firnot" class="form-select">
        <option value="0" selected>Disabled</option>
        <option value="1">Enabled</option>
      </select>
    </div>
    <div class="input-group input-group-sm">
      <span class="input-group-text col-md-5">Maps</span>
      <select name="maps" class="form-select">
        <option value="detail" selected>Detailed</option>
        <option value="simple">Simple</option>
        <option value="none">None</option>
      </select>
    </div>
  </div>
</div>