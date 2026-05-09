# Bootstrap Icons Migration Guide
**FontAwesome → Bootstrap Icons Conversion**

## Icon Reference Table

| FontAwesome Class | Bootstrap Icon Class | Notes |
|------------------|---------------------|-------|
| `fab fa-discord` | `bi bi-discord` | Discord icon |
| `fab fa-facebook` | `bi bi-facebook` | Facebook |
| `fab fa-twitter` | `bi bi-twitter-x` or `bi bi-x` | Twitter → X |
| `fas fa-sign-in-alt` | `bi bi-box-arrow-in-right` | Login button |
| `fas fa-sign-out-alt` | `bi bi-box-arrow-right` | Logout button |
| `fas fa-home` | `bi bi-house-door` | Home icon |
| `fas fa-calendar` | `bi bi-calendar` | Calendar |
| `fas fa-phone` | `bi bi-telephone` | Phone |
| `fas fa-phone-alt` | `bi bi-telephone-fill` | Phone filled |
| `fas fa-envelope` | `bi bi-envelope` | Email |
| `fas fa-envelope-open` | `bi bi-envelope-open` | Envelope open |
| `fas fa-users` | `bi bi-people` | Users |
| `fas fa-user` | `bi bi-person` | User |
| `fas fa-user-circle` | `bi bi-person-circle` | User circle |
| `fas fa-user-edit` | `bi bi-person-badge` | User edit |
| `fas fa-user-plus` | `bi bi-person-plus` | User add |
| `fas fa-user-check` | `bi bi-person-check` | User verified |
| `fas fa-user-lock` | `bi bi-person-lock` | User locked |
| `fas fa-clipboard-list` | `bi bi-clipboard-check` | Clipboard list |
| `fas fa-cog` | `bi bi-gear` | Settings |
| `fas fa-cogs` | `bi bi-gears` | Multiple settings |
| `fas fa-chart-bar` | `bi bi-bar-chart` | Bar chart |
| `fas fa-chart-line` | `bi bi-graph-up` | Line chart |
| `fas fa-chart-pie` | `bi bi-pie-chart` | Pie chart |
| `fas fa-check-circle` | `bi bi-check-circle` | Check circle |
| `fas fa-exclamation-circle` | `bi bi-exclamation-circle` | Warning circle |
| `fas fa-info-circle` | `bi bi-info-circle` | Info circle |
| `fas fa-times-circle` | `bi bi-x-circle` | Close circle |
| `fas fa-question-circle` | `bi bi-question-circle` | Help circle |
| `fas fa-check` | `bi bi-check2` | Checkmark |
| `fas fa-times` | `bi bi-x` | Close |
| `fas fa-ellipsis-v` | `bi bi-three-dots-vertical` | Vertical menu |
| `fas fa-ellipsis-h` | `bi bi-three-dots` | Horizontal menu |
| `fas fa-search` | `bi bi-search` | Search |
| `fas fa-heart` | `bi bi-heart` | Heart |
| `fas fa-star` | `bi bi-star` | Star |
| `fas fa-thumbs-up` | `bi bi-hand-thumbs-up` | Like |
| `fas fa-thumbs-down` | `bi bi-hand-thumbs-down` | Dislike |
| `fas fa-eye` | `bi bi-eye` | View |
| `fas fa-eye-slash` | `bi bi-eye-slash` | Hide |
| `fas fa-spinner` | `bi bi-hourglass-split` or custom spinner | Loading |
| `fas fa-clock` | `bi bi-clock` | Time |
| `fas fa-history` | `bi bi-clock-history` | History |
| `fas fa-download` | `bi bi-download` | Download |
| `fas fa-upload` | `bi bi-cloud-upload` | Upload |
| `fas fa-trash` | `bi bi-trash` | Delete |
| `fas fa-edit` | `bi bi-pencil-square` | Edit |
| `fas fa-save` | `bi bi-floppy` | Save |
| `fas fa-file` | `bi bi-file-earmark` | File |
| `fas fa-file-alt` | `bi bi-file-earmark-text` | Text file |
| `fas fa-file-pdf` | `bi bi-file-earmark-pdf` | PDF file |
| `fas fa-file-word` | `bi bi-file-earmark-word` | Word file |
| `fas fa-file-excel` | `bi bi-file-earmark-xls` | Excel file |
| `fas fa-folder` | `bi bi-folder` | Folder |
| `fas fa-folder-open` | `bi bi-folder-open` | Open folder |
| `fas fa-search-plus` | `bi bi-search-plus` | Zoom in |
| `fas fa-search-minus` | `bi bi-search-minus` | Zoom out |
| `fas fa-step-backward` | `bi bi-skip-start` | Previous |
| `fas fa-step-forward` | `bi bi-skip-end` | Next |
| `fas fa-undo` | `bi bi-rotate-ccw` | Undo |
| `fas fa-redo` | `bi bi-rotate-cw` | Redo |
| `fas fa-play` | `bi bi-play` | Play |
| `fas fa-pause` | `bi bi-pause` | Pause |
| `fas fa-stop` | `bi bi-stop` | Stop |
| `fas fa-refresh` | `bi bi-arrow-counterclockwise` | Refresh |
| `fas fa-random` | `bi bi-shuffle` | Shuffle |
| `fas fa-bar-chart` | `bi bi-bar-chart` | Chart |
| `fas fa-filter` | `bi bi-funnel` | Filter |
| `fas fa-print` | `bi bi-printer` | Print |
| `fas fa-share` | `bi bi-share` | Share |
| `fas fa-external-link-alt` | `bi bi-box-arrow-up-right` | External link |
| `fas fa-lock` | `bi bi-lock` | Lock |
| `fas fa-unlock` | `bi bi-lock-open` | Unlock |
| `fas fa-key` | `bi bi-key` | Key |
| `fas fa-user-lock` | `bi bi-person-lock` | Locked user |
| `fas fa-unlock-alt` | `bi bi-lock-open` | Unlock |
| `fas fa-bell` | `bi bi-bell` | Notification |
| `fas fa-bell-slash` | `bi bi-bell-slash` | Mute bell |
| `fas fa-comment` | `bi bi-chat-dots` | Comment |
| `fas fa-comment-alt` | `bi bi-chat-square-text` | Alt comment |
| `fas fa-comments` | `bi bi-chat-left-text` | Comments |
| `fas fa-comment-dots` | `bi bi-chat-dots` | Message with dots |
| `fas fa-comment-alt-dots` | `bi bi-chat-square-dots` | Alt message dots |
| `fas fa-paperclip` | `bi bi-paperclip` | Attachment |
| `fas fa-map-marker-alt` | `bi bi-geo-alt` | Location |
| `fas fa-map` | `bi bi-map` | Map |
| `fas fa-globe` | `bi bi-globe` | Globe |
| `fas fa-globe-americas` | `bi bi-globe-americas` | Americas globe |
| `fas fa-globe-asia` | `bi bi-globe-asia` | Asia globe |
| `fas fa-fighter-jet` | `bi bi-plane` | Fighter jet |
| `fas fa-plane` | `bi bi-plane` | Plane |
| `fas fa-plane-departure` | `bi bi-airplane-departure` | Departure |
| `fas fa-plane-arrival` | `bi bi-airplane-arrival` | Arrival |
| `fas fa-rocket` | `bi bi-rocket-takeoff` | Rocket |
| `fas fa-wind` | `bi bi-dharmachakra` | Wind |
| `fas fa-tachometer-alt` | `bi bi-speedometer2` | Tachometer |
| `fas fa-tachometer` | `bi bi-speedometer` | Tachometer old |
| `fas fa-cloud` | `bi bi-cloud` | Cloud |
| `fas fa-cloud-download-alt` | `bi bi-cloud-download` | Download cloud |
| `fas fa-cloud-upload-alt` | `bi bi-cloud-upload` | Upload cloud |
| `fas fa-cloud-drizzle` | `bi bi-cloud-rain` | Light rain |
| `fas fa-cloud-lightning` | `bi bi-cloud-lightning` | Storm cloud |
| `fas fa-cloud-sun` | `bi bi-cloud-sun` | Sunny cloud |
| `fas fa-cloud-moon` | `bi bi-cloud-moon` | Cloudy |
| `fas fa-droplet` | `bi bi-droplet` | Water drop |
| `fas fa-droplet-half` | `bi bi-droplet-half` | Half drop |
| `fas fa-tint` | `bi bi-droplet` | Tint |
| `fas fa-temperature-high` | `bi bi-thermometer-high` | Hot temp |
| `fas fa-temperature-low` | `bi bi-thermometer-snow` | Cold temp |
| `fas fa-sun` | `bi bi-sun` | Sun |
| `fas fa-moon` | `bi bi-moon-stars` | Moon |
| `fas fa-star` | `bi bi-star` | Star |
| `fas fa-star-half-alt` | `bi bi-star-half` | Half star |
| `fas fa-star-and-crescent` | `bi bi-star-half` | Alternative |
| `fas fa-at` | `bi bi-at` | At sign |
| `fas fa-hashtag` | `bi bi-hash` | Hashtag |
| `fas fa-percentage` | `bi bi-percent` | Percentage |
| `fas fa-hash` | `bi bi-hash` | Hash |
| `fas fa-square` | `bi bi-square` | Square |
| `fas fa-square-check` | `bi bi-square-check` | Checked square |
| `fas fa-square-full` | `bi bi-square-full` | Full square |
| `fas fa-square-plus` | `bi bi-square-plus` | Plus square |
| `fas fa-square-times` | `bi bi-square-x` | X square |
| `fas fa-circle` | `bi bi-circle` | Circle |
| `fas fa-circle-notch` | `bi bi-hourglass-split` | Spinner |
| `fas fa-circle-check` | `bi bi-check-circle` | Checked circle |
| `fas fa-circle-o-notch` | `bi bi-hourglass-split` | Old spinner |
| `fas fa-minus` | `bi bi-dash` | Minus |
| `fas fa-minus-circle` | `bi bi-circle-dash` | Minus circle |
| `fas fa-minus-square` | `bi bi-square-dash` | Minus square |
| `fas fa-plus` | `bi bi-plus` | Plus |
| `fas fa-plus-circle` | `bi bi-circle-plus` | Plus circle |
| `fas fa-plus-square` | `bi bi-square-plus` | Plus square |
| `fas fa-times` | `bi bi-x` | X mark |
| `fas fa-times-circle` | `bi bi-x-circle` | X circle |
| `fas fa-times-square` | `bi bi-x-square` | X square |
| `fas fa-ban` | `bi bi-circle-x` | Ban |
| `fas fa-check-circle` | `bi bi-check-circle` | Check circle |
| `fas fa-check-square` | `bi bi-square-check` | Check square |
| `fas fa-times` | `bi bi-x` | Close |
| `fas fa-times-circle` | `bi bi-x-circle` | Close circle |
| `fas fa-angry` | `bi bi-face-angry` | Angry face |
| `fas fa-grimace` | `bi bi-face-wink` | Grimace |
| `fas fa-grin` | `bi bi-face-laugh-squint` | Grin |
| `fas fa-meh` | `bi bi-face-neutral` | Meh |
| `fas fa-smile` | `bi bi-face-smile` | Smile |
| `fas fa-frown` | `bi bi-face-frown` | Frown |
| `fas fa-magic` | `bi bi-magic` | Magic |
| `fas fa-wallet` | `bi bi-wallet2` | Wallet |
| `fas fa-ambulance` | `bi bi-ambulance` | Ambulance |
| `fas fa-ambulance-medical` | `bi bi-ambulance` | Medical |
| `fas fa-bank` | `bi bi-building-columns` | Bank |
| `fas fa-building` | `bi bi-building` | Building |
| `fas fa-building-columns` | `bi bi-building-columns` | Bank |
| `fas fa-certificate` | `bi bi-badge-check` | Certificate |
| `fas fa-credit-card` | `bi bi-credit-card-2-front` | Credit card |
| `fas fa-dollar-sign` | `bi bi-currency-dollar` | Dollar |
| `fas fa-euro-sign` | `bi bi-currency-euro` | Euro |
| `fas fa-file-invoice` | `bi bi-file-earmark-database` | Invoice |
| `fas fa-file-invoice-dollar` | `bi bi-file-earmark-database` | Invoice USD |
| `fas fa-file-medical` | `bi bi-file-earmark-health` | Medical file |
| `fas fa-hospital` | `bi bi-hospital` | Hospital |
| `fas fa-hand-holding-usd` | `bi bi-hand-thumbs-up` | Dollar |
| `fas fa-money-bill` | `bi bi-money-bill` | Money bill |
| `fas fa-money-bill-wave` | `bi bi-money-bill-wave` | Wavy bill |
| `fas fa-piggy-bank` | `bi bi-box-seam` | Piggy bank |
| `fas fa-pound-sign` | `bi bi-currency-pound` | Pound |
| `fas fa-random` | `bi bi-shuffle` | Random |
| `fas fa-ruble-sign` | `bi bi-currency-rupee` | Ruble |
| `fas fa-rupee-sign` | `bi bi-currency-rupee` | Rupee |
| `fas fa-share-alt` | `bi bi-share` | Share |
| `fas fa-share-square` | `bi bi-square-share` | Share square |
| `fas fa-shower` | `bi bi-shower` | Shower |
| `fas fa-turkish-lira-sign` | `bi bi-currency-try` | Turkish Lira |
| `fas fa-yen-sign` | `bi bi-currency-yen` | Yen |
| `fas fa-volume-up` | `bi bi-volume-up` | Volume up |
| `fas fa-volume-down` | `bi bi-volume-down` | Volume down |
| `fas fa-volume-mute` | `bi bi-volume-mute` | Mute |
| `fas fa-volume-off` | `bi bi-volume-off` | Volume off |
| `fas fa-wifi` | `bi bi-wifi` | WiFi |
| `fas fa-wrench` | `bi bi-tools` | Wrench |
| `fas fa-bicycle` | `bi bi-bicycle` | Bicycle |
| `fas fa-bomb` | `bi bi-bomb` | Bomb |
| `fas fa-box-open` | `bi bi-box-seam` | Box open |
| `fas fa-briefcase` | `bi bi-briefcase` | Briefcase |
| `fas fa-briefcase-open` | `bi bi-briefcase` | Open briefcase |
| `fas fa-car` | `bi bi-car-front` | Car |
| `fas fa-car-crash` | `bi bi-car-crash` | Crash |
| `fas fa-car-side` | `bi bi-car-front` | Side view |
| `fas fa-closed-captioning` | `bi bi-captions` | Captions |
| `fas fa-coffee` | `bi bi-mug-hot` | Coffee |
| `fas fa-coins` | `bi bi-coins` | Coins |
| `fas fa-comments` | `bi bi-chat-left-text` | Comments |
| `fas fa-concierge-bell` | `bi bi-person-badge` | Concierge |
| `fas fa-cookie` | `bi bi-cookie` | Cookie |
| `fas fa-cookie-bite` | `bi bi-cookie` | Bite cookie |
| `fas fa-copyright` | `bi bi-copyright` | Copyright |
| `fas fa-credit-card` | `bi bi-credit-card-2-front` | Credit card |
| `fas fa-drum` | `bi bi-joint` | Drum |
| `fas fa-drum-steelpan` | `bi bi-music-note-beamed` | Steelpan |
| `fas fa-envelope` | `bi bi-envelope` | Envelope |
| `fas fa-envelope-open` | `bi bi-envelope-open` | Open envelope |
| `fas fa-envelope-open-text` | `bi bi-envelope-open` | Open text |
| `fas fa-file` | `bi bi-file-earmark` | File |
| `fas fa-file-alt` | `bi bi-file-earmark` | Alt file |
| `fas fa-file-archive` | `bi bi-file-earmark-zip` | Archive |
| `fas fa-file-code` | `bi bi-file-earmark-code` | Code file |
| `fas fa-file-contract` | `bi bi-file-earmark-lock` | Contract |
| `fas fa-file-csv` | `bi bi-file-earmark-spreadsheet` | CSV |
| `fas fa-file-excel` | `bi bi-file-earmark-xls` | Excel |
| `fas fa-file-export` | `bi bi-file-earmark-arrow-up` | Export |
| `fas fa-file-import` | `bi bi-file-earmark-arrow-down` | Import |
| `fas fa-file-import` | `bi bi-file-earmark-arrow-down` | Import |
| `fas fa-file-invoice` | `bi bi-file-earmark-database` | Invoice |
| `fas fa-file-invoice-dollar` | `bi bi-file-earmark-database-dollar` | Invoice USD |
| `fas fa-file-medical` | `bi bi-file-earmark-health` | Medical |
| `fas fa-file-medical-alt` | `bi bi-file-earmark-health` | Alt medical |
| `fas fa-file-pdf` | `bi bi-file-earmark-pdf` | PDF |
| `fas fa-file-powerpoint` | `bi bi-file-earmark-powerpoint` | PowerPoint |
| `fas fa-file-signature` | `bi bi-file-earmark-check` | Signature |
| `fas fa-file-upload` | `bi bi-file-earmark-arrow-up` | Upload |
| `fas fa-folder` | `bi bi-folder` | Folder |
| `fas fa-folder-open` | `bi bi-folder-open` | Open |
| `fas fa-folder-plus` | `bi bi-folder-plus` | Add |
| `fas fa-folder-minus` | `bi bi-folder-minus` | Remove |
| `fas fa-glass-martini` | `bi bi-glass-martini` | Martini |
| `fas fa-glass-martini-alt` | `bi bi-glass-martini` | Alt martini |
| `fas fa-glass-cheers` | `bi bi-glass-cheers` | Cheers |
| `fas fa-glass-whiskey` | `bi bi-glass-martini` | Whiskey |
| `fas fa-glass-martini` | `bi bi-glass-martini` | Martini |
| `fas fa-glass-martini-alt` | `bi bi-glass-martini` | Alt |
| `fas fa-glass-cheers` | `bi bi-glass-cheers` | Toast |
| `fas fa-glass-martini` | `bi bi-glass-martini` | Classic |
| `fas fa-glass-martini-alt` | `bi bi-glass-martini` | Variation |
| `fas fa-glass-whiskey` | `bi bi-glass-martini` | Whiskey |
| `fas fa-glass-cheers` | `bi bi-glass-cheers` | Cheers |
| `fas fa-glass-martini` | `bi bi-glass-martini` | Classic |
| `fas fa-heart` | `bi bi-heart` | Heart |
| `fas fa-heartbeat` | `bi bi-heart-pulse` | Heartbeat |
| `fas fa-hospital` | `bi bi-hospital` | Hospital |
| `fas fa-hospital-alt` | `bi bi-hospital` | Alt |
| `fas fa-hospital-symbol` | `bi bi-fingerprint` | Symbol |
| `fas fa-hospital-user` | `bi bi-person-heart` | User hospital |
| `fas fa-idea` | `bi bi-lightbulb` | Idea |
| `fas fa-id-badge` | `bi bi-person-badge` | ID badge |
| `fas fa-id-card` | `bi bi-card-heading` | ID card |
| `fas fa-id-card-alt` | `bi bi-card-text` | Alt card |
| `fas fa-image` | `bi bi-image` | Image |
| `fas fa-images` | `bi bi-images` | Multiple images |
| `fas fa-images` | `bi bi-camera` | Images |
| `fas fa-mug-hot` | `bi bi-mug-hot` | Hot drink |
| `fas fa-medal` | `bi bi-medal` | Medal |
| `fas fa-money-bill` | `bi bi-money-bill` | Bill |
| `fas fa-money-bill-wave` | `bi bi-money-bill-wave` | Wavy |
| `fas fa-money-bill-wave-alt` | `bi bi-money-bill-wave` | Alt wavy |
| `fas fa-mortar-pestle` | `bi bi-mortarboard` | Pestle |
| `fas fa-newspaper` | `bi bi-newspaper` | Newspaper |
| `fas fa-notes-medical` | `bi bi-file-earmark-prescription` | Notes |
| `fas fa-pills` | `bi bi-capsules` | Pills |
| `fas fa-plus` | `bi bi-plus` | Plus |
| `fas fa-plus-square` | `bi bi-square-plus` | Plus square |
| `fas fa-podcast` | `bi bi-diagram-3` | Podcast |
| `fas fa-procedures` | `bi bi-flask` | Procedures |
| `fas fa-puzzle-piece` | `bi bi-puzzle` | Puzzle |
| `fas fa-quote-left` | `bi bi-quote` | Quote left |
| `fas fa-quote-right` | `bi bi-quote` | Quote right |
| `fas fa-recycle` | `bi bi-recycle` | Recycle |
| `fas fa-redo` | `bi bi-arrow-repeat` | Redo |
| `fas fa-refresh` | `bi bi-arrow-counterclockwise` | Refresh |
| `fas fa-reply` | `bi bi-arrow-left` | Reply |
| `fas fa-reply-all` | `bi bi-chat-left-quote` | Reply all |
| `fas fa-reply` | `bi bi-arrow-left-short` | Short reply |
| `fas fa-reply` | `bi bi-arrow-left` | Reply |
| `fas fa-rocket` | `bi bi-rocket-takeoff` | Rocket |
| `fas fa-scooter` | `bi bi-scooter` | Scooter |
| `fas fa-sign-out-alt` | `bi bi-box-arrow-right` | Logout |
| `fas fa-sim-card` | `bi bi-memory` | SIM card |
| `fas fa-sitemap` | `bi bi-diagram-3` | Sitemap |
| `fas fa-sliders-h` | `bi bi-sliders` | Sliders |
| `fas fa-smoking` | `bi bi-cigar` | Smoking |
| `fas fa-smoking-ban` | `bi bi-cigar` | Ban smoking |
| `fas fa-sort` | `bi bi-arrow-down-up` | Sort |
| `fas fa-sort-alpha-down` | `bi bi-sort-alpha-down` | Sort alpha down |
| `fas fa-sort-alpha-down-alt` | `bi bi-sort-alpha-down` | Alt |
| `fas fa-sort-amount-down` | `bi bi-sort-amount-down` | Sort amount |
| `fas fa-sort-down` | `bi bi-arrow-down-short` | Sort down |
| `fas fa-sort-amount-up` | `bi bi-sort-amount-up` | Sort amount up |
| `fas fa-sort-amount-up-alt` | `bi bi-sort-amount-up` | Alt |
| `fas fa-sort-alpha-up` | `bi bi-sort-alpha-up` | Sort alpha up |
| `fas fa-sort-alpha-up-alt` | `bi bi-sort-alpha-up` | Alt |
| `fas fa-sort-numeric-down` | `bi bi-sort-numeric-down` | Sort numeric down |
| `fas fa-sort-numeric-up` | `bi bi-sort-numeric-up` | Sort numeric up |
| `fas fa-sort-up` | `bi bi-arrow-up-short` | Sort up |
| `fas fa-sync` | `bi bi-arrow-counterclockwise` | Sync |
| `fas fa-sync-alt` | `bi bi-arrow-repeat` | Alt sync |
| `fas fa-table-cells` | `bi bi-table` | Table cells |
| `fas fa-table-cells-large` | `bi bi-table` | Large table |
| `fas fa-table-cells-row-select` | `bi bi-table-columns` | Row select |
| `fas fa-table-cells-column-select` | `bi bi-table-columns` | Column select |
| `fas fa-table-cells-row-head` | `bi bi-table` | Row head |
| `fas fa-table-cells-row-head-select` | `bi bi-table` | Row head select |
| `fas fa-table-cells-row-unselect` | `bi bi-table` | Row unselect |
| `fas fa-table-cells-column-head` | `bi bi-table` | Column head |
| `fas fa-table-cells-column-head-select` | `bi bi-table` | Column head select |
| `fas fa-table-cells-column-unselect` | `bi bi-table` | Column unselect |
| `fas fa-table-cells-large` | `bi bi-table` | Large |
| `fas fa-table-cells` | `bi bi-table` | Normal |
| `fas fa-table` | `bi bi-table` | Table |
| `fas fa-table-list` | `bi bi-list-columns` | List |
| `fas fa-table-columns` | `bi bi-table-columns` | Columns |
| `fas fa-th` | `bi bi-grid` | Grid view |
| `fas fa-th-large` | `bi bi-grid` | Large grid |
| `fas fa-th-list` | `bi bi-list` | List view |
| `fas fa-thumbs-up` | `bi bi-hand-thumbs-up` | Like |
| `fas fa-thumbs-down` | `bi bi-hand-thumbs-down` | Dislike |
| `fas fa-trophy` | `bi bi-trophy` | Trophy |
| `fas fa-truck` | `bi bi-truck` | Truck |
| `fas fa-truck-loading` | `bi bi-truck-front` | Loading |
| `fas fa-truck-moving` | `bi bi-truck-front` | Moving |
| `fas fa-tshirt` | `bi bi-tshirt` | T-shirt |
| `fas fa-undo` | `bi bi-arrow-counterclockwise` | Undo |
| `fas fa-undo-alt` | `bi bi-arrow-repeat` | Alt undo |
| `fas fa-venus` | `bi bi-venus` | Venus |
| `fas fa-venus-double` | `bi bi-venus` | Double |
| `fas fa-venus-mars` | `bi bi-venus` | Venus Mars |
| `fas fa-vials` | `bi bi-flask` | Vials |
| `fas fa-vial` | `bi bi-flask` | Single vial |
| `fas fa-volume-up` | `bi bi-volume-up` | Volume up |
| `fas fa-volume-down` | `bi bi-volume-down` | Volume down |
| `fas fa-volume-mute` | `bi bi-volume-mute` | Mute |
| `fas fa-volume-off` | `bi bi-volume-off` | Volume off |
| `fas fa-volume-up` | `bi bi-volume-up` | Up |
| `fas fa-volume-down` | `bi bi-volume-down` | Down |
| `fas fa-volume-off` | `bi bi-volume-off` | Off |
| `fas fa-volume-mute` | `bi bi-volume-mute` | Mute |
| `fas fa-wine-glass` | `bi bi-glass-martini` | Wine glass |
| `fas fa-wine-glass-alt` | `bi bi-glass-martini-alt` | Alt |
| `fas fa-wrench` | `bi bi-tools` | Wrench |
| `fas fa-x-ray` | `bi bi-x-ray` | X-ray |
| `fas fa-yin-yang` | `bi bi-yin-yang` | Yin Yang |
| `fas fa-calendar` | `bi bi-calendar` | Calendar |
| `fas fa-calendar-alt` | `bi bi-calendar` | Alt |
| `fas fa-calendar-check` | `bi bi-calendar-check` | Check |
| `fas fa-calendar-minus` | `bi bi-calendar-minus` | Minus |
| `fas fa-calendar-plus` | `bi bi-calendar-plus` | Plus |
| `fas fa-calendar-times` | `bi bi-calendar-x` | Times |
| `fas fa-calendar-day` | `bi bi-calendar-event` | Day |
| `fas fa-calendar-week` | `bi bi-calendar-week` | Week |
| `fas fa-calendar-day` | `bi bi-calendar-event` | Event |
| `fas fa-calendar-week` | `bi bi-calendar-week` | Week |
| `fas fa-calendar-day` | `bi bi-calendar-event` | Daily |
| `fas fa-calendar-week` | `bi bi-calendar-week` | Weekly |