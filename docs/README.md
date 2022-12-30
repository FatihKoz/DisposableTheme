# Disposable Theme v3

phpVMS v7 theme/skin (Bootstrap v5.x + FontAwesome v5.x)  

Compatible with phpVMS v7 builds as described below;

* Theme versions starting with v3.1.xx and up supports **only** php8 and laravel9
* Minimum required phpVMS v7 version is `phpVms 7.0.0-dev+221227.f4fc71` for v3.2.xx
---
* Theme version v3.0.19 is the latest version with php7.4 and laravel8 support
* It is not supported and updated anymore, so use it at your own risk.
* Latest available phpVMS v7 version is `phpVms 7.0.0-dev+220307.00bf18` (07.MAR.22) for v3.0.19
* Minimum required phpVMS v7 version is `phpVms 7.0.0-dev+211214.c12cf0` (14.DEC.21) for v3.0.19
---
* If you try to use latest version of this addon with an old version of phpvms, it will fail.
* If you try to use latest phpvms with an old version of this addon, it will fail.
* If you try to use your duplicated old blades with this version without checking and applying necessary changes, it will fail.
---

## Installation

Same folder structure is used with phpvms v7, so if you have a default installation for it then installing the theme will take only seconds.  
Just extract the zip file at the root folder of your phpvms v7 installation and select the template from admin section.

### Non Standard Installation

If you want to manually upload the files or have a modified installation of phpvms please follow the instructions below;

* Contents of `public\image` should be placed in your *phpvms public* folder.
* Contents of `public\disposable` should be placed in your *phpvms public* folder.
* Contents of `resources\lang` folder should be placed under your *phpvms resources\lang* folder.
* Contents of `resources\views\layouts` folder should be placed under your *phpvms resources\views\layouts* folder.

According to your installation, `public` folder may be `public` or `public_html` or something else configured via your hosting control panel.

## Customization and Theme Cloning

Below you can find some details about the theme, customization of it and some minor technical info about duplication.

### Theme Cloning / Theme Duplication

