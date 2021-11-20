# Disposable Theme v3

phpVMS v7 theme/skin (Bootstrap v5.x + FontAwesome v5.x)  

## Important Changes

* License changed
* Bootstrap version changed from v4.x to v5.x
* Theme helpers logic changed and now can be customized by duplication as per your needs. Theme no longer uses other Disposable addon helpers.
* Theme is NOT compatible with older seperate Disposable addons, it is designed to be fully compatible with Disposable v3 series addons (Basic and Special as of date)
* Theme is NOT compatible with beta4 or earlier development builds of phpVMS v7 prior to 09.NOV.21
* Minimum required phpVMS v7 version is `7.0.0-dev+211109.4e7149`

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
"extends" : "Disposable_v3",  // Here we tell Laravel that we are extending DH2 theme
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
GRAVATAR_DEFAULT_AVATAR='http://your.phpvms.url.comes.here/disposable/nophoto.jpg'
```

### Defining a custom FavIcon

Edit your duplicated `app.blade.php` and add below line to the `head` section

```html
<link rel="shortcut icon" type="image/png" href="{{ public_asset('/disposable/your_airline_icon_file.png') }}"/>
```

### Customizing VA Logo images and Menu items

This can be achieved in two ways, either you need to change the image files provided in the package `theme_logo.png` and `theme_logo_big.png` or you need to edit blade files to use your own paths for your logos (preferred way)

Files holding logo definitions `nav_side.blade.php` , `nav_top.blade.php` and `nav_menu.blade.php`

Both SideBar and NavBar uses the same file for menu items `nav_menu.blade.php`

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
    "gen_ivao_vaid": "",              // Your IVAO Member VA ID (only changes the logo at the moment)
    "gen_vatsim_logo": 1,             // VATSIM logo placed on all pages
    "gen_vatsim_field": "VATSIM",     // Your phpvms custom profile field name defined for VATSIM CID's
    "gen_discord_invite": "",         // Your static discord invite link (get only the last part like 4fkDHiNv )
    "gen_discord_server": "",         // Your discrod server ID, used for Discord Widget (Disposable Basic)
    "gen_map_flight": 1,              // Map Widget for flights (Disposable Basic)
    "gen_map_fleet": 1,               // Map Widget for fleet (Disposable Basic)
    "gen_darkmode": 0,                // Enable - Disable dark mode switch
    "gen_nicescroll": 0,              // Enable - Disable nice scroll (kills page performance and has issues!)
    
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
    "flights_table": 1,               // Classic table or card view switch for flights searc page

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
    "simbrief_rvr": "500",            // SimBrief ATC Flight plan RVR value
    "simbrief_rmk": "Disposable VA",  // SimBrief ATC Flight plan remark field addition (like RMK/TCAS Disposable VA)
    "simbrief_crew": 1,               // SimBrief Crew names at SimBrief summary page
    "simbrief_ivao": 1,               // File ATC to IVAO button at SimBrief summary page
    "simbrief_vatsim": 1,             // File ATC to VATSIM button at SimBrief summary page
    "simbrief_specs": 1,              // Use addon based specifications at SimBrief form (Disposable Basic)

    "user_disable_hub": 0,            // Disable changing hubs from profile edit
    "user_disable_airline": 0         // Disable changing airlines from profile edit
```

## Footer Positioning and Content

As per the license, **theme name should be always visible in all pages**. Editing the footer is still possible but `Disposable` link SHOULD BE always visible.

If you need more space in footer area, kindly check theme stylesheet to add yourself some space 'cause it is really limited with a small area and always placed at the bottom.

## Release / Update Notes

20.NOV.21

* Fix for new user registration (password confirmation field)

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
