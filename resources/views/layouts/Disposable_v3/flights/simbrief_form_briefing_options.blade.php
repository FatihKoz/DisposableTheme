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
      <select id="ofp_weights" name="units" class="form-control" onchange="ConvertWeights()">
        @if($units['weight'] === 'kg')
          <option value="KGS" selected>KGS</option>
          <option value="LBS">LBS</option>
        @else
          <option value="KGS">KGS</option>
          <option value="LBS" selected>LBS</option>
        @endif
      </select>
    </div>
    <div class="input-group input-group-sm">
      <span class="input-group-text col-md-5">OFP Format</span>
      <select name="planformat" class="form-control">
        <option value="lido" selected>LIDO (SimBrief Default)</option>
        <option value="aal" >American Airlines</option>
        <option value="aca" >Air Canada</option>
        <option value="afr" >Air France (2012)</option>
        <option value="afr2017" >Air France (2017)</option>
        <option value="awe" >US Airways</option>
        <option value="baw" >British Airways</option>
        <option value="ber" >Air Berlin</option>
        <option value="dal" >Delta Air Lines</option>
        <option value="dlh" >Lufthansa</option>
        <option value="ein" >Aer Lingus</option>
        <option value="etd" >Etihad Airways</option>
        <option value="ezy" >easyJet</option>
        <option value="gwi" >Germanwings</option>
        <option value="jbu" >JetBlue Airways</option>
        <option value="jza" >Jazz Aviation</option>
        <option value="klm" >KLM Royal Dutch Airlines</option>
        <option value="qfa" >Qantas</option>
        <option value="ryr" >Ryanair</option>
        <option value="swa" >Southwest Airlines</option>
        <option value="thy" >Turkish Airlines</option>
        <option value="uae" >Emirates Airline</option>
        <option value="ual" >United Airlines (2012)</option>
        <option value="ual f:wz" >United Airlines (2018)</option>
      </select>
    </div>
    <div class="input-group input-group-sm">
      <span class="input-group-text col-md-5">Navigation Log</span>
      <select name="navlog" class="form-control">
        <option value="0">Disabled</option>
        <option value="1" selected>Enabled</option>
      </select>
    </div>
    <div class="input-group input-group-sm">
      <span class="input-group-text col-md-5">Runway Analysis (TLR)</span>
      <select name="tlr" class="form-control">
        <option value="0">Disabled</option>
        <option value="1" selected>Enabled</option>
      </select>
    </div>
    <div class="input-group input-group-sm">
      <span class="input-group-text col-md-5">NOTAMs (Airport)</span>
      <select name="notams" class="form-control">
        <option value="0">Disabled</option>
        <option value="1" selected>Enabled</option>
      </select>
    </div>
    <div class="input-group input-group-sm">
      <span class="input-group-text col-md-5">NOTAMs (FIR)</span>
      <select name="firnot" class="form-control">
        <option value="0" selected>Disabled</option>
        <option value="1">Enabled</option>
      </select>
    </div>
    <div class="input-group input-group-sm">
      <span class="input-group-text col-md-5">Maps</span>
      <select name="maps" class="form-control">
        <option value="detail" selected>Detailed</option>
        <option value="simple">Simple</option>
        <option value="none">None</option>
      </select>
    </div>
  </div>
</div>