* Just create a new folder under your `resources\views\layouts\` folder and name it `MyTheme`  
* Copy the `theme.json` file from Disposable_v3 folder to this folder.  
* Edit this file as below (only first two lines are shown to save space);

```json
"name"    : "MyTheme",        // Theme Name (and also the folder name)
"extends" : "Disposable_v3",  // Here we tell Laravel that we are extending Disposable_v3 theme
```

* Now copy any file you want to edit/change from `Disposable_v3` folder to your `MyTheme` folder, for example take `home.blade.php`
* From this moment on, if you switch to `MyTheme` from admin settings, this clone theme will be active and its contents will be used
* For the rest, non-modified files, `Disposable_v3` theme contents will be used

Technically you can copy any number of files to your new/duplicated theme. Just keep the file names and file paths intact, editing contents of the files is up to you.

### Theme Styling / Customization

* CSS, Stylesheet files are located under `/public/disposable/stylesheet/` folder.

There are two stylesheet files provided with the main package, one for general usage and holds all required styles in it `theme_v3.css`,  
Second one is for dark mode conversion and technically should hold only the items you want to change in a dark-theme `theme_v3_darkmode.css`

Unless really necessary for technical reasons, no hard coded style tags used in theme blades. So you can configure perrty much everything via css files.

### Defining a custom default Gravatar

You can simply define your own custom default gravatar for pilots. Just edit your `env.php` file and add below lines to the end of it  

```php
# GRAVATAR DEFAULT
GRAVATAR_DEFAULT_AVATAR='https://your.phpvms.url.comes.here/disposable/nophoto.jpg'
```

### Defining a custom FavIcon

Edit your duplicated `app.blade.php` and add below line to the `head` section

```html
<link rel="shortcut icon" type="image/png" href="{{ public_asset('/disposable/your_airline_icon_file.png') }}"/>
```

### Customizing VA Logo images and Menu items

This can be achieved in two ways, either you need to change the image files provided in the package `theme_logo.png` and `theme_logo_big.png` or you need to edit blade files to use your own paths for your logos (preferred way)

Files holding logo definitions are `nav_side.blade.php`, `nav_top.blade.php` and `nav_menu.blade.php`

Both SideBar and NavBar uses the same file for menu items `nav_menu.blade.php`  
`nav_menu.blade.php` also holds the new language switching dropdown

## Settings (via theme.json)

There are some options defined in this file for quick settings or for pre-defined features to be enabled/disabled easily without editing blade files.

```json
    "name": "Disposable_v3",          // Theme Name
    "extends": "default",             // Safety feature to extend default theme

    "gen_background_img": 1,          // Enable - Disable background image
    "gen_sidebar": 1,                 // SideBar , NavBar switch
    "gen_utc_clock": 1,               // Enable - Disable local and utc clock display
    "gen_ivao_logo": 1,               // IVAO logo placed on all pages 
    "gen_ivao_field": "IVAO",         // Your phpvms custom profile field name defined for IVAO ID's 
    "gen_ivao_vaid": "",              // Your IVAO Member VA ID (will be used for VA System reports)
    "gen_ivao_icao": "",              // Your IVAO Approved VA ICAO code (will be used for VA System reports)
    "gen_vatsim_logo": 1,             // VATSIM logo placed on all pages
    "gen_vatsim_field": "VATSIM",     // Your phpvms custom profile field name defined for VATSIM CID's
    "gen_discord_invite": "",         // Your static discord invite link (get only the last part like 4fkDHiNv )
    "gen_discord_server": "",         // Your discrod server ID, used for Discord Widget (Disposable Basic)
    "gen_map_flight": 1,              // Map Widget for flights (Disposable Basic)
    "gen_map_fleet": 1,               // Map Widget for fleet (Disposable Basic)
    "gen_darkmode": 0,                // Enable - Disable dark mode switch
    "gen_nicescroll": 0,              // Enable - Disable nice scroll (kills page performance and has issues!)
    "gen_stable_approach": 0,         // Enable - Disable Stable Approach plugin support (Disposable Basic)
    "gen_multilang": 0,               // Enable - Disable Language Selection / Multiple Languages
    
    "home_disable": 0,                // Disable home (landing) page for quests
    "home_ivao_logo": 0,              // Home page IVAO logo (with link)
    "home_vatsim_logo": 0,            // Home page VATSIM logo (with link)
    "home_carousel": 1,               // Home page image slider
    
    "dash_embed_wx": 1,               // Embedded current wx display at dashboard
    "dash_livemap": 0,                // LiveMap at dashboard
    "dash_whazzup_ivao": 0,           // WhazzUp Widget for IVAO (Disposable Basic)
    "dash_whazzup_vatsim": 0,         // WhazzUp Widget for VATSIM (Disposable Basic)

    "download_counts": 0,             // Download counts display

    "flight_bid": 1,                  // Bid Add/Remove button on flight details page
    "flight_simbrief": 1,             // SimBrief OFP generation button on flight details page
    "flight_jumpseat": 0,             // Quick Travel button on flight details page (Disposable Basic)
    "flight_notams": 0,               // Display NOTAMs at flight details page (Disposable Special)

    "flights_flags": 1,               // Enable - Disable country flags on flight related pages
    "flights_table": 1,               // Classic table or card view switch for flights search page

    "login_logo": 0,                  // Show bigger VA logo at login page

    "pireps_manual": 1,               // Hide or show manual pirep filing buttons

    "roster_userimage": 1,            // Use profile images (or gravatar) at roster
    "roster_ident": 0,                // Use ident at roster (like DSP001 Name P)
    "roster_flags": 0,                // Use country flags at roster
    "roster_airline": 1,              // Display user's airline at roster
    "roster_combinetimes": 0,         // Combine flight time and transfer time at roster
    "roster_ivao": 1,                 // Show IVAO ID's and link at roster
    "roster_vatsim": 1,               // Show VATSIM ID's and link at roster

    "simbrief_extrafuel": 1,          // Extra fuel field in SimBrief form
    "simbrief_tankering": 1,          // Tankering advice for Extra Fuel field
    "simbrief_raw_wx": 1,             // Raw wx display at SimBrief form
    "simbrief_rfinder": 1,            // RouteFinder modal at SimBrief form
    "simbrief_runways": 1,            // Runway selection at SimBrief form (Disposable Basic)
    "simbrief_taxitimes": 0,          // Taxi Times droddown for Dep - Arrival Airports (with averages, Disposable Basic)
    "simbrief_rvr": "500",            // SimBrief ATC Flight plan RVR value
    "simbrief_rmk": "Disposable VA",  // SimBrief ATC Flight plan remark field addition (like RMK/TCAS Disposable VA)
    "simbrief_crew": 1,               // SimBrief Crew names at SimBrief summary page
    "simbrief_ivao": 1,               // File ATC to IVAO button at SimBrief summary page
    "simbrief_vatsim": 1,             // File ATC to VATSIM button at SimBrief summary page
    "simbrief_specs": 1,              // Use addon based specifications at SimBrief form (Disposable Basic)

    "user_disable_hub": 0,            // Disable changing hubs from profile edit
    "user_disable_airline": 0         // Disable changing airlines from profile edit
```

## About IVAO VA System Support

As this is really an optional feature and the system itself is too old, it is provided only for VA's already using it. You should define your IVAO approved `Airline ID` and `Airline ICAO code` at theme.json file for the auto placed badges to show up.

Below you can find an example, it checks if you have necessary definitions at theme.json and includes the file. Which will have a visible badge/button, when clicked it will open up a modal window for the pilot to send the report.

```php
@if(Theme::getSetting('gen_ivao_vaid') && Theme::getSetting('gen_ivao_icao'))
  @include('pireps.ivao_vasys')
@endif
```

Be advised, IVAO's login cookies do not work properly even if you click "Remember Me". This is the reason of that "Login IVAO" button placed in the modal. It is higly advised that pilots click that button first, complete their login to IVAO, which will send them back to your VA, then click the "Send Report" button.

Here is an answer from [IVAO Official Wiki](https://wiki.ivao.aero/en/home/flightoperations/FAQ_VA) about VA System usage

```md
Do the pilots need to report their flights? 

