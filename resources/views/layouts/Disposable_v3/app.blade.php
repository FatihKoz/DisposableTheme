<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport'/>
    <title>@yield('title') | {{ config('app.name') }}</title>
    {{-- Start of required lines block. DON'T REMOVE THESE LINES! They're required or might break things --}}
    <meta name="base-url" content="{!! url('') !!}">
    <meta name="api-key" content="{!! Auth::check() ? Auth::user()->api_key: '' !!}">
    <meta name="csrf-token" content="{!! csrf_token() !!}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lato:wght@400;800">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/1310cf8385.js" crossorigin="anonymous"></script>
    <link href="{{ public_asset('/assets/global/css/vendor.css') }}" rel="stylesheet"/>
    <link href="{{ public_asset('/disposable/stylesheet/theme_v3.css') }}" rel="stylesheet"/>
    @if(Theme::getSetting('gen_darkmode'))
      <link href="{{ public_asset('/disposable/stylesheet/theme_v3_darkmode.css') }}" rel="stylesheet"/>
    @endif
    @yield('scripts_head')
    @yield('css')
    {{-- End of the required stuff in the head block --}}
  </head>
  @if(isset($plain))
    <body id="page-container" style="background-color: transparent; background-image: none;">
  @else
    <body id="page-container" @if(!Theme::getSetting('gen_background_img')) style="background-image: none;" @endif>
  @endif
    {{-- Theme Helpers --}}
      @include('theme_helpers')
      @php
        $DBasic = isset($DBasic) ? $DBasic : DT_CheckModule('DisposableBasic');
        $DSpecial = isset($DSpecial) ? $DSpecial : DT_CheckModule('DisposableSpecial');
      @endphp

    {{-- Navigation --}}
      @if(empty($disable_nav))
        @if(Theme::getSetting('gen_sidebar'))
          @include('nav_side')
        @else
          @include('nav_top')
        @endif
      @endif

    {{-- Page Contents --}}
      <div id="page-contents" class="container-fluid">
        @include('flash.message')
        @yield('content')

        {{-- Fixed position logos for IVAO and VATSIM, links are not possible --}}
        @if(Theme::getSetting('gen_ivao_logo'))
          <div class="card col-1 shadow-none bg-transparent border-0" style="position: absolute; bottom: 2rem; left: 2rem; z-index: -1;">
            @if(filled(Theme::getSetting('gen_ivao_vaid')))
              <img class="card-img" src="{{ public_asset('disposable/logo_ivao_partner.svg') }}">
            @else
              <img class="card-img" src="{{ public_asset('disposable/logo_ivao_main.png') }}">
            @endif
          </div>
        @endif
        @if(Theme::getSetting('gen_vatsim_logo'))
          <div class="card col-1 shadow-none bg-transparent border-0" style="position: absolute; bottom: 2rem; right: 2rem; z-index: -1;">
            <img class="card-img" src="{{ public_asset('disposable/logo_vatsim.png') }}">
          </div>
        @endif
      </div>

    {{-- Footer --}}
      <div id="footer" class="container-fluid">
        <div class="card my-1 px-1">
          <div class="row row-cols-3">
            <div class="col text-start">
              &copy; @if(setting('general.start_date')->format('Y') != date('Y')) {{ setting('general.start_date')->format('Y') }} - @endif {{ date('Y').' '.config('app.name') }}
              @if(Theme::getSetting('gen_discord_invite') != '')
                &nbsp;|&nbsp;<a href="https://discord.gg/{{ Theme::getSetting('gen_discord_invite') }}" target="_blank"><i class="fab fa-discord mx-1"></i>Join Our Discord Server</a>
              @endif
            </div>
            <div class="col text-center">
              {{-- This "Disposable Theme" must be kept visible as-per theme license. If you want to remove the attribution send an email for details --}}
              @include('theme_version')
            </div>
            <div class="col text-end">
              {{-- This "Powered by phpVMS" must be kept visible as-per phpVMS license. If you want to remove the attribution, a license can be purchased https://docs.phpvms.net/#license --}}
              Powered by <a href="http://www.phpvms.net" target="_blank">phpVMS v7</a>
            </div>
          </div>
        </div>
      </div>

    {{-- Start of the required tags block. Don't remove these or things will break!! --}}
      <script src="{{ public_asset('/assets/global/js/vendor.js') }}"></script>
      <script src="{{ public_asset('/assets/frontend/js/vendor.js') }}"></script>
      <script src="{{ public_asset('/assets/frontend/js/app.js') }}"></script>
      @if(Theme::getSetting('gen_darkmode'))
        <script src="{{ public_asset('/disposable/js/darkmode/dark-mode-switch.min.js') }}"></script>
      @endif
      @if(Theme::getSetting('gen_nicescroll'))
        <script src="{{ public_asset('/disposable/js/nicescroll/jquery.nicescroll.js') }}"></script>
        <script>$("body").niceScroll();</script>
      @endif
      @yield('scripts')
      @if(empty($plain))
        {{-- EU Privacy Laws Requirements --}}
        {{-- https://privacypolicies.com/blog/eu-cookie-law --}}
        <script>
          window.addEventListener("load", function () {
            window.cookieconsent.initialise({
              palette: {
                popup: {background: "#edeff5",text: "#838391"},
                button: {"background": "#067ec1"}
              },
              position: "top",
            })
          });
        </script>
      @endif
      <script>$(document).ready(function () { $(".select2").select2({width: 'resolve'}); });</script>
    {{-- End the required tags block --}}
    {{--
    Google Analytics tracking code. Only active if an ID has been entered
    You can modify to any tracking code and re-use that settings field, or
    just remove it completely. Only added as a convenience factor
    --}}
      @php $gtag = setting('general.google_analytics_id'); @endphp
      @if($gtag)
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $gtag }}"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());
          gtag('config', '{{ $gtag }}');
        </script>
      @endif
    {{-- End of the Google Analytics code --}}
    {{-- UTC Clock --}}
      @if(Theme::getSetting('gen_utc_clock'))
        <script type="text/javascript">
          var timeInterval = setInterval(display_ct, 500);
          function display_ct() {
            var Now = new Date();
            var Local_Clock = ('0' + Now.getHours()).slice(-2) + ':' +  ("0" + Now.getMinutes()).slice(-2);
            var UTC_Clock = ('0' + Now.getUTCHours()).slice(-2) + ':' +  ("0" + Now.getUTCMinutes()).slice(-2);
            // var Local_Clock = ('0' + Now.getHours()).slice(-2) + ':' +  ("0" + Now.getMinutes()).slice(-2) + ':' +  ('0' + Now.getSeconds()).slice(-2);
            // var UTC_Clock = ('0' + Now.getUTCHours()).slice(-2) + ':' +  ("0" + Now.getUTCMinutes()).slice(-2) + ':' +  ('0' + Now.getUTCSeconds()).slice(-2);
            document.getElementById('utc_clock').innerHTML = Local_Clock + ' LMT, ' + UTC_Clock + ' UTC';
          }
        </script>
      @endif
    {{-- Bootstrap Scripts v5.1.3 CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>