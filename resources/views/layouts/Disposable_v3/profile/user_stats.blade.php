{{-- Last 15 Days --}}
<div class="row row-cols-2">
  <div class="col-md">
    @widget('DBasic::PersonalStats', ['disp' => 'full', 'user' => $user->id, 'type' => 'totflight', 'period' => 15])
  </div>
  <div class="col-md">
    @widget('DBasic::PersonalStats', ['disp' => 'full', 'user' => $user->id, 'type' => 'avgtime', 'period' => 15])
  </div>
  <div class="col-md">
    @widget('DBasic::PersonalStats', ['disp' => 'full', 'user' => $user->id, 'type' => 'avgdistance', 'period' => 15])
  </div>
  <div class="col-md">
    @widget('DBasic::PersonalStats', ['disp' => 'full', 'user' => $user->id, 'type' => 'avgfuel', 'period' => 15])
  </div>
  <div class="col-md">
    @widget('DBasic::PersonalStats', ['disp' => 'full', 'user' => $user->id, 'type' => 'avglanding', 'period' => 15])
  </div>
  @if(Theme::getSetting('gen_stable_approach') && DB_SapReports($user->id))
    <div class="col-md">
      @widget('DBasic::PersonalStats', ['disp' => 'full', 'user' => $user->id, 'type' => 'fdm', 'period' => 15])
    </div>
  @endif
  <div class="col-md">
    @widget('DBasic::PersonalStats', ['disp' => 'full', 'user' => $user->id, 'type' => 'avgscore', 'period' => 15])
  </div>
</div>
<hr>
{{-- Monthly Stats --}}
<div class="row row-cols-2">
  <div class="col-md">
    @widget('DBasic::PersonalStats', ['disp' => 'full', 'user' => $user->id, 'type' => 'totflight', 'period' => 'currentm'])
    @widget('DBasic::PersonalStats', ['disp' => 'full', 'user' => $user->id, 'type' => 'totflight', 'period' => 'lastm'])
    @widget('DBasic::PersonalStats', ['disp' => 'full', 'user' => $user->id, 'type' => 'totflight', 'period' => 'prevm'])
  </div>
  @if($DSpecial)
    <div class="col-md">
      @widget('DBasic::PersonalStats', ['disp' => 'full', 'user' => $user->id, 'type' => 'assignment', 'period' => 'currentm'])
      @widget('DBasic::PersonalStats', ['disp' => 'full', 'user' => $user->id, 'type' => 'assignment', 'period' => 'lastm'])
      @widget('DBasic::PersonalStats', ['disp' => 'full', 'user' => $user->id, 'type' => 'assignment', 'period' => 'prevm'])
    </div>
  @endif
  <div class="col-md">
    @widget('DBasic::PersonalStats', ['disp' => 'full', 'user' => $user->id, 'type' => 'tottime', 'period' => 'currentm'])
    @widget('DBasic::PersonalStats', ['disp' => 'full', 'user' => $user->id, 'type' => 'tottime', 'period' => 'lastm'])
    @widget('DBasic::PersonalStats', ['disp' => 'full', 'user' => $user->id, 'type' => 'tottime', 'period' => 'prevm'])
  </div>
  <div class="col-md">
    @widget('DBasic::PersonalStats', ['disp' => 'full', 'user' => $user->id, 'type' => 'totdistance', 'period' => 'currentm'])
    @widget('DBasic::PersonalStats', ['disp' => 'full', 'user' => $user->id, 'type' => 'totdistance', 'period' => 'lastm'])
    @widget('DBasic::PersonalStats', ['disp' => 'full', 'user' => $user->id, 'type' => 'totdistance', 'period' => 'prevm'])
  </div>
  <div class="col-md">
    @widget('DBasic::PersonalStats', ['disp' => 'full', 'user' => $user->id, 'type' => 'totfuel', 'period' => 'currentm'])
    @widget('DBasic::PersonalStats', ['disp' => 'full', 'user' => $user->id, 'type' => 'totfuel', 'period' => 'lastm'])
    @widget('DBasic::PersonalStats', ['disp' => 'full', 'user' => $user->id, 'type' => 'totfuel', 'period' => 'prevm'])
  </div>
  <div class="col-md">
    @widget('DBasic::PersonalStats', ['disp' => 'full', 'user' => $user->id, 'type' => 'avglanding', 'period' => 'currentm'])
    @widget('DBasic::PersonalStats', ['disp' => 'full', 'user' => $user->id, 'type' => 'avglanding', 'period' => 'lastm'])
    @widget('DBasic::PersonalStats', ['disp' => 'full', 'user' => $user->id, 'type' => 'avglanding', 'period' => 'prevm'])
  </div>
  @if(Theme::getSetting('gen_stable_approach') && DB_SapReports($user->id))
    <div class="col-md">
      @widget('DBasic::PersonalStats', ['disp' => 'full', 'user' => $user->id, 'type' => 'fdm', 'period' => 'currentm'])
      @widget('DBasic::PersonalStats', ['disp' => 'full', 'user' => $user->id, 'type' => 'fdm', 'period' => 'lastm'])
      @widget('DBasic::PersonalStats', ['disp' => 'full', 'user' => $user->id, 'type' => 'fdm', 'period' => 'prevm'])
    </div>
  @endif
  <div class="col-md">
    @widget('DBasic::PersonalStats', ['disp' => 'full', 'user' => $user->id, 'type' => 'avgscore', 'period' => 'currentm'])
    @widget('DBasic::PersonalStats', ['disp' => 'full', 'user' => $user->id, 'type' => 'avgscore', 'period' => 'lastm'])
    @widget('DBasic::PersonalStats', ['disp' => 'full', 'user' => $user->id, 'type' => 'avgscore', 'period' => 'prevm'])
  </div>
</div>
