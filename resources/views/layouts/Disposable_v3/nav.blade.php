{{-- Generic Style Settings For Navbar / SideBar --}}
@php
  // Check Disposable Module Presence
  $DBasic = isset($DBasic) ? $DBasic : check_module('DisposableBasic');
  $DSpecial = isset($DSpecial) ? $DSpecial : check_module('DisposableSpecial');
  // Style differences between navbar and sidebar
  if (Theme::getSetting('gen_sidebar')) {
    $icon_style = "float-end m-1 me-0";
    $border = "border-0";
  } else {
    $icon_style = "float-start m-1 me-2";
    $border = null;
  }
  // Get Authorized User
  $user = Auth::user();
@endphp
{{-- Include Either Sidebar or Classic Navbar --}}
@if(Theme::getSetting('gen_sidebar'))
  @include('nav_side')
@else
  @include('nav_top')
@endif