Currently, the VA System is withdrawn, and not to be used anymore. The new VA system should be back alive in 2021. In the meantime, as we have no backup solution, no flight reporting is asked to pilots. 
```

## Footer Positioning and Content

As per the license, **theme name should be always visible in all pages**. Editing the footer is still possible but `Disposable` link **SHOULD BE** always visible.

If you need more space in footer area, kindly check theme stylesheet to add yourself some space 'cause it is really limited with a small area and always placed at the bottom.

## Release / Update Notes

30.DEC.22

* Added support for multi language (can be enabled via theme.json)

17.DEC.22

* Quick fixes applied for IVAO/VATSIM/POSCON plan filing systems applied (IVAO API Change, SB xml changes)
* Added public pireps page link to menu/nav (Needs Dispo Basic)
* Added UserPireps widget to profile index (Needs Dispo Basic)

15.NOV.22

* PT-BR Translation (Thanks to @Joaolzc)
* PT-PT Translation (Thanks to @PVPVA , specially JCB)
* License Updated (more non-authorized virtual airlines added !)

21.OCT.22

* IVAO URL/Link fixes (User profile and Roster)

27.AUG.22

* Added customizations for core map support (pirep maps and live flights widget)
  *Needs phpvms 7.0.0-dev+220822.231e54 and later*

22.AUG.22

* Added radio telephony callsign to SimBrief form (if defined at airline it will be used automatically)

14.AUG.22

* Added notes to Airport Details page (needs phpvms core update, possible upcoming dev release)

09.JUL.22

* Added baggage weight definitions to SimBrief form (follow up for SimBrief API changes)

11.JUN.22

* Fixed a conversion error in Theme Helpers (fuel price conversion from lbs to kgs)

17.APR.22

* Fixed Date Of Flight (DOF) issue in SimBrief form (was effecting ofp generation around 23 UTC with edited ETD and changed dates)

14.MAR.22

* Theme is now only compatible with php8 and Laravel9
* All blades changed to provide better support mobile devices
* Theme helpers updated to meet new core requirements
* Added some admin only items to pilot profile page (to support Disposable Special features)
* Added some details to My Bids page, allowed deletion of bids when the pilot is not at that airport
* Spanish (Spain) translation, thanks to @arv187

01.MAR.22

**WARNING: THIS IS THE LAST VERSION SUPPORTING PHP 7.4.xx AND LARAVEL 8**

* No functional changes, just version matching with all v3.0.xx series Disposable addons

28.FEB.22

* Added support for IVAO VA System
  *Needs to be manually placed and enabled if needed, be aware this system is too old for full automation*
* Stable Approach Plugin stats will be visible if the pilot uses it and sends FDM reports to VA
  *Needs Disposable Basic Module v3.0.18 or later if you are using it*
* Added Assignment and Tour Progress Widgets to user profile (visible only to admins, check Profile Details pill)
  *Needs Disposable Special Module v3.0.16 or later*

04.FEB.22

* Added French translation (Thanks to Jbaltazar67, from phpVMS Forum)

12.JAN.22

* Fixed the error at user profile (caused by Monthly Flight Assignment stats)  
  *Disposable Special module needs to be installed and enabled for it to work*

05.JAN.22

* Fixed the ordering of Type Ratings (it is now alphabetically sorted at user profile)
* Added Stable Approach Plugin's FDM Results to personal pireps page
* Added some new stats to user profile page (for FDM and Monthly Flight Assignments)  
  *Both additions need minimum Disposable Basic v3.0.9 and Stable Approach Plugin*

18.DEC.21

* Stable Approach Plugin support  
  *Needs minimum Disposable Basic v3.0.6 and Stable Approach Plugin 1.2.0-beta.3*

14.DEC.21

* Update Live Map Widget blade (added refresh interval setting)

05.DEC.21

* Added "Type Ratings" at user profile page (requires phpVms 7.0.0-dev+211130.c45d52 or later)
* Added Taxi Time selection dropdowns to SimBrief form (like the old theme, needs Disposable Basic)
* Changed the logic of "Route Finder" setting, on SSL enabled servers it will be a link, non-SSL servers will have a modal  
  *Route Finder change is related to recent browser changes blocking non-secure content in secure pages*

26.NOV.21

* Added natural sort for flight search > dropdowns and flight > subfleets.
* Italian translation (Thanks to Fabietto for his support)

20.NOV.21

* Fix new user registration (password confirmation field)

19.NOV.21

* Fixed manual pirep sending buttons not following theme settings in some blades
* Reduced the empty space at login page when logo is enabled
* Added menu item language/translation definitions
* Fixed SimBrief NO ALTN display

18.NOV.21

* Added Quick Travel button to flight details page (requires Disposable Basic to work)
* Fixed some minor placing issues at flight and pirep details pages
* Added missing "login_logo" setting to Theme.json
* Added min/max time to flight search (requires phpvms 7.0.0-dev+211118.66d83c or later)

16.NOV.21

* Initial Release
