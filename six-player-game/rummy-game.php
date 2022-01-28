<!DOCTYPE html>
<html>
<head>
	<title>RummySahara</title>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<link href="favicon.ico" rel="shortcut icon" type="image/ico">
	<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
	<link href="css/style_six.css" rel="stylesheet">
	<script src="/jquery.js"></script>
	<script src="/socket.io/socket.io.js"></script>
	<style media="all" id="fa-main">/*!
 * Font Awesome Free 5.15.3 by @fontawesome - https://fontawesome.com
 * License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License)
 */.fa,.fab,.fad,.fal,.far,.fas{-moz-osx-font-smoothing:grayscale;-webkit-font-smoothing:antialiased;display:inline-block;font-style:normal;font-variant:normal;text-rendering:auto;line-height:1}.fa-lg{font-size:1.33333em;line-height:.75em;vertical-align:-.0667em}.fa-xs{font-size:.75em}.fa-sm{font-size:.875em}.fa-1x{font-size:1em}.fa-2x{font-size:2em}.fa-3x{font-size:3em}.fa-4x{font-size:4em}.fa-5x{font-size:5em}.fa-6x{font-size:6em}.fa-7x{font-size:7em}.fa-8x{font-size:8em}.fa-9x{font-size:9em}.fa-10x{font-size:10em}.fa-fw{text-align:center;width:1.25em}.fa-ul{list-style-type:none;margin-left:2.5em;padding-left:0}.fa-ul>li{position:relative}.fa-li{left:-2em;position:absolute;text-align:center;width:2em;line-height:inherit}.fa-border{border:.08em solid #eee;border-radius:.1em;padding:.2em .25em .15em}.fa-pull-left{float:left}.fa-pull-right{float:right}.fa.fa-pull-left,.fab.fa-pull-left,.fal.fa-pull-left,.far.fa-pull-left,.fas.fa-pull-left{margin-right:.3em}.fa.fa-pull-right,.fab.fa-pull-right,.fal.fa-pull-right,.far.fa-pull-right,.fas.fa-pull-right{margin-left:.3em}.fa-spin{-webkit-animation:fa-spin 2s linear infinite;animation:fa-spin 2s linear infinite}.fa-pulse{-webkit-animation:fa-spin 1s steps(8) infinite;animation:fa-spin 1s steps(8) infinite}@-webkit-keyframes fa-spin{0%{-webkit-transform:rotate(0deg);transform:rotate(0deg)}to{-webkit-transform:rotate(1turn);transform:rotate(1turn)}}@keyframes fa-spin{0%{-webkit-transform:rotate(0deg);transform:rotate(0deg)}to{-webkit-transform:rotate(1turn);transform:rotate(1turn)}}.fa-rotate-90{-ms-filter:"progid:DXImageTransform.Microsoft.BasicImage(rotation=1)";-webkit-transform:rotate(90deg);transform:rotate(90deg)}.fa-rotate-180{-ms-filter:"progid:DXImageTransform.Microsoft.BasicImage(rotation=2)";-webkit-transform:rotate(180deg);transform:rotate(180deg)}.fa-rotate-270{-ms-filter:"progid:DXImageTransform.Microsoft.BasicImage(rotation=3)";-webkit-transform:rotate(270deg);transform:rotate(270deg)}.fa-flip-horizontal{-ms-filter:"progid:DXImageTransform.Microsoft.BasicImage(rotation=0, mirror=1)";-webkit-transform:scaleX(-1);transform:scaleX(-1)}.fa-flip-vertical{-webkit-transform:scaleY(-1);transform:scaleY(-1)}.fa-flip-both,.fa-flip-horizontal.fa-flip-vertical,.fa-flip-vertical{-ms-filter:"progid:DXImageTransform.Microsoft.BasicImage(rotation=2, mirror=1)"}.fa-flip-both,.fa-flip-horizontal.fa-flip-vertical{-webkit-transform:scale(-1);transform:scale(-1)}:root .fa-flip-both,:root .fa-flip-horizontal,:root .fa-flip-vertical,:root .fa-rotate-90,:root .fa-rotate-180,:root .fa-rotate-270{-webkit-filter:none;filter:none}.fa-stack{display:inline-block;height:2em;line-height:2em;position:relative;vertical-align:middle;width:2.5em}.fa-stack-1x,.fa-stack-2x{left:0;position:absolute;text-align:center;width:100%}.fa-stack-1x{line-height:inherit}.fa-stack-2x{font-size:2em}.fa-inverse{color:#fff}.fa-500px:before{content:"\f26e"}.fa-accessible-icon:before{content:"\f368"}.fa-accusoft:before{content:"\f369"}.fa-acquisitions-incorporated:before{content:"\f6af"}.fa-ad:before{content:"\f641"}.fa-address-book:before{content:"\f2b9"}.fa-address-card:before{content:"\f2bb"}.fa-adjust:before{content:"\f042"}.fa-adn:before{content:"\f170"}.fa-adversal:before{content:"\f36a"}.fa-affiliatetheme:before{content:"\f36b"}.fa-air-freshener:before{content:"\f5d0"}.fa-airbnb:before{content:"\f834"}.fa-algolia:before{content:"\f36c"}.fa-align-center:before{content:"\f037"}.fa-align-justify:before{content:"\f039"}.fa-align-left:before{content:"\f036"}.fa-align-right:before{content:"\f038"}.fa-alipay:before{content:"\f642"}.fa-allergies:before{content:"\f461"}.fa-amazon:before{content:"\f270"}.fa-amazon-pay:before{content:"\f42c"}.fa-ambulance:before{content:"\f0f9"}.fa-american-sign-language-interpreting:before{content:"\f2a3"}.fa-amilia:before{content:"\f36d"}.fa-anchor:before{content:"\f13d"}.fa-android:before{content:"\f17b"}.fa-angellist:before{content:"\f209"}.fa-angle-double-down:before{content:"\f103"}.fa-angle-double-left:before{content:"\f100"}.fa-angle-double-right:before{content:"\f101"}.fa-angle-double-up:before{content:"\f102"}.fa-angle-down:before{content:"\f107"}.fa-angle-left:before{content:"\f104"}.fa-angle-right:before{content:"\f105"}.fa-angle-up:before{content:"\f106"}.fa-angry:before{content:"\f556"}.fa-angrycreative:before{content:"\f36e"}.fa-angular:before{content:"\f420"}.fa-ankh:before{content:"\f644"}.fa-app-store:before{content:"\f36f"}.fa-app-store-ios:before{content:"\f370"}.fa-apper:before{content:"\f371"}.fa-apple:before{content:"\f179"}.fa-apple-alt:before{content:"\f5d1"}.fa-apple-pay:before{content:"\f415"}.fa-archive:before{content:"\f187"}.fa-archway:before{content:"\f557"}.fa-arrow-alt-circle-down:before{content:"\f358"}.fa-arrow-alt-circle-left:before{content:"\f359"}.fa-arrow-alt-circle-right:before{content:"\f35a"}.fa-arrow-alt-circle-up:before{content:"\f35b"}.fa-arrow-circle-down:before{content:"\f0ab"}.fa-arrow-circle-left:before{content:"\f0a8"}.fa-arrow-circle-right:before{content:"\f0a9"}.fa-arrow-circle-up:before{content:"\f0aa"}.fa-arrow-down:before{content:"\f063"}.fa-arrow-left:before{content:"\f060"}.fa-arrow-right:before{content:"\f061"}.fa-arrow-up:before{content:"\f062"}.fa-arrows-alt:before{content:"\f0b2"}.fa-arrows-alt-h:before{content:"\f337"}.fa-arrows-alt-v:before{content:"\f338"}.fa-artstation:before{content:"\f77a"}.fa-assistive-listening-systems:before{content:"\f2a2"}.fa-asterisk:before{content:"\f069"}.fa-asymmetrik:before{content:"\f372"}.fa-at:before{content:"\f1fa"}.fa-atlas:before{content:"\f558"}.fa-atlassian:before{content:"\f77b"}.fa-atom:before{content:"\f5d2"}.fa-audible:before{content:"\f373"}.fa-audio-description:before{content:"\f29e"}.fa-autoprefixer:before{content:"\f41c"}.fa-avianex:before{content:"\f374"}.fa-aviato:before{content:"\f421"}.fa-award:before{content:"\f559"}.fa-aws:before{content:"\f375"}.fa-baby:before{content:"\f77c"}.fa-baby-carriage:before{content:"\f77d"}.fa-backspace:before{content:"\f55a"}.fa-backward:before{content:"\f04a"}.fa-bacon:before{content:"\f7e5"}.fa-bacteria:before{content:"\e059"}.fa-bacterium:before{content:"\e05a"}.fa-bahai:before{content:"\f666"}.fa-balance-scale:before{content:"\f24e"}.fa-balance-scale-left:before{content:"\f515"}.fa-balance-scale-right:before{content:"\f516"}.fa-ban:before{content:"\f05e"}.fa-band-aid:before{content:"\f462"}.fa-bandcamp:before{content:"\f2d5"}.fa-barcode:before{content:"\f02a"}.fa-bars:before{content:"\f0c9"}.fa-baseball-ball:before{content:"\f433"}.fa-basketball-ball:before{content:"\f434"}.fa-bath:before{content:"\f2cd"}.fa-battery-empty:before{content:"\f244"}.fa-battery-full:before{content:"\f240"}.fa-battery-half:before{content:"\f242"}.fa-battery-quarter:before{content:"\f243"}.fa-battery-three-quarters:before{content:"\f241"}.fa-battle-net:before{content:"\f835"}.fa-bed:before{content:"\f236"}.fa-beer:before{content:"\f0fc"}.fa-behance:before{content:"\f1b4"}.fa-behance-square:before{content:"\f1b5"}.fa-bell:before{content:"\f0f3"}.fa-bell-slash:before{content:"\f1f6"}.fa-bezier-curve:before{content:"\f55b"}.fa-bible:before{content:"\f647"}.fa-bicycle:before{content:"\f206"}.fa-biking:before{content:"\f84a"}.fa-bimobject:before{content:"\f378"}.fa-binoculars:before{content:"\f1e5"}.fa-biohazard:before{content:"\f780"}.fa-birthday-cake:before{content:"\f1fd"}.fa-bitbucket:before{content:"\f171"}.fa-bitcoin:before{content:"\f379"}.fa-bity:before{content:"\f37a"}.fa-black-tie:before{content:"\f27e"}.fa-blackberry:before{content:"\f37b"}.fa-blender:before{content:"\f517"}.fa-blender-phone:before{content:"\f6b6"}.fa-blind:before{content:"\f29d"}.fa-blog:before{content:"\f781"}.fa-blogger:before{content:"\f37c"}.fa-blogger-b:before{content:"\f37d"}.fa-bluetooth:before{content:"\f293"}.fa-bluetooth-b:before{content:"\f294"}.fa-bold:before{content:"\f032"}.fa-bolt:before{content:"\f0e7"}.fa-bomb:before{content:"\f1e2"}.fa-bone:before{content:"\f5d7"}.fa-bong:before{content:"\f55c"}.fa-book:before{content:"\f02d"}.fa-book-dead:before{content:"\f6b7"}.fa-book-medical:before{content:"\f7e6"}.fa-book-open:before{content:"\f518"}.fa-book-reader:before{content:"\f5da"}.fa-bookmark:before{content:"\f02e"}.fa-bootstrap:before{content:"\f836"}.fa-border-all:before{content:"\f84c"}.fa-border-none:before{content:"\f850"}.fa-border-style:before{content:"\f853"}.fa-bowling-ball:before{content:"\f436"}.fa-box:before{content:"\f466"}.fa-box-open:before{content:"\f49e"}.fa-box-tissue:before{content:"\e05b"}.fa-boxes:before{content:"\f468"}.fa-braille:before{content:"\f2a1"}.fa-brain:before{content:"\f5dc"}.fa-bread-slice:before{content:"\f7ec"}.fa-briefcase:before{content:"\f0b1"}.fa-briefcase-medical:before{content:"\f469"}.fa-broadcast-tower:before{content:"\f519"}.fa-broom:before{content:"\f51a"}.fa-brush:before{content:"\f55d"}.fa-btc:before{content:"\f15a"}.fa-buffer:before{content:"\f837"}.fa-bug:before{content:"\f188"}.fa-building:before{content:"\f1ad"}.fa-bullhorn:before{content:"\f0a1"}.fa-bullseye:before{content:"\f140"}.fa-burn:before{content:"\f46a"}.fa-buromobelexperte:before{content:"\f37f"}.fa-bus:before{content:"\f207"}.fa-bus-alt:before{content:"\f55e"}.fa-business-time:before{content:"\f64a"}.fa-buy-n-large:before{content:"\f8a6"}.fa-buysellads:before{content:"\f20d"}.fa-calculator:before{content:"\f1ec"}.fa-calendar:before{content:"\f133"}.fa-calendar-alt:before{content:"\f073"}.fa-calendar-check:before{content:"\f274"}.fa-calendar-day:before{content:"\f783"}.fa-calendar-minus:before{content:"\f272"}.fa-calendar-plus:before{content:"\f271"}.fa-calendar-times:before{content:"\f273"}.fa-calendar-week:before{content:"\f784"}.fa-camera:before{content:"\f030"}.fa-camera-retro:before{content:"\f083"}.fa-campground:before{content:"\f6bb"}.fa-canadian-maple-leaf:before{content:"\f785"}.fa-candy-cane:before{content:"\f786"}.fa-cannabis:before{content:"\f55f"}.fa-capsules:before{content:"\f46b"}.fa-car:before{content:"\f1b9"}.fa-car-alt:before{content:"\f5de"}.fa-car-battery:before{content:"\f5df"}.fa-car-crash:before{content:"\f5e1"}.fa-car-side:before{content:"\f5e4"}.fa-caravan:before{content:"\f8ff"}.fa-caret-down:before{content:"\f0d7"}.fa-caret-left:before{content:"\f0d9"}.fa-caret-right:before{content:"\f0da"}.fa-caret-square-down:before{content:"\f150"}.fa-caret-square-left:before{content:"\f191"}.fa-caret-square-right:before{content:"\f152"}.fa-caret-square-up:before{content:"\f151"}.fa-caret-up:before{content:"\f0d8"}.fa-carrot:before{content:"\f787"}.fa-cart-arrow-down:before{content:"\f218"}.fa-cart-plus:before{content:"\f217"}.fa-cash-register:before{content:"\f788"}.fa-cat:before{content:"\f6be"}.fa-cc-amazon-pay:before{content:"\f42d"}.fa-cc-amex:before{content:"\f1f3"}.fa-cc-apple-pay:before{content:"\f416"}.fa-cc-diners-club:before{content:"\f24c"}.fa-cc-discover:before{content:"\f1f2"}.fa-cc-jcb:before{content:"\f24b"}.fa-cc-mastercard:before{content:"\f1f1"}.fa-cc-paypal:before{content:"\f1f4"}.fa-cc-stripe:before{content:"\f1f5"}.fa-cc-visa:before{content:"\f1f0"}.fa-centercode:before{content:"\f380"}.fa-centos:before{content:"\f789"}.fa-certificate:before{content:"\f0a3"}.fa-chair:before{content:"\f6c0"}.fa-chalkboard:before{content:"\f51b"}.fa-chalkboard-teacher:before{content:"\f51c"}.fa-charging-station:before{content:"\f5e7"}.fa-chart-area:before{content:"\f1fe"}.fa-chart-bar:before{content:"\f080"}.fa-chart-line:before{content:"\f201"}.fa-chart-pie:before{content:"\f200"}.fa-check:before{content:"\f00c"}.fa-check-circle:before{content:"\f058"}.fa-check-double:before{content:"\f560"}.fa-check-square:before{content:"\f14a"}.fa-cheese:before{content:"\f7ef"}.fa-chess:before{content:"\f439"}.fa-chess-bishop:before{content:"\f43a"}.fa-chess-board:before{content:"\f43c"}.fa-chess-king:before{content:"\f43f"}.fa-chess-knight:before{content:"\f441"}.fa-chess-pawn:before{content:"\f443"}.fa-chess-queen:before{content:"\f445"}.fa-chess-rook:before{content:"\f447"}.fa-chevron-circle-down:before{content:"\f13a"}.fa-chevron-circle-left:before{content:"\f137"}.fa-chevron-circle-right:before{content:"\f138"}.fa-chevron-circle-up:before{content:"\f139"}.fa-chevron-down:before{content:"\f078"}.fa-chevron-left:before{content:"\f053"}.fa-chevron-right:before{content:"\f054"}.fa-chevron-up:before{content:"\f077"}.fa-child:before{content:"\f1ae"}.fa-chrome:before{content:"\f268"}.fa-chromecast:before{content:"\f838"}.fa-church:before{content:"\f51d"}.fa-circle:before{content:"\f111"}.fa-circle-notch:before{content:"\f1ce"}.fa-city:before{content:"\f64f"}.fa-clinic-medical:before{content:"\f7f2"}.fa-clipboard:before{content:"\f328"}.fa-clipboard-check:before{content:"\f46c"}.fa-clipboard-list:before{content:"\f46d"}.fa-clock:before{content:"\f017"}.fa-clone:before{content:"\f24d"}.fa-closed-captioning:before{content:"\f20a"}.fa-cloud:before{content:"\f0c2"}.fa-cloud-download-alt:before{content:"\f381"}.fa-cloud-meatball:before{content:"\f73b"}.fa-cloud-moon:before{content:"\f6c3"}.fa-cloud-moon-rain:before{content:"\f73c"}.fa-cloud-rain:before{content:"\f73d"}.fa-cloud-showers-heavy:before{content:"\f740"}.fa-cloud-sun:before{content:"\f6c4"}.fa-cloud-sun-rain:before{content:"\f743"}.fa-cloud-upload-alt:before{content:"\f382"}.fa-cloudflare:before{content:"\e07d"}.fa-cloudscale:before{content:"\f383"}.fa-cloudsmith:before{content:"\f384"}.fa-cloudversify:before{content:"\f385"}.fa-cocktail:before{content:"\f561"}.fa-code:before{content:"\f121"}.fa-code-branch:before{content:"\f126"}.fa-codepen:before{content:"\f1cb"}.fa-codiepie:before{content:"\f284"}.fa-coffee:before{content:"\f0f4"}.fa-cog:before{content:"\f013"}.fa-cogs:before{content:"\f085"}.fa-coins:before{content:"\f51e"}.fa-columns:before{content:"\f0db"}.fa-comment:before{content:"\f075"}.fa-comment-alt:before{content:"\f27a"}.fa-comment-dollar:before{content:"\f651"}.fa-comment-dots:before{content:"\f4ad"}.fa-comment-medical:before{content:"\f7f5"}.fa-comment-slash:before{content:"\f4b3"}.fa-comments:before{content:"\f086"}.fa-comments-dollar:before{content:"\f653"}.fa-compact-disc:before{content:"\f51f"}.fa-compass:before{content:"\f14e"}.fa-compress:before{content:"\f066"}.fa-compress-alt:before{content:"\f422"}.fa-compress-arrows-alt:before{content:"\f78c"}.fa-concierge-bell:before{content:"\f562"}.fa-confluence:before{content:"\f78d"}.fa-connectdevelop:before{content:"\f20e"}.fa-contao:before{content:"\f26d"}.fa-cookie:before{content:"\f563"}.fa-cookie-bite:before{content:"\f564"}.fa-copy:before{content:"\f0c5"}.fa-copyright:before{content:"\f1f9"}.fa-cotton-bureau:before{content:"\f89e"}.fa-couch:before{content:"\f4b8"}.fa-cpanel:before{content:"\f388"}.fa-creative-commons:before{content:"\f25e"}.fa-creative-commons-by:before{content:"\f4e7"}.fa-creative-commons-nc:before{content:"\f4e8"}.fa-creative-commons-nc-eu:before{content:"\f4e9"}.fa-creative-commons-nc-jp:before{content:"\f4ea"}.fa-creative-commons-nd:before{content:"\f4eb"}.fa-creative-commons-pd:before{content:"\f4ec"}.fa-creative-commons-pd-alt:before{content:"\f4ed"}.fa-creative-commons-remix:before{content:"\f4ee"}.fa-creative-commons-sa:before{content:"\f4ef"}.fa-creative-commons-sampling:before{content:"\f4f0"}.fa-creative-commons-sampling-plus:before{content:"\f4f1"}.fa-creative-commons-share:before{content:"\f4f2"}.fa-creative-commons-zero:before{content:"\f4f3"}.fa-credit-card:before{content:"\f09d"}.fa-critical-role:before{content:"\f6c9"}.fa-crop:before{content:"\f125"}.fa-crop-alt:before{content:"\f565"}.fa-cross:before{content:"\f654"}.fa-crosshairs:before{content:"\f05b"}.fa-crow:before{content:"\f520"}.fa-crown:before{content:"\f521"}.fa-crutch:before{content:"\f7f7"}.fa-css3:before{content:"\f13c"}.fa-css3-alt:before{content:"\f38b"}.fa-cube:before{content:"\f1b2"}.fa-cubes:before{content:"\f1b3"}.fa-cut:before{content:"\f0c4"}.fa-cuttlefish:before{content:"\f38c"}.fa-d-and-d:before{content:"\f38d"}.fa-d-and-d-beyond:before{content:"\f6ca"}.fa-dailymotion:before{content:"\e052"}.fa-dashcube:before{content:"\f210"}.fa-database:before{content:"\f1c0"}.fa-deaf:before{content:"\f2a4"}.fa-deezer:before{content:"\e077"}.fa-delicious:before{content:"\f1a5"}.fa-democrat:before{content:"\f747"}.fa-deploydog:before{content:"\f38e"}.fa-deskpro:before{content:"\f38f"}.fa-desktop:before{content:"\f108"}.fa-dev:before{content:"\f6cc"}.fa-deviantart:before{content:"\f1bd"}.fa-dharmachakra:before{content:"\f655"}.fa-dhl:before{content:"\f790"}.fa-diagnoses:before{content:"\f470"}.fa-diaspora:before{content:"\f791"}.fa-dice:before{content:"\f522"}.fa-dice-d20:before{content:"\f6cf"}.fa-dice-d6:before{content:"\f6d1"}.fa-dice-five:before{content:"\f523"}.fa-dice-four:before{content:"\f524"}.fa-dice-one:before{content:"\f525"}.fa-dice-six:before{content:"\f526"}.fa-dice-three:before{content:"\f527"}.fa-dice-two:before{content:"\f528"}.fa-digg:before{content:"\f1a6"}.fa-digital-ocean:before{content:"\f391"}.fa-digital-tachograph:before{content:"\f566"}.fa-directions:before{content:"\f5eb"}.fa-discord:before{content:"\f392"}.fa-discourse:before{content:"\f393"}.fa-disease:before{content:"\f7fa"}.fa-divide:before{content:"\f529"}.fa-dizzy:before{content:"\f567"}.fa-dna:before{content:"\f471"}.fa-dochub:before{content:"\f394"}.fa-docker:before{content:"\f395"}.fa-dog:before{content:"\f6d3"}.fa-dollar-sign:before{content:"\f155"}.fa-dolly:before{content:"\f472"}.fa-dolly-flatbed:before{content:"\f474"}.fa-donate:before{content:"\f4b9"}.fa-door-closed:before{content:"\f52a"}.fa-door-open:before{content:"\f52b"}.fa-dot-circle:before{content:"\f192"}.fa-dove:before{content:"\f4ba"}.fa-download:before{content:"\f019"}.fa-draft2digital:before{content:"\f396"}.fa-drafting-compass:before{content:"\f568"}.fa-dragon:before{content:"\f6d5"}.fa-draw-polygon:before{content:"\f5ee"}.fa-dribbble:before{content:"\f17d"}.fa-dribbble-square:before{content:"\f397"}.fa-dropbox:before{content:"\f16b"}.fa-drum:before{content:"\f569"}.fa-drum-steelpan:before{content:"\f56a"}.fa-drumstick-bite:before{content:"\f6d7"}.fa-drupal:before{content:"\f1a9"}.fa-dumbbell:before{content:"\f44b"}.fa-dumpster:before{content:"\f793"}.fa-dumpster-fire:before{content:"\f794"}.fa-dungeon:before{content:"\f6d9"}.fa-dyalog:before{content:"\f399"}.fa-earlybirds:before{content:"\f39a"}.fa-ebay:before{content:"\f4f4"}.fa-edge:before{content:"\f282"}.fa-edge-legacy:before{content:"\e078"}.fa-edit:before{content:"\f044"}.fa-egg:before{content:"\f7fb"}.fa-eject:before{content:"\f052"}.fa-elementor:before{content:"\f430"}.fa-ellipsis-h:before{content:"\f141"}.fa-ellipsis-v:before{content:"\f142"}.fa-ello:before{content:"\f5f1"}.fa-ember:before{content:"\f423"}.fa-empire:before{content:"\f1d1"}.fa-envelope:before{content:"\f0e0"}.fa-envelope-open:before{content:"\f2b6"}.fa-envelope-open-text:before{content:"\f658"}.fa-envelope-square:before{content:"\f199"}.fa-envira:before{content:"\f299"}.fa-equals:before{content:"\f52c"}.fa-eraser:before{content:"\f12d"}.fa-erlang:before{content:"\f39d"}.fa-ethereum:before{content:"\f42e"}.fa-ethernet:before{content:"\f796"}.fa-etsy:before{content:"\f2d7"}.fa-euro-sign:before{content:"\f153"}.fa-evernote:before{content:"\f839"}.fa-exchange-alt:before{content:"\f362"}.fa-exclamation:before{content:"\f12a"}.fa-exclamation-circle:before{content:"\f06a"}.fa-exclamation-triangle:before{content:"\f071"}.fa-expand:before{content:"\f065"}.fa-expand-alt:before{content:"\f424"}.fa-expand-arrows-alt:before{content:"\f31e"}.fa-expeditedssl:before{content:"\f23e"}.fa-external-link-alt:before{content:"\f35d"}.fa-external-link-square-alt:before{content:"\f360"}.fa-eye:before{content:"\f06e"}.fa-eye-dropper:before{content:"\f1fb"}.fa-eye-slash:before{content:"\f070"}.fa-facebook:before{content:"\f09a"}.fa-facebook-f:before{content:"\f39e"}.fa-facebook-messenger:before{content:"\f39f"}.fa-facebook-square:before{content:"\f082"}.fa-fan:before{content:"\f863"}.fa-fantasy-flight-games:before{content:"\f6dc"}.fa-fast-backward:before{content:"\f049"}.fa-fast-forward:before{content:"\f050"}.fa-faucet:before{content:"\e005"}.fa-fax:before{content:"\f1ac"}.fa-feather:before{content:"\f52d"}.fa-feather-alt:before{content:"\f56b"}.fa-fedex:before{content:"\f797"}.fa-fedora:before{content:"\f798"}.fa-female:before{content:"\f182"}.fa-fighter-jet:before{content:"\f0fb"}.fa-figma:before{content:"\f799"}.fa-file:before{content:"\f15b"}.fa-file-alt:before{content:"\f15c"}.fa-file-archive:before{content:"\f1c6"}.fa-file-audio:before{content:"\f1c7"}.fa-file-code:before{content:"\f1c9"}.fa-file-contract:before{content:"\f56c"}.fa-file-csv:before{content:"\f6dd"}.fa-file-download:before{content:"\f56d"}.fa-file-excel:before{content:"\f1c3"}.fa-file-export:before{content:"\f56e"}.fa-file-image:before{content:"\f1c5"}.fa-file-import:before{content:"\f56f"}.fa-file-invoice:before{content:"\f570"}.fa-file-invoice-dollar:before{content:"\f571"}.fa-file-medical:before{content:"\f477"}.fa-file-medical-alt:before{content:"\f478"}.fa-file-pdf:before{content:"\f1c1"}.fa-file-powerpoint:before{content:"\f1c4"}.fa-file-prescription:before{content:"\f572"}.fa-file-signature:before{content:"\f573"}.fa-file-upload:before{content:"\f574"}.fa-file-video:before{content:"\f1c8"}.fa-file-word:before{content:"\f1c2"}.fa-fill:before{content:"\f575"}.fa-fill-drip:before{content:"\f576"}.fa-film:before{content:"\f008"}.fa-filter:before{content:"\f0b0"}.fa-fingerprint:before{content:"\f577"}.fa-fire:before{content:"\f06d"}.fa-fire-alt:before{content:"\f7e4"}.fa-fire-extinguisher:before{content:"\f134"}.fa-firefox:before{content:"\f269"}.fa-firefox-browser:before{content:"\e007"}.fa-first-aid:before{content:"\f479"}.fa-first-order:before{content:"\f2b0"}.fa-first-order-alt:before{content:"\f50a"}.fa-firstdraft:before{content:"\f3a1"}.fa-fish:before{content:"\f578"}.fa-fist-raised:before{content:"\f6de"}.fa-flag:before{content:"\f024"}.fa-flag-checkered:before{content:"\f11e"}.fa-flag-usa:before{content:"\f74d"}.fa-flask:before{content:"\f0c3"}.fa-flickr:before{content:"\f16e"}.fa-flipboard:before{content:"\f44d"}.fa-flushed:before{content:"\f579"}.fa-fly:before{content:"\f417"}.fa-folder:before{content:"\f07b"}.fa-folder-minus:before{content:"\f65d"}.fa-folder-open:before{content:"\f07c"}.fa-folder-plus:before{content:"\f65e"}.fa-font:before{content:"\f031"}.fa-font-awesome:before{content:"\f2b4"}.fa-font-awesome-alt:before{content:"\f35c"}.fa-font-awesome-flag:before{content:"\f425"}.fa-font-awesome-logo-full:before{content:"\f4e6"}.fa-fonticons:before{content:"\f280"}.fa-fonticons-fi:before{content:"\f3a2"}.fa-football-ball:before{content:"\f44e"}.fa-fort-awesome:before{content:"\f286"}.fa-fort-awesome-alt:before{content:"\f3a3"}.fa-forumbee:before{content:"\f211"}.fa-forward:before{content:"\f04e"}.fa-foursquare:before{content:"\f180"}.fa-free-code-camp:before{content:"\f2c5"}.fa-freebsd:before{content:"\f3a4"}.fa-frog:before{content:"\f52e"}.fa-frown:before{content:"\f119"}.fa-frown-open:before{content:"\f57a"}.fa-fulcrum:before{content:"\f50b"}.fa-funnel-dollar:before{content:"\f662"}.fa-futbol:before{content:"\f1e3"}.fa-galactic-republic:before{content:"\f50c"}.fa-galactic-senate:before{content:"\f50d"}.fa-gamepad:before{content:"\f11b"}.fa-gas-pump:before{content:"\f52f"}.fa-gavel:before{content:"\f0e3"}.fa-gem:before{content:"\f3a5"}.fa-genderless:before{content:"\f22d"}.fa-get-pocket:before{content:"\f265"}.fa-gg:before{content:"\f260"}.fa-gg-circle:before{content:"\f261"}.fa-ghost:before{content:"\f6e2"}.fa-gift:before{content:"\f06b"}.fa-gifts:before{content:"\f79c"}.fa-git:before{content:"\f1d3"}.fa-git-alt:before{content:"\f841"}.fa-git-square:before{content:"\f1d2"}.fa-github:before{content:"\f09b"}.fa-github-alt:before{content:"\f113"}.fa-github-square:before{content:"\f092"}.fa-gitkraken:before{content:"\f3a6"}.fa-gitlab:before{content:"\f296"}.fa-gitter:before{content:"\f426"}.fa-glass-cheers:before{content:"\f79f"}.fa-glass-martini:before{content:"\f000"}.fa-glass-martini-alt:before{content:"\f57b"}.fa-glass-whiskey:before{content:"\f7a0"}.fa-glasses:before{content:"\f530"}.fa-glide:before{content:"\f2a5"}.fa-glide-g:before{content:"\f2a6"}.fa-globe:before{content:"\f0ac"}.fa-globe-africa:before{content:"\f57c"}.fa-globe-americas:before{content:"\f57d"}.fa-globe-asia:before{content:"\f57e"}.fa-globe-europe:before{content:"\f7a2"}.fa-gofore:before{content:"\f3a7"}.fa-golf-ball:before{content:"\f450"}.fa-goodreads:before{content:"\f3a8"}.fa-goodreads-g:before{content:"\f3a9"}.fa-google:before{content:"\f1a0"}.fa-google-drive:before{content:"\f3aa"}.fa-google-pay:before{content:"\e079"}.fa-google-play:before{content:"\f3ab"}.fa-google-plus:before{content:"\f2b3"}.fa-google-plus-g:before{content:"\f0d5"}.fa-google-plus-square:before{content:"\f0d4"}.fa-google-wallet:before{content:"\f1ee"}.fa-gopuram:before{content:"\f664"}.fa-graduation-cap:before{content:"\f19d"}.fa-gratipay:before{content:"\f184"}.fa-grav:before{content:"\f2d6"}.fa-greater-than:before{content:"\f531"}.fa-greater-than-equal:before{content:"\f532"}.fa-grimace:before{content:"\f57f"}.fa-grin:before{content:"\f580"}.fa-grin-alt:before{content:"\f581"}.fa-grin-beam:before{content:"\f582"}.fa-grin-beam-sweat:before{content:"\f583"}.fa-grin-hearts:before{content:"\f584"}.fa-grin-squint:before{content:"\f585"}.fa-grin-squint-tears:before{content:"\f586"}.fa-grin-stars:before{content:"\f587"}.fa-grin-tears:before{content:"\f588"}.fa-grin-tongue:before{content:"\f589"}.fa-grin-tongue-squint:before{content:"\f58a"}.fa-grin-tongue-wink:before{content:"\f58b"}.fa-grin-wink:before{content:"\f58c"}.fa-grip-horizontal:before{content:"\f58d"}.fa-grip-lines:before{content:"\f7a4"}.fa-grip-lines-vertical:before{content:"\f7a5"}.fa-grip-vertical:before{content:"\f58e"}.fa-gripfire:before{content:"\f3ac"}.fa-grunt:before{content:"\f3ad"}.fa-guilded:before{content:"\e07e"}.fa-guitar:before{content:"\f7a6"}.fa-gulp:before{content:"\f3ae"}.fa-h-square:before{content:"\f0fd"}.fa-hacker-news:before{content:"\f1d4"}.fa-hacker-news-square:before{content:"\f3af"}.fa-hackerrank:before{content:"\f5f7"}.fa-hamburger:before{content:"\f805"}.fa-hammer:before{content:"\f6e3"}.fa-hamsa:before{content:"\f665"}.fa-hand-holding:before{content:"\f4bd"}.fa-hand-holding-heart:before{content:"\f4be"}.fa-hand-holding-medical:before{content:"\e05c"}.fa-hand-holding-usd:before{content:"\f4c0"}.fa-hand-holding-water:before{content:"\f4c1"}.fa-hand-lizard:before{content:"\f258"}.fa-hand-middle-finger:before{content:"\f806"}.fa-hand-paper:before{content:"\f256"}.fa-hand-peace:before{content:"\f25b"}.fa-hand-point-down:before{content:"\f0a7"}.fa-hand-point-left:before{content:"\f0a5"}.fa-hand-point-right:before{content:"\f0a4"}.fa-hand-point-up:before{content:"\f0a6"}.fa-hand-pointer:before{content:"\f25a"}.fa-hand-rock:before{content:"\f255"}.fa-hand-scissors:before{content:"\f257"}.fa-hand-sparkles:before{content:"\e05d"}.fa-hand-spock:before{content:"\f259"}.fa-hands:before{content:"\f4c2"}.fa-hands-helping:before{content:"\f4c4"}.fa-hands-wash:before{content:"\e05e"}.fa-handshake:before{content:"\f2b5"}.fa-handshake-alt-slash:before{content:"\e05f"}.fa-handshake-slash:before{content:"\e060"}.fa-hanukiah:before{content:"\f6e6"}.fa-hard-hat:before{content:"\f807"}.fa-hashtag:before{content:"\f292"}.fa-hat-cowboy:before{content:"\f8c0"}.fa-hat-cowboy-side:before{content:"\f8c1"}.fa-hat-wizard:before{content:"\f6e8"}.fa-hdd:before{content:"\f0a0"}.fa-head-side-cough:before{content:"\e061"}.fa-head-side-cough-slash:before{content:"\e062"}.fa-head-side-mask:before{content:"\e063"}.fa-head-side-virus:before{content:"\e064"}.fa-heading:before{content:"\f1dc"}.fa-headphones:before{content:"\f025"}.fa-headphones-alt:before{content:"\f58f"}.fa-headset:before{content:"\f590"}.fa-heart:before{content:"\f004"}.fa-heart-broken:before{content:"\f7a9"}.fa-heartbeat:before{content:"\f21e"}.fa-helicopter:before{content:"\f533"}.fa-highlighter:before{content:"\f591"}.fa-hiking:before{content:"\f6ec"}.fa-hippo:before{content:"\f6ed"}.fa-hips:before{content:"\f452"}.fa-hire-a-helper:before{content:"\f3b0"}.fa-history:before{content:"\f1da"}.fa-hive:before{content:"\e07f"}.fa-hockey-puck:before{content:"\f453"}.fa-holly-berry:before{content:"\f7aa"}.fa-home:before{content:"\f015"}.fa-hooli:before{content:"\f427"}.fa-hornbill:before{content:"\f592"}.fa-horse:before{content:"\f6f0"}.fa-horse-head:before{content:"\f7ab"}.fa-hospital:before{content:"\f0f8"}.fa-hospital-alt:before{content:"\f47d"}.fa-hospital-symbol:before{content:"\f47e"}.fa-hospital-user:before{content:"\f80d"}.fa-hot-tub:before{content:"\f593"}.fa-hotdog:before{content:"\f80f"}.fa-hotel:before{content:"\f594"}.fa-hotjar:before{content:"\f3b1"}.fa-hourglass:before{content:"\f254"}.fa-hourglass-end:before{content:"\f253"}.fa-hourglass-half:before{content:"\f252"}.fa-hourglass-start:before{content:"\f251"}.fa-house-damage:before{content:"\f6f1"}.fa-house-user:before{content:"\e065"}.fa-houzz:before{content:"\f27c"}.fa-hryvnia:before{content:"\f6f2"}.fa-html5:before{content:"\f13b"}.fa-hubspot:before{content:"\f3b2"}.fa-i-cursor:before{content:"\f246"}.fa-ice-cream:before{content:"\f810"}.fa-icicles:before{content:"\f7ad"}.fa-icons:before{content:"\f86d"}.fa-id-badge:before{content:"\f2c1"}.fa-id-card:before{content:"\f2c2"}.fa-id-card-alt:before{content:"\f47f"}.fa-ideal:before{content:"\e013"}.fa-igloo:before{content:"\f7ae"}.fa-image:before{content:"\f03e"}.fa-images:before{content:"\f302"}.fa-imdb:before{content:"\f2d8"}.fa-inbox:before{content:"\f01c"}.fa-indent:before{content:"\f03c"}.fa-industry:before{content:"\f275"}.fa-infinity:before{content:"\f534"}.fa-info:before{content:"\f129"}.fa-info-circle:before{content:"\f05a"}.fa-innosoft:before{content:"\e080"}.fa-instagram:before{content:"\f16d"}.fa-instagram-square:before{content:"\e055"}.fa-instalod:before{content:"\e081"}.fa-intercom:before{content:"\f7af"}.fa-internet-explorer:before{content:"\f26b"}.fa-invision:before{content:"\f7b0"}.fa-ioxhost:before{content:"\f208"}.fa-italic:before{content:"\f033"}.fa-itch-io:before{content:"\f83a"}.fa-itunes:before{content:"\f3b4"}.fa-itunes-note:before{content:"\f3b5"}.fa-java:before{content:"\f4e4"}.fa-jedi:before{content:"\f669"}.fa-jedi-order:before{content:"\f50e"}.fa-jenkins:before{content:"\f3b6"}.fa-jira:before{content:"\f7b1"}.fa-joget:before{content:"\f3b7"}.fa-joint:before{content:"\f595"}.fa-joomla:before{content:"\f1aa"}.fa-journal-whills:before{content:"\f66a"}.fa-js:before{content:"\f3b8"}.fa-js-square:before{content:"\f3b9"}.fa-jsfiddle:before{content:"\f1cc"}.fa-kaaba:before{content:"\f66b"}.fa-kaggle:before{content:"\f5fa"}.fa-key:before{content:"\f084"}.fa-keybase:before{content:"\f4f5"}.fa-keyboard:before{content:"\f11c"}.fa-keycdn:before{content:"\f3ba"}.fa-khanda:before{content:"\f66d"}.fa-kickstarter:before{content:"\f3bb"}.fa-kickstarter-k:before{content:"\f3bc"}.fa-kiss:before{content:"\f596"}.fa-kiss-beam:before{content:"\f597"}.fa-kiss-wink-heart:before{content:"\f598"}.fa-kiwi-bird:before{content:"\f535"}.fa-korvue:before{content:"\f42f"}.fa-landmark:before{content:"\f66f"}.fa-language:before{content:"\f1ab"}.fa-laptop:before{content:"\f109"}.fa-laptop-code:before{content:"\f5fc"}.fa-laptop-house:before{content:"\e066"}.fa-laptop-medical:before{content:"\f812"}.fa-laravel:before{content:"\f3bd"}.fa-lastfm:before{content:"\f202"}.fa-lastfm-square:before{content:"\f203"}.fa-laugh:before{content:"\f599"}.fa-laugh-beam:before{content:"\f59a"}.fa-laugh-squint:before{content:"\f59b"}.fa-laugh-wink:before{content:"\f59c"}.fa-layer-group:before{content:"\f5fd"}.fa-leaf:before{content:"\f06c"}.fa-leanpub:before{content:"\f212"}.fa-lemon:before{content:"\f094"}.fa-less:before{content:"\f41d"}.fa-less-than:before{content:"\f536"}.fa-less-than-equal:before{content:"\f537"}.fa-level-down-alt:before{content:"\f3be"}.fa-level-up-alt:before{content:"\f3bf"}.fa-life-ring:before{content:"\f1cd"}.fa-lightbulb:before{content:"\f0eb"}.fa-line:before{content:"\f3c0"}.fa-link:before{content:"\f0c1"}.fa-linkedin:before{content:"\f08c"}.fa-linkedin-in:before{content:"\f0e1"}.fa-linode:before{content:"\f2b8"}.fa-linux:before{content:"\f17c"}.fa-lira-sign:before{content:"\f195"}.fa-list:before{content:"\f03a"}.fa-list-alt:before{content:"\f022"}.fa-list-ol:before{content:"\f0cb"}.fa-list-ul:before{content:"\f0ca"}.fa-location-arrow:before{content:"\f124"}.fa-lock:before{content:"\f023"}.fa-lock-open:before{content:"\f3c1"}.fa-long-arrow-alt-down:before{content:"\f309"}.fa-long-arrow-alt-left:before{content:"\f30a"}.fa-long-arrow-alt-right:before{content:"\f30b"}.fa-long-arrow-alt-up:before{content:"\f30c"}.fa-low-vision:before{content:"\f2a8"}.fa-luggage-cart:before{content:"\f59d"}.fa-lungs:before{content:"\f604"}.fa-lungs-virus:before{content:"\e067"}.fa-lyft:before{content:"\f3c3"}.fa-magento:before{content:"\f3c4"}.fa-magic:before{content:"\f0d0"}.fa-magnet:before{content:"\f076"}.fa-mail-bulk:before{content:"\f674"}.fa-mailchimp:before{content:"\f59e"}.fa-male:before{content:"\f183"}.fa-mandalorian:before{content:"\f50f"}.fa-map:before{content:"\f279"}.fa-map-marked:before{content:"\f59f"}.fa-map-marked-alt:before{content:"\f5a0"}.fa-map-marker:before{content:"\f041"}.fa-map-marker-alt:before{content:"\f3c5"}.fa-map-pin:before{content:"\f276"}.fa-map-signs:before{content:"\f277"}.fa-markdown:before{content:"\f60f"}.fa-marker:before{content:"\f5a1"}.fa-mars:before{content:"\f222"}.fa-mars-double:before{content:"\f227"}.fa-mars-stroke:before{content:"\f229"}.fa-mars-stroke-h:before{content:"\f22b"}.fa-mars-stroke-v:before{content:"\f22a"}.fa-mask:before{content:"\f6fa"}.fa-mastodon:before{content:"\f4f6"}.fa-maxcdn:before{content:"\f136"}.fa-mdb:before{content:"\f8ca"}.fa-medal:before{content:"\f5a2"}.fa-medapps:before{content:"\f3c6"}.fa-medium:before{content:"\f23a"}.fa-medium-m:before{content:"\f3c7"}.fa-medkit:before{content:"\f0fa"}.fa-medrt:before{content:"\f3c8"}.fa-meetup:before{content:"\f2e0"}.fa-megaport:before{content:"\f5a3"}.fa-meh:before{content:"\f11a"}.fa-meh-blank:before{content:"\f5a4"}.fa-meh-rolling-eyes:before{content:"\f5a5"}.fa-memory:before{content:"\f538"}.fa-mendeley:before{content:"\f7b3"}.fa-menorah:before{content:"\f676"}.fa-mercury:before{content:"\f223"}.fa-meteor:before{content:"\f753"}.fa-microblog:before{content:"\e01a"}.fa-microchip:before{content:"\f2db"}.fa-microphone:before{content:"\f130"}.fa-microphone-alt:before{content:"\f3c9"}.fa-microphone-alt-slash:before{content:"\f539"}.fa-microphone-slash:before{content:"\f131"}.fa-microscope:before{content:"\f610"}.fa-microsoft:before{content:"\f3ca"}.fa-minus:before{content:"\f068"}.fa-minus-circle:before{content:"\f056"}.fa-minus-square:before{content:"\f146"}.fa-mitten:before{content:"\f7b5"}.fa-mix:before{content:"\f3cb"}.fa-mixcloud:before{content:"\f289"}.fa-mixer:before{content:"\e056"}.fa-mizuni:before{content:"\f3cc"}.fa-mobile:before{content:"\f10b"}.fa-mobile-alt:before{content:"\f3cd"}.fa-modx:before{content:"\f285"}.fa-monero:before{content:"\f3d0"}.fa-money-bill:before{content:"\f0d6"}.fa-money-bill-alt:before{content:"\f3d1"}.fa-money-bill-wave:before{content:"\f53a"}.fa-money-bill-wave-alt:before{content:"\f53b"}.fa-money-check:before{content:"\f53c"}.fa-money-check-alt:before{content:"\f53d"}.fa-monument:before{content:"\f5a6"}.fa-moon:before{content:"\f186"}.fa-mortar-pestle:before{content:"\f5a7"}.fa-mosque:before{content:"\f678"}.fa-motorcycle:before{content:"\f21c"}.fa-mountain:before{content:"\f6fc"}.fa-mouse:before{content:"\f8cc"}.fa-mouse-pointer:before{content:"\f245"}.fa-mug-hot:before{content:"\f7b6"}.fa-music:before{content:"\f001"}.fa-napster:before{content:"\f3d2"}.fa-neos:before{content:"\f612"}.fa-network-wired:before{content:"\f6ff"}.fa-neuter:before{content:"\f22c"}.fa-newspaper:before{content:"\f1ea"}.fa-nimblr:before{content:"\f5a8"}.fa-node:before{content:"\f419"}.fa-node-js:before{content:"\f3d3"}.fa-not-equal:before{content:"\f53e"}.fa-notes-medical:before{content:"\f481"}.fa-npm:before{content:"\f3d4"}.fa-ns8:before{content:"\f3d5"}.fa-nutritionix:before{content:"\f3d6"}.fa-object-group:before{content:"\f247"}.fa-object-ungroup:before{content:"\f248"}.fa-octopus-deploy:before{content:"\e082"}.fa-odnoklassniki:before{content:"\f263"}.fa-odnoklassniki-square:before{content:"\f264"}.fa-oil-can:before{content:"\f613"}.fa-old-republic:before{content:"\f510"}.fa-om:before{content:"\f679"}.fa-opencart:before{content:"\f23d"}.fa-openid:before{content:"\f19b"}.fa-opera:before{content:"\f26a"}.fa-optin-monster:before{content:"\f23c"}.fa-orcid:before{content:"\f8d2"}.fa-osi:before{content:"\f41a"}.fa-otter:before{content:"\f700"}.fa-outdent:before{content:"\f03b"}.fa-page4:before{content:"\f3d7"}.fa-pagelines:before{content:"\f18c"}.fa-pager:before{content:"\f815"}.fa-paint-brush:before{content:"\f1fc"}.fa-paint-roller:before{content:"\f5aa"}.fa-palette:before{content:"\f53f"}.fa-palfed:before{content:"\f3d8"}.fa-pallet:before{content:"\f482"}.fa-paper-plane:before{content:"\f1d8"}.fa-paperclip:before{content:"\f0c6"}.fa-parachute-box:before{content:"\f4cd"}.fa-paragraph:before{content:"\f1dd"}.fa-parking:before{content:"\f540"}.fa-passport:before{content:"\f5ab"}.fa-pastafarianism:before{content:"\f67b"}.fa-paste:before{content:"\f0ea"}.fa-patreon:before{content:"\f3d9"}.fa-pause:before{content:"\f04c"}.fa-pause-circle:before{content:"\f28b"}.fa-paw:before{content:"\f1b0"}.fa-paypal:before{content:"\f1ed"}.fa-peace:before{content:"\f67c"}.fa-pen:before{content:"\f304"}.fa-pen-alt:before{content:"\f305"}.fa-pen-fancy:before{content:"\f5ac"}.fa-pen-nib:before{content:"\f5ad"}.fa-pen-square:before{content:"\f14b"}.fa-pencil-alt:before{content:"\f303"}.fa-pencil-ruler:before{content:"\f5ae"}.fa-penny-arcade:before{content:"\f704"}.fa-people-arrows:before{content:"\e068"}.fa-people-carry:before{content:"\f4ce"}.fa-pepper-hot:before{content:"\f816"}.fa-perbyte:before{content:"\e083"}.fa-percent:before{content:"\f295"}.fa-percentage:before{content:"\f541"}.fa-periscope:before{content:"\f3da"}.fa-person-booth:before{content:"\f756"}.fa-phabricator:before{content:"\f3db"}.fa-phoenix-framework:before{content:"\f3dc"}.fa-phoenix-squadron:before{content:"\f511"}.fa-phone:before{content:"\f095"}.fa-phone-alt:before{content:"\f879"}.fa-phone-slash:before{content:"\f3dd"}.fa-phone-square:before{content:"\f098"}.fa-phone-square-alt:before{content:"\f87b"}.fa-phone-volume:before{content:"\f2a0"}.fa-photo-video:before{content:"\f87c"}.fa-php:before{content:"\f457"}.fa-pied-piper:before{content:"\f2ae"}.fa-pied-piper-alt:before{content:"\f1a8"}.fa-pied-piper-hat:before{content:"\f4e5"}.fa-pied-piper-pp:before{content:"\f1a7"}.fa-pied-piper-square:before{content:"\e01e"}.fa-piggy-bank:before{content:"\f4d3"}.fa-pills:before{content:"\f484"}.fa-pinterest:before{content:"\f0d2"}.fa-pinterest-p:before{content:"\f231"}.fa-pinterest-square:before{content:"\f0d3"}.fa-pizza-slice:before{content:"\f818"}.fa-place-of-worship:before{content:"\f67f"}.fa-plane:before{content:"\f072"}.fa-plane-arrival:before{content:"\f5af"}.fa-plane-departure:before{content:"\f5b0"}.fa-plane-slash:before{content:"\e069"}.fa-play:before{content:"\f04b"}.fa-play-circle:before{content:"\f144"}.fa-playstation:before{content:"\f3df"}.fa-plug:before{content:"\f1e6"}.fa-plus:before{content:"\f067"}.fa-plus-circle:before{content:"\f055"}.fa-plus-square:before{content:"\f0fe"}.fa-podcast:before{content:"\f2ce"}.fa-poll:before{content:"\f681"}.fa-poll-h:before{content:"\f682"}.fa-poo:before{content:"\f2fe"}.fa-poo-storm:before{content:"\f75a"}.fa-poop:before{content:"\f619"}.fa-portrait:before{content:"\f3e0"}.fa-pound-sign:before{content:"\f154"}.fa-power-off:before{content:"\f011"}.fa-pray:before{content:"\f683"}.fa-praying-hands:before{content:"\f684"}.fa-prescription:before{content:"\f5b1"}.fa-prescription-bottle:before{content:"\f485"}.fa-prescription-bottle-alt:before{content:"\f486"}.fa-print:before{content:"\f02f"}.fa-procedures:before{content:"\f487"}.fa-product-hunt:before{content:"\f288"}.fa-project-diagram:before{content:"\f542"}.fa-pump-medical:before{content:"\e06a"}.fa-pump-soap:before{content:"\e06b"}.fa-pushed:before{content:"\f3e1"}.fa-puzzle-piece:before{content:"\f12e"}.fa-python:before{content:"\f3e2"}.fa-qq:before{content:"\f1d6"}.fa-qrcode:before{content:"\f029"}.fa-question:before{content:"\f128"}.fa-question-circle:before{content:"\f059"}.fa-quidditch:before{content:"\f458"}.fa-quinscape:before{content:"\f459"}.fa-quora:before{content:"\f2c4"}.fa-quote-left:before{content:"\f10d"}.fa-quote-right:before{content:"\f10e"}.fa-quran:before{content:"\f687"}.fa-r-project:before{content:"\f4f7"}.fa-radiation:before{content:"\f7b9"}.fa-radiation-alt:before{content:"\f7ba"}.fa-rainbow:before{content:"\f75b"}.fa-random:before{content:"\f074"}.fa-raspberry-pi:before{content:"\f7bb"}.fa-ravelry:before{content:"\f2d9"}.fa-react:before{content:"\f41b"}.fa-reacteurope:before{content:"\f75d"}.fa-readme:before{content:"\f4d5"}.fa-rebel:before{content:"\f1d0"}.fa-receipt:before{content:"\f543"}.fa-record-vinyl:before{content:"\f8d9"}.fa-recycle:before{content:"\f1b8"}.fa-red-river:before{content:"\f3e3"}.fa-reddit:before{content:"\f1a1"}.fa-reddit-alien:before{content:"\f281"}.fa-reddit-square:before{content:"\f1a2"}.fa-redhat:before{content:"\f7bc"}.fa-redo:before{content:"\f01e"}.fa-redo-alt:before{content:"\f2f9"}.fa-registered:before{content:"\f25d"}.fa-remove-format:before{content:"\f87d"}.fa-renren:before{content:"\f18b"}.fa-reply:before{content:"\f3e5"}.fa-reply-all:before{content:"\f122"}.fa-replyd:before{content:"\f3e6"}.fa-republican:before{content:"\f75e"}.fa-researchgate:before{content:"\f4f8"}.fa-resolving:before{content:"\f3e7"}.fa-restroom:before{content:"\f7bd"}.fa-retweet:before{content:"\f079"}.fa-rev:before{content:"\f5b2"}.fa-ribbon:before{content:"\f4d6"}.fa-ring:before{content:"\f70b"}.fa-road:before{content:"\f018"}.fa-robot:before{content:"\f544"}.fa-rocket:before{content:"\f135"}.fa-rocketchat:before{content:"\f3e8"}.fa-rockrms:before{content:"\f3e9"}.fa-route:before{content:"\f4d7"}.fa-rss:before{content:"\f09e"}.fa-rss-square:before{content:"\f143"}.fa-ruble-sign:before{content:"\f158"}.fa-ruler:before{content:"\f545"}.fa-ruler-combined:before{content:"\f546"}.fa-ruler-horizontal:before{content:"\f547"}.fa-ruler-vertical:before{content:"\f548"}.fa-running:before{content:"\f70c"}.fa-rupee-sign:before{content:"\f156"}.fa-rust:before{content:"\e07a"}.fa-sad-cry:before{content:"\f5b3"}.fa-sad-tear:before{content:"\f5b4"}.fa-safari:before{content:"\f267"}.fa-salesforce:before{content:"\f83b"}.fa-sass:before{content:"\f41e"}.fa-satellite:before{content:"\f7bf"}.fa-satellite-dish:before{content:"\f7c0"}.fa-save:before{content:"\f0c7"}.fa-schlix:before{content:"\f3ea"}.fa-school:before{content:"\f549"}.fa-screwdriver:before{content:"\f54a"}.fa-scribd:before{content:"\f28a"}.fa-scroll:before{content:"\f70e"}.fa-sd-card:before{content:"\f7c2"}.fa-search:before{content:"\f002"}.fa-search-dollar:before{content:"\f688"}.fa-search-location:before{content:"\f689"}.fa-search-minus:before{content:"\f010"}.fa-search-plus:before{content:"\f00e"}.fa-searchengin:before{content:"\f3eb"}.fa-seedling:before{content:"\f4d8"}.fa-sellcast:before{content:"\f2da"}.fa-sellsy:before{content:"\f213"}.fa-server:before{content:"\f233"}.fa-servicestack:before{content:"\f3ec"}.fa-shapes:before{content:"\f61f"}.fa-share:before{content:"\f064"}.fa-share-alt:before{content:"\f1e0"}.fa-share-alt-square:before{content:"\f1e1"}.fa-share-square:before{content:"\f14d"}.fa-shekel-sign:before{content:"\f20b"}.fa-shield-alt:before{content:"\f3ed"}.fa-shield-virus:before{content:"\e06c"}.fa-ship:before{content:"\f21a"}.fa-shipping-fast:before{content:"\f48b"}.fa-shirtsinbulk:before{content:"\f214"}.fa-shoe-prints:before{content:"\f54b"}.fa-shopify:before{content:"\e057"}.fa-shopping-bag:before{content:"\f290"}.fa-shopping-basket:before{content:"\f291"}.fa-shopping-cart:before{content:"\f07a"}.fa-shopware:before{content:"\f5b5"}.fa-shower:before{content:"\f2cc"}.fa-shuttle-van:before{content:"\f5b6"}.fa-sign:before{content:"\f4d9"}.fa-sign-in-alt:before{content:"\f2f6"}.fa-sign-language:before{content:"\f2a7"}.fa-sign-out-alt:before{content:"\f2f5"}.fa-signal:before{content:"\f012"}.fa-signature:before{content:"\f5b7"}.fa-sim-card:before{content:"\f7c4"}.fa-simplybuilt:before{content:"\f215"}.fa-sink:before{content:"\e06d"}.fa-sistrix:before{content:"\f3ee"}.fa-sitemap:before{content:"\f0e8"}.fa-sith:before{content:"\f512"}.fa-skating:before{content:"\f7c5"}.fa-sketch:before{content:"\f7c6"}.fa-skiing:before{content:"\f7c9"}.fa-skiing-nordic:before{content:"\f7ca"}.fa-skull:before{content:"\f54c"}.fa-skull-crossbones:before{content:"\f714"}.fa-skyatlas:before{content:"\f216"}.fa-skype:before{content:"\f17e"}.fa-slack:before{content:"\f198"}.fa-slack-hash:before{content:"\f3ef"}.fa-slash:before{content:"\f715"}.fa-sleigh:before{content:"\f7cc"}.fa-sliders-h:before{content:"\f1de"}.fa-slideshare:before{content:"\f1e7"}.fa-smile:before{content:"\f118"}.fa-smile-beam:before{content:"\f5b8"}.fa-smile-wink:before{content:"\f4da"}.fa-smog:before{content:"\f75f"}.fa-smoking:before{content:"\f48d"}.fa-smoking-ban:before{content:"\f54d"}.fa-sms:before{content:"\f7cd"}.fa-snapchat:before{content:"\f2ab"}.fa-snapchat-ghost:before{content:"\f2ac"}.fa-snapchat-square:before{content:"\f2ad"}.fa-snowboarding:before{content:"\f7ce"}.fa-snowflake:before{content:"\f2dc"}.fa-snowman:before{content:"\f7d0"}.fa-snowplow:before{content:"\f7d2"}.fa-soap:before{content:"\e06e"}.fa-socks:before{content:"\f696"}.fa-solar-panel:before{content:"\f5ba"}.fa-sort:before{content:"\f0dc"}.fa-sort-alpha-down:before{content:"\f15d"}.fa-sort-alpha-down-alt:before{content:"\f881"}.fa-sort-alpha-up:before{content:"\f15e"}.fa-sort-alpha-up-alt:before{content:"\f882"}.fa-sort-amount-down:before{content:"\f160"}.fa-sort-amount-down-alt:before{content:"\f884"}.fa-sort-amount-up:before{content:"\f161"}.fa-sort-amount-up-alt:before{content:"\f885"}.fa-sort-down:before{content:"\f0dd"}.fa-sort-numeric-down:before{content:"\f162"}.fa-sort-numeric-down-alt:before{content:"\f886"}.fa-sort-numeric-up:before{content:"\f163"}.fa-sort-numeric-up-alt:before{content:"\f887"}.fa-sort-up:before{content:"\f0de"}.fa-soundcloud:before{content:"\f1be"}.fa-sourcetree:before{content:"\f7d3"}.fa-spa:before{content:"\f5bb"}.fa-space-shuttle:before{content:"\f197"}.fa-speakap:before{content:"\f3f3"}.fa-speaker-deck:before{content:"\f83c"}.fa-spell-check:before{content:"\f891"}.fa-spider:before{content:"\f717"}.fa-spinner:before{content:"\f110"}.fa-splotch:before{content:"\f5bc"}.fa-spotify:before{content:"\f1bc"}.fa-spray-can:before{content:"\f5bd"}.fa-square:before{content:"\f0c8"}.fa-square-full:before{content:"\f45c"}.fa-square-root-alt:before{content:"\f698"}.fa-squarespace:before{content:"\f5be"}.fa-stack-exchange:before{content:"\f18d"}.fa-stack-overflow:before{content:"\f16c"}.fa-stackpath:before{content:"\f842"}.fa-stamp:before{content:"\f5bf"}.fa-star:before{content:"\f005"}.fa-star-and-crescent:before{content:"\f699"}.fa-star-half:before{content:"\f089"}.fa-star-half-alt:before{content:"\f5c0"}.fa-star-of-david:before{content:"\f69a"}.fa-star-of-life:before{content:"\f621"}.fa-staylinked:before{content:"\f3f5"}.fa-steam:before{content:"\f1b6"}.fa-steam-square:before{content:"\f1b7"}.fa-steam-symbol:before{content:"\f3f6"}.fa-step-backward:before{content:"\f048"}.fa-step-forward:before{content:"\f051"}.fa-stethoscope:before{content:"\f0f1"}.fa-sticker-mule:before{content:"\f3f7"}.fa-sticky-note:before{content:"\f249"}.fa-stop:before{content:"\f04d"}.fa-stop-circle:before{content:"\f28d"}.fa-stopwatch:before{content:"\f2f2"}.fa-stopwatch-20:before{content:"\e06f"}.fa-store:before{content:"\f54e"}.fa-store-alt:before{content:"\f54f"}.fa-store-alt-slash:before{content:"\e070"}.fa-store-slash:before{content:"\e071"}.fa-strava:before{content:"\f428"}.fa-stream:before{content:"\f550"}.fa-street-view:before{content:"\f21d"}.fa-strikethrough:before{content:"\f0cc"}.fa-stripe:before{content:"\f429"}.fa-stripe-s:before{content:"\f42a"}.fa-stroopwafel:before{content:"\f551"}.fa-studiovinari:before{content:"\f3f8"}.fa-stumbleupon:before{content:"\f1a4"}.fa-stumbleupon-circle:before{content:"\f1a3"}.fa-subscript:before{content:"\f12c"}.fa-subway:before{content:"\f239"}.fa-suitcase:before{content:"\f0f2"}.fa-suitcase-rolling:before{content:"\f5c1"}.fa-sun:before{content:"\f185"}.fa-superpowers:before{content:"\f2dd"}.fa-superscript:before{content:"\f12b"}.fa-supple:before{content:"\f3f9"}.fa-surprise:before{content:"\f5c2"}.fa-suse:before{content:"\f7d6"}.fa-swatchbook:before{content:"\f5c3"}.fa-swift:before{content:"\f8e1"}.fa-swimmer:before{content:"\f5c4"}.fa-swimming-pool:before{content:"\f5c5"}.fa-symfony:before{content:"\f83d"}.fa-synagogue:before{content:"\f69b"}.fa-sync:before{content:"\f021"}.fa-sync-alt:before{content:"\f2f1"}.fa-syringe:before{content:"\f48e"}.fa-table:before{content:"\f0ce"}.fa-table-tennis:before{content:"\f45d"}.fa-tablet:before{content:"\f10a"}.fa-tablet-alt:before{content:"\f3fa"}.fa-tablets:before{content:"\f490"}.fa-tachometer-alt:before{content:"\f3fd"}.fa-tag:before{content:"\f02b"}.fa-tags:before{content:"\f02c"}.fa-tape:before{content:"\f4db"}.fa-tasks:before{content:"\f0ae"}.fa-taxi:before{content:"\f1ba"}.fa-teamspeak:before{content:"\f4f9"}.fa-teeth:before{content:"\f62e"}.fa-teeth-open:before{content:"\f62f"}.fa-telegram:before{content:"\f2c6"}.fa-telegram-plane:before{content:"\f3fe"}.fa-temperature-high:before{content:"\f769"}.fa-temperature-low:before{content:"\f76b"}.fa-tencent-weibo:before{content:"\f1d5"}.fa-tenge:before{content:"\f7d7"}.fa-terminal:before{content:"\f120"}.fa-text-height:before{content:"\f034"}.fa-text-width:before{content:"\f035"}.fa-th:before{content:"\f00a"}.fa-th-large:before{content:"\f009"}.fa-th-list:before{content:"\f00b"}.fa-the-red-yeti:before{content:"\f69d"}.fa-theater-masks:before{content:"\f630"}.fa-themeco:before{content:"\f5c6"}.fa-themeisle:before{content:"\f2b2"}.fa-thermometer:before{content:"\f491"}.fa-thermometer-empty:before{content:"\f2cb"}.fa-thermometer-full:before{content:"\f2c7"}.fa-thermometer-half:before{content:"\f2c9"}.fa-thermometer-quarter:before{content:"\f2ca"}.fa-thermometer-three-quarters:before{content:"\f2c8"}.fa-think-peaks:before{content:"\f731"}.fa-thumbs-down:before{content:"\f165"}.fa-thumbs-up:before{content:"\f164"}.fa-thumbtack:before{content:"\f08d"}.fa-ticket-alt:before{content:"\f3ff"}.fa-tiktok:before{content:"\e07b"}.fa-times:before{content:"\f00d"}.fa-times-circle:before{content:"\f057"}.fa-tint:before{content:"\f043"}.fa-tint-slash:before{content:"\f5c7"}.fa-tired:before{content:"\f5c8"}.fa-toggle-off:before{content:"\f204"}.fa-toggle-on:before{content:"\f205"}.fa-toilet:before{content:"\f7d8"}.fa-toilet-paper:before{content:"\f71e"}.fa-toilet-paper-slash:before{content:"\e072"}.fa-toolbox:before{content:"\f552"}.fa-tools:before{content:"\f7d9"}.fa-tooth:before{content:"\f5c9"}.fa-torah:before{content:"\f6a0"}.fa-torii-gate:before{content:"\f6a1"}.fa-tractor:before{content:"\f722"}.fa-trade-federation:before{content:"\f513"}.fa-trademark:before{content:"\f25c"}.fa-traffic-light:before{content:"\f637"}.fa-trailer:before{content:"\e041"}.fa-train:before{content:"\f238"}.fa-tram:before{content:"\f7da"}.fa-transgender:before{content:"\f224"}.fa-transgender-alt:before{content:"\f225"}.fa-trash:before{content:"\f1f8"}.fa-trash-alt:before{content:"\f2ed"}.fa-trash-restore:before{content:"\f829"}.fa-trash-restore-alt:before{content:"\f82a"}.fa-tree:before{content:"\f1bb"}.fa-trello:before{content:"\f181"}.fa-tripadvisor:before{content:"\f262"}.fa-trophy:before{content:"\f091"}.fa-truck:before{content:"\f0d1"}.fa-truck-loading:before{content:"\f4de"}.fa-truck-monster:before{content:"\f63b"}.fa-truck-moving:before{content:"\f4df"}.fa-truck-pickup:before{content:"\f63c"}.fa-tshirt:before{content:"\f553"}.fa-tty:before{content:"\f1e4"}.fa-tumblr:before{content:"\f173"}.fa-tumblr-square:before{content:"\f174"}.fa-tv:before{content:"\f26c"}.fa-twitch:before{content:"\f1e8"}.fa-twitter:before{content:"\f099"}.fa-twitter-square:before{content:"\f081"}.fa-typo3:before{content:"\f42b"}.fa-uber:before{content:"\f402"}.fa-ubuntu:before{content:"\f7df"}.fa-uikit:before{content:"\f403"}.fa-umbraco:before{content:"\f8e8"}.fa-umbrella:before{content:"\f0e9"}.fa-umbrella-beach:before{content:"\f5ca"}.fa-uncharted:before{content:"\e084"}.fa-underline:before{content:"\f0cd"}.fa-undo:before{content:"\f0e2"}.fa-undo-alt:before{content:"\f2ea"}.fa-uniregistry:before{content:"\f404"}.fa-unity:before{content:"\e049"}.fa-universal-access:before{content:"\f29a"}.fa-university:before{content:"\f19c"}.fa-unlink:before{content:"\f127"}.fa-unlock:before{content:"\f09c"}.fa-unlock-alt:before{content:"\f13e"}.fa-unsplash:before{content:"\e07c"}.fa-untappd:before{content:"\f405"}.fa-upload:before{content:"\f093"}.fa-ups:before{content:"\f7e0"}.fa-usb:before{content:"\f287"}.fa-user:before{content:"\f007"}.fa-user-alt:before{content:"\f406"}.fa-user-alt-slash:before{content:"\f4fa"}.fa-user-astronaut:before{content:"\f4fb"}.fa-user-check:before{content:"\f4fc"}.fa-user-circle:before{content:"\f2bd"}.fa-user-clock:before{content:"\f4fd"}.fa-user-cog:before{content:"\f4fe"}.fa-user-edit:before{content:"\f4ff"}.fa-user-friends:before{content:"\f500"}.fa-user-graduate:before{content:"\f501"}.fa-user-injured:before{content:"\f728"}.fa-user-lock:before{content:"\f502"}.fa-user-md:before{content:"\f0f0"}.fa-user-minus:before{content:"\f503"}.fa-user-ninja:before{content:"\f504"}.fa-user-nurse:before{content:"\f82f"}.fa-user-plus:before{content:"\f234"}.fa-user-secret:before{content:"\f21b"}.fa-user-shield:before{content:"\f505"}.fa-user-slash:before{content:"\f506"}.fa-user-tag:before{content:"\f507"}.fa-user-tie:before{content:"\f508"}.fa-user-times:before{content:"\f235"}.fa-users:before{content:"\f0c0"}.fa-users-cog:before{content:"\f509"}.fa-users-slash:before{content:"\e073"}.fa-usps:before{content:"\f7e1"}.fa-ussunnah:before{content:"\f407"}.fa-utensil-spoon:before{content:"\f2e5"}.fa-utensils:before{content:"\f2e7"}.fa-vaadin:before{content:"\f408"}.fa-vector-square:before{content:"\f5cb"}.fa-venus:before{content:"\f221"}.fa-venus-double:before{content:"\f226"}.fa-venus-mars:before{content:"\f228"}.fa-vest:before{content:"\e085"}.fa-vest-patches:before{content:"\e086"}.fa-viacoin:before{content:"\f237"}.fa-viadeo:before{content:"\f2a9"}.fa-viadeo-square:before{content:"\f2aa"}.fa-vial:before{content:"\f492"}.fa-vials:before{content:"\f493"}.fa-viber:before{content:"\f409"}.fa-video:before{content:"\f03d"}.fa-video-slash:before{content:"\f4e2"}.fa-vihara:before{content:"\f6a7"}.fa-vimeo:before{content:"\f40a"}.fa-vimeo-square:before{content:"\f194"}.fa-vimeo-v:before{content:"\f27d"}.fa-vine:before{content:"\f1ca"}.fa-virus:before{content:"\e074"}.fa-virus-slash:before{content:"\e075"}.fa-viruses:before{content:"\e076"}.fa-vk:before{content:"\f189"}.fa-vnv:before{content:"\f40b"}.fa-voicemail:before{content:"\f897"}.fa-volleyball-ball:before{content:"\f45f"}.fa-volume-down:before{content:"\f027"}.fa-volume-mute:before{content:"\f6a9"}.fa-volume-off:before{content:"\f026"}.fa-volume-up:before{content:"\f028"}.fa-vote-yea:before{content:"\f772"}.fa-vr-cardboard:before{content:"\f729"}.fa-vuejs:before{content:"\f41f"}.fa-walking:before{content:"\f554"}.fa-wallet:before{content:"\f555"}.fa-warehouse:before{content:"\f494"}.fa-watchman-monitoring:before{content:"\e087"}.fa-water:before{content:"\f773"}.fa-wave-square:before{content:"\f83e"}.fa-waze:before{content:"\f83f"}.fa-weebly:before{content:"\f5cc"}.fa-weibo:before{content:"\f18a"}.fa-weight:before{content:"\f496"}.fa-weight-hanging:before{content:"\f5cd"}.fa-weixin:before{content:"\f1d7"}.fa-whatsapp:before{content:"\f232"}.fa-whatsapp-square:before{content:"\f40c"}.fa-wheelchair:before{content:"\f193"}.fa-whmcs:before{content:"\f40d"}.fa-wifi:before{content:"\f1eb"}.fa-wikipedia-w:before{content:"\f266"}.fa-wind:before{content:"\f72e"}.fa-window-close:before{content:"\f410"}.fa-window-maximize:before{content:"\f2d0"}.fa-window-minimize:before{content:"\f2d1"}.fa-window-restore:before{content:"\f2d2"}.fa-windows:before{content:"\f17a"}.fa-wine-bottle:before{content:"\f72f"}.fa-wine-glass:before{content:"\f4e3"}.fa-wine-glass-alt:before{content:"\f5ce"}.fa-wix:before{content:"\f5cf"}.fa-wizards-of-the-coast:before{content:"\f730"}.fa-wodu:before{content:"\e088"}.fa-wolf-pack-battalion:before{content:"\f514"}.fa-won-sign:before{content:"\f159"}.fa-wordpress:before{content:"\f19a"}.fa-wordpress-simple:before{content:"\f411"}.fa-wpbeginner:before{content:"\f297"}.fa-wpexplorer:before{content:"\f2de"}.fa-wpforms:before{content:"\f298"}.fa-wpressr:before{content:"\f3e4"}.fa-wrench:before{content:"\f0ad"}.fa-x-ray:before{content:"\f497"}.fa-xbox:before{content:"\f412"}.fa-xing:before{content:"\f168"}.fa-xing-square:before{content:"\f169"}.fa-y-combinator:before{content:"\f23b"}.fa-yahoo:before{content:"\f19e"}.fa-yammer:before{content:"\f840"}.fa-yandex:before{content:"\f413"}.fa-yandex-international:before{content:"\f414"}.fa-yarn:before{content:"\f7e3"}.fa-yelp:before{content:"\f1e9"}.fa-yen-sign:before{content:"\f157"}.fa-yin-yang:before{content:"\f6ad"}.fa-yoast:before{content:"\f2b1"}.fa-youtube:before{content:"\f167"}.fa-youtube-square:before{content:"\f431"}.fa-zhihu:before{content:"\f63f"}.sr-only{border:0;clip:rect(0,0,0,0);height:1px;margin:-1px;overflow:hidden;padding:0;position:absolute;width:1px}.sr-only-focusable:active,.sr-only-focusable:focus{clip:auto;height:auto;margin:0;overflow:visible;position:static;width:auto}@font-face{font-family:"Font Awesome 5 Brands";font-style:normal;font-weight:400;font-display:block;src:url(https://ka-f.fontawesome.com/releases/v5.15.3/webfonts/free-fa-brands-400.eot);src:url(https://ka-f.fontawesome.com/releases/v5.15.3/webfonts/free-fa-brands-400.eot?#iefix) format("embedded-opentype"),url(https://ka-f.fontawesome.com/releases/v5.15.3/webfonts/free-fa-brands-400.woff2) format("woff2"),url(https://ka-f.fontawesome.com/releases/v5.15.3/webfonts/free-fa-brands-400.woff) format("woff"),url(https://ka-f.fontawesome.com/releases/v5.15.3/webfonts/free-fa-brands-400.ttf) format("truetype"),url(https://ka-f.fontawesome.com/releases/v5.15.3/webfonts/free-fa-brands-400.svg#fontawesome) format("svg")}.fab{font-family:"Font Awesome 5 Brands"}@font-face{font-family:"Font Awesome 5 Free";font-style:normal;font-weight:400;font-display:block;src:url(https://ka-f.fontawesome.com/releases/v5.15.3/webfonts/free-fa-regular-400.eot);src:url(https://ka-f.fontawesome.com/releases/v5.15.3/webfonts/free-fa-regular-400.eot?#iefix) format("embedded-opentype"),url(https://ka-f.fontawesome.com/releases/v5.15.3/webfonts/free-fa-regular-400.woff2) format("woff2"),url(https://ka-f.fontawesome.com/releases/v5.15.3/webfonts/free-fa-regular-400.woff) format("woff"),url(https://ka-f.fontawesome.com/releases/v5.15.3/webfonts/free-fa-regular-400.ttf) format("truetype"),url(https://ka-f.fontawesome.com/releases/v5.15.3/webfonts/free-fa-regular-400.svg#fontawesome) format("svg")}@font-face{font-family:"Font Awesome 5 Pro";font-style:normal;font-weight:400;font-display:block;src:url(https://ka-f.fontawesome.com/releases/v5.15.3/webfonts/free-fa-regular-400.eot);src:url(https://ka-f.fontawesome.com/releases/v5.15.3/webfonts/free-fa-regular-400.eot?#iefix) format("embedded-opentype"),url(https://ka-f.fontawesome.com/releases/v5.15.3/webfonts/free-fa-regular-400.woff2) format("woff2"),url(https://ka-f.fontawesome.com/releases/v5.15.3/webfonts/free-fa-regular-400.woff) format("woff"),url(https://ka-f.fontawesome.com/releases/v5.15.3/webfonts/free-fa-regular-400.ttf) format("truetype"),url(https://ka-f.fontawesome.com/releases/v5.15.3/webfonts/free-fa-regular-400.svg#fontawesome) format("svg")}.fab,.far{font-weight:400}@font-face{font-family:"Font Awesome 5 Free";font-style:normal;font-weight:900;font-display:block;src:url(https://ka-f.fontawesome.com/releases/v5.15.3/webfonts/free-fa-solid-900.eot);src:url(https://ka-f.fontawesome.com/releases/v5.15.3/webfonts/free-fa-solid-900.eot?#iefix) format("embedded-opentype"),url(https://ka-f.fontawesome.com/releases/v5.15.3/webfonts/free-fa-solid-900.woff2) format("woff2"),url(https://ka-f.fontawesome.com/releases/v5.15.3/webfonts/free-fa-solid-900.woff) format("woff"),url(https://ka-f.fontawesome.com/releases/v5.15.3/webfonts/free-fa-solid-900.ttf) format("truetype"),url(https://ka-f.fontawesome.com/releases/v5.15.3/webfonts/free-fa-solid-900.svg#fontawesome) format("svg")}@font-face{font-family:"Font Awesome 5 Pro";font-style:normal;font-weight:900;font-display:block;src:url(https://ka-f.fontawesome.com/releases/v5.15.3/webfonts/free-fa-solid-900.eot);src:url(https://ka-f.fontawesome.com/releases/v5.15.3/webfonts/free-fa-solid-900.eot?#iefix) format("embedded-opentype"),url(https://ka-f.fontawesome.com/releases/v5.15.3/webfonts/free-fa-solid-900.woff2) format("woff2"),url(https://ka-f.fontawesome.com/releases/v5.15.3/webfonts/free-fa-solid-900.woff) format("woff"),url(https://ka-f.fontawesome.com/releases/v5.15.3/webfonts/free-fa-solid-900.ttf) format("truetype"),url(https://ka-f.fontawesome.com/releases/v5.15.3/webfonts/free-fa-solid-900.svg#fontawesome) format("svg")}.fa,.far,.fas{font-family:"Font Awesome 5 Free"}.fa,.fas{font-weight:900}</style>
	<style>
	#jokerimg span:last-child:after 
{
       content: "\0004A"; 
       font-size: 150%; 
       padding-left: 10px; 
       float: right; 
       position: relative; 
       top: 15px 
}

.overlay-middle {
	position: fixed;
    top: 30%;
    bottom: 0;
    left: 0;
    right: 0;    
    display: none;
    z-index: 1000;
}
.closepopup a {
	cursor: pointer;
}

	</style>
</head>
<body>
	<div class="table-wrapper">
	<div class="table-playing">
		<img src="/table22.png">
		</div>
		
	<!--<img src="table22.png"  height="400px" alt="" style="position:absolute; margin-left: 4%; margin-top: 18%; z-index:-1">-->
	
	<!-- top menu start -->
	<div class="tl-menu">
		<ul>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<li><a class="openInfo"><i class="fa fa-info-circle openInfo" data-toggle="modal" data-target="#myModal"></i></a></li>&nbsp;&nbsp;&nbsp;&nbsp;
			<li><a href="http://rummysahara.com/public/point-fun-games.php" target="_blank" id="game_lobby">Lobby</a></li>&nbsp;&nbsp;&nbsp;&nbsp;
			<li><a href="https://rummysahara.com/public/buy-chips.php" target="_blank" id="buy_chips">Buy Chips</a></li>
		</ul>
		<ul style="float:right">
		    <ul class="top_design_center">
				<li><a><strong>Balance : <i class="fa fa-life-ring" aria-hidden="true"></i>  <script> document.write(account_bal);</script></strong></a></li></ul>
			<ul class="top_design_right">&nbsp;&nbsp;&nbsp;
			
			
			<li><a><i class="fa fa-signal" aria-hidden="true"></i></a></li>&nbsp;&nbsp;&nbsp;
			<li><a><i onClick="muteMe(this)" id="mutefun" class="fa fa-volume-up"></i></a></li>&nbsp;&nbsp;&nbsp;
			<li><a><i id="expan" onclick="myFunction(this)" class="fa fa-expand" aria-hidden="true"></i></a></li>&nbsp;&nbsp;&nbsp;
			<li><a><i id="refresh" class="fa fa-refresh"></i></a></li>&nbsp;&nbsp;&nbsp;
			<li><a class="button" href="#popup1" id="leave_confirm"><i class="fas fa-sign-out-alt" aria-hidden="true"></i></a></li>
		</ul>
	</div>
	<!-- top menu end -->
	
	<!-- game info start -->
	<div class="gameInfo">
		<div style="background:#474749; padding:2% 4%; color:#fff">
			<h4>Game Information</h4>
			<i class="fa fa-times" aria-hidden="true"></i>
		</div>
		<table>
			<tbody>
				<tr>
					<td style="border:none">Table Name</td>
					<td style="border:none">:<script> document.write(table_name);</script></td>
				</tr>
				<tr>
					<td style="border:none">Game Varient</td>
					<td style="border:none">: <script> document.write(game);
						</script></td>
				</tr>
				<tr>
					<td style="border:none">Game Type</td>
					<td style="border:none">: <script> document.write(game_type);</script></td>
				</tr>
				<tr>
					<td style="border:none">Deal Id</td>
					<td style="border:none">:  <span id="deal_id"></span></td>
				</tr>
				<tr>
					<td style="border:none">Points Value</td>
					<td style="border:none">: <script> document.write(point_value);</script>point(s)</td>
				</tr>
				<tr>
					<td style="border:none">First Drop</td>
					<td style="border:none">: 20 points</td>
				</tr>
				<tr>
					<td style="border:none">Middle Drop</td>
					<td style="border:none">: 40 points</td>
				</tr>
				<tr>
					<td style="border:none">Full Counts</td>
					<td style="border:none">: 80 points</td>
				</tr>
			</tbody>
		</table>
	</div>
	<!-- game info start -->
	
	<!-- close popup start -->
		<div id="popup1" class="overlay">
			<div class="popup">
				<div class="content">
					<div style="background:#474749; color:#fff">
						<span>RummySahara says...</span>
						<a class="close" href="#" style="text-align:right">&times;</a>
					</div>
					<div class="closepopup" style="background:#231f20">
						<h5>Do you want to leave the game table ?</h5>
						<a id="leave_group">Yes</a>
						<a id="leave_group_cancel" href="#">No</a>
					</div>
				</div>
			</div>
		</div>
	<!-- close popup end -->
		<div id="popup-confirm" class="overlay-middle">
			<div class="popup">
				<div class="content">
					<div class="closepopup" style="background:#231f20">
						<h5><span id="confirm-msg"></span></h5>
						<a id="confirm-yes">Yes</a>
						<a id="confirm-no">No</a>
					</div>
				</div>
			</div>
		</div>
	<!-- close popup end -->
	
	<!-- top sit here button -->
	<div class="top-chair">
		<!--<div class="front-chair" id="player_4_chair"><img src="chair-4.png"/></div>-->
		<div class="male-user"><img style="display:none" id="player_4_male_player" src="male-4.png"/></div>
		 <div class="female-user"><img style="display:none" id="player_4_female_player" src="male-4.png"/></div> 
		 <div id="player_4_disconnect" style="position: absolute;
			    top: 29%;right: 40.2%;color: #0033cc;font-weight: bold;background-color: #80b3ff;display:none;">
			<label id="player_4_status"></label> <!-- disconnected-->
		</div>
		<div class="sit"><img id="player_4_sit"   src="chair-456.png" ></div>
		<div class="front-dealer" style="display:none"  id="player_4_dealer"><img src="dealer-icon.png"></div>
		<div class="ct-loader" style="display:none" id="player_4_loader"><img src="buyin.gif"></div>
		<div id="player_4_counts">
			<div class="ct-fif-sec" style="color:#fff" id="player_4_count1">
				<span  id="player4turn"></span>
			</div>
			<div class="ct-twe-sec" style="color:#fff" id="player_4_count2">
				
			</div>
		</div>
	</div>
	<div class="player4" style="display:none;" id="player_4_details">
		<label id="player_4_name"><big><b></b></big></label><br>
		<label id="player_4_amount"><big><b></b></big></label>
		<label id="player_4_poolamount" style="display:none"></label>
	</div>
	<!-- top sit here button -->
	
	<!-- top right user start -->
	<div class="top-right-menu">
		<!--<div class="tr-chair" id="player_3_chair"><img src="chair-3.png"/></div>-->
		<div class="tr-female-user"><img id="player_3_female_player" style="display:none" src="female-3.png"/></div>
		<div class="tr-male-user"><img id="player_3_male_player" style="display:none" src="male-3.png"/></div> 
		<div id="player_3_disconnect" style="position: absolute;
			top: 30%;right: 18%;color: #0033cc;font-weight: bold;background-color: #80b3ff;display:none;">
			<label id="player_3_status"></label>
		</div>
		<div class="tr-sit-here"><img id="player_3_sit" src="chair-33.png" /></div>
		<div class="tr-dealer"><img style="display:none"  id="player_3_dealer" src="dealer-icon.png"/></div>
		<div class="tr-loader"><img style="display:none"  id="player_3_loader" src="buyin.gif"></div>
		<div id="player_3_counts">
			<div class="tr-fif-sec" style="color:#fff"  id="player_3_count1">
				<span  id="player3turn"></span>
			</div>
			<div class="tr-twe-sec" style="color:#fff"  id="player_3_count2">
				
			</div>
		</div>
	</div>
	<div class="player3" style="display:none;" id="player_3_details">
		<label id="player_3_name"><big><b></b></big></label><br>
		<label id="player_3_amount"><big><b></b></big></label>
		<label id="player_3_poolamount" style="display:none"></label>
	</div>
	<!-- top right user start -->
	
	<!-- center right user start -->
	<div class="center-right-menu">
		<!--<div class="cr-chair" id="player_2_chair"><img src="chair-2.png"/></div>-->
		<div class="cr-female-user"><img id="player_2_female_player" style="display:none" src="female-2.png"/></div>
		<div class="cr-male-user"><img id="player_2_male_player" style="display:none" src="male-2.png"/></div>
		<div id="player_2_disconnect" style="position: absolute;
			        top: 59%;
    right: 6%;color: #0033cc;font-weight: bold;background-color: #80b3ff;display:none;">
			<label id="player_2_status"></label> 
		</div>
		<div class="cr-sit-here"><img id="player_2_sit" src="chair-266.png" /></div>
		<div class="cr-dealer"><img style="display:none"  id="player_2_dealer" src="dealer-icon.png"/></div>
		<div class="cr-loader"><img style="display:none"  id="player_2_loader" src="buyin.gif"></div>
		<div id="player_2_counts">
			<div class="cr-fif-sec" style="color:#fff" id="player_2_count1">
				<span  id="player2turn"></span>
			</div>
			<div class="cr-twe-sec" style="color:#fff" id="player_2_count2">
				
			</div>
		</div>
	</div>
	<div class="player2" style="display:none;" id="player_2_details">
		<label id="player_2_name"><big><b></b></big></label><br>
		<label id="player_2_amount"><big><b></b></big></label>
		<label id="player_2_poolamount" style="display:none"></label>
	</div>
	<!-- center right user end -->
	
	<!-- top left user start -->
	<div class="top-left-menu">
		<!--<div class="tl-chair" id="player_5_chair"><img src="chair-5.png"/></div>-->
		<div class="tl-female-user"><img id="player_5_female_player" style="display:none" src="male-5.png"/></div>
		<div class="tl-male-user"><img id="player_5_male_player" style="display:none" src="male-5.png"/></div>
		<div id="player_5_disconnect" style="position: absolute;
			top: 30%;left: 32%;color: #0033cc;font-weight: bold;background-color: #80b3ff;display:none;">
			<label id="player_5_status"></label> 
		</div>
		<div class="tl-sit-here"><img id="player_5_sit" src="chair-56.png" /></div>
		<div class="tl-dealer"><img style="display:none"  id="player_5_dealer" src="dealer-icon.png"/></div>
		<div class="tl-loader"><img src="buyin.gif" style="display:none"  id="player_5_loader"></div>
		<div id="player_5_counts">
			<div class="tl-fif-sec" style="color:#fff" id="player_5_count1">
				<span  id="player5turn"></span>
			</div>
			<div class="tl-twe-sec" style="color:#fff" id="player_5_count2">
				
			</div>
		</div>
	</div>
	<div class="player5" style="display:none;" id="player_5_details">
		<label id="player_5_name"><big><b></b></big></label><br>
		<label id="player_5_amount"><big><b></b></big></label>
		<label id="player_5_poolamount" style="display:none"></label>
	</div>
	<!-- top left user end -->
	
	<!-- center left user start -->
	<div class="center-left-menu">
		<!--<div class="cl-chair" id="player_6_chair"><img src="chair-6.png"/></div>-->
		<div class="cl-female-user" ><img id="player_6_female_player" style="display:none" src="male-6.png"/></div>
		<div class="cl-male-user"><img id="player_6_male_player" style="display:none" src="male-6.png"/></div>
		<div id="player_6_disconnect" style="position: absolute;
			top: 62%;left: 6%;color: #0033cc;font-weight: bold;background-color: #80b3ff;display:none;">
			<label id="player_6_status"></label> 
		</div>
		<div class="cl-sit-here"><img id="player_6_sit" src="sithere_btnlf.png" /></div>
		<div class="cl-dealer" style="display:none"  id="player_6_dealer"><img src="dealer-icon.png"/></div>
		<div class="cl-loader" style="display:none"  id="player_6_loader"><img src="buyin.gif"></div>
		<div id="player_6_counts">
			<div class="cl-fif-sec" style="color:#fff" id="player_6_count1">
				<span  id="player6turn"></span>
			</div>
			<div class="cl-twe-sec" style="color:#fff" id="player_6_count2">
				
			</div>
		</div>
	</div> 
	<div class="player6" style="display:none;" id="player_6_details">
		<label id="player_6_name"><big><b></b></big></label><br>
		<label id="player_6_amount"><big><b></b></big></label>
		<label id="player_6_poolamount" style="display:none;"></label>
	</div>
	<!-- center left user end -->
	
	<!-- table pop-up -->
	<div class="table-popup" id="table_popup">
		<div>
			<table style="border:none; font-size:13px">
				<tbody>
					<tr>
						<td>Table Name</td>
						<td>: <script> document.write(table_name);</script></td>
					</tr>
					<tr>
						<td>Game Type</td>
						<td>: <script> document.write(game_type);</script></td>
					</tr>
					<tr>
						<td>Point Value</td>
						<td>:  <script> document.write(point_value);</script></td>
					</tr>
					<tr>
						<td>Min Required</td>
						<td>: <span  id="table_min_entry"><script> document.write(min_entry);</script> </span></td>
					</tr>
					<tr>
						<td>Max Required</td>
						<td>: 	<span  id="max_entry"><script> document.write(min_entry*10);</script></span></td>
					</tr>
					<tr>
						<td>Your Account Bal</td>
						<td>:  <script> document.write(account_bal);</script></td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="dis-ib">
			<p class="dis-ib" style="width:70%; font-size:12px">How much would you like to bring amount on this table ?</p>
			<input type="text" style="width:28%" id="amount" name="amount"/>
		</div>
		<div style="font-size:12px; color:#ff3300">
			<span id="user_account_msg" style="color:red;"></span>
			<p style="margin:0px">*Amount should be in min and max required.</p>
		</div>
		<div>
			<img src="buyinwindow-ok-btn.png" class="btn-ok" id="btn_ok">
			<img src="repoart-prob-cancel-btn.png" class="btn-cancel" id="btn_cancel">
		</div>
	</div>
	<!-- table pop-up -->
	
	<!-- table cards -->
	<div class="waiting-msg dis-ib" id="div_msg" style="display:none">			
	</div>

	<div class="table-content-wrapper">
		<div class="joker-card dis-ib">
				<img src="" id="joker_card"  style="display:none" > 
		</div>
		<div class="close-card dis-ib">
			<img src="" id="closed_cards"  style="display:none" > 
		</div>
		<div class="open-card dis-ib">
				<img src="" id="open_card"  style="display:none" > 
		</div>
		<div class="discard-arrow dis-ib" style="display:none" id="open_deck">
			<img src="arrow-right.png">
		</div>
		<div class="discard-cards dis-ib" id="discareded_open_cards">
		</div>
		<div class="finish-card dis-ib">
			<img src="" id="finish_card">  
		</div>

		<div class="player1_turn_card" style="display:none;">
			<label>Your Card</label>
			<img id="player1_turn_card" />
		</div>
		<div class="player2_turn_card" style="display:none;">
			<label></label>
			<img id="player2_turn_card" />
		</div>
		<div class="player3_turn_card" style="display:none;">
			<label></label>
			<img id="player3_turn_card" />
		</div>
		<div class="player4_turn_card" style="display:none;">
			<label></label>
			<img id="player4_turn_card" />
		</div>
		<div class="player5_turn_card" style="display:none;">
			<label></label>
			<img id="player5_turn_card" />
		</div>
		<div class="player6_turn_card" style="display:none;">
			<label></label>
			<img id="player6_turn_card" />
		</div>

	</div>
	<!-- table cards -->
	
	<!-- declare buttons -->
	<div class="content-buttons">
		<span id="msg"></span>
		<div class="declare-but" id="declare" style="display:none">
			<img src="declare.png">
		</div>
		<div class="discard-but" id="discard_card" style="display:none">
			<img src="discard-btn.png">
		</div>
		<div class="finish-but"  id="finish_game" style="display:none">
			<img src="finish.png">
		</div>
	</div>
	<!-- declare buttons -->
	
	<!-- declare popup start -->
	<div class="declare-table">
		<table class="table-bordered" id="game_summary" style="color:#fff">
			<tbody>
				<tr>
					<th style="padding:1% 4%" colspan="4">Table Name : <script> document.write(table_name);</script></th>
					<th class="close-declpop">Close</th>
				</tr>
				<tr>
					<th style="padding:1% 4%" colspan="5">You Declared &nbsp;<span id="seq"></span>   &nbsp; sequence.</th>
				</tr>
				<tr style="text-align:center;background:#ff4d4d;color:#404040;border-top:1px solid #fff;border-bottom:1px solid #fff" id="tr_summary">
					<th style="width:12%">User Name</th>
					<th style="width:10%">Show Status</th>
					<th style="width:70%">Results</th>
					<th>Game Score</th>
					<th>Amount Won</th>
				</tr>
			</body>
		</table>
	</div>
	<!-- declare popup end -->
	
	<!-- rummy cards start -->
	<div class="rummy-cards" id="images_parent">
		<div class="btn-group"  style="display:inline">
			<button id="group_cards" style="display:none">Group</button>
		</div>
		<div class="add-here-1"  style="display:inline">
				<button id="add_group1" style="display:none">Add Here</button>
		</div>
		<div class="group1" id="card_group1">
		</div>
		<div class="add-here-2"  style="display:inline">
				<button id="add_group2" style="display:none">Add Here</button>
		</div>
		<div class="group2" id="card_group2">
		</div>
		<div class="add-here-3"   style="display:inline">
				<button id="add_group3" style="display:none">Add Here</button>
		</div>
		<div class="group3" id="card_group3">
		</div>
		<div class="add-here-4"   style="display:inline">
				<button id="add_group4" style="display:none">Add Here</button>
			</div>
		<div class="group4" id="card_group4">
		</div>
		<div class="add-here-5"   style="display:inline">
				<button id="add_group5" style="display:none">Add Here</button>
			</div>
		<div class="group5" id="card_group5">
		</div>
		<div class="add-here-6"   style="display:inline">
				<button id="add_group6" style="display:none">Add Here</button>
			</div>
		<div class="group6" id="card_group6">
		</div>
		<div class="add-here-7"   style="display:inline">
				<button id="add_group7" style="display:none">Add Here</button>
			</div>
		<div class="group7" id="card_group7">
		</div>
		<div class="group_images" id="images" style="">
		</div>
		<div class="group_images" id="jokerimages" style="">
		</div>
	</div>
	<!-- rummy cards start -->
	
	<!-- bottom sit here button -->
	<div class="bottom-chair">
		<div class="bott-chair"  id="player_1_chair"><img src="chair-1.png"/></div>
		<div class="bott-female"><img  id="player_1_female_player" style="display:none" src="male-1.png"/></div>
		<div class="bott-male"><img id="player_1_male_player" style="display:none" src="male-1.png"/></div>
		<div id="player_1_disconnect" style="position: absolute;
			    bottom: 9%;
    left: 57%;color: #0033cc;font-weight: bold;background-color: #80b3ff;display:none;">
			<label id="player_1_status"></label> 
		</div>
		<div class="bott-sit"><img  id="player_1_sit"  src="sithere_btn_btm.png" class="sit-popup" ></div>
		<div class="bot-dealer"  style="display:none"  id="player_1_dealer"><img src="dealer-icon.png"></div>
		<div class="cb-loader" style="display:none"  id="player_1_loader"><img src="buyin.gif"></div>
		<div class="count-down"  id="player_1_counts">
			<div class="cb-fif-sec" style="color:#fff" id="player_1_count1">
				<span  id="player1turn"></span>
			</div>
			<div class="cb-twe-sec" style="color:#fff" id="player_1_count2">
			</div>
		</div>
	</div>
	<div class="player1" style="display:none;" id="player_1_details">
		<label id="player_1_name"><big><b></b></big></label><br>
		<label id="player_1_amount"><big><b></b></big></label>
		<label id="player_1_poolamount" style="display:none"></label>
	</div>
	<!-- bottom sit here button -->
	
	<!-- sort drop button -->
	<div class="sort-drop-but">
		<div class="sort-but" id="sort_cards" style="display:none">
			<img src="sortbtn.png"/>
		</div>
		<div class="drop-but" style="display:none" id="drop_game">
			<img src="Dropbtn.png"/>
		</div>
	</div>
	<!-- sort drop button -->
	
	<!-- bottom menu start -->
	<!--<div class="bottom-menu">
		<div style="text-align:right">
			<i class="fa fa-volume-up" aria-hidden="true"></i>
			<i class="fa fa-signal" aria-hidden="true"></i>
			<label id="minutes">00</label><label> : </label><label id="seconds">00</label>
		</div>
	</div>-->
	<!-- bottom menu ends -->
	
	</div>
</body>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>	
	<script type="text/javascript" src="/jquery.dragsort-0.5.2.min.js"></script>
	<!--<script src="countdown_six.js"></script>-->
<!--	<script src="pop-up_six.js"></script>-->
<script>
function myFunction(al) {
  var element = al.className; 
  if(element=='fa fa-expand'){
	 $("#expan").removeClass("fa fa-expand");
     $("#expan").addClass("fa fa-compress");	
     document.documentElement.requestFullscreen();
      //$(".table-playing img").css("height", "50%");
  }else{
	 $("#expan").removeClass("fa fa-compress");
     $("#expan").addClass("fa fa-expand");
     document.exitFullscreen();	
     //$(".table-playing img").css("height", "auto");	
  }
  	 
}
//mute
			function muteMe(elem) { 
	var name=elem.className; 
	if(name=='fa fa-volume-up')
	{
	 $("#mutefun").removeClass("fa fa-volume-up");
     $("#mutefun").addClass("fas fa-volume-mute");
	}else{
	 $("#mutefun").removeClass("fas fa-volume-mute");
     $("#mutefun").addClass("fa fa-volume-up");
	}
} 
			  
			//mute 
</script>
	<script>
			var joined_table=false;
	 	$(function(){
			
			$("#player_1_count1").hide();
			$("#player_1_count2").hide();
			$("#player_2_count1").hide();
			$("#player_2_count2").hide();
			$("#player_3_count1").hide();
			$("#player_3_count2").hide();
			$("#player_4_count1").hide();
			$("#player_4_count2").hide();
			$("#player_5_count1").hide();
			$("#player_5_count2").hide();
			$("#player_6_count1").hide();
			$("#player_6_count2").hide();
			$("#finish_card").hide();
			$('#finish_card').attr("disabled", 'disabled');
			var btnclicked;
		 	var random_group_roundno =0;
		
			var check_join_count = 10;
		 	var player_amount;
		 	var player_poolamount;
			var activity_timer_status=false;
		 	var user_assigned_cards = [];
		 	var activity_msg_count = 3;
		 	var player_turn = false;
		  	////used for return card if no discard within timer ////
		  	var picked_card_value;
		  	var picked_card_id;
			var discard_click = false ;
			var is_picked_card = false;
			var is_finished = false ;
			var next_turn = false ;
			var remove_obj;
			var is_open_close_picked = 0;
			var top_image,bottom_image,top_img_id,bottom_img_id;
			var ttt = false;
			var declare = 0;
			var is_opp_pl_discareded = false;
			var opp_pl_discareded;
			var browser_type = checkBrowser();
			var os_type = detectOS();
			var temp_closed_cards_arr = [];
			var temp_closed_cards_arr1 = [];
			var closed_card_src_temp;
			var closed_card_id_temp = 0;
			var selected_card_count=0;
		    var open_card_src,closed_card_src;
		    var selected_card_arr = [];
		    var selected_card_arr1 = [];
	        var selected_group_card_arr = [];
		    var click_count = 0; var margin_left = 25;
		    var vars = {};
		    var grp1 = [];var grp2 = [];var grp3 = [];var grp4 = [];
		    var grp5 = [];var grp6 = [];var grp7 = [];
		    var open_card_id;
		    var close_card_id;
		    var table_round_id = 0;
		    var card_click = [] ; var clicked_key; 
		    var card_click_grp = []; var clicked_key_grp;
		    var prev_discard_key ;
		    var card_count ;
		    var open_data = '',close_data='';
		    var open_obj;
		    var is_sorted = false;
		    var is_grouped = false;
		    var initial_group = false;
		    var is_grouped_temp = false;
		    var initial_group_temp = false;
		    var discarded_open_arr = [];
		    var parent_group_id;
		    var selected_group_id;
		    var selected_card_id;
		    var is_declared = false ;
		    var is_other_declared = false ;
		    var is_game_started = false;
		    var is_game_dropped = false;
		    var socket=null;
		    var initial_open_card;
		    var player_having_turn = "";
		    var audio_shuffle = new Audio('sounds/SHUFFLE.wav');
		    var audio_open  = new Audio('sounds/CardPick-Discard.wav');
		    var audio_close  = new Audio('sounds/CardPick-Discard.wav');
		    var audio_discard  = new Audio('sounds/CardPick-Discard.wav');
		    var audio_player_turn_end  = new Audio('sounds/Turn.wav');
		    var audio_player_turn_ending  = new Audio('sounds/Player-Timer.wav');
		    var audio_player_winner  = new Audio('sounds/Winner.wav');
		    var is_refreshed = false;
		    var player_in_game = true;
			var poolamt=0;
			var join_count=0;
			var no_of_jokers=0;

			var bWaiting_Join = false;
			var bLosted = false;
			var dragcards = false;

			var sort_grp1 =[], sort_grp2 =[], sort_grp3 =[], sort_grp4 =[],
					sort_grp5 =[], sort_grp6 =[], sort_grp7 =[]; 
		  /**** Emit to server -
			1. on connect check if any other player already exist on table
			2. on connect check logged player already present on table 
			****/
			 $(document).keydown(function (e) {  
            return (e.which || e.keyCode) != 116;  
			});  
			$(document).ready(function() {
			if(game_type=='Pool Rummy')
					{
						$("#player_1_poolamount").css('display','block');						
						$("#player_2_poolamount").css('display','block');
						$("#player_3_poolamount").css('display','block');						
						$("#player_4_poolamount").css('display','block');
						$("#player_5_poolamount").css('display','block');						
						$("#player_6_poolamount").css('display','block');							
					}						
			});
			socket= io.connect('http://rummysahara.com:3000');

		    socket.on('connect', function(){
				if(tableid != 0 && loggeduser != "")
				{
					poolamt=poolamount;
					if(game_type=='Pool Rummy')
						socket.emit('check_if_joined_player_pool',loggeduser,tableid);
					else
						socket.emit('check_if_joined_player',loggeduser,tableid);
				}
			});

		   socket.on('table_ip_restrict', function(playername, table_id) {
		   		if(tableid == table_id && loggeduser == playername){					
					alert("Another player from same ip joined table so please join another table to play game");
					window.close();
				}
		   });

		   socket.on('table_is_full', function(playername, table_id) {
		   		if(tableid == table_id && loggeduser == playername){					
					alert("Table is full.");
				}
		   });

		   socket.on('exist_player_seat', function(playername, table_id, sit_no) {
		   		if(tableid == table_id ){					
					alert("Player "+playername+" is already sited here.");
				}
		   });

		   	function checkBrowser()
			{
				var browser_type ;
				var isOpera = (!!window.opr && !!opr.addons) || !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0;
					if(isOpera == true) { browser_type ="Opera Mini"; return browser_type;}
				// Firefox 1.0+
				var isFirefox = typeof InstallTrigger !== 'undefined';
					if(isFirefox == true) { browser_type ="Mozilla Firefox";  return browser_type;}
				// At least Safari 3+: "[object HTMLElementConstructor]"
				var isSafari = Object.prototype.toString.call(window.HTMLElement).indexOf('Constructor') > 0;
					if(isSafari == true) { browser_type ="Safari"; return browser_type;}
				// Internet Explorer 6-11
				var isIE = /*@cc_on!@*/false || !!document.documentMode;
					if(isIE == true) { browser_type ="Internet Explorer";  return browser_type;}
				// Edge 20+
				var isEdge = !isIE && !!window.StyleMedia;
					if(isEdge == true) { browser_type ="Edge";  return browser_type;}
				// Chrome 1+
				var isChrome = /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor);
				//var isChrome = !!window.chrome && !!window.chrome.webstore;
					if(isChrome == true) { browser_type ="Google Chrome"; }
					return browser_type;
			}


			function detectOS() {
				var OSName="Unknown OS";
				if (navigator.appVersion.indexOf("Win")!=-1) OSName="Windows";
				if (navigator.appVersion.indexOf("Mac")!=-1) OSName="MacOS";
				if (navigator.appVersion.indexOf("X11")!=-1) OSName="UNIX";
				if (navigator.appVersion.indexOf("Linux")!=-1) OSName="Linux";

				return OSName;
			}

			function setMessage( strMsg ) {								
				if( bWaiting_Join || bLosted ) {
					if( bWaiting_Join ) {
						strMsg = '<label style="color:white">Please wait until game finish!</label>';
					} else {
						strMsg = '<label style="color:white">Please wait until next game!</label>';
					}
				}

				$('#div_msg').html(strMsg);
				$('#div_msg').show();
			}

			function emptyMessage() {
				if( bWaiting_Join || bLosted ) {
					return;
				}		

				$('#div_msg').empty();
				$('#div_msg').hide();
			}


		socket.on('check_if_joined_player', function(players_joined,player_sit_arr,tableid_listening,player_amount_arr,player_gender_arr,is_restart_game)
		{
			console.log("\n IN check_if_joined_player sit array  "+JSON.stringify(player_sit_arr)+" amount array "+JSON.stringify(player_amount_arr)+" gender array "+JSON.stringify(player_gender_arr)+" players name array  "+JSON.stringify(players_joined));
			console.log("\n tableid "+tableid+" tableid_listening "+tableid_listening+"--is_restart_game--"+is_restart_game);

			if(tableid==tableid_listening)
			{
				is_finished = false;

				console.log("\nANDY check_if_joined_player  declare:" + declare);
				declare = 0;
				is_game_dropped=false;

				// if(is_game_started == true || is_restart_game == false)
				// {
				// 	$('#div_msg').empty(); 
				// }
				if(is_game_started == false)
				{
					for(var  i = 0; i < players_joined.length; i++)
					{
						if(loggeduser==players_joined[i])
						{  joined_table=true; }
					}	
				} 
				if(is_restart_game == true){ is_game_started = true; }
			    else { is_game_started = false; }

				if($('.declare-table').is(':visible'))
				{
					var check_join_count = 3;
					var countdown1 = setInterval(function(){
					check_join_count--;
					if (check_join_count == 0)
					{
						clearInterval(countdown1);  
						$(".declare-table").hide();
						activity_timer_status=false;
					}
				  }, 1000);
				}
				if(is_game_started == false)
				{
					for(var  i = 1; i < 7; i++)
					{
						$("#player_"+(i)+"_name").text("");
						$("#player_"+(i)+"_amount").text("");
						$("#player_"+(i)+"_details").hide();
						$("#player_"+(i)+"_male_player").css('display','none');
						$("#player_"+(i)+"_female_player").css('display','none');
						$("#player_"+(i)+"_sit").show();
					}
					console.log("\n name "+("#player_"+(player_sit_arr[0])+"_loader")+"---sit----"+('#player_'+(player_sit_arr[0])+'_sit'));
					for(var  i = 0; i < players_joined.length; i++)
					{
						$("#player_"+(player_sit_arr[i])+"_loader").hide();
						$('#player_'+(player_sit_arr[i])+'_sit').css('display','none');
						$("#player_"+(player_sit_arr[i])+"_name").text(players_joined[i]);
						$("#player_"+(player_sit_arr[i])+"_amount").text(player_amount_arr[i]);
						$("#player_"+(player_sit_arr[i])+"_details").show();

						if(player_gender_arr[i] == 'Male')
						{ 
							$("#player_"+(player_sit_arr[i])+"_male_player").css('display','block');
							$("#player_"+(player_sit_arr[i])+"_female_player").css('display','none');					
						}
						else 
						{ 
							$("#player_"+(player_sit_arr[i])+"_male_player").css('display','none');
							$("#player_"+(player_sit_arr[i])+"_female_player").css('display','block'); 
						} 
						if($.trim($("#div_msg").html())=='' && players_joined.length ==1)
						{
							console.log("\ div_msg is empty ");
							setMessage('<label style="color:white">Waiting for another Player to join Table!</label>');
						}
					
					}//for ends 
				}
			}
		});
		
		socket.on('check_if_joined_player_pool', function(players_joined,player_sit_arr,tableid_listening,player_amount_arr,player_poolamount_arr,player_gender_arr,is_restart_game)
		{
			console.log("\n IN check_if_joined_player_pool sit array  "+JSON.stringify(player_sit_arr)+" amount array "+JSON.stringify(player_amount_arr)+" gender array "+JSON.stringify(player_gender_arr)+" players name array  "+JSON.stringify(players_joined));
			console.log("\n tableid "+tableid+" tableid_listening "+tableid_listening+"--is_restart_game--"+is_restart_game);

			if(tableid==tableid_listening)
			{
				is_finished = false;
				declare = 0;
				is_game_dropped=false;

				if(is_game_started == false)
				{
					for(var  i = 0; i < players_joined.length; i++)
					{
						if(loggeduser==players_joined[i])
						{  joined_table=true; }
					}	
				} 
				if(is_restart_game == true){ is_game_started = true; }
			    else { is_game_started = false; }

				if($('.declare-table').is(':visible'))
				{
					var check_join_count = 3;
					var countdown1 = setInterval(function(){
					check_join_count--;
					if (check_join_count == 0)
					{
						clearInterval(countdown1);  
						$(".declare-table").hide();
						activity_timer_status=false;
					}
				  }, 1000);
				}
				if(is_game_started == false)
				{
					for(var  i = 1; i < 7; i++)
					{
						$("#player_"+(i)+"_name").text("");
						$("#player_"+(i)+"_amount").text("");
						$("#player_"+(i)+"_poolamount").text("");
						$("#player_"+(i)+"_details").hide();
						$("#player_"+(i)+"_male_player").css('display','none');
						$("#player_"+(i)+"_female_player").css('display','none');
						$("#player_"+(i)+"_sit").show();
					}
					//console.log("\n name "+("#player_"+(player_sit_arr[0])+"_loader")+"---sit----"+('#player_'+(player_sit_arr[0])+'_sit'));
					for(var  i = 0; i < players_joined.length; i++)
					{
						$("#player_"+(player_sit_arr[i])+"_loader").hide();
						$('#player_'+(player_sit_arr[i])+'_sit').css('display','none');
						$("#player_"+(player_sit_arr[i])+"_name").text(players_joined[i]);
						$("#player_"+(player_sit_arr[i])+"_amount").text(player_amount_arr[i]);
						$("#player_"+(player_sit_arr[i])+"_poolamount").text(player_poolamount_arr[i]);
						$("#player_"+(player_sit_arr[i])+"_details").show();

						if(player_gender_arr[i] == 'Male')
						{ 
							$("#player_"+(player_sit_arr[i])+"_male_player").css('display','block');
							$("#player_"+(player_sit_arr[i])+"_female_player").css('display','none');					
						}
						else 
						{ 
							$("#player_"+(player_sit_arr[i])+"_male_player").css('display','none');
							$("#player_"+(player_sit_arr[i])+"_female_player").css('display','block'); 
						} 
						if($.trim($("#div_msg").html())=='' && players_joined.length ==1)
						{
							console.log("\ div_msg is empty ");
							setMessage('<label style="color:white">Waiting for another Player to join Table!</label>');
						}
					
					}//for ends 
				}
			}
		});
			//player 1 sit click
			$("#player_1_sit").unbind().on('click',function()
			{
				//socket.emit('file1Event'); 
				 if(tableid == 0 && loggeduser == "")
				{
					alert("Please Login to website  to Play Game");
				}
				else
				{
					if(is_game_started == false)
					{
						btnclicked = 1;
			 			if(account_bal > 0)
			 			{
							$('#user_account_msg').text("");
							if(joined_table == true )
							{
								$("#player_1_loader").css('display','none');
								$("#player_1_sit").css('display','block');
							}
							else {
								$("#player_1_loader").css('display','block');
								$("#player_1_sit").css('display','none');
								socket.emit('player_connecting_to_six_player_table', loggeduser,tableid,btnclicked); 
							 	 }
								check_join_count = 10;
								var countdown1 = setInterval(function()
								{
								check_join_count--;
								if (check_join_count == 0 && joined_table==false)
								{
									clearInterval(countdown1);  
									$("#table_popup").css('display','none');
									$("#player_1_loader").css('display','none');
									$("#player_1_sit").css('display','block');
									socket.emit('player_not_connecting_to_six_player_table', loggeduser,tableid,btnclicked);
								}
								}, 1000);
						}else { 
						$("#table_popup").css('display','none');
						}
					}
			   }
			});

			//player 2 sit click
			$("#player_2_sit").unbind().on('click',function()
			{
				if(tableid == 0 && loggeduser == "")
				{
					alert("Please Login to website  to Play Game");
				}
				else
				{
					if(is_game_started == false)
					{
						btnclicked = 2;
			 			if(account_bal > 0)
			 			{
							$('#user_account_msg').text("");
							if(joined_table == true )
							{
								$("#player_2_loader").css('display','none');
								$("#player_2_sit").css('display','block');
							}
							else {
								$("#player_2_loader").css('display','block');
								$("#player_2_sit").css('display','none');
								socket.emit('player_connecting_to_six_player_table', loggeduser,tableid,btnclicked); 
							 	 }
								check_join_count = 10;
								var countdown1 = setInterval(function()
								{
								check_join_count--;
								if (check_join_count == 0 && joined_table==false)
								{
									clearInterval(countdown1);  
									$("#table_popup").css('display','none');
									$("#player_2_loader").css('display','none');
									$("#player_2_sit").css('display','block');
									socket.emit('player_not_connecting_to_six_player_table', loggeduser,tableid,btnclicked);
								}
								}, 1000);
						}else { 
						$("#table_popup").css('display','none');
						}
					}
			   }
			});

			//player 3 sit click
			$("#player_3_sit").unbind().on('click',function()
			{
				if(tableid == 0 && loggeduser == "")
				{
					alert("Please Login to website  to Play Game");
				}
				else
				{
					if(is_game_started == false)
					{
						btnclicked = 3;
						
			 			if(account_bal > 0)
			 			{
							$('#user_account_msg').text("");
							if(joined_table == true )
							{
								$("#player_3_loader").css('display','none');
								$("#player_3_sit").css('display','block');
							}
							else {
								$("#player_3_loader").css('display','block');
								$("#player_3_sit").css('display','none');
								socket.emit('player_connecting_to_six_player_table', loggeduser,tableid,btnclicked); 
							 	 }
								check_join_count = 10;
								var countdown1 = setInterval(function()
								{
								check_join_count--;
								if (check_join_count == 0 && joined_table==false)
								{
									clearInterval(countdown1);  
									$("#table_popup").css('display','none');
									$("#player_3_loader").css('display','none');
									$("#player_3_sit").css('display','block');
									socket.emit('player_not_connecting_to_six_player_table', loggeduser,tableid,btnclicked);
								}
								}, 1000);
						}else { 
						$("#table_popup").css('display','none');
						}
					}
			   }
			});

			//player 4 sit click
			$("#player_4_sit").unbind().on('click',function()
			//$("#player_4_sit").click(function()
			{
				if(tableid == 0 && loggeduser == "")
				{
					alert("Please Login to website  to Play Game");
				}
				else
				{
					if(is_game_started == false)
					{
						btnclicked = 4;
						if(account_bal > 0)
			 			{
							$('#user_account_msg').text("");
							if(joined_table == true )
							{
								$("#player_4_loader").css('display','none');
								$("#player_4_sit").css('display','block');
							}
							else {
								$("#player_4_loader").css('display','block');
								$("#player_4_sit").css('display','none');
								socket.emit('player_connecting_to_six_player_table', loggeduser,tableid,btnclicked); 
							 	 }
								check_join_count = 10;
								var countdown1 = setInterval(function()
								{
								check_join_count--;
								if (check_join_count == 0 && joined_table==false)
								{
									clearInterval(countdown1);  
									$("#table_popup").css('display','none');
									$("#player_4_loader").css('display','none');
									$("#player_4_sit").css('display','block');
									socket.emit('player_not_connecting_to_six_player_table', loggeduser,tableid,btnclicked);
								}
								}, 1000);
						}else { 
						$("#table_popup").css('display','none');
						}
					}
			   }
			});
			//player 5 sit click
			$("#player_5_sit").unbind().on('click',function()
			{
				if(tableid == 0 && loggeduser == "")
				{
					alert("Please Login to website  to Play Game");
				}
				else
				{
					if(is_game_started == false)
					{
						btnclicked = 5;
			 			if(account_bal > 0)
			 			{
							$('#user_account_msg').text("");
							if(joined_table == true )
							{
								$("#player_5_loader").css('display','none');
								$("#player_5_sit").css('display','block');
							}
							else {
								$("#player_5_loader").css('display','block');
								$("#player_5_sit").css('display','none');
								socket.emit('player_connecting_to_six_player_table', loggeduser,tableid,btnclicked); 
							 	 }
								check_join_count = 10;
								var countdown1 = setInterval(function()
								{
								check_join_count--;
								if (check_join_count == 0 && joined_table==false)
								{
									clearInterval(countdown1);  
									$("#table_popup").css('display','none');
									$("#player_5_loader").css('display','none');
									$("#player_5_sit").css('display','block');
									socket.emit('player_not_connecting_to_six_player_table', loggeduser,tableid,btnclicked);
								}
								}, 1000);
						}else { 
						$("#table_popup").css('display','none');
						}
					}
			   }
			});

			//player 6 sit click
			$("#player_6_sit").unbind().on('click',function()
			{
				if(tableid == 0 && loggeduser == "")
				{
					alert("Please Login to website  to Play Game");
				}
				else
				{
					if(is_game_started == false)
					{
						btnclicked = 6;
			 			if(account_bal > 0)
			 			{
							$('#user_account_msg').text("");
							if(joined_table == true )
							{
								$("#player_6_loader").css('display','none');
								$("#player_6_sit").css('display','block');
							}
							else {
								$("#player_6_loader").css('display','block');
								$("#player_6_sit").css('display','none');
								socket.emit('player_connecting_to_six_player_table', loggeduser,tableid,btnclicked); 
							 	 }
								check_join_count = 10;
								var countdown1 = setInterval(function()
								{
								check_join_count--;
								if (check_join_count == 0 && joined_table==false)
								{
									clearInterval(countdown1);  
									$("#table_popup").css('display','none');
									$("#player_6_loader").css('display','none');
									$("#player_6_sit").css('display','block');
									socket.emit('player_not_connecting_to_six_player_table', loggeduser,tableid,btnclicked);
								}
								}, 1000);
						}else { 
						$("#table_popup").css('display','none');
						}
					}
			   }
			});

			/*Validation if amount entered */
			$("#amount").blur(function()
			{
			var entered_amount = parseInt($("#amount").val());
			var max_entry = parseInt(min_entry*10);
			var table_min_entry  = parseInt(min_entry);
			var user_account_bal = parseInt(account_bal);
			
			if(entered_amount >= table_min_entry)
			{
			  if((entered_amount < user_account_bal) || (entered_amount == user_account_bal))
				{
					if((entered_amount < max_entry) || (entered_amount == max_entry))
					{
						$('#user_account_msg').text("");
					}
					else 
					{
						$("#amount").val('');
						$('#user_account_msg').text("Amount must be in between max entry and min entry");
					}
				}
				else 
					{
						$("#amount").val('');
						$('#user_account_msg').text("Enter valid amount.");
					}
			}
			else
			{
				$("#amount").val('');
				$('#user_account_msg').text("Enter amount greater than min entry.");
			}
			
			check_join_count = 10;
				var countdown3 = setInterval(function(){
				  check_join_count--;
					if (check_join_count == 0 && joined_table==false)
					{
						clearInterval(countdown3);
						$("#table_popup").hide();
						if(btnclicked == 1 )
						{
							$("#player_1_loader").css('display','none');
							$("#player_1_sit").css('display','block');
						}
						else if(btnclicked == 2 )
						{	
							$("#player_2_loader").css('display','none');
							$("#player_2_sit").css('display','block');
						}
						else if(btnclicked == 3 )
						{	
							$("#player_3_loader").css('display','none');
							$("#player_3_sit").css('display','block');
						}
						else if(btnclicked == 4 )
						{	
							$("#player_4_loader").css('display','none');
							$("#player_4_sit").css('display','block');
						}
						else if(btnclicked == 5 )
						{	
							$("#player_5_loader").css('display','none');
							$("#player_5_sit").css('display','block');
						}
						else if(btnclicked == 6 )
						{	
							$("#player_6_loader").css('display','none');
							$("#player_6_sit").css('display','block');
						}

					}
					}, 1000);
		});		

			$("#btn_ok").unbind().on('click',function()
			{				
				if(game_type == 'Pool Rummy')
				{
					console.log(" \n btn ok clicked btnclicked "+btnclicked);
					// browser_type = checkBrowser();
					// os_type = detectOS();
					if(joined_table==false)
					{
						var max_entry = parseInt(min_entry*10);
						var entered_amount = $("#amount").val();
						var account_val = parseInt(account_bal);
						player_poolamount=parseInt(poolamt);
						if(entered_amount == '')
						{
						if(max_entry <= account_val)
							{player_amount = max_entry;
							}
							else
							{
								if(account_val >= min_entry)
								{player_amount =account_bal;}
								else
								{
									alert("You don't have sufficient balance to play game.");
									$("#table_popup").css('display','none');
									$("#btn_cancel").trigger("click");
									return;
								}
							}
						}
						else {player_amount = parseInt(entered_amount); }
					
						if(player_amount > 0)
						{
							$("#table_popup").css('display','none');
							
							if(btnclicked == 1 ) 
							{
								$("#player_1_name").text(loggeduser);
								$("#player_1_amount").text(player_amount);
								$("#player_1_poolamount").text(player_poolamount);
								$("#player_1_details").show();
								$("#player_1_loader").css('display','none');
								if(player_gender == 'Male')
								{ $("#player_1_male_player").css('display','block'); }
								else { $("#player_1_female_player").css('display','block'); }
							}
							else if(btnclicked == 2 ) 
							{
								$("#player_2_name").text(loggeduser);
								$("#player_2_amount").text(player_amount);
								$("#player_2_poolamount").text(player_poolamount);
								$("#player_2_details").show();
								$("#player_2_loader").css('display','none');
								if(player_gender == 'Male')
								{ $("#player_2_male_player").css('display','block'); }
								else { $("#player_2_female_player").css('display','block'); }
							}
							else if(btnclicked == 3 ) 
							{
								$("#player_3_name").text(loggeduser);
								$("#player_3_amount").text(player_amount);
								$("#player_3_poolamount").text(player_poolamount);
								$("#player_3_details").show();
								$("#player_3_loader").css('display','none');
								if(player_gender == 'Male')
								{ $("#player_3_male_player").css('display','block'); }
								else { $("#player_3_female_player").css('display','block'); }
							}
							else if(btnclicked == 4 ) 
							{
								console.log(" \n btn 4th  clicked ");
								$("#player_4_name").text(loggeduser);
								$("#player_4_amount").text(player_amount);
								$("#player_4_poolamount").text(player_poolamount);
								$("#player_4_details").show();
								$("#player_4_loader").css('display','none');
								if(player_gender == 'Male')
								{ $("#player_4_male_player").css('display','block'); }
								else { $("#player_4_female_player").css('display','block'); }
							}
							else if(btnclicked == 5 ) 
							{
								$("#player_5_name").text(loggeduser);
								$("#player_5_amount").text(player_amount);
								$("#player_5_poolamount").text(player_poolamount);
								$("#player_5_details").show();
								$("#player_5_loader").css('display','none');
								if(player_gender == 'Male')
								{ $("#player_5_male_player").css('display','block'); }
								else { $("#player_5_female_player").css('display','block'); }
							}
							else if(btnclicked == 6 ) 
							{
								$("#player_6_name").text(loggeduser);
								$("#player_6_amount").text(player_amount);
								$("#player_6_poolamount").text(player_poolamount);
								$("#player_6_details").show();
								$("#player_6_loader").css('display','none');
								if(player_gender == 'Male')
								{ $("#player_6_male_player").css('display','block'); }
								else { $("#player_6_female_player").css('display','block'); }
							}
							if($.trim($("#div_msg").html())=='')
							 {
							 	setMessage('<label style="color:white">Waiting for another Player to join Table!</label>');
								  socket.emit('player_join_table_pool', loggeduser,btnclicked,tableid,random_group_roundno,1,player_amount,player_poolamount,player_gender,browser_type, os_type,user_id, false);  
							 }
							else
							 {
								socket.emit('player_join_table_pool', loggeduser,btnclicked,tableid,random_group_roundno,2,player_amount,player_poolamount,player_gender,browser_type, os_type,user_id, false); 
							 }

							joined_table=true;
						}//if(player_amount > 0) ends 
					}
					else
					{
						if(btnclicked == 1 )
						{ $('#player_1_sit').prop('disabled', true); }
						else if(btnclicked == 2 )
						{ $('#player_2_sit').prop('disabled', true); }
						else if(btnclicked == 3 )
						{ $('#player_3_sit').prop('disabled', true); }
						else if(btnclicked == 4 )
						{ $('#player_4_sit').prop('disabled', true); }
						else if(btnclicked == 5 )
						{ $('#player_5_sit').prop('disabled', true); }
						else if(btnclicked == 6 )
						{ $('#player_6_sit').prop('disabled', true); }
					}
				}else
				{
					
					console.log(" \n btn ok clicked btnclicked "+btnclicked);
				// browser_type = checkBrowser();
				// os_type = detectOS();
				if(joined_table==false)
				{
					var max_entry = parseInt(min_entry*10);
					var entered_amount = $("#amount").val();
					var account_val = parseInt(account_bal);
					if(entered_amount == '')
					{
						if(max_entry <= account_val)
						{player_amount = max_entry;}
						else
						{
							if(account_val >= min_entry)
							{player_amount =account_bal;}
							else
							{
								alert("You don't have sufficient balance to play game.");
								$("#btn_cancel").trigger("click");
								$("#table_popup").css('display','none');
								return;
							}
						}
					}
					else {player_amount = parseInt(entered_amount); }
				
					if(player_amount > 0)
					{
						$("#table_popup").css('display','none');
						
						if(btnclicked == 1 ) 
						{
							$("#player_1_name").text(loggeduser);
							$("#player_1_amount").text(player_amount);
							$("#player_1_details").show();
							$("#player_1_loader").css('display','none');
							if(player_gender == 'Male')
							{ $("#player_1_male_player").css('display','block'); }
							else { $("#player_1_female_player").css('display','block'); }
						}
						else if(btnclicked == 2 ) 
						{
							$("#player_2_name").text(loggeduser);
							$("#player_2_amount").text(player_amount);
							$("#player_2_details").show();
							$("#player_2_loader").css('display','none');
							if(player_gender == 'Male')
							{ $("#player_2_male_player").css('display','block'); }
							else { $("#player_2_female_player").css('display','block'); }
						}
						else if(btnclicked == 3 ) 
						{
							$("#player_3_name").text(loggeduser);
							$("#player_3_amount").text(player_amount);
							$("#player_3_details").show();
							$("#player_3_loader").css('display','none');
							if(player_gender == 'Male')
							{ $("#player_3_male_player").css('display','block'); }
							else { $("#player_3_female_player").css('display','block'); }
						}
						else if(btnclicked == 4 ) 
						{
							console.log(" \n btn 4th  clicked ");
							$("#player_4_name").text(loggeduser);
							$("#player_4_amount").text(player_amount);
							$("#player_4_details").show();
							$("#player_4_loader").css('display','none');
							if(player_gender == 'Male')
							{ $("#player_4_male_player").css('display','block'); }
							else { $("#player_4_female_player").css('display','block'); }
						}
						else if(btnclicked == 5 ) 
						{
							$("#player_5_name").text(loggeduser);
							$("#player_5_amount").text(player_amount);
							$("#player_5_details").show();
							$("#player_5_loader").css('display','none');
							if(player_gender == 'Male')
							{ $("#player_5_male_player").css('display','block'); }
							else { $("#player_5_female_player").css('display','block'); }
						}
						else if(btnclicked == 6 ) 
						{
							$("#player_6_name").text(loggeduser);
							$("#player_6_amount").text(player_amount);
							$("#player_6_details").show();
							$("#player_6_loader").css('display','none');
							if(player_gender == 'Male')
							{ $("#player_6_male_player").css('display','block'); }
							else { $("#player_6_female_player").css('display','block'); }
						}
						if($.trim($("#div_msg").html())=='')
						 {
						 	setMessage('<label style="color:white">Waiting for another Player to join Table!</label>');
							  socket.emit('player_join_table', loggeduser,btnclicked,tableid,random_group_roundno,1,player_amount,player_gender,browser_type, os_type,user_id, false);  
						 }
						else
						 {
							socket.emit('player_join_table', loggeduser,btnclicked,tableid,random_group_roundno,2,player_amount,player_gender,browser_type, os_type,user_id, false); 
						 }

						joined_table=true;
					}//if(player_amount > 0) ends 
				}
				else
				{
					if(btnclicked == 1 )
					{ $('#player_1_sit').prop('disabled', true); }
					else if(btnclicked == 2 )
					{ $('#player_2_sit').prop('disabled', true); }
					else if(btnclicked == 3 )
					{ $('#player_3_sit').prop('disabled', true); }
					else if(btnclicked == 4 )
					{ $('#player_4_sit').prop('disabled', true); }
					else if(btnclicked == 5 )
					{ $('#player_5_sit').prop('disabled', true); }
					else if(btnclicked == 6 )
					{ $('#player_6_sit').prop('disabled', true); }
				}
				}
			});
			

			$("#btn_cancel").unbind().on('click',function()
			{
				if(btnclicked == 1 )
					{
						$("#player_1_loader").css('display','none');
						$("#player_1_sit").css('display','block');
						socket.emit('player_not_connecting_to_six_player_table', loggeduser,tableid,btnclicked);
					}
				if(btnclicked == 2 )
					{	
						$("#player_2_loader").css('display','none');
						$("#player_2_sit").css('display','block');
						socket.emit('player_not_connecting_to_six_player_table', loggeduser,tableid,btnclicked);
					}
				if(btnclicked == 3 )
					{	
						$("#player_3_loader").css('display','none');
						$("#player_3_sit").css('display','block');
						socket.emit('player_not_connecting_to_six_player_table', loggeduser,tableid,btnclicked);
					}
				if(btnclicked == 4 )
					{	
						$("#player_4_loader").css('display','none');
						$("#player_4_sit").css('display','block');
						socket.emit('player_not_connecting_to_six_player_table', loggeduser,tableid,btnclicked);
					}
				if(btnclicked == 5 )
					{	
						$("#player_5_loader").css('display','none');
						$("#player_5_sit").css('display','block');
						socket.emit('player_not_connecting_to_six_player_table', loggeduser,tableid,btnclicked);
					}
				if(btnclicked == 6 )
					{	
						$("#player_6_loader").css('display','none');
						$("#player_6_sit").css('display','block');
						socket.emit('player_not_connecting_to_six_player_table', loggeduser,tableid,btnclicked);
					}

			});

			/* show loader to other players if a player is connecting on same table - to avoid join collision*/
			socket.on('player_connecting_to_six_player_table', function(playername,tableid_recvd,btn_clicked)
			   {
			   	if(loggeduser!=playername && tableid==tableid_recvd)
					{
						if(!activity_timer_status)
						{
							if(btn_clicked == 1 ) 
							{
								$("#player_1_loader").css('display','block');
								$("#player_1_sit").css('display','none');
							}
							else if(btn_clicked == 2 )
							{	
								$("#player_2_loader").css('display','block');
								$("#player_2_sit").css('display','none');
							}
							else if(btn_clicked == 3 )
							{	
								$("#player_3_loader").css('display','block');
								$("#player_3_sit").css('display','none');
							}
							else if(btn_clicked == 4 )
							{	
								$("#player_4_loader").css('display','block');
								$("#player_4_sit").css('display','none');
							}
							else if(btn_clicked == 5 )
							{	
								$("#player_5_loader").css('display','block');
								$("#player_5_sit").css('display','none');
							}
							else if(btn_clicked == 6 )
							{	
								$("#player_6_loader").css('display','block');
								$("#player_6_sit").css('display','none');
							}
						}
					}
			   });


		/* hide loader to other players if a player is dis-connecting on same table - to avoid join collision*/
				socket.on('player_not_connecting_to_six_player_table', function(playername,tableid_recvd,btn_clicked)
				{
					//alert("activity_timer_status"+activity_timer_status);
					if(loggeduser!=playername && tableid==tableid_recvd)
						{
							if(!activity_timer_status)
							{
								if(btn_clicked == 1 ) 
								{
									$("#player_1_loader").css('display','none');
									$("#player_1_sit").css('display','block');
								}
								if(btn_clicked == 2 )
								{	
									$("#player_2_loader").css('display','none');
									$("#player_2_sit").css('display','block');
								}
								if(btn_clicked == 3 )
								{	
									$("#player_3_loader").css('display','none');
									$("#player_3_sit").css('display','block');
								}
								if(btn_clicked == 4 )
								{	
									$("#player_4_loader").css('display','none');
									$("#player_4_sit").css('display','block');
								}
								if(btn_clicked == 5 )
								{	
									$("#player_5_loader").css('display','none');
									$("#player_5_sit").css('display','block');
								}
								if(btn_clicked == 6 )
								{	
									$("#player_6_loader").css('display','none');
									$("#player_6_sit").css('display','block');
								}
							}
						}
				});

			/*  on joining table show connected player to appropriate sit */
			var player_name_array =[];
			var player_sit_array =[];
			var player_amount_array =[];
			var player_poolamount_array =[];
			var player_gender_array =[];

			/*  on joining table show connected player to appropriate sit */
			socket.on('player_join_table', function(username_recvd, playing_users, user,tableid_listening,recvd_random_group_roundno,activity_timer,amount,gender,is_restart_game,activity_timer_client_side_needed,is_joined_table)
			{
			
				console.log("%%%%%%% is_restart_game"+is_restart_game+" activity_timer "+activity_timer+" --- "+activity_timer_client_side_needed);
				console.log("\n in player_join_table is_finished "+is_finished+" declare "+declare+" is_game_dropped "+is_game_dropped);
				console.log('user'+user);
				// if(is_restart_game == true){ 
				// is_game_started = true; 
				// joined_table = is_joined_table;
				// }else {is_game_started = false;}
				
				if(tableid==tableid_listening)
				{

					if(activity_timer==-1 || activity_timer==-2)//&& is_restart_game == false)
					{
						if( activity_timer==-1 ) {
							if( username_recvd == loggeduser )
								hide_all_players_details();

					    	console.log(" \n @@@@@@ ONLY 1 PLAYER SO WAITING MSG ------ ");
					    	setMessage('<label style="color:white">Waiting for another Player to join Table!</label>');
						}

						if( activity_timer == -2 ) {
							for(i = 0; i < playing_users.length; i++) {
								if( playing_users[i] == loggeduser ) {

									for(j = 1; j < 7; j++) {
										if($("#player_" + j + "_name").text() == "" ) {
											$("#player_"+ j+ "_sit").css('display','none');
											$("#player_"+ j+ "_loader").css('display','none');
											$("#player_"+ j+ "_loader").hide();

											$("#player_"+ j+"_disconnect").css('display','block'); 
											$("#player_"+ j+"_status").text("Waiting");

											if(is_restart_game == false){
												$("#player_"+ j+ "_name").text(username_recvd);
												$("#player_"+ j+ "_amount").text(amount);
												$("#player_"+ j+ "_details").show();
												if(gender == 'Male')
												{ $("#player_"+ j+ "_male_player").css('display','block'); }
												else { $("#player_"+ j+ "_female_player").css('display','block'); }
											}											
											return;
										}
									}
								}
							}
						}

						if(user==1)
						{
							$("#player_1_sit").css('display','none');
							$("#player_1_loader").css('display','none');
							$("#player_1_loader").hide();
							if(is_restart_game == false){
							$("#player_1_name").text(username_recvd);
							$("#player_1_amount").text(amount);
							$("#player_1_details").show();
							if(gender == 'Male')
							{ $("#player_1_male_player").css('display','block'); }
							else { $("#player_1_female_player").css('display','block'); }
							}
						}
						else if(user==2) {
							$("#player_2_sit").css('display','none');						
							$("#player_2_loader").css('display','none');
							$("#player_2_loader").hide();
							if(is_restart_game == false){
							$("#player_2_name").text(username_recvd);
							$("#player_2_amount").text(amount);
							$("#player_2_details").show();
							
							if(gender == 'Male')
							{ $("#player_2_male_player").css('display','block'); }
							else { $("#player_2_female_player").css('display','block'); }
							}
						}
						else if(user==3) {
							$("#player_3_sit").css('display','none');						
							$("#player_3_loader").css('display','none');
							$("#player_3_loader").hide();
							if(is_restart_game == false){
							$("#player_3_name").text(username_recvd);
							$("#player_3_amount").text(amount);
							$("#player_3_details").show();
							
							if(gender == 'Male')
							{ $("#player_3_male_player").css('display','block'); }
							else { $("#player_3_female_player").css('display','block'); }
							}
						}
						else if(user==4) {
							$("#player_4_sit").css('display','none');						
							$("#player_4_loader").css('display','none');
							$("#player_4_loader").hide();
							if(is_restart_game == false){
							$("#player_4_name").text(username_recvd);
							$("#player_4_amount").text(amount);
							$("#player_4_details").show();
							
							if(gender == 'Male')
							{ $("#player_4_male_player").css('display','block'); }
							else { $("#player_4_female_player").css('display','block'); }
							}
						}
						else if(user==5) {
							$("#player_5_sit").css('display','none');						
							$("#player_5_loader").css('display','none');
							$("#player_5_loader").hide();
							if(is_restart_game == false){
							$("#player_5_name").text(username_recvd);
							$("#player_5_amount").text(amount);
							$("#player_5_details").show();
							
							if(gender == 'Male')
							{ $("#player_5_male_player").css('display','block'); }
							else { $("#player_5_female_player").css('display','block'); }
							}
						}
						else if(user==6) {
							$("#player_6_sit").css('display','none');						
							$("#player_6_loader").css('display','none');
							$("#player_6_loader").hide();
							if(is_restart_game == false){
							$("#player_6_name").text(username_recvd);
							$("#player_6_amount").text(amount);
							$("#player_6_details").show();
							
							if(gender == 'Male')
							{ $("#player_6_male_player").css('display','block'); }
							else { $("#player_6_female_player").css('display','block'); }
							}
						}
					  
				}
				else 
				{
				 	console.log("\n rem players sit array  "+JSON.stringify(user)+" amt "+JSON.stringify(amount)+" gen "+JSON.stringify(gender)+" recvd  uname "+JSON.stringify(username_recvd));
					//if (is_restart_game == false) 
					
						player_name_array =[];
					 	player_name_array.push.apply(player_name_array,username_recvd);
					 	player_sit_array =[];
						player_sit_array.push.apply(player_sit_array,user);
						player_amount_array =[];
						player_amount_array.push.apply(player_amount_array,amount);
						player_gender_array =[];
						player_gender_array.push.apply(player_gender_array,gender);
					
				 	console.log('player_name_array'+player_name_array);
					console.log('player_sit_array'+player_sit_array);
					setMessage('<label style="color:white" id="Timer">Game will start within '+activity_timer +' seconds..!</label><br>');

					console.log("\n 1");
					if (activity_timer == 1) 
					{
						console.log("\n 2  ");
						if(is_restart_game == true){ 
						is_game_started = true; 
						joined_table = is_joined_table;
						}
						//else {is_game_started = false;}

						$("#deal_id").html(recvd_random_group_roundno);
						table_round_id = recvd_random_group_roundno;
						activity_timer_status = true;
						$("#Timer").text("");

						emptyMessage();
					}

					console.log("\nAndy isfinish:" + is_finished + " declare:" + declare + " is_game_dropped:" + is_game_dropped);
					if(is_finished == true || declare == 2 || is_game_dropped == true)
					{
									$("#restart_game_timer").text('Game will start within '+activity_timer +' seconds..!');
										activity_timer_status=false;
										if (activity_timer == 1) {
												$(".declare-table").hide();
												emptyMessage();
												declare = 0;
												activity_timer_status=true;
												is_finished = false ;
												is_game_dropped = false;
												player_in_game = true;
												$("#restart_game_timer").text("");
												$("#side_joker").attr('src', ""); 
												$('#game_summary').find('td').remove();
												$('#game_summary tr:gt(3)').remove();
											}
					}
					//else

					{
						console.log("\n is_restart_game "+is_restart_game);
						//if (activity_timer == activity_timer_client_side_needed && is_restart_game == false) 
						
						console.log("---------------------player_join_table------------------------");

						if( joined_table ) {
							hide_all_players_details();
						}
							//if(is_restart_game==false )
							{
								for(var  i = 0; i < user.length; i++)
								{
									console.log('user[i]'+user[i]);
									$("#player_"+(user[i])+"_loader").hide();
									$("#player_"+(user[i])+"_loader").css('display','none');
									$('#player_'+(user[i])+'_sit').css('display','none');
									$("#player_"+(user[i])+"_name").text(username_recvd[i]);
									$("#player_"+(user[i])+"_amount").text(amount[i]);
									$("#player_"+(user[i])+"_details").show();

									if(gender[i] == 'Male')
									{ 
										$("#player_"+(user[i])+"_male_player").css('display','block');
										$("#player_"+(user[i])+"_female_player").css('display','none');					
									}
									else 
									{ 
										$("#player_"+(user[i])+"_male_player").css('display','none');
										$("#player_"+(user[i])+"_female_player").css('display','block'); 
									} 
								
								}//for ends 
							}
					 }///is finished-else
				}//else 
				}//same table no
			});
			
			socket.on('player_join_table_wait', function(tableid_listening) {
				setMessage('<label style="color:white">Please wait until game finish!</label>');
				bWaiting_Join = true;
				console.log("bWaiting_Join true");
			});
			
			socket.on('player_join_table_pool', function(username_recvd, playing_users, user,tableid_listening,recvd_random_group_roundno,activity_timer,amount,poolamount,gender,is_restart_game,activity_timer_client_side_needed,is_joined_table)
			{
				console.log("%%%%%%% is_restart_game"+is_restart_game+" activity_timer "+activity_timer+" --- "+activity_timer_client_side_needed);
				console.log("\n in player_join_table is_finished "+is_finished+" declare "+declare+" is_game_dropped "+is_game_dropped);
				
				// if(is_restart_game == true){ 
				// is_game_started = true; 
				// joined_table = is_joined_table;
				// }else {is_game_started = false;}
				
			  if(tableid==tableid_listening)
			  {
			  	if(activity_timer==-1 || activity_timer== -2)//&& is_restart_game == false)
				 {
				 	if( activity_timer==-1 ) {
				 		if( username_recvd == loggeduser )
							hide_all_players_details();

				    	console.log(" \n @@@@@@ ONLY 1 PLAYER SO WAITING MSG ------ ");
				    	setMessage('<label style="color:white">Waiting for another Player to join Table!</label>');
					}


						if( activity_timer == -2 ) {
							for(i = 0; i < playing_users.length; i++) {
								if( playing_users[i] == loggeduser ) {
									
									for(j = 1; j < 7; j++) {
										if($("#player_" + j + "_name").text() == "" ) {
											$("#player_"+ j+ "_sit").css('display','none');
											$("#player_"+ j+ "_loader").css('display','none');
											$("#player_"+ j+ "_loader").hide();

											$("#player_"+ j+"_disconnect").css('display','block'); 
											$("#player_"+ j+"_status").text("Waiting");

											if(is_restart_game == false){
												$("#player_"+ j+ "_name").text(username_recvd);
												$("#player_"+ j+ "_amount").text(amount);
												$("#player_"+ j+ "_poolamount").text(poolamount);
												$("#player_"+ j+ "_details").show();
												if(gender == 'Male')
												{ $("#player_"+ j+ "_male_player").css('display','block'); }
												else { $("#player_"+ j+ "_female_player").css('display','block'); }
											}											
											return;
										}
									}
								}
							}
						}

						if(user==1)
						{
							$("#player_1_sit").css('display','none');
							$("#player_1_loader").css('display','none');
							
							if(is_restart_game == false){
							$("#player_1_name").text(username_recvd);
							$("#player_1_amount").text(amount);
							$("#player_1_poolamount").text(poolamount);
							$("#player_1_details").show();
							if(gender == 'Male')
							{ $("#player_1_male_player").css('display','block'); }
							else { $("#player_1_female_player").css('display','block'); }
							}
						}
						else if(user==2) {
							$("#player_2_sit").css('display','none');						
							$("#player_2_loader").css('display','none');
							if(is_restart_game == false){
							$("#player_2_name").text(username_recvd);
							$("#player_2_amount").text(amount);
							$("#player_2_poolamount").text(poolamount);
							$("#player_2_details").show();
							
							if(gender == 'Male')
							{ $("#player_2_male_player").css('display','block'); }
							else { $("#player_2_female_player").css('display','block'); }
							}
						}
						else if(user==3) {
							$("#player_3_sit").css('display','none');						
							$("#player_3_loader").css('display','none');
							if(is_restart_game == false){
							$("#player_3_name").text(username_recvd);
							$("#player_3_amount").text(amount);
							$("#player_3_poolamount").text(poolamount);
							$("#player_3_details").show();
							
							if(gender == 'Male')
							{ $("#player_3_male_player").css('display','block'); }
							else { $("#player_3_female_player").css('display','block'); }
							}
						}
						else if(user==4) {
							$("#player_4_sit").css('display','none');						
							$("#player_4_loader").css('display','none');
							if(is_restart_game == false){
							$("#player_4_name").text(username_recvd);
							$("#player_4_amount").text(amount);
							$("#player_4_poolamount").text(poolamount);
							$("#player_4_details").show();
							
							if(gender == 'Male')
							{ $("#player_4_male_player").css('display','block'); }
							else { $("#player_4_female_player").css('display','block'); }
							}
						}
						else if(user==5) {
							$("#player_5_sit").css('display','none');						
							$("#player_5_loader").css('display','none');
							if(is_restart_game == false){
							$("#player_5_name").text(username_recvd);
							$("#player_5_amount").text(amount);
							$("#player_5_poolamount").text(poolamount);
							$("#player_5_details").show();
							
							if(gender == 'Male')
							{ $("#player_5_male_player").css('display','block'); }
							else { $("#player_5_female_player").css('display','block'); }
							}
						}
						else if(user==6) {
							$("#player_6_sit").css('display','none');						
							$("#player_6_loader").css('display','none');
							if(is_restart_game == false){
							$("#player_6_name").text(username_recvd);
							$("#player_6_amount").text(amount);
							$("#player_6_poolamount").text(poolamount);
							$("#player_6_details").show();
							
							if(gender == 'Male')
							{ $("#player_6_male_player").css('display','block'); }
							else { $("#player_6_female_player").css('display','block'); }
							}
						}

						if( poolamount <= 0 ) {
							$("#player_"+(user)+"_disconnect").css('display','block'); 
							$("#player_"+(user)+"_status").text("Lost");
							bLosted = true;
						} else {
							bLosted = false;
						}		  
				 }
				else
				{
				 	console.log("\n rem players sit array  "+JSON.stringify(user)+" amt "+JSON.stringify(amount)+" gen "+JSON.stringify(gender)+" recvd  uname "+JSON.stringify(username_recvd));
					//if (is_restart_game == false) 
					{
						player_name_array =[];
					 	player_name_array.push.apply(player_name_array,username_recvd);
					 	player_sit_array =[];
						player_sit_array.push.apply(player_sit_array,user);
						player_amount_array =[];
						player_amount_array.push.apply(player_amount_array,amount);
						player_poolamount_array =[];
						player_poolamount_array.push.apply(player_poolamount_array,poolamount);
						player_gender_array =[];
						player_gender_array.push.apply(player_gender_array,gender);
					}

					bLosted = false;
					for(var  i = 0; i < user.length; i++)
					{
						if( loggeduser == username_recvd[i]) {
							if( poolamount[i] <= 0 ) {
								bLosted = true;
							}
						}
					}
				 	
				 	setMessage('<label style="color:white" id="Timer">Game will start within '+activity_timer +' seconds..!</label><br>')
						console.log("\n 1");
					if (activity_timer == 1) 
					{
						console.log("\n 2  ");
						if(is_restart_game == true){ 
						is_game_started = true; 
						joined_table = is_joined_table;
						}
						//else {is_game_started = false;}

						$("#deal_id").html(recvd_random_group_roundno);
						table_round_id = recvd_random_group_roundno;
						activity_timer_status = true;

						emptyMessage();
					}
					if(is_finished == true || declare == 2 || is_game_dropped == true)
					{
									$("#restart_game_timer").text('Game will start within '+activity_timer +' seconds..!');
										activity_timer_status=false;
										if (activity_timer == 1) {
												$(".declare-table").hide();
												
												emptyMessage();

												declare = 0;
												activity_timer_status=true;
												is_finished = false ;
												is_game_dropped = false;
												player_in_game = true;
												$("#restart_game_timer").text("");
												$("#side_joker").attr('src', ""); 
												$('#game_summary').find('td').remove();
												$('#game_summary tr:gt(3)').remove();
											}
					}
					//else
					{
						//console.log("\n 33333 ");
						//if (activity_timer == activity_timer_client_side_needed && is_restart_game == false) 
						//if (is_restart_game == false) 
						{
						console.log("---------------------player_join_table------------------------");
						if( joined_table ) {
							hide_all_players_details();
						}
							
							for(var  i = 0; i < user.length; i++)
							{
									$("#player_"+(user[i])+"_loader").hide();
									$('#player_'+(user[i])+'_sit').css('display','none');
									$("#player_"+(user[i])+"_name").text(username_recvd[i]);
									$("#player_"+(user[i])+"_amount").text(amount[i]);
									$("#player_"+(user[i])+"_poolamount").text(poolamount[i]);
									$("#player_"+(user[i])+"_details").show();

									if(gender[i] == 'Male')
									{ 
										$("#player_"+(user[i])+"_male_player").css('display','block');
										$("#player_"+(user[i])+"_female_player").css('display','none');					
									}
									else 
									{ 
										$("#player_"+(user[i])+"_male_player").css('display','none');
										$("#player_"+(user[i])+"_female_player").css('display','block'); 
									} 

									if( poolamount[i] <= 0 ) {
										$("#player_"+(user[i])+"_disconnect").css('display','block'); 
										$("#player_"+(user[i])+"_status").text("Lost");
									}
							}//for ends 
					 	}///if timer==10
					 }///is finished-else
				}//else 
				}//same table no
			});
			/////displaying turn card on deck to both players to decide turn
			socket.on("six_pl_turn_card", function(data) 
			{
			console.log("\n --------DATA  in six_pl_turn_card"+JSON.stringify(data));
			 if(tableid==data.group_id)///check for same table
			  {
			    if(table_round_id == data.round_no)///check for same table-round id
			    {
					var card_no_arr = [];
					var card_no_arr_temp = [];
					var card_path_arr = [];
					var card_path_arr_temp = [];
					var player_name_array_temp = [];var player_sit_array_temp = [];
					var player_amount_array_temp = [];var player_gender_array_temp = [];
					var player_card_no  = data.card_no;
					var index = -1;

					//console.log("\n player_card_no "+player_card_no);
					//console.log("\n after data.game_restart "+data.game_restart);

					card_no_arr.push.apply(card_no_arr,data.other_card_no);
					card_path_arr.push.apply(card_path_arr,data.other_card_path);
					
					console.log("\n card_no_arr "+JSON.stringify(card_no_arr));
					console.log("\n card_path_arr "+JSON.stringify(card_path_arr));
					console.log("\n player_name_array "+JSON.stringify(player_name_array));
					console.log("\n player_sit_array "+JSON.stringify(player_sit_array));

					console.log("\n player_amount_array "+JSON.stringify(player_amount_array));
					//console.log("\n player_gender_array "+JSON.stringify(player_gender_array));
					
					

					//compare and if found remove from array 
					//for(var  i = 0; i < card_no_arr.length;)
					for(var  i = 0; i < player_name_array.length;)
					{
						//console.log(" card_no_arr[i] != player_card_no "+card_no_arr[i]+"---"+player_card_no);
						//if(card_no_arr[i] != player_card_no)
						if(player_name_array[i] != loggeduser)
						{
							//console.log(" not equal "+i);
							card_no_arr_temp.push(card_no_arr[i]);
							card_path_arr_temp.push(card_path_arr[i]);

							player_name_array_temp.push(player_name_array[i]);
							player_sit_array_temp.push(player_sit_array[i]);
							//if(is_game_started == false)
							{
							player_amount_array_temp.push(player_amount_array[i]);
							player_gender_array_temp.push(player_gender_array[i]);
							}
							index = i;
							if(index != -1)
							{
								//card_no_arr.remove(index);
								 card_no_arr.splice(index, 1);
								 card_path_arr.splice(index, 1);

								 player_name_array.splice(index, 1);
								 player_sit_array.splice(index, 1);
								//if(is_game_started == false)
								{
								player_amount_array.splice(index, 1);
								player_gender_array.splice(index, 1);
								}
							}
						}
						else
						{
							//console.log(" equal so break "+i);
							i++
							break;
						}
					}
					//console.log("\n if found after remove card_no_arr "+JSON.stringify(card_no_arr));
					console.log("\n if found after remove player_name_array "+JSON.stringify(player_name_array));
					//console.log("\n if found after remove player_sit_array "+JSON.stringify(player_sit_array));
					console.log("\n if found after remove player_amount_array "+JSON.stringify(player_amount_array));
					//console.log("\n if found after remove player_gender_array "+JSON.stringify(player_gender_array));
					//combine both array	
					card_no_arr.push.apply(card_no_arr,card_no_arr_temp);
					card_path_arr.push.apply(card_path_arr,card_path_arr_temp);

					player_name_array.push.apply(player_name_array,player_name_array_temp);
					player_sit_array.push.apply(player_sit_array,player_sit_array_temp);
					//if(is_game_started == false)
					{
					player_amount_array.push.apply(player_amount_array,player_amount_array_temp);
					player_gender_array.push.apply(player_gender_array,player_gender_array_temp);
					}

					console.log("\n after combine card_no_arr "+JSON.stringify(card_no_arr));
					console.log("\n  player_name_array "+JSON.stringify(player_name_array));
					console.log("\n player_sit_array "+JSON.stringify(player_sit_array));
					console.log("\n player_amount_array "+JSON.stringify(player_amount_array));
					console.log("\n player_gender_array "+JSON.stringify(player_gender_array));
					console.log("\n player_turn_card_array "+JSON.stringify(card_path_arr));

					if(is_game_started == false)
					{
						hide_all_players_details();
					}
					else
					{
						for(var  i = 1; i < 7; i++)
						{
							$("#player_"+(i)+"_name").text("");
							$("#player_"+(i)+"_details").hide();
							$("#player_"+(i)+"_sit").hide();
							$("#player_"+(i)+"_male_player").css('display','none');
							$("#player_"+(i)+"_female_player").css('display','none'); 
						}
					}
					
					for(var  i = 0; i < player_sit_array.length; i++)
					{
						var seat = player_sit_array[i];
						$("#player_"+(i+1)+"_name").text(player_name_array[i]);
						$("#player_"+(i+1)+"_amount").text(player_amount_array[i]);
						//if(is_game_started == false)
						{
							console.log("---------------------in six pl turn card ------------------------");
							//$("#player_"+(i+1)+"_amount").text(player_amount_array[i]);
							if(player_gender_array[i] == 'Male')
							{ 
								$("#player_"+(i+1)+"_male_player").css('display','block');
								$("#player_"+(i+1)+"_female_player").css('display','none');					
							}
							else 
							{ 
								$("#player_"+(i+1)+"_male_player").css('display','none');
								$("#player_"+(i+1)+"_female_player").css('display','block'); 
							} 
						}
						$("#player_"+(i+1)+"_details").show();
						$("#player"+(i+1)+"_turn_card").attr('src',card_path_arr[i]); 
						
						$(".player"+(i+1)+"_turn_card").show(); 
						

						if(($("#player_"+(i+1)+"_name").text())==data.dealer)
						{$("#player_"+(i+1)+"_dealer").show();}

					}
					if(is_game_started == true)
					{
						is_game_started = false;
					}
				}
			  }
			});///firstcard ends 
			socket.on("six_pl_turn_card_pool", function(data) 
			{
			console.log("\n --------DATA  in six_pl_turn_card"+JSON.stringify(data));
			 if(tableid==data.group_id)///check for same table
			  {
			    if(table_round_id == data.round_no)///check for same table-round id
			    {
					var card_no_arr = [];
					var card_no_arr_temp = [];
					var card_path_arr = [];
					var card_path_arr_temp = [];
					var player_name_array_temp = [];var player_sit_array_temp = [];
					var player_amount_array_temp = [];
					var player_poolamount_array_temp = [];var player_gender_array_temp = [];
					var player_card_no  = data.card_no;
					var index = -1;

					//console.log("\n player_card_no "+player_card_no);
					//console.log("\n after data.game_restart "+data.game_restart);

					for(i = 0; i < player_name_array.length; i++) {
						var bFind = false;
						for(j = 0; j < data.players.length; j++) {
							if(player_name_array[i] == data.players[j]) {
								bFind = true;
								card_no_arr.push(data.other_card_no[j]);
								card_path_arr.push(data.other_card_path[j]);
								break;
							}
						}
						if( bFind == false ) {
							card_no_arr.push( -1 );
							card_path_arr.push( -1 );
						}
					}
					//ANDY card_no_arr.push.apply(card_no_arr,data.other_card_no);
					//ANDY card_path_arr.push.apply(card_path_arr,data.other_card_path);
					
					//console.log("\n card_no_arr "+JSON.stringify(card_no_arr));
					//console.log("\n card_path_arr "+JSON.stringify(card_path_arr));
					console.log("\n player_name_array "+JSON.stringify(player_name_array));
					//console.log("\n player_sit_array "+JSON.stringify(player_sit_array));

					console.log("\n player_amount_array "+JSON.stringify(player_amount_array));
					//console.log("\n player_gender_array "+JSON.stringify(player_gender_array));
					
					

					//compare and if found remove from array 
					//for(var  i = 0; i < card_no_arr.length;)
					for(var  i = 0; i < player_name_array.length;)
					{
						//console.log(" card_no_arr[i] != player_card_no "+card_no_arr[i]+"---"+player_card_no);
						//if(card_no_arr[i] != player_card_no)
						if(player_name_array[i] != loggeduser)
						{
							//console.log(" not equal "+i);
							card_no_arr_temp.push(card_no_arr[i]);
							card_path_arr_temp.push(card_path_arr[i]);

							player_name_array_temp.push(player_name_array[i]);
							player_sit_array_temp.push(player_sit_array[i]);
							//if(is_game_started == false)
							{
							player_amount_array_temp.push(player_amount_array[i]);
							player_poolamount_array_temp.push(player_poolamount_array[i]);
							player_gender_array_temp.push(player_gender_array[i]);
							}
							index = i;
							if(index != -1)
							{
								//card_no_arr.remove(index);
								 card_no_arr.splice(index, 1);
								 card_path_arr.splice(index, 1);

								 player_name_array.splice(index, 1);
								 player_sit_array.splice(index, 1);
								//if(is_game_started == false)
								{
								player_amount_array.splice(index, 1);
								player_poolamount_array.splice(index, 1);
								player_gender_array.splice(index, 1);
								}
							}
						}
						else
						{
							//console.log(" equal so break "+i);
							i++
							break;
						}
					}
					//console.log("\n if found after remove card_no_arr "+JSON.stringify(card_no_arr));
					console.log("\n if found after remove player_name_array "+JSON.stringify(player_name_array));
					//console.log("\n if found after remove player_sit_array "+JSON.stringify(player_sit_array));
					console.log("\n if found after remove player_amount_array "+JSON.stringify(player_amount_array));
					//console.log("\n if found after remove player_gender_array "+JSON.stringify(player_gender_array));
					//combine both array	
					card_no_arr.push.apply(card_no_arr,card_no_arr_temp);
					card_path_arr.push.apply(card_path_arr,card_path_arr_temp);

					player_name_array.push.apply(player_name_array,player_name_array_temp);
					player_sit_array.push.apply(player_sit_array,player_sit_array_temp);
					//if(is_game_started == false)
					{
					player_amount_array.push.apply(player_amount_array,player_amount_array_temp);
					player_poolamount_array.push.apply(player_poolamount_array,player_poolamount_array_temp);
					player_gender_array.push.apply(player_gender_array,player_gender_array_temp);
					}

					console.log("\n after combine card_no_arr "+JSON.stringify(card_no_arr));
					console.log("\n  player_name_array "+JSON.stringify(player_name_array));
					console.log("\n player_sit_array "+JSON.stringify(player_sit_array));
					console.log("\n player_amount_array "+JSON.stringify(player_amount_array));
					console.log("\n player_gender_array "+JSON.stringify(player_gender_array));
					console.log("\n player_turn_card_array "+JSON.stringify(card_path_arr));

					if(is_game_started == false)
					{
						hide_all_players_details();
					}
					else
					{
						for(var  i = 1; i < 7; i++)
						{
							$("#player_"+(i)+"_name").text("");
							$("#player_"+(i)+"_details").hide();
							$("#player_"+(i)+"_sit").hide();
							$("#player_"+(i)+"_male_player").css('display','none');
							$("#player_"+(i)+"_female_player").css('display','none'); 
							$("#player_"+(i)+"_disconnect").css('display','none');

							console.log("BLOCK on six_pl_turn_card_pool");
						}
					}
					
					bLosted = false;
					for(var  i = 0; i < player_name_array.length; i++)
					{
						$("#player_"+(i+1)+"_name").text(player_name_array[i]);
						$("#player_"+(i+1)+"_amount").text(player_amount_array[i]);
						$("#player_"+(i+1)+"_poolamount").text(player_poolamount_array[i]);

						if( player_poolamount_array[i] <= 0 ) {
							$("#player_"+(i+1)+"_disconnect").css('display','block'); 
							$("#player_"+(i+1)+"_status").text("Lost");

							if( player_name_array[i] == loggeduser )
								bLosted = true;
						}
						//if(is_game_started == false)
						{
							console.log("---------------------in six pl turn card ------------------------");
							//$("#player_"+(i+1)+"_amount").text(player_amount_array[i]);
							if(player_gender_array[i] == 'Male')
							{ 
								$("#player_"+(i+1)+"_male_player").css('display','block');
								$("#player_"+(i+1)+"_female_player").css('display','none');					
							}
							else 
							{ 
								$("#player_"+(i+1)+"_male_player").css('display','none');
								$("#player_"+(i+1)+"_female_player").css('display','block'); 
							} 
						}
						$("#player_"+(i+1)+"_details").show();

						if(card_no_arr[i] == -1) {							
							$(".player"+(i+1)+"_turn_card").hide();

							$("#player_"+(i+1)+"_disconnect").css('display','block'); 
							if( player_poolamount_array[i] <= 0 ) {
								$("#player_"+(i+1)+"_status").text("Lost");							
							} else {
								$("#player_"+(i+1)+"_status").text("Waiting");							
							}
							console.log("WWWWWWWWWWWWWWWW2401");
						} else {
							$("#player"+(i+1)+"_turn_card").attr('src',card_path_arr[i]); 					
							$(".player"+(i+1)+"_turn_card").show(); 
						}
						

						if(($("#player_"+(i+1)+"_name").text())==data.dealer)
						{$("#player_"+(i+1)+"_dealer").show();}

					}
					if(is_game_started == true)
					{
						is_game_started = false;
					}
				}
			  }
			});///firstcard ends 
		function hide_all_players_details()
		{
			for(var  i = 1; i < 7; i++)
			{
				$("#player_"+(i)+"_name").text("");
				$("#player_"+(i)+"_amount").text("");
				$("#player_"+(i)+"_disconnect").css('display','none');
				$("#player_"+(i)+"_details").hide();
				$("#player_"+(i)+"_male_player").css('display','none');
				$("#player_"+(i)+"_female_player").css('display','none');
				$("#player_"+(i)+"_sit").hide();
			}
			console.log("BLOCK on hide_all_players_details");
		}

		//// According to turn distribute both players their respective 13 hand cards with open ,joker and closed cards
			var open_arr_temp = [];
			socket.on("turn", function(data) 
			{
			 if(tableid == data.group_id)///check for same table
			 {
			  if(table_round_id == data.round_no)
			  {
				var opp_player;
				$(".declare-table").hide();
				if(data.myturn) 
				{
					setMessage("<span style='color:white;top:50%' class='label label-important'>You will Play First.</span>");
				} 
				else 
				{
					setMessage("<span style='color:white;top:50%' class='label label-info'>Player  <b>"+data.turn_of_user+"  </b> will play first.</span>");
				}
					var temp_count = 5;
					
					if(((data.closedcards_path).length)!=0)
					{temp_closed_cards_arr.push.apply(temp_closed_cards_arr,data.closedcards_path);}
					
						  var countdown = setInterval(function(){
						  temp_count--;
						  if (temp_count == 0) {
						 		  clearInterval(countdown);  
						 		  emptyMessage();
								 $("#images").empty();
								 for(var  i = 0; i < 6; i++)
								 {
								   $(".player"+(i+1)+"_turn_card").hide();
								 }
								  
								user_assigned_cards.push.apply(user_assigned_cards, data.assigned_cards); 
								////// assign 13 cards to both players 
								$('#images_parent').append( $('#images') );
								show_player_hand_cards(data.assigned_cards,data.sidejokername);
								audio_shuffle.play();
									////// open and closed and side joker images
									 $("#open_card").show();
									 $("#closed_cards").show();
									 $("#joker_card").show();
									 $("#open_card").attr('src', data.opencard);  
									 initial_open_card = data.opencard1;
									 open_arr_temp.push(data.opencard1);
									 open_card_id=data.opencard_id;
									 $("#closed_cards").attr('src', "c3.jpg");  
									 $("#joker_card").attr('src', data.sidejoker);  
									 $("#open_deck").show();
									 
									temp_closed_cards_arr1 = [];
									temp_closed_cards_arr1.push.apply(temp_closed_cards_arr1,data.closedcards);
									closed_card_src_temp = data.closedcards[0].card_path;
									closed_card_id_temp = data.closedcards[0].id;
								}//temp count of 5 second ends 
							}, 1000);
				   }//check is same table-round id
				}//check is same table
			});///turn ends 

		function show_player_hand_cards(_cards,sidejokername)
		{
				console.log(" @@@@@@@@@ show_player_hand_cards @@@@@@@@@@@ ");
				console.log("\n -- "+JSON.stringify(_cards));
				var user_hand_arr = [];
				user_hand_arr.push.apply(user_hand_arr,_cards);
				$("#images").empty();
				$.each(user_hand_arr, function(k, v) 
				{
					if(k==0)
					{
						$("#images").append("<div><img id="+v.id+" src="+v.card_path+"></div>");
						if(v.name==sidejokername)
						 $("#jokerimages").append("<span id='jokerimg' />");
						
					}
					else
					{
						$("#images").append("<div><img id="+v.id+"  src="+v.card_path+"></div>");
						if(v.name==sidejokername)
						 $("#jokerimages").append("<span id='jokerimg' />");
						 
					}
					$("#sort_cards").show();
					
					$("#"+v.id).click(function() 
					{
					  if(player_in_game != false)
					  {
						if(($.inArray(v.id,card_click))>-1)
						{ 
							$("#"+v.id).css('border', ""); 
							idx = $.inArray(v.id,card_click);
							card_click.splice(idx, 1);
							card_click_grp.splice(idx, 1);
							/*
							card_click = jQuery.grep(card_click, function(value) {
							  return value != v.id;
							});*/
							selected_card_count--;
							groupCards(v.id,v,selected_card_count,0); 
						}
						else 
						{
							clicked_key = v.id;
							card_click.push(clicked_key);
							card_click_grp.push(0);
							$("#"+v.id).css('border', "solid 1px blue"); 
							selected_card_count++;
							groupCards(clicked_key,v,selected_card_count,1);
						}

						if( selected_card_count == 1 ) {
							clicked_key = card_click[0];
							clicked_key_grp = card_click_grp[0];
						}
						console.log("selected_card_count"+selected_card_count);
						if(selected_card_count > 1)
						{$("#group_cards").show();console.log("can do group");}
						else {$("#group_cards").hide();console.log("u can not group");}
							if($.trim($("#images").html())!='')
							{ 
							 card_count = $("#images").children().length;
							 }
							console.log('no_of_jokers'+no_of_jokers);
							console.log('card_count'+card_count);
							if(card_count==14  && player_turn==true && selected_card_count ==1)
							{
								$("#discard_card").show();
								$("#finish_game").show();
								$("#group_cards").hide();
							}
							else
							{
								$("#discard_card").hide();
								$("#finish_game").hide();
								$('#discard_card').attr("disabled", 'disabled');
								$('#finish_game').attr("disabled", 'disabled');
							}
						$("#discard_card").unbind().on('click',function()
						{
							audio_discard.play();													
							 $('#discard_card').attr("disabled", 'disabled');
							  $("#discard_card").hide();													
							 $('#finish_game').attr("disabled", 'disabled');												
							 $('#drop_game').attr("disabled", 'disabled');
							$("#finish_game").hide();
							$("#drop_game").hide();

							$("#popup-confirm").hide();
							if(clicked_key!=prev_discard_key)
							{
								var src = $("#"+clicked_key).attr("src");
								console.log("discard CARD clicked_key "+clicked_key+" src "+src);
								var open_objj;
								for(var  i = 0; i < user_hand_arr.length; i++){	
									if(user_hand_arr[i].id == clicked_key){
											open_objj = user_hand_arr[i];
											break;
										}
									}
								console.log("discard CARD ----clicked_key "+clicked_key+" open obj "+open_objj);
								//discard("#",src,clicked_key,"#images", user_hand_arr[clicked_key],clicked_key,open_objj);
								discard("#",src,clicked_key,"#images", open_objj,clicked_key,open_objj);
								prev_discard_key = clicked_key;
							}
							selected_card_arr = [];
							selected_card_count = 0;
						});
						$("#finish_game").unbind().on('click',function()
						{
							var finish_card_obj;
								for(var  i = 0; i < user_hand_arr.length; i++){
									if(user_hand_arr[i].id == clicked_key){
											finish_card_obj = user_hand_arr[i];
											break;
										}
									}
							finish(finish_card_obj,clicked_key,0);
						});
					  }
					});
				});
		}///show_player_hand_cards ends 

		/////after discard/return ,update hand cards of player
		socket.on("update_hand_cards_six", function(data) 
		{
			console.log("UPDATING HAND CARDS AFTER DISCARD/RETURN");
			if(data.user==loggeduser)
			{
				if(tableid==data.group)
				{
					if(table_round_id == data.round_id)
					{
						console.log("before discard/return HAND CARDS: "+user_assigned_cards.length+"--"+JSON.stringify(user_assigned_cards));
						user_assigned_cards = [];
						user_assigned_cards.push.apply(user_assigned_cards,data.hand_cards);
						console.log("\n AFTER discard/return HAND CARDS:  "+user_assigned_cards.length+"--"+JSON.stringify(user_assigned_cards));
						show_player_hand_cards(data.hand_cards,data.sidejokername); 
					}
				}
			}
		});
				

		/// function for alternate turns once turn end of a player
		/////show turn timer to other player on first ends 
		socket.on("timer_six", function(data) 
		{
			// $("#sort_cards").show();
			if(!(navigator.onLine))
			{
			//	alert("Connection Failed,Please Check your Internet connection..!");
			}
			if(tableid==data.group_id)///check for same table
			{
			    if(table_round_id == data.round_id)///check for same table-round id
			    {
			    	hide_all_players_turn_details();
			    	//alert("showing game turn timer");
			    	//console.log(" timer _details "+JSON.stringify(data));
			    	 if($.trim($("#images").html())!='')
					{ 
						card_count = $("#images").children().length;
						card_count =card_count - no_of_jokers;		
					}
					else
					{
						card_count= ($("#card_group1").children().length)+($("#card_group2").children().length)+($("#card_group3").children().length)+($("#card_group4").children().length)+($("#card_group5").children().length)+($("#card_group6").children().length)+($("#card_group7").children().length);
						card_count =card_count - no_of_jokers;		
					}

						game_count = data.game_timer;
						extra_count = data.extra_time;
						player_having_turn  = data.turn_of_user;
						
						for(var  i = 1; i < 7; i++)
						{
							if(($("#player_"+(i)+"_name").text())==data.turn_of_user)
							{
								$("#player_"+(i)+"_count1").show();
								$("#player"+(i)+"turn").show();
								if( game_count >= 1 ) {
									$("#player"+(i)+"turn").text(game_count);
								} else {
									$("#player"+(i)+"turn").text("Ex: " + extra_count);
								}
								
								//$("#player_"+(i)+"_dealer").show();
							}//if-turn
						}//for
						if(data.myturn) 
						{
							player_turn = true;

							if(card_count == 13 && game_type!='Deal Rummy')
								{ $("#drop_game").show(); }
							else
								{ $("#drop_game").hide();
								$('#drop_game').attr("disabled", 'disabled');
								}

							if(is_finished == true || is_other_declared == true)
								{
								 $('#drop_game').attr("disabled", 'disabled');
								$("#drop_game").hide(); }
											
							if(data.is_discard == true || data.is_declared == true || data.is_dropped == true || data.is_poolpoint == true)
								{ game_count = 1; extra_count = 1;} 

							if (game_count <= 1 && extra_count <= 1) 
								{
									audio_player_turn_end.play();
									is_open_close_picked = 0;
									$('#drop_game').attr("disabled", 'disabled');
									$("#drop_game").hide();
									ttt = false ;
									hide_all_add_here_buttons();
									selected_card_arr = [];
									selected_group_card_arr = [];
											
									data.is_discard = false;
									player_turn = false;
									is_other_declared = false;
									is_picked_card = false;
									
									$('#discard_card').attr("disabled", 'disabled');
									$("#discard_card").hide();
									$('#finish_game').attr("disabled", 'disabled');
									$("#finish_game").hide();

									$("#popup-confirm").hide();
									hide_all_players_turn_details();
								}
						}
						else
						{
							player_turn = false;
							$('#discard_card').attr("disabled", 'disabled');
							$("#drop_game").hide();
							if(data.is_discard == true || data.is_declared == true  || data.is_dropped == true || data.is_poolpoint == true)
							{ game_count = 1; extra_count = 1;} 
										
							if(game_count <= 1 && extra_count <= 1) 
							{
								audio_player_turn_end.play();
								data.is_discard = false;
								hide_all_players_turn_details();
							}
						}
						if(game_count < 5)
							{ audio_player_turn_ending.play();}
					}
						
			    }
		});//timer_six ends 

   		function hide_all_players_turn_details()
   		{
   			for(var  i = 1; i < 7; i++)
			{
				$("#player_"+(i)+"_count1").hide();
				//$("#player_"+(i)+"_dealer").hide();
			}			
		}//hide_all_players_turn_details ends 

		////// Sorting according to card-suit on sort_card button click
		$("#sort_cards").click(function()
		{
			if(player_in_game != false)
			{
			   
				$("#sort_cards").hide();
				is_sorted = true;// to know sorting has done
			    var temp = []; 
				var temp_group1 = [],temp_group2 = [],temp_group3 = [],temp_group4 = [];
				if(user_assigned_cards.length == 13 || user_assigned_cards.length == 14)
				{
					temp.push.apply(temp,user_assigned_cards);
				}
				if(temp.length >0)	
				{
					temp = temp.sort(function(a,b) {
						return (a.suit < b.suit ? -1 : 1)
					});
					
					temp = temp.sort(function(a,b) {
						return (a.suit_id < b.suit_id ? -1 : 1)
					});
				
					$("#images").empty();
				
					$.each(temp, function(key, obj)
					{ 
						var div_name = obj.suit;
						if(div_name=='C')
							{grp1.push({v:obj,k:key});
							temp_group1.push(obj);}
						if(div_name=='S')
							{
							grp2.push({v:obj, k: key});
							temp_group2.push(obj);
							}
						if(div_name=='H')
							{
							grp3.push({v:obj, k: key});
							temp_group3.push(obj);
							}
						if(div_name=='D' || div_name=='Red_Joker' || div_name=='Black_Joker')
							{
							grp4.push({v:obj, k: key});
							temp_group4.push(obj);
							}
					});
				
					/// emit player groups after sort to server///
					socket.emit("update_player_groups_six",{player:loggeduser,group:tableid,round_id:table_round_id,group1:temp_group1,group2:temp_group2,group3:temp_group3,group4:temp_group4,is_sort:is_sorted,is_group:is_grouped,is_initial_group:initial_group,parent_group:grp2});
				}
			   
			}//if-player-in-game 
		});////sort_cards() ends 

		/* show player hand card groups after sort */
		socket.on("update_player_groups_six", function(data) 
		{
			show_player_hand_cards_after_sort(data.user,data.group,data.round_id,data.grp1_cards,data.grp2_cards,data.grp3_cards,data.grp4_cards,data.grp5_cards,data.grp6_cards,data.grp7_cards,data.sidejokername);
		});
			
		var add_card_obj;// = [];
		function show_player_hand_cards_after_sort(user,group,round_id,grp1_cards,grp2_cards,grp3_cards,grp4_cards,grp5_cards,grp6_cards,grp7_cards,sidejokername)
		{
				var src ;
				var card_count=0;
				var clicked_card_count=0;
				var card_click = [] ; var clicked_key;
				var card_click_grp = [] ; var clicked_key_grp;
				sort_grp1 =[], sort_grp2 =[], sort_grp3 =[], sort_grp4 =[],
					sort_grp5 =[], sort_grp6 =[], sort_grp7 =[]; 
			    var discard_obj = [];
				 console.log("Showing player card groups after sort");
			  console.log("\n grp1_cards "+grp1_cards.length);
			  
				$("#card_group1").empty();
				$("#card_group2").empty();
				$("#card_group3").empty();
				$("#card_group4").empty();
				$("#card_group5").empty();
				$("#card_group6").empty();
				$("#card_group7").empty();
				$("#images").empty();
			
			  if(user==loggeduser)
			  {
				if(tableid==group)
				{
				 if(table_round_id == round_id)
				  {

					$("#discard_card").unbind().on('click',function()
					{
						audio_discard.play();
						$('#discard_card').attr("disabled", 'disabled');
						$('#finish_game').attr("disabled", 'disabled');
						$('#drop_game').attr("disabled", 'disabled');
						$("#discard_card").hide();
						$("#finish_game").hide();
						$("#drop_game").hide();
						$("#popup-confirm").hide();
						
						hide_all_add_here_buttons();
						discard_click  = true ;
						next_turn = true;
						open_card_id = clicked_key;
						src=$("#"+clicked_key).attr("src");
						$("#open_card").attr('src', src);  
						ttt = false;
						
						socket.emit("discard_fired_six",{discarded_user:loggeduser,group:tableid,round_id:table_round_id});
						
						var sort_grp_temp;
						if(clicked_key_grp == 1) {
							sort_grp_temp = sort_grp1;
						} else if(clicked_key_grp == 2) {
							sort_grp_temp = sort_grp2;
						} else if(clicked_key_grp == 3) {
							sort_grp_temp = sort_grp3;
						} else if(clicked_key_grp == 4) {
							sort_grp_temp = sort_grp4;
						} else if(clicked_key_grp == 5) {
							sort_grp_temp = sort_grp5;
						} else if(clicked_key_grp == 6) {
							sort_grp_temp = sort_grp6;
						} else if(clicked_key_grp == 7) {
							sort_grp_temp = sort_grp7;
						}

						for(var  i = 0; i < sort_grp_temp.length; i++)
						{
							if(sort_grp_temp[i].id == clicked_key)
							{
								open_obj = sort_grp_temp[i];
								break;
							}
						}
						discard_obj.push(open_obj);
						
						card_click = [];
						card_click_grp = [];
						clicked_card_count = 0;

						socket.emit("show_open_card_six",{user: loggeduser,group:tableid,open_card_src:src,check:ttt,round_id:table_round_id,open_card_id:open_card_id,discard_card_data:open_card_id,discarded_open_data:discard_obj,is_sort:is_sorted,is_group:is_grouped,group_from_discarded:clicked_key_grp,is_initial_group:initial_group});
						discard_obj = [];
						selected_card_arr = [];
						selected_group_card_arr = [];
					});
					$("#finish_game").unbind().on('click',function()
					{
						var finish_card_obj;
						var sort_grp_temp;
						if(clicked_key_grp == 1) {
							sort_grp_temp = sort_grp1;
						} else if(clicked_key_grp == 2) {
							sort_grp_temp = sort_grp2;
						} else if(clicked_key_grp == 3) {
							sort_grp_temp = sort_grp3;
						} else if(clicked_key_grp == 4) {
							sort_grp_temp = sort_grp4;
						} else if(clicked_key_grp == 5) {
							sort_grp_temp = sort_grp5;
						} else if(clicked_key_grp == 6) {
							sort_grp_temp = sort_grp6;
						} else if(clicked_key_grp == 7) {
							sort_grp_temp = sort_grp7;
						}
						for(var  i = 0; i < sort_grp_temp.length; i++){
						if(sort_grp_temp[i].id == clicked_key){
							finish_card_obj = sort_grp_temp[i];
							break;
							}
						}
						console.log("finish clicked grp 1 "+JSON.stringify(finish_card_obj)+"----"+clicked_key);
						finish(finish_card_obj,clicked_key,clicked_key_grp);
					});	

				   if(grp1_cards.length != 0)
				   {
				    sort_grp1.push.apply(sort_grp1,grp1_cards);
					console.log("--Group1 -"+JSON.stringify(sort_grp1));
					$.each(sort_grp1, function(key, obj)
					{
					  if(key==0)
						{
							$("#card_group1").append("<div><img id='"+obj.id+"' src="+obj.card_path+"></div>");
							//if(obj.name==sidejokername)
							//$("#card_group1").append("<img  width='8%' height='9%'  src='joker.png'>");
						}
					  else
						{
							$("#card_group1").append("<div><img id='"+obj.id+"' src="+obj.card_path+"></div>");
							//if(obj.name==sidejokername)
							//$("#card_group1").append("<img  width='8%' height='9%'  src='joker.png'>");
						} 
					$("#"+obj.id).click(function() 
						{
					      if(player_in_game != false)
						  {
							if(($.inArray(obj.id,card_click))>-1)
								{
									$("#"+obj.id).css('border', ""); 
									idx = $.inArray(obj.id,card_click);
									card_click.splice(idx, 1);
									card_click_grp.splice(idx, 1);
									/* card_click = jQuery.grep(card_click, function(value) {
									 return value != obj.id;
									});*/
									clicked_card_count--;
									hide_all_add_here_buttons();
									group_of_group(obj.id,obj,clicked_card_count,0,1); 
								}
								else 
								{
									clicked_key = obj.id;
									card_click.push(clicked_key);
									card_click_grp.push(1);
									$("#"+obj.id).css('border', "solid 1px blue"); 
									clicked_card_count++;
									group_of_group(obj.id,obj,clicked_card_count,1,1); 
								}

								if( clicked_card_count == 1 ) {
									clicked_key = card_click[0];
									clicked_key_grp = card_click_grp[0];
								}
								card_count= ($("#card_group1").children().length)+($("#card_group2").children().length)+($("#card_group3").children().length)+($("#card_group4").children().length)+($("#card_group5").children().length)+($("#card_group6").children().length)+($("#card_group7").children().length);
								console.log("clicked_card_count GRP1 "+clicked_card_count);
							////ADD HERE 1
							if(clicked_card_count==1)
							{
							    parent_group_id =1;
							    selected_card_id = clicked_key; 
								for(var  i = 0; i < sort_grp1.length; i++)
								{
									if(sort_grp1[i].id == selected_card_id)
									{
										open_obj = sort_grp1[i];
										break;
									}
								}
								add_card_obj=open_obj;	
								if(($("#card_group2").children().length) != 0)
								{ $("#add_group2").show(); }
								if(($("#card_group3").children().length) != 0)
								{ $("#add_group3").show(); }
								if(($("#card_group4").children().length) != 0)
								{ $("#add_group4").show(); }
								if(($("#card_group5").children().length) != 0)
								{ $("#add_group5").show(); }
								if(($("#card_group6").children().length) != 0)
								{ $("#add_group6").show(); }
								if(($("#card_group7").children().length) != 0)
								{ $("#add_group7").show(); }
							}
							
							if(card_count==14  && player_turn==true && clicked_card_count==1)
							{
								$("#discard_card").show();
								$("#finish_game").show();
								$("#group_cards").hide();
							}
							else 
							{
								$("#discard_card").hide();
								$("#finish_game").hide();
								$('#discard_card').attr("disabled", 'disabled');
								$('#finish_game').attr("disabled", 'disabled');
							}
							if(clicked_card_count>1)
							{
								console.log("can do group");
								$("#group_cards").show();
								hide_all_add_here_buttons();
							}
							else
							{
								console.log("can NOT do group");
								$("#group_cards").hide();
							}
						  }
						});
					});///1st grp
				}//1st grp not empty 
				if(grp2_cards.length != 0)
				{
				 console.log("-GROUP 2-"+JSON.stringify(grp2_cards));
				 sort_grp2.push.apply(sort_grp2,grp2_cards);
				 $.each(sort_grp2, function(key, obj)
				 {
					if(key==0)
					{
						$("#card_group2").append("<div><img id='"+obj.id+"' src="+obj.card_path+"></div>");
						//if(obj.name==sidejokername)
						//$("#card_group2").append("<img  width='8%' height='9%' src='joker.png'>");
					}else
					{
						$("#card_group2").append("<div><img id='"+obj.id+"' src="+obj.card_path+"></div>");
						//if(obj.name==sidejokername)
						//$("#card_group2").append("<img  width='8%' height='9%' src='joker.png'>");
					}
					//$("#card_group2").css('margin-left', "7%"); 
					
					$("#"+obj.id).click(function() 
						{
						  if(player_in_game != false)
						  {
							if(($.inArray(obj.id,card_click))>-1)
								{
									$("#"+obj.id).css('border', ""); 
									idx = $.inArray(obj.id,card_click);
									card_click.splice(idx, 1);
									card_click_grp.splice(idx, 1);				
									/* card_click = jQuery.grep(card_click, function(value) {
									 return value != obj.id;
									});*/
									clicked_card_count--;
									hide_all_add_here_buttons();
									group_of_group(obj.id,obj,clicked_card_count,0,2);  
								}
								else 
								{
									clicked_key = obj.id;
									card_click.push(clicked_key);
									card_click_grp.push(2);
									$("#"+obj.id).css('border', "solid 1px blue"); 
									clicked_card_count++;
									group_of_group(obj.id,obj,clicked_card_count,1,2); 
								}
							card_count= ($("#card_group1").children().length)+($("#card_group2").children().length)+($("#card_group3").children().length)+($("#card_group4").children().length)+($("#card_group5").children().length)+($("#card_group6").children().length)+($("#card_group7").children().length);
							////ADD HERE 2
							if(clicked_card_count==1)
							{
								clicked_key = card_click[0];
								clicked_key_grp = card_click_grp[0];
								parent_group_id =2;
								selected_card_id = clicked_key;
								for(var  i = 0; i < sort_grp2.length; i++)
								{
									if(sort_grp2[i].id == selected_card_id)
									{
										open_obj = sort_grp2[i];
										break;
									}
								}
								add_card_obj=open_obj;
								if(($("#card_group1").children().length) != 0)
								{ $("#add_group1").show(); }
								if(($("#card_group3").children().length) != 0)
								{ $("#add_group3").show(); }
								if(($("#card_group4").children().length) != 0)
								{ $("#add_group4").show(); }
								if(($("#card_group5").children().length) != 0)
								{ $("#add_group5").show(); }
								if(($("#card_group6").children().length) != 0)
								{ $("#add_group6").show(); }
								if(($("#card_group7").children().length) != 0)
								{ $("#add_group7").show(); }
							}
							
							if(card_count==14  && player_turn==true && clicked_card_count==1)
							{
								$("#discard_card").show();
								$("#finish_game").show();
								$("#group_cards").hide();
							}
							else 
							{
								$("#discard_card").hide();
								$("#finish_game").hide();
								$('#discard_card').attr("disabled", 'disabled');
								$('#finish_game').attr("disabled", 'disabled');
							}
								console.log("clicked_card_count GRP2 "+clicked_card_count);
							if(clicked_card_count>1)
							{
							console.log("can do group");
								$("#group_cards").show();
								hide_all_add_here_buttons();
							}
							else
							{
								console.log("can NOT do group");
							$("#group_cards").hide();
							}
						  }//if-player-in-game
						});
				});//2nd grp
				}//2nd group
				if(grp3_cards.length != 0)
				{
				 console.log("-GROUP 3-"+JSON.stringify(grp3_cards));
				 sort_grp3.push.apply(sort_grp3,grp3_cards);
				 $.each(sort_grp3, function(key, obj)
				 {
					if(key==0)
					{
						$("#card_group3").append("<div><img id='"+obj.id+"' src="+obj.card_path+"></div>");
						//if(obj.name==sidejokername)
						//$("#card_group3").append("<img  width='8%' height='9%' src='joker.png'>");
					}else
					{
						$("#card_group3").append("<div><img id='"+obj.id+"' src="+obj.card_path+"></div>");
						//if(obj.name==sidejokername)
						//$("#card_group3").append("<img  width='8%' height='9%' src='joker.png'>");
					}
					//$("#card_group3").css('margin-left', "7%"); 
					$("#"+obj.id).click(function() 
						{
						  if(player_in_game != false)
						  {
							card_count= ($("#card_group1").children().length)+($("#card_group2").children().length)+($("#card_group3").children().length)+($("#card_group4").children().length)+($("#card_group5").children().length)+($("#card_group6").children().length)+($("#card_group7").children().length);
							if(($.inArray(obj.id,card_click))>-1)
								{
									$("#"+obj.id).css('border', ""); 
									idx = $.inArray(obj.id,card_click);
									card_click.splice(idx, 1);
									card_click_grp.splice(idx, 1);				
									/* card_click = jQuery.grep(card_click, function(value) {
									 return value != obj.id;
									});*/
									clicked_card_count--;
									hide_all_add_here_buttons();
									group_of_group(obj.id,obj,clicked_card_count,0,3); 
								}
								else 
								{
									clicked_key = obj.id;
									card_click.push(clicked_key);
									card_click_grp.push(3);
									$("#"+obj.id).css('border', "solid 1px blue"); 
									clicked_card_count++;
									group_of_group(obj.id,obj,clicked_card_count,1,3); 
								}
								////ADD HERE 3
							if(clicked_card_count==1)
							{
								clicked_key = card_click[0];
								clicked_key_grp = card_click_grp[0];
								parent_group_id =3;
								selected_card_id = clicked_key;
								for(var  i = 0; i < sort_grp3.length; i++)
								{
									if(sort_grp3[i].id == selected_card_id)
									{
										open_obj = sort_grp3[i];
										break;
									}
								}
								add_card_obj=open_obj;
								if(($("#card_group1").children().length) != 0)
								{ $("#add_group1").show(); }
								if(($("#card_group2").children().length) != 0)
								{ $("#add_group2").show(); }
								if(($("#card_group4").children().length) != 0)
								{ $("#add_group4").show(); }
								if(($("#card_group5").children().length) != 0)
								{ $("#add_group5").show(); }
								if(($("#card_group6").children().length) != 0)
								{ $("#add_group6").show(); }
								if(($("#card_group7").children().length) != 0)
								{ $("#add_group7").show(); }
							}
							if(card_count==14  && player_turn==true && clicked_card_count==1)
							{
								$("#discard_card").show();
								$("#finish_game").show();
								$("#group_cards").hide();
							}
							else 
							{
								$("#discard_card").hide();
								$("#finish_game").hide();
								$('#discard_card').attr("disabled", 'disabled');
								$('#finish_game').attr("disabled", 'disabled');
							}
							console.log("clicked_card_count GRP3 "+clicked_card_count);
							if(clicked_card_count>1)
							{
							console.log("can do group");
								$("#group_cards").show();
								hide_all_add_here_buttons();
							}
							else
							{
							console.log("can NOT do group");
							$("#group_cards").hide();
							}
						  }
						});
				});//3rd group
				}//3rd
				if(grp4_cards.length != 0)
				{
				console.log("-GROUP 4-"+JSON.stringify(grp4_cards));
				sort_grp4.push.apply(sort_grp4,grp4_cards);
				$.each(sort_grp4, function(key, obj)
				{
				   if(key==0)
					{
						$("#card_group4").append("<div><img id='"+obj.id+"' src="+obj.card_path+"></div>");
					//	if(obj.name==sidejokername)
						//$("#card_group4").append("<img  width='8%' height='9%' src='joker.png'>");
					}else
					{
						$("#card_group4").append("<div><img id='"+obj.id+"'  src="+obj.card_path+"></div>");
						//if(obj.name==sidejokername)
						//$("#card_group4").append("<img  width='8%' height='9%' src='joker.png'>");
					}
					//$("#card_group4").css('margin-left', "7%");
					$("#"+obj.id).click(function() 
						{
						  if(player_in_game != false)
						  {
							card_count= ($("#card_group1").children().length)+($("#card_group2").children().length)+($("#card_group3").children().length)+($("#card_group4").children().length)+($("#card_group5").children().length)+($("#card_group6").children().length)+($("#card_group7").children().length);
							if(($.inArray(obj.id,card_click))>-1)
								{
									$("#"+obj.id).css('border', ""); 
									idx = $.inArray(obj.id,card_click);
									card_click.splice(idx, 1);
									card_click_grp.splice(idx, 1);				
									/* card_click = jQuery.grep(card_click, function(value) {
									 return value != obj.id;
									});*/
									clicked_card_count--;
									hide_all_add_here_buttons();
									group_of_group(obj.id,obj,clicked_card_count,0,4); 
								}
								else 
								{
									clicked_key = obj.id;
									card_click.push(clicked_key);
									$("#"+obj.id).css('border', "solid 1px blue"); 
									card_click_grp.push(4);
									clicked_card_count++;
									group_of_group(obj.id,obj,clicked_card_count,1,4);  
								}
								////ADD HERE 4
							if(clicked_card_count==1)
							{
								clicked_key = card_click[0];
								clicked_key_grp = card_click_grp[0];
								//parent_group_id =("card_group4");
								parent_group_id =4;
								selected_card_id = clicked_key;
								for(var  i = 0; i < sort_grp4.length; i++)
								{
									if(sort_grp4[i].id == selected_card_id)
									{
										open_obj = sort_grp4[i];
										break;
									}
								}
								add_card_obj=open_obj;
								if(($("#card_group1").children().length) != 0)
								{ $("#add_group1").show(); }
								if(($("#card_group2").children().length) != 0)
								{ $("#add_group2").show(); }
								if(($("#card_group3").children().length) != 0)
								{ $("#add_group3").show(); }
								if(($("#card_group5").children().length) != 0)
								{ $("#add_group5").show(); }
								if(($("#card_group6").children().length) != 0)
								{ $("#add_group6").show(); }
								if(($("#card_group7").children().length) != 0)
								{ $("#add_group7").show(); }
							}
							if(card_count==14  && player_turn==true && clicked_card_count==1)
							{
								$("#discard_card").show();
								$("#finish_game").show();
								$("#group_cards").hide();
							}
							else 
							{
								$("#discard_card").hide();
								$("#finish_game").hide();
								$('#discard_card').attr("disabled", 'disabled');
								$('#finish_game').attr("disabled", 'disabled');
							}
							console.log("clicked_card_count GRP4 "+clicked_card_count);
							if(clicked_card_count>1)
							{
							console.log("can do group");
								$("#group_cards").show();
								hide_all_add_here_buttons();
							}
							else
							{
							console.log("can NOT do group");
							$("#group_cards").hide();
							}
						  }
						});
				});///4th group
				}//4th
				if(grp5_cards.length != 0)
				{
				console.log("-GROUP 5-"+JSON.stringify(grp5_cards));
				sort_grp5.push.apply(sort_grp5,grp5_cards);
				$.each(sort_grp5, function(key, obj)
				{
				    if(key==0)
					{
						$("#card_group5").append("<div><img id='"+obj.id+"' src="+obj.card_path+"></div>");
						//if(obj.name==sidejokername)
						//$("#card_group5").append("<img  width='8%' height='9%' src='joker.png'>");
					}else
					{
						$("#card_group5").append("<div><img id='"+obj.id+"' src="+obj.card_path+"></div>");
						//if(obj.name==sidejokername)
						//$("#card_group5").append("<img  width='8%' height='9%' src='joker.png'>");
					}
					//$("#card_group5").css('margin-left', "7%");
					$("#"+obj.id).click(function() 
						{
						 if(player_in_game != false)
						 {
							card_count= ($("#card_group1").children().length)+($("#card_group2").children().length)+($("#card_group3").children().length)+($("#card_group4").children().length)+($("#card_group5").children().length)+($("#card_group6").children().length)+($("#card_group7").children().length);
							if(($.inArray(obj.id,card_click))>-1)
								{
									$("#"+obj.id).css('border', ""); 
									idx = $.inArray(obj.id,card_click);
									card_click.splice(idx, 1);
									card_click_grp.splice(idx, 1);				
									/* card_click = jQuery.grep(card_click, function(value) {
									 return value != obj.id;
									});*/
									clicked_card_count--;
									hide_all_add_here_buttons();
									group_of_group(obj.id,obj,clicked_card_count,0,5); 
								}
								else 
								{
									clicked_key = obj.id;
									card_click.push(clicked_key);
									$("#"+obj.id).css('border', "solid 1px blue"); 
									card_click_grp.push(5);
									clicked_card_count++;
									group_of_group(obj.id,obj,clicked_card_count,1,5);  
								}
								////ADD HERE 4
							if(clicked_card_count==1)
							{
								clicked_key = card_click[0];
								clicked_key_grp = card_click_grp[0];
								parent_group_id =5;
								selected_card_id = clicked_key;
								for(var  i = 0; i < sort_grp5.length; i++)
								{
									if(sort_grp5[i].id == selected_card_id)
									{
										open_obj = sort_grp5[i];
										break;
									}
								}
								add_card_obj=open_obj;
								if(($("#card_group1").children().length) != 0)
								{ $("#add_group1").show(); }
								if(($("#card_group2").children().length) != 0)
								{ $("#add_group2").show(); }
								if(($("#card_group3").children().length) != 0)
								{ $("#add_group3").show(); }
								if(($("#card_group4").children().length) != 0)
								{ $("#add_group4").show(); }
								if(($("#card_group6").children().length) != 0)
								{ $("#add_group6").show(); }
								if(($("#card_group7").children().length) != 0)
								{ $("#add_group7").show(); }
							}
							if(card_count==14  && player_turn==true && clicked_card_count==1)
							{
								$("#discard_card").show();
								$("#finish_game").show();
								$("#group_cards").hide();
							}
							else 
							{
								$("#discard_card").hide();
								$("#finish_game").hide();
								$('#discard_card').attr("disabled", 'disabled');
								$('#finish_game').attr("disabled", 'disabled');
							}
							console.log("clicked_card_count GRP5 "+clicked_card_count);
							if(clicked_card_count>1)
							{
							console.log("can do group");
								$("#group_cards").show();
								hide_all_add_here_buttons();
							}
							else
							{
							console.log("can NOT do group");
							$("#group_cards").hide();
							}
						 }
						});
				});///5th group
				}//5th
				if(grp6_cards.length != 0)
				{
				console.log("-GROUP 6-"+JSON.stringify(grp6_cards));
				sort_grp6.push.apply(sort_grp6,grp6_cards);
				
				$.each(sort_grp6, function(key, obj)
				{
				   if(key==0)
					{
						$("#card_group6").append("<div><img id='"+obj.id+"' src="+obj.card_path+"></div>");
						//if(obj.name==sidejokername)
						//$("#card_group6").append("<img  width='8%' height='9%' src='joker.png'>");
					}else
					{
						$("#card_group6").append("<div><img id='"+obj.id+"' src="+obj.card_path+"></div>");
						//if(obj.name==sidejokername)
						//$("#card_group6").append("<img  width='8%' height='9%' src='joker.png'>");
					}
					//$("#card_group6").css('margin-left', "7%");
					$("#"+obj.id).click(function() 
						{
						if(player_in_game != false)
						 {
						card_count= ($("#card_group1").children().length)+($("#card_group2").children().length)+($("#card_group3").children().length)+($("#card_group4").children().length)+($("#card_group5").children().length)+($("#card_group6").children().length)+($("#card_group7").children().length);
							if(($.inArray(obj.id,card_click))>-1)
								{
									$("#"+obj.id).css('border', ""); 
									idx = $.inArray(obj.id,card_click);
									card_click.splice(idx, 1);
									card_click_grp.splice(idx, 1);				
									/* card_click = jQuery.grep(card_click, function(value) {
									 return value != obj.id;
									});*/
									clicked_card_count--;
									hide_all_add_here_buttons();
									group_of_group(obj.id,obj,clicked_card_count,0,6); 
								}
								else 
								{
									clicked_key = obj.id;
									card_click.push(clicked_key);
									card_click_grp.push(6);
									$("#"+obj.id).css('border', "solid 1px blue"); 
									clicked_card_count++;
									group_of_group(obj.id,obj,clicked_card_count,1,6);  
								}
								////ADD HERE 6
							if(clicked_card_count==1)
							{
								clicked_key = card_click[0];
								clicked_key_grp = card_click_grp[0];
								parent_group_id =6;
								selected_card_id = clicked_key;
								for(var  i = 0; i < sort_grp6.length; i++)
								{
									if(sort_grp6[i].id == selected_card_id)
									{
										open_obj = sort_grp6[i];
										break;
									}
								}
								add_card_obj=open_obj;
								if(($("#card_group1").children().length) != 0)
								{ $("#add_group1").show(); }
								if(($("#card_group2").children().length) != 0)
								{ $("#add_group2").show(); }
								if(($("#card_group3").children().length) != 0)
								{ $("#add_group3").show(); }
								if(($("#card_group4").children().length) != 0)
								{ $("#add_group4").show(); }
								if(($("#card_group5").children().length) != 0)
								{ $("#add_group5").show(); }
								if(($("#card_group7").children().length) != 0)
								{ $("#add_group7").show(); }
							}
							if(card_count==14  && player_turn==true && clicked_card_count==1)
							{
								$("#discard_card").show();
								$("#finish_game").show();
								$("#group_cards").hide();								
							}
							else 
							{
								$("#discard_card").hide();
								$("#finish_game").hide();
								$('#discard_card').attr("disabled", 'disabled');
								$('#finish_game').attr("disabled", 'disabled');
							}
							console.log("clicked_card_count GRP6 "+clicked_card_count);
							if(clicked_card_count>1)
							{
							console.log("can do group");
								$("#group_cards").show();
								hide_all_add_here_buttons();
							}
							else
							{
							console.log("can NOT do group");
							$("#group_cards").hide();
							}
						}
						});
				});///4th group
				}//4th
				if(grp7_cards.length != 0)
				{
				console.log("-GROUP 7-"+JSON.stringify(grp7_cards));
				sort_grp7.push.apply(sort_grp7,grp7_cards);
				$.each(sort_grp7, function(key, obj)
				{
				   if(key==0)
					{
						$("#card_group7").append("<div><img id='"+obj.id+"' width='8%' height='9%'  src="+obj.card_path+"></div>");
						//if(obj.name==sidejokername)
						//$("#card_group7").append("<img  width='8%' height='9%' src='joker.png'>");
					}else
					{
						$("#card_group7").append("<div><img id='"+obj.id+"' width='8%' height='9%'  src="+obj.card_path+"></div>");
						//if(obj.name==sidejokername)
						//$("#card_group7").append("<img  width='8%' height='9%' src='joker.png'>");
					}
					//$("#card_group7").css('margin-left', "7%");
					$("#"+obj.id).click(function() 
						{
						if(player_in_game != false)
						 {
						card_count= ($("#card_group1").children().length)+($("#card_group2").children().length)+($("#card_group3").children().length)+($("#card_group4").children().length)+($("#card_group5").children().length)+($("#card_group6").children().length)+($("#card_group7").children().length);
							if(($.inArray(obj.id,card_click))>-1)
								{
									$("#"+obj.id).css('border', ""); 
									idx = $.inArray(obj.id,card_click);
									card_click.splice(idx, 1);
									card_click_grp.splice(idx, 1);				
									/* card_click = jQuery.grep(card_click, function(value) {
									 return value != obj.id;
									});*/
									clicked_card_count--;
									hide_all_add_here_buttons();
									group_of_group(obj.id,obj,clicked_card_count,0,7); 
								}
								else 
								{
									clicked_key = obj.id;
									card_click.push(clicked_key);
									card_click_grp.push(7);
									$("#"+obj.id).css('border', "solid 1px blue"); 
									clicked_card_count++;
									group_of_group(obj.id,obj,clicked_card_count,1,7); 
								}
								////ADD HERE 7
							if(clicked_card_count==1)
							{
								clicked_key = card_click[0];
								clicked_key_grp = card_click_grp[0];
								parent_group_id =7;
								selected_card_id = clicked_key;
								for(var  i = 0; i < sort_grp7.length; i++)
								{
									if(sort_grp7[i].id == selected_card_id)
									{
										open_obj = sort_grp7[i];
										break;
									}
								}
								add_card_obj=open_obj;
								if(($("#card_group1").children().length) != 0)
								{ $("#add_group1").show(); }
								if(($("#card_group2").children().length) != 0)
								{ $("#add_group2").show(); }
								if(($("#card_group3").children().length) != 0)
								{ $("#add_group3").show(); }
								if(($("#card_group4").children().length) != 0)
								{ $("#add_group4").show(); }
								if(($("#card_group5").children().length) != 0)
								{ $("#add_group5").show(); }
								if(($("#card_group6").children().length) != 0)
								{ $("#add_group6").show(); }
								
							}
							if(card_count==14  && player_turn==true && clicked_card_count==1)
							{
								$("#discard_card").show();
								$("#finish_game").show();
								$("#group_cards").hide();
							}
							else 
							{
								$("#discard_card").hide();
								$("#finish_game").hide();
								$('#discard_card').attr("disabled", 'disabled');
								$('#finish_game').attr("disabled", 'disabled');
							}
							console.log("clicked_card_count GRP4 "+clicked_card_count);
							if(clicked_card_count>1)
							{
							console.log("can do group");
								$("#group_cards").show();
								hide_all_add_here_buttons();
							}
							else
							{
							console.log("can NOT do group");
							$("#group_cards").hide();
							}
						}
						});
				});///7th group
				}//7th
					  }
					}
				  }
			}///show_cards_after_sort ends

		/* ------------   ADD HERE  start -----------*/
		$("#add_group1").click(function()
			{ add_here(1); });
		$("#add_group2").click(function()
			{ add_here(2); });
		$("#add_group3").click(function()
			{ add_here(3); });
		$("#add_group4").click(function()
			{ add_here(4); });
		$("#add_group5").click(function()
			{ add_here(5); });
		$("#add_group6").click(function()
			{ add_here(6); });
		$("#add_group7").click(function()
			{ add_here(7); });
			
		function add_here(btn_id)
		{
            var chkcard=0;
			if(selected_card_id == 0){chkcard=1;}
			if(selected_card_id == ""){chkcard=1;}
			if(selected_card_id == null){chkcard=1;}
			if(selected_card_id == undefined){chkcard=1;}
			if(add_card_obj == ""){chkcard=1;}
			if(add_card_obj == null){chkcard=1;}
			if(add_card_obj == undefined){chkcard=1;}
			if (add_card_obj.length > 1){chkcard=1;}
			if (add_card_obj.length === 0){chkcard=1;}
			if (!add_card_obj){chkcard=1;}
			console.log("===========chkcard1================="+chkcard);
			if(chkcard == 0){
				socket.emit("add_here_six",{player:loggeduser,group:tableid,round_id:table_round_id,selected_card:selected_card_id,selected_card_src:add_card_obj,add_to_group:btn_id,remove_from_group:parent_group_id});
					add_card_obj = "";
					selected_card_id="";
				$("#discard_card").hide();
				$("#finish_game").hide();
				$('#discard_card').attr("disabled", 'disabled');
				$('#finish_game').attr("disabled", 'disabled');

				setTimeout(()=>{
					selected_card_arr = [];
					selected_group_card_arr = [];
					$("#group_cards").hide();
					hide_all_add_here_buttons();			
				}, 20);
			}else{
					add_card_obj = "";
					
				$("#discard_card").hide();
				$("#finish_game").hide();
				$('#discard_card').attr("disabled", 'disabled');
				$('#finish_game').attr("disabled", 'disabled');

				setTimeout(()=>{
					selected_card_arr = [];
					selected_group_card_arr = [];
					$("#group_cards").hide();
					hide_all_add_here_buttons();			
				}, 20);
			}
		}//add_here ends
		
		function add_here_drop(btn_id,pos)
		{
			 var chkcard=0;
			if(selected_card_id == 0){chkcard=1;}
			if(selected_card_id == ""){chkcard=1;}
			if(selected_card_id == null){chkcard=1;}
			if(selected_card_id == undefined){chkcard=1;}
			if(add_card_obj == ""){chkcard=1;}
			if(add_card_obj == null){chkcard=1;}
			if(add_card_obj == undefined){chkcard=1;}
			if (add_card_obj.length === 0){chkcard=1;}
			if (add_card_obj.length > 1){chkcard=1;}
			if (!add_card_obj){chkcard=1;}
			console.log("===========chkcard================="+chkcard);
			if(chkcard == 0){
				if(pos >= 0){
					if(dragcards == true){
						dragcards=false;
						socket.emit("add_here_six_drop",{player:loggeduser,group:tableid,round_id:table_round_id,selected_card:selected_card_id,selected_card_src:add_card_obj,add_to_group:btn_id,remove_from_group:parent_group_id,position:pos});
							add_card_obj = "";
							selected_card_id="";
							
						$("#discard_card").hide();
						$("#finish_game").hide();
						$('#discard_card').attr("disabled", 'disabled');
						$('#finish_game').attr("disabled", 'disabled');

						setTimeout(()=>{
							selected_card_arr = [];
							selected_group_card_arr = [];
							$("#group_cards").hide();
							hide_all_add_here_buttons();			
						}, 20);
					}else{
						dragcards=false;
							add_card_obj = "";
							selected_card_id="";
						$("#discard_card").hide();
						$("#finish_game").hide();
						$('#discard_card').attr("disabled", 'disabled');
						$('#finish_game').attr("disabled", 'disabled');

						setTimeout(()=>{
							selected_card_arr = [];
							selected_group_card_arr = [];
							$("#group_cards").hide();
							hide_all_add_here_buttons();			
						}, 20);
					}
				}
			}else{
					add_card_obj = "";
					
				$("#discard_card").hide();
				$("#finish_game").hide();
				$('#discard_card').attr("disabled", 'disabled');
				$('#finish_game').attr("disabled", 'disabled');

				setTimeout(()=>{
					selected_card_arr = [];
					selected_group_card_arr = [];
					$("#group_cards").hide();
					hide_all_add_here_buttons();			
				}, 20);
			}
		}//add_here ends

		function hide_all_add_here_buttons()
		{
				$("#add_group1").hide();
				$("#add_group2").hide();
				$("#add_group3").hide();
				$("#add_group4").hide();
				$("#add_group5").hide();
				$("#add_group6").hide();
				$("#add_group7").hide();
		}//hide_all_add_here_buttons ends

	/* ------------   ADD HERE  end -----------*/

	/* ------------   GROUP OF CARDS  Start -----------*/
	function groupCards(key, value,selected_card_count,clicked) 
	{
		//alert(" in groupCards");
		index = key;
		selectedCard = value;
		if (selected_card_count <1 && discard_click == false) 
			{ initial_group = false;}
		if (selected_card_count>1) 
			{ 
				//initial_group = true;
				is_sorted = false;
			}
				 				  
		console.log("\n making groups before"+JSON.stringify(selected_card_arr));
		if(clicked==1)
			{
			   selected_card_arr.push(selectedCard);
			}
			if(clicked==0)
			{
				selected_card_arr = jQuery.grep(selected_card_arr, function(value) {
				return value != selectedCard;});
			}
		console.log("\n after making groups "+JSON.stringify(selected_card_arr));
	}
			
	function group_of_group(key,value,selected_card_count,clicked,card_parent) 
	{
		console.log("\n key "+key+" value"+JSON.stringify(value)+" count "+selected_card_count+" select/unselect "+clicked+" parent no"+card_parent);
		index = key;
		selectedCard = value;
			   
		if (selected_card_count <1 && discard_click == false && is_grouped != true) 
			{ is_grouped = false;}
		if (selected_card_count>1) 
			{ 
				is_grouped = true;
				is_sorted = false;
				initial_group = false;
			} 
		if(clicked==1)
			{
				selected_card_arr.push(selectedCard);
				selected_group_card_arr.push(card_parent);
			}
		console.log("\n ***** selected_group_card_arr after group of group "+JSON.stringify(selected_group_card_arr));
		if(clicked==0)
			{
				selected_card_arr = jQuery.grep(selected_card_arr, function(value) {
				return value != selectedCard;});
					
				selected_group_card_arr = jQuery.grep(selected_group_card_arr, function(value) {
				return value != card_parent;});
			}
	}///group_of_group ends 

	$("#group_cards").click(function()
	{
		if(player_in_game != false)
		{
			$("#group_cards").hide();
			$("#sort_cards").hide();
			is_sorted = false;
			
			if( is_grouped == true)
				initial_group = false;
			else
				initial_group = true;

			grp1 = [];
			$.each(selected_card_arr, function(n, m) 
			{grp1.push(m);});
			console.log("GRP after intial group "+JSON.stringify(grp1));
				
			//if( is_grouped == true)
			//{
				//alert('hi');
				grp2 = [];
				$.each(selected_group_card_arr, function(n, m) 
				{grp2.push(m);});
				console.log("GRP after group of group "+JSON.stringify(grp2));
			//}
				
			/// emit player groups after group to server///
			socket.emit("update_player_groups_six",{player:loggeduser,group:tableid,round_id:table_round_id,card_group:grp1,is_sort:is_sorted,is_group:is_grouped,is_initial_group:initial_group,parent_group:grp2});
				
			selected_card_arr = [];
			selected_group_card_arr = [];
		}
	});//group_card click ends 
			
			
	socket.on("group_limit_six", function(data) 
	{
		if(data.user==loggeduser)
		{
			if(tableid==data.group)
			{
				if(table_round_id == data.round_id)
				{
					alert("You can make only 7 groups");
				}
			}
		}	
	});
/* ------------   GROUP OF CARDS  End -----------*/

/**************** Open / Close card select start ********/
//// open card click
	$("#open_card").unbind().on('click',function()
	{
		console.log("OPEN CARD CLICKED ");
		if(player_turn==true )
		{			
			if( is_picked_card ) {
				alert("You can pick only 1 card at a time from open/close cards1!");
				return;
			}


			hide_all_add_here_buttons();

			audio_open.play();
			open_card_src =$("#open_card").attr("src");
			if(open_card_src=='closedimg.bmp')
			{//alert("No Open Card/(s) available..!");
			}
			else 
			{	
				is_picked_card = true;
				var data_of_open_card;
				console.log("start open_data"+open_data);
				if(open_data !='')
				{
					data_of_open_card=open_data;
					console.log("***** open_data IF NOT BLANK "+JSON.stringify(data_of_open_card));
				}
				else
				{
					data_of_open_card=initial_open_card;
					console.log("***** open_data IF BLANK "+JSON.stringify(data_of_open_card));
				} 

				/* ANDY */
				selected_card_arr = [];
				selected_card_count = 0;
				card_click = [];
				card_click_grp = [];
				//initial_group = false;
				$("#group_cards").hide();	
				socket.emit("check_open_closed_pick_count_six",{user:player_having_turn,group:tableid,card:'open',card_data:data_of_open_card,path:open_card_src,round_id:table_round_id,is_sort:is_sorted,is_group:is_grouped,is_initial_group:initial_group});
			}
		}
		else
		{
			//show this alert message as tooltip near open card
			//alert("You do not have turn to select open card!");
		}
	});
	
	//close click 

	//// closed card click
	$("#closed_cards").unbind().on('click',function()
	{ 
		console.log("CLOSE  CARD CLICKED ");
		
		console.log("================is_picked_card================="+is_picked_card);
		if(player_turn==true)
		{
			
			if( is_picked_card ) {
				alert("You can pick only 1 card at a time from open/close cards2!");
				return;
			}

			is_picked_card = true;
			audio_close.play();

			hide_all_add_here_buttons();
				
			var data_of_closed_card;
			console.log("before card used by close array "+temp_closed_cards_arr1.length);
			data_of_closed_card = temp_closed_cards_arr1[0];
			closed_card_src = closed_card_src_temp;
			close_card_id = closed_card_id_temp;
					
			console.log("After USED CLOSED "+JSON.stringify(data_of_closed_card));
			console.log("After close card used path "+closed_card_src+" id "+close_card_id);

			/* ANDY */
			selected_card_arr = [];
			selected_card_count = 0;
			card_click = [];			
			card_click_grp = [];
			//initial_group = false;
			$("#group_cards").hide();																
			socket.emit("check_open_closed_pick_count_six",{user:player_having_turn,group:tableid,card:'close',card_data:data_of_closed_card,path:closed_card_src,round_id:table_round_id,is_sort:is_sorted,is_group:is_grouped,is_initial_group:initial_group});
		}
		else
		{
		//show this alert message as tool-tip near open card
		//alert("You do not have turn to select close cards!");
		}
	});
	///select open/close card to continue game 
	socket.on("open_close_click_count_six", function(data) 
	{
		//alert("in event ");
			  if(tableid==data.group)///check for same table
			  {
			   if(table_round_id == data.round_id)///check for same table-round id
			    {
			      if((data.pick_count)==0)
				   {
					
					var card_click = [] ; var clicked_key;
					var clicked_card_count = 0;
					var card_type = data.card;
					var appended_key = (($("#images").children().length));
					var  src , obj ; 
					var appended_group_div;
					var next_key;
					
					ttt = data.check ;
					if(card_type=='open')
					{
						src=$("#open_card").attr("src");
						open_card_src =$("#open_card").attr("src");
						picked_card_value = src;
						next_key = open_card_id;
						picked_card_id = open_card_id;
						is_open_close_picked = 1;
						
						obj = data.card_data.reduce(function(acc, cur, i) {
							acc[i] = cur;
						return acc;
						});
						remove_obj = obj;
						
						if(((data.open_arr).length)!=0)
						{
							discarded_open_arr = [];
							discarded_open_arr.push.apply(discarded_open_arr,data.open_arr);
						}
						console.log("Open Card Array "+discarded_open_arr.length+"--"+JSON.stringify(discarded_open_arr));
						
						if((discarded_open_arr.length)==0)
						{
							$("#open_card").attr('src', "closedimg.bmp");  
						}
						else
						{
							$("#open_card").attr('src', discarded_open_arr[(discarded_open_arr.length)-1].card_path);
						}
					}
					else if(card_type=='close')
					{
						src=data.path;
						open_card_src =$("#open_card").attr("src");
						picked_card_value = src;
						next_key = close_card_id;
						picked_card_id = data.card_data.id;
						is_open_close_picked = 1;
						remove_obj =data.card_data;
						if(((data.open_arr).length)!=0)
						{
							temp_closed_cards_arr1 = [];
							temp_closed_cards_arr1.push.apply(temp_closed_cards_arr1,data.open_arr);
							closed_card_src_temp = data.open_arr[0].card_path;
							closed_card_id_temp = data.open_arr[0].id;
							console.log("******************* open/close closed card array --"+JSON.stringify(temp_closed_cards_arr1));
						}else {closed_card_src_temp ="";closed_card_id_temp = 0;}
					}
					
						user_assigned_cards = [];
						if(data.hand_cards.length<=14)
						user_assigned_cards.push.apply(user_assigned_cards,data.hand_cards);
						if(appended_key!=0)
						{
						////showing updated hand cards(14) after open/close select-initial
						 if(data.hand_cards.length<=14)
						 show_player_hand_cards(data.hand_cards,data.sidejokername);
						}
						else
						{console.log("Update groups");}
					//}
				}
				else
				{
					alert("You have already picked card from either Close / Open Card ");
				}
			   }
			  }
	});///open/close card click 	

	/////after open selected - if it is joker card then message select close card
	socket.on("pick_close_card_six", function(data) 
	{
		if(data.user==loggeduser)
		{
			if(tableid==data.group)///check for same table
			{
				if(table_round_id == data.round_id)///check for same table-round id
				{
					////show this message by using tooltip ////					
					is_picked_card = false;
					alert("You are trying to select Joker Card, Select Card From Closed Cards.");
				}
			}
		}
	});
				
				
	/////after open selected - if it is joker card then message select close card
	socket.on("disallow_pick_card_six", function(data) 
	{
		if(data.user==loggeduser)
	  {
		if(tableid==data.group)///check for same table
		{
			if(table_round_id == data.round_id)///check for same table-round id
			{
				alert("You can pick only 1 card at a time from open/close cards3!");
			}
		}
	  }
	});
/**************** Open / Close card select ends  ********/

/* ------------------ discard / show open card start --------------*/

///if selected open/close card ,discard card 
	function discard(clicked_card_id,clicked_card_src,key,parent,cardvalue,card_id,open_obj)//,checkvalue
	{
	var c = [];
	c.push(open_obj);
	console.log("open card data @ discard ---------"+JSON.stringify(open_data)); 
				  
	selected_card_arr = jQuery.grep(selected_card_arr, function(value) {
		return value != cardvalue;});
	selected_card_arr1 = jQuery.grep(selected_card_arr1, function(value) {
		return value != key;});
	is_open_close_picked = 0;
					
	var selected_card_arr11 = []; 
	$("#discard_card").hide();
	$("#finish_game").hide();
	$('#discard_card').attr("disabled", 'disabled');
	$('#finish_game').attr("disabled", 'disabled');
	discard_click  = true ;
	next_turn = true;
	console.log("open card id and path before discard"+open_card_id+"---"+$("#open_card").attr("src"));
	$("#open_card").attr('src', clicked_card_src);  
	open_card_id = key;
	console.log("open card id and path AFTER discard"+open_card_id+"---"+$("#open_card").attr("src"));
	ttt = false;
	selected_card_arr = [];
	selected_group_card_arr = [];
					
		socket.emit("discard_fired_six",{discarded_user:loggeduser,group:tableid,round_id:table_round_id});
		console.log("discard clicked by "+loggeduser);
		socket.emit("show_open_card_six",
			{
				user: loggeduser,group:tableid,open_card_src:clicked_card_src,check:ttt,round_id:table_round_id,open_card_id:open_card_id,discard_card_data:card_id,discarded_open_data:open_data,is_sort:is_sorted,is_group:is_grouped,group_from_discarded:0,is_initial_group:initial_group
			});
	}//discard ends 

	/////after discard , show open card to other player
	socket.on("open_card_six", function(data) 
	{
		console.log("discard_open_cards "+JSON.stringify(data.discard_open_cards));
		if(tableid==data.group)///check for same table
		{
			if(table_round_id == data.round_id)///check for same table-round id
			{
				$("#open_card").attr('src', data.path); 
				open_card_src =$("#open_card").attr("src");
				open_card_id = data.id;
				is_open_close_picked = 0;
				ttt = data.check;
				var temp = [];
				var temp1 = [];
				temp.push(data.discareded_open_card);
						
				console.log("OPEN DATA recvd  "+JSON.stringify(temp));
				open_data = temp;
				discard_click  = false ;
				$("#discareded_open_cards").empty();		
				
				console.log("\n data.discard_open_cards.length "+data.discard_open_cards.length+"--data--"+JSON.stringify(data.discard_open_cards));

				if(data.discard_open_cards.length>0)
				{
					$.each(data.discard_open_cards, function(k, v) 
					{
						$("#discareded_open_cards").append("<img width='10%' height='10%' src="+v.card_path+">");
					});
				}		
			}
		}
	});
/* ------------------ discard / show open card start --------------*/

/* ------------ Finish Start   -----------------*/
	function finish(finish_card_obj,key,parent)
	{
		$("#confirm-msg").html("Are you sure to finish?");
		$("#popup-confirm").show();

		$("#confirm-yes").unbind().click(function() {
			$("#popup-confirm").hide();

			$("#finish_card").show(); 
			is_finished = true;
			$('#finish_game').attr("disabled", 'disabled');
			$('#discard_card').attr("disabled", 'disabled');
			$("#discard_card").hide();
			$("#finish_game").hide();
			hide_all_add_here_buttons();
						
			var parent_id = parent;
			console.log("\n &&&&&&& in finish"+JSON.stringify(finish_card_obj)+"-- parent --"+parent+" parent_id "+parent_id);
						
			socket.emit("show_finish_card_six",
				{
					player:loggeduser,group:tableid,round_id:table_round_id,finish_card_id:key,finish_card_obj:finish_card_obj,is_sort:is_sorted,is_group:is_grouped,is_initial_group:initial_group,group_from_finished:parent_id,is_finished:is_finished
				});
						
				// $("#player1turn").hide();
				// $("#player2turn").hide();
				hide_all_players_turn_details();
				$('#declare').attr("disabled", 'disabled');
				$("#declare").show();
				$("#msg").empty();
				$("#msg").css('display', "inline-block"); 
				$("#msg").html("Group your cards and Declare...!");

			is_picked_card = false;
		});
	}///finish ends 
				
	socket.on("finish_card_six", function(data) 
	{
	   if(data.user==loggeduser)
		{
			if(tableid==data.group)
			{
			    if(table_round_id == data.round_id)
				{
					if( !bLosted ) {
						$("#finish_card").show();
						$("#finish_card").attr('src', data.path); 
					// $("#player1turn").hide();
					// $("#player2turn").hide();
						hide_all_players_turn_details();
					}					
			    }
			}  
		}
	});
/* ------------ Finish Start   -----------------*/	
	$("#confirm-no").click(function() {
		$("#popup-confirm").hide();
	});
/*-------------- Drop Game start ---------------*/
	$("#drop_game").click(function()
	{		
		$("#confirm-msg").html("Are you sure to drop?");
		$("#popup-confirm").show();

		$("#confirm-yes").unbind().click(function() {
			$("#popup-confirm").hide();

			$('#drop_game').attr("disabled", 'disabled');
			//if(player_turn==true)
			//{
				$("#drop_game").hide();
				$("#drop_game").css('display','none');
				is_game_dropped = true;
				console.log(" Game Dropped by player "+loggeduser);
				if(game_type=='Pool Rummy')
					socket.emit("drop_game_six_pool",{user_who_dropped_game: loggeduser,group:tableid,round_id:table_round_id,/*amount:player_amount,poolamount:player_poolamount,*/is_sort:is_sorted,is_group:is_grouped,is_initial_group:initial_group,game_type:game_type});
				else
				{
					socket.emit("drop_game_six",
					{
						user_who_dropped_game: loggeduser,group:tableid,round_id:table_round_id,/*amount:player_amount,*/is_sort:is_sorted,is_group:is_grouped,is_initial_group:initial_group,game_type:game_type
					});
				}
			//}
		});		
	});	

	socket.on('player_dropped_game', function(playername,tableid_recvd)
	{
		if($('.declare-table').is(':visible'))
		{
			$(".declare-table").hide();
		}
		if(tableid==tableid_recvd)
		{
			for(var  i = 1; i < 7; i++)
			{
				if(($("#player_"+(i)+"_name").text()) == playername)
				{
					$("#player_"+(i)+"_disconnect").css('display','block'); 
					$("#player_"+(i)+"_status").text("Dropped");
				}
				if(playername == loggeduser)
				{
					player_in_game = false;
					$("#sort_cards").hide();
				}
			}
		}
	});

	
	socket.on('player_poollost_game', function(playername,tableid_recvd)
	{
		if($('.declare-table').is(':visible'))
		{
			$(".declare-table").hide();
		}
		if(tableid==tableid_recvd)
		{
			if(playername == loggeduser)
			{
				player_in_game = false;
				clear_player_data_after_declare();
				hide_all_players_turn_details();
				setMessage('<label style="color:white">Please wait until next game</label>');
				bLosted = true;
			}
			for(var  i = 1; i < 7; i++)
			{
				if(($("#player_"+(i)+"_name").text()) == playername)
				{
					$("#player_"+(i)+"_disconnect").css('display','block'); 
					$("#player_"+(i)+"_status").text("Lost");
				}

			}
		}
	});

	////after player dropped game 
	socket.on("dropped_game_six", function(data) 
	{
		hide_all_add_here_buttons();
		console.log("\n dropped data "+JSON.stringify(data));
		$(".declare-table").show();
		var card_arr1 = [],card_arr2 = [],card_arr3 = [],card_arr4 = [],card_arr5 = [],card_arr6 = [],card_arr7 = [];
		$('#game_summary').find('td').remove();
		$('#game_summary tr:gt(3)').remove();

		var restart_timer = 10;
		var name; 
		var game_score =0 , amount_won =0;
		var player_grouped = false;
		var index = -1;
		var players_name_arr = [];
		var players_card_arr = [];
		var players_group_status_arr = [];
		var players_score_arr = [];
		var players_amount_arr = [];

		var pl_name_arr_temp = [];
		var pl_card_arr_temp = [];
		var pl_grp_status_arr_temp = [];
		var pl_score_arr_temp = [];
		var pl_amount_arr_temp = [];
		var temp_grps = [];

		players_name_arr.push.apply(players_name_arr,data.players);
		players_card_arr.push.apply(players_card_arr,data.players_cards);
		players_group_status_arr.push.apply(players_group_status_arr,data.group_status);
		players_score_arr.push.apply(players_score_arr,data.players_score);
		players_amount_arr.push.apply(players_amount_arr,data.players_amount);

		for(var  i = 0; i < players_name_arr.length;)
		{
			if(players_name_arr[i] != loggeduser)
			{
				pl_name_arr_temp.push(players_name_arr[i]);
				pl_card_arr_temp.push(players_card_arr[i]);
				pl_grp_status_arr_temp.push(players_group_status_arr[i]);
				pl_score_arr_temp.push(players_score_arr[i]);
				pl_amount_arr_temp.push(players_amount_arr[i]);

				index = i;
				if(index != -1)
				{
					players_name_arr.splice(index, 1);
					players_card_arr.splice(index, 1);
					players_group_status_arr.splice(index, 1);
					players_score_arr.splice(index, 1);
					players_amount_arr.splice(index, 1);
				}
			}
			else
			{
				i++
				break;
			}
		}
		players_name_arr.push.apply(players_name_arr,pl_name_arr_temp);
		players_card_arr.push.apply(players_card_arr,pl_card_arr_temp);
		players_group_status_arr.push.apply(players_group_status_arr,pl_grp_status_arr_temp);
		players_score_arr.push.apply(players_score_arr,pl_score_arr_temp);
		players_amount_arr.push.apply(players_amount_arr,pl_amount_arr_temp);

		//show popup to no of connnected players (playing game)
		//for(var k=1; k<=data.players.length; k++)
		for(var k=1; k<=players_name_arr.length; k++)
		{
			// if(k==1)
			// {
			// 	name = loggeduser;
			// 	game_score = 0;
			// 	amount_won = 0;
			// }
			// else
			// { 
			// 	name = data.players[k-1]; 
			// 	game_score = 0;
			// 	amount_won = 0;
			// }

			name = players_name_arr[k-1]; 
			game_score = players_score_arr[k-1];
			amount_won = players_amount_arr[k-1];

			$('#game_summary').append('<tr id="tr_cards'+(k)+'"><td style="text-align:center">'+name+'</td><td style="text-align:center" id="win'+(k)+'"></td><td class="declare-cards"><div id="pl'+(k)+'cards1" class="decl-group1"></div><div id="pl'+(k)+'cards2" class="decl-group2"></div><div id="pl'+(k)+'cards3" class="decl-group3"></div><div id="pl'+(k)+'cards4" class="decl-group4"></div><div id="pl'+(k)+'cards5" class="decl-group5"></div><div id="pl'+(k)+'cards6" class="decl-group6"></div><div id="pl'+(k)+'cards7" class="decl-group7"></div></td><td style="text-align:center">'+game_score+'</td><td style="text-align:center">'+amount_won+'</td></tr>');

			if(k==players_name_arr.length)
			{
				$('#game_summary').append('<tr class="joker" style="text-align:center" id="tr_joker" style="display:none"><th>Joker</th><th><img id="side_joker" ></th><th></th><th></th><th></th></tr><tr style="text-align:center" id="tr_msg" style="display:none"><th colspan="5" style="text-align:center; padding:2% 0%"><span style="color:white" id="restart_game_timer"></span></th></tr>');
									
				var joker_card_src = $("#joker_card").attr("src");	
				$("#side_joker").attr('src', joker_card_src); 
			}

			if(name==data.winner)
			{
				$('#win'+(k)+'').append('<img style="width: 40%" src="winner-rummy.jpg"/>');
			}

			if(loggeduser==data.winner)
			{
				audio_player_winner.play();
				$("#seq").text(" Valid ");
			}
			else { $("#seq").text(" Wrong "); }

			if(players_group_status_arr[k-1] == false)
			{
				if(players_card_arr[k-1].length>0)
				{
					$.each(players_card_arr[k-1], function(n,m)
					{
						if(n=0)
							$('#pl'+(k)+'cards1').append('<img  src="' + m.card_path + '" />'); 
						else
							$('#pl'+(k)+'cards1').append('<img  src="' + m.card_path + '" />');  
					});
				}
			}
			else
			{
				temp_grps = [];
				temp_grps.push.apply(temp_grps,players_card_arr[k-1]);
				if(temp_grps.length>0)
				{
					for(var p=1; p<=temp_grps.length; p++)
					{
						if(temp_grps[p-1].length>0)
						{
							$.each(temp_grps[p-1], function(n,m)
							{
								if(n=0)
									$('#pl'+(k)+'cards'+p).append('<img  src="' + m.card_path + '" />'); 
								else
									$('#pl'+(k)+'cards'+p).append('<img  src="' + m.card_path + '" />'); 
							});
						}//if-pl-group-length not 0
					}
				}
			}	
		}//for ends 
					
		///clear data after game ends 
		clear_player_data_after_declare();
		hide_all_players_turn_details();
		$('#div_msg').show();
		declare = 2;
		console.log("***************declare"+declare);
	});///after player dropped game
	socket.on("dropped_game_six_pool", function(data) 
	{
		console.log("\n dropped data "+JSON.stringify(data));
		$(".declare-table").show();
		var card_arr1 = [],card_arr2 = [],card_arr3 = [],card_arr4 = [],card_arr5 = [],card_arr6 = [],card_arr7 = [];
		$('#game_summary').find('td').remove();
		$('#game_summary tr:gt(3)').remove();

		var restart_timer = 10;
		var name; 
		var game_score =0 , amount_won=0,poolamount_won=0;
		var player_grouped = false;
		var index = -1;
		var players_name_arr = [];
		var players_card_arr = [];
		var players_group_status_arr = [];
		var players_score_arr = [];
		var players_amount_arr = [];
		var players_poolamount_arr = [];
		var pl_name_arr_temp = [];
		var pl_card_arr_temp = [];
		var pl_grp_status_arr_temp = [];
		var pl_score_arr_temp = [];
		var pl_amount_arr_temp = [];
		var pl_poolamount_arr_temp = [];
		var temp_grps = [];

		players_name_arr.push.apply(players_name_arr,data.players);
		players_card_arr.push.apply(players_card_arr,data.players_cards);
		players_group_status_arr.push.apply(players_group_status_arr,data.group_status);
		players_score_arr.push.apply(players_score_arr,data.players_score);
		players_amount_arr.push.apply(players_amount_arr,data.players_amount);
		players_poolamount_arr.push.apply(players_poolamount_arr,data.players_poolamount);
		for(var  i = 0; i < players_name_arr.length;)
		{
			if(players_name_arr[i] != loggeduser)
			{
				pl_name_arr_temp.push(players_name_arr[i]);
				pl_card_arr_temp.push(players_card_arr[i]);
				pl_grp_status_arr_temp.push(players_group_status_arr[i]);
				pl_score_arr_temp.push(players_score_arr[i]);
				pl_amount_arr_temp.push(players_amount_arr[i]);
				pl_poolamount_arr_temp.push(players_poolamount_arr[i]);
				index = i;
				if(index != -1)
				{
					players_name_arr.splice(index, 1);
					players_card_arr.splice(index, 1);
					players_group_status_arr.splice(index, 1);
					players_score_arr.splice(index, 1);
					players_amount_arr.splice(index, 1);
					players_poolamount_arr.splice(index, 1);
				}
			}
			else
			{
				i++
				break;
			}
		}
		players_name_arr.push.apply(players_name_arr,pl_name_arr_temp);
		players_card_arr.push.apply(players_card_arr,pl_card_arr_temp);
		players_group_status_arr.push.apply(players_group_status_arr,pl_grp_status_arr_temp);
		players_score_arr.push.apply(players_score_arr,pl_score_arr_temp);
		players_amount_arr.push.apply(players_amount_arr,pl_amount_arr_temp);
		players_poolamount_arr.push.apply(players_poolamount_arr,pl_poolamount_arr_temp);
		//show popup to no of connnected players (playing game)
		//for(var k=1; k<=data.players.length; k++)
		for(var k=1; k<=players_name_arr.length; k++)
		{
			// if(k==1)
			// {
			// 	name = loggeduser;
			// 	game_score = 0;
			// 	amount_won = 0;
			// }
			// else
			// { 
			// 	name = data.players[k-1]; 
			// 	game_score = 0;
			// 	amount_won = 0;
			// }

			name = players_name_arr[k-1]; 
			game_score = players_score_arr[k-1];
			amount_won = players_amount_arr[k-1];
			poolamount_won = players_poolamount_arr[k-1];
			$('#game_summary').append('<tr id="tr_cards'+(k)+'"><td style="text-align:center">'+name+'</td><td style="text-align:center" id="win'+(k)+'"></td><td class="declare-cards"><div id="pl'+(k)+'cards1" class="decl-group1"></div><div id="pl'+(k)+'cards2" class="decl-group2"></div><div id="pl'+(k)+'cards3" class="decl-group3"></div><div id="pl'+(k)+'cards4" class="decl-group4"></div><div id="pl'+(k)+'cards5" class="decl-group5"></div><div id="pl'+(k)+'cards6" class="decl-group6"></div><div id="pl'+(k)+'cards7" class="decl-group7"></div></td><td style="text-align:center">'+game_score+'</td><td style="text-align:center">'+amount_won+'</td></tr>');

			if(k==players_name_arr.length)
			{
				$('#game_summary').append('<tr class="joker" style="text-align:center" id="tr_joker" style="display:none"><th>Joker</th><th><img id="side_joker" ></th><th></th><th></th><th></th></tr><tr style="text-align:center" id="tr_msg" style="display:none"><th colspan="5" style="text-align:center; padding:2% 0%"><span style="color:white" id="restart_game_timer"></span></th></tr>');
									
				var joker_card_src = $("#joker_card").attr("src");	
				$("#side_joker").attr('src', joker_card_src); 
			}

			if(name==data.winner)
			{
				$('#win'+(k)+'').append('<img style="width: 40%" src="winner-rummy.jpg"/>');
			}

			if(loggeduser==data.winner)
			{
				audio_player_winner.play();
				$("#seq").text(" Valid ");
			}
			else { $("#seq").text(" Wrong "); }

			if(players_group_status_arr[k-1] == false)
			{
				if(players_card_arr[k-1].length>0)
				{
					$.each(players_card_arr[k-1], function(n,m)
					{
						if(n=0)
							$('#pl'+(k)+'cards1').append('<img  src="' + m.card_path + '" />'); 
						else
							$('#pl'+(k)+'cards1').append('<img  src="' + m.card_path + '" />');  
					});
				}
			}
			else
			{
				temp_grps = [];
				temp_grps.push.apply(temp_grps,players_card_arr[k-1]);
				if(temp_grps.length>0)
				{
					for(var p=1; p<=temp_grps.length; p++)
					{
						if(temp_grps[p-1].length>0)
						{
							$.each(temp_grps[p-1], function(n,m)
							{
								if(n=0)
									$('#pl'+(k)+'cards'+p).append('<img  src="' + m.card_path + '" />'); 
								else
									$('#pl'+(k)+'cards'+p).append('<img  src="' + m.card_path + '" />'); 
							});
						}//if-pl-group-length not 0
					}
				}
			}	
		}//for ends 
					
		///clear data after game ends 
		clear_player_data_after_declare();
		hide_all_players_turn_details();
		$('#div_msg').show();
		declare = 2;
	});///after player dropped game
	/*-------------- Drop Game start ---------------*/

/*******************  Declare game start *************/
$("#declare").click(function()
{
	$("#confirm-msg").html("Are you sure to declare?");
	$("#popup-confirm").show();

	$("#confirm-yes").unbind().click(function() {
		$("#popup-confirm").hide();
		$(".declare-table").show();
		
		$('#declare').attr("disabled", 'disabled');
		$("#declare").hide();
		$("#msg").hide();
		is_declared = true;
		if(game_type=='Pool Rummy')
			socket.emit("declare_game_six_pool",{user: loggeduser,group:tableid,round_id:table_round_id,amount:player_amount,poolamount:player_poolamount,is_declared:is_declared,is_sort:is_sorted,is_group:is_grouped,is_initial_group:initial_group,auto_declare:false,game_type:game_type});
		else
			socket.emit("declare_game_six",{user: loggeduser,group:tableid,round_id:table_round_id,amount:player_amount,is_declared:is_declared,is_sort:is_sorted,is_group:is_grouped,is_initial_group:initial_group,auto_declare:false,game_type:game_type});
		if(declare == 1 )
		{
			declare = 2;
		}
	});	
});///declare_click ends

///event to show wrong-declared player status publically
socket.on('player_declared_game', function(playername,tableid_recvd)
{
	if($('.declare-table').is(':visible'))
	{
		$(".declare-table").hide();
	}
	if(tableid==tableid_recvd)
	{
		$("#finish_card").hide();
		$('#finish_card').attr("disabled", 'disabled');
		$("#finish_card").attr('src',"");
		
		if(playername == loggeduser)
		{
			player_in_game = false;
			$('#declare').attr("disabled", 'disabled');
			$("#declare").hide();

			$("#sort_cards").hide();
			$("#msg").hide();

			is_picked_card = false;
			if(declare == 1 )
			{
				declare = 2;
			}
		}
		for(var  i = 1; i < 7; i++)
		{
			if(($("#player_"+(i)+"_name").text()) == playername)
			{
				$("#player_"+(i)+"_disconnect").css('display','block'); 
				$("#player_"+(i)+"_status").text("Invalid Declared");
			}
		}
	}
});
	
///event to show group cards message publically if any player declared valid sequence
socket.on('declared_six', function(data)
{
	if(data.user==loggeduser)
	{
		if(tableid==data.group)
		{
		    if(table_round_id == data.round_id)
			{
				//if(data.game_status == "dropped"  || )
				if( player_in_game ) {
				    console.log("\n declared_user is  "+data.declared_user);
					$("#msg").empty();
					$("#msg").css('display', "inline-block"); 
					$("#msg").html("Player "+data.declared_user+" has declared game,group your cards and declare");
					$('#declare').attr("disabled", 'disabled');
					$("#declare").show();
					declare = data.declare;

					//Andy if(declare == 1 )
					{
						is_other_declared = true;//check and change here sbt 6-pl-condition
					}
				}
			}
		}  
	}
});//declared ends 

////after player declared valid game 
socket.on("declared_data_six", function(data) 
{
	console.log("\n declared  data "+JSON.stringify(data));
	$(".declare-table").show();
	is_declared = false;
	$('#declare').attr("disabled", 'disabled');
	$("#declare").hide();
	$("#msg").hide();
	$("#tr_joker").hide();
	$("#tr_msg").hide();
	
	$('#game_summary').find('td').remove();
	$('#game_summary tr:gt(3)').remove();
	is_picked_card = false;
	if(declare == 1 )
	{ declare = 2; }

	var name; 
	var game_score =0 , amount_won =0;
	var player_grouped = false;
	var index = -1;
	var players_name_arr = [];
	var players_card_arr = [];
	var players_group_status_arr = [];
	
	var pl_name_arr_temp = [];
	var pl_card_arr_temp = [];
	var pl_grp_status_arr_temp = [];
	var pl_score_arr_temp = [];
	var pl_amount_arr_temp = [];
	var temp_grps = [];

	players_name_arr.push.apply(players_name_arr,data.players);
	players_card_arr.push.apply(players_card_arr,data.players_cards);
	players_group_status_arr.push.apply(players_group_status_arr,data.group_status);
	
	for(var  i = 0; i < players_name_arr.length;)
	{
		if(players_name_arr[i] != loggeduser)
		{
			pl_name_arr_temp.push(players_name_arr[i]);
			pl_card_arr_temp.push(players_card_arr[i]);
			pl_grp_status_arr_temp.push(players_group_status_arr[i]);
			
			index = i;
			if(index != -1)
			{
				players_name_arr.splice(index, 1);
				players_card_arr.splice(index, 1);
				players_group_status_arr.splice(index, 1);
			}
		}
		else
		{
			i++
			break;
		}
	}
	players_name_arr.push.apply(players_name_arr,pl_name_arr_temp);
	players_card_arr.push.apply(players_card_arr,pl_card_arr_temp);
	players_group_status_arr.push.apply(players_group_status_arr,pl_grp_status_arr_temp);
	
	//show popup to no of connnected players (playing game)
	for(var k=1; k<=players_name_arr.length; k++)
	{
		name = players_name_arr[k-1]; 
		if(name == loggeduser)
		{
			game_score = 0;
			amount_won = '--';

			$('#game_summary').append('<tr id="tr_cards'+(k)+'"><td style="text-align:center">'+name+'</td><td style="text-align:center" id="win'+(k)+'"></td><td class="declare-cards" style="text-align: center;"><div id="pl'+(k)+'cards1" class="decl-group1"></div><div id="pl'+(k)+'cards2" class="decl-group2"></div><div id="pl'+(k)+'cards3" class="decl-group3"></div><div id="pl'+(k)+'cards4" class="decl-group4"></div><div id="pl'+(k)+'cards5" class="decl-group5"></div><div id="pl'+(k)+'cards6" class="decl-group6"></div><div id="pl'+(k)+'cards7" class="decl-group7"></div></td><td style="text-align:center">'+game_score+'</td><td style="text-align:center">'+amount_won+'</td></tr>');

			if(players_group_status_arr[k-1] == false)
			{
				if(players_card_arr[k-1].length>0)
				{
					$.each(players_card_arr[k-1], function(n,m)
					{
						if(n=0)
							$('#pl'+(k)+'cards1').append('<img  src="' + m.card_path + '" />'); 
						else
							$('#pl'+(k)+'cards1').append('<img  src="' + m.card_path + '" />');  
					});
				}
			}
			else
			{
				temp_grps = [];
				temp_grps.push.apply(temp_grps,players_card_arr[k-1]);
				if(temp_grps.length>0)
				{
					for(var p=1; p<=temp_grps.length; p++)
					{
						if(temp_grps[p-1].length>0)
						{
							$.each(temp_grps[p-1], function(n,m)
							{
								if(n=0)
									$('#pl'+(k)+'cards'+p).append('<img  src="' + m.card_path + '" />'); 
								else
									$('#pl'+(k)+'cards'+p).append('<img  src="' + m.card_path + '" />'); 
							});
						}//if-pl-group-length not 0
					}
				}
			}
		}
		else
		{
			$('#game_summary').append('<tr id="tr_cards'+(k)+'"><td style="text-align:center">'+name+'</td><td style="text-align:center" id="win'+(k)+'"></td><td class="declare-cards" style="text-align: center;"><div id="pl'+(k)+'cards1" class="decl-group1"></div><div id="pl'+(k)+'cards2" class="decl-group2"></div><div id="pl'+(k)+'cards3" class="decl-group3"></div><div id="pl'+(k)+'cards4" class="decl-group4"></div><div id="pl'+(k)+'cards5" class="decl-group5"></div><div id="pl'+(k)+'cards6" class="decl-group6"></div><div id="pl'+(k)+'cards7" class="decl-group7"></div></td><td style="text-align:center"><img style="width: 42%;" src="buyin.gif" /></td><td style="text-align:center"><img style="width: 30%;" src="buyin.gif" /></td></tr>');
			$("#seq").text(" Valid ");

			$('#pl'+(k)+'cards'+1).append('<img  src="buyin.gif" />'); 
		}	
	}//for ends 
					
	///clear data after game ends 
	clear_player_data_after_declare();
	setMessage('<label id="lbl_popup" style="color:white">To see Popup details </label><label id="click_here_popup" style="color:blue;text-decoration:underline">Click here</label><br>');
						
	$("#click_here_popup").click(function()
	{
		$(".declare-table").show();
	});

	console.log("declared_data_six end");
});///after player declared valid  game

socket.on("declared_data_six_pool", function(data) 
{
	console.log("\n declared  data "+JSON.stringify(data));
	$(".declare-table").show();
	is_declared = false;
	$('#declare').attr("disabled", 'disabled');
	$("#declare").hide();
	$("#msg").hide();
	$("#tr_joker").hide();
	$("#tr_msg").hide();
	
	$('#game_summary').find('td').remove();
	$('#game_summary tr:gt(3)').remove();
	if(declare == 1 )
	{ declare = 2; }

	var name; 
	var game_score =0 , amount_won =0,  poolamount_won =0;;
	var player_grouped = false;
	var index = -1;
	var players_name_arr = [];
	var players_card_arr = [];
	var players_group_status_arr = [];
	
	var pl_name_arr_temp = [];
	var pl_card_arr_temp = [];
	var pl_grp_status_arr_temp = [];
	var pl_score_arr_temp = [];
	var pl_amount_arr_temp = [];
	var pl_poolamount_arr_temp = [];
	var temp_grps = [];

	//console.log("\n player_name_array "+JSON.stringify(player_name_array));

	players_name_arr.push.apply(players_name_arr,data.players);
	players_card_arr.push.apply(players_card_arr,data.players_cards);
	players_group_status_arr.push.apply(players_group_status_arr,data.group_status);
	
	for(var  i = 0; i < players_name_arr.length;)
	{
		if(players_name_arr[i] != loggeduser)
		{
			pl_name_arr_temp.push(players_name_arr[i]);
			pl_card_arr_temp.push(players_card_arr[i]);
			pl_grp_status_arr_temp.push(players_group_status_arr[i]);
			
			index = i;
			if(index != -1)
			{
				players_name_arr.splice(index, 1);
				players_card_arr.splice(index, 1);
				players_group_status_arr.splice(index, 1);
			}
		}
		else
		{
			i++
			break;
		}
	}
	players_name_arr.push.apply(players_name_arr,pl_name_arr_temp);
	players_card_arr.push.apply(players_card_arr,pl_card_arr_temp);
	players_group_status_arr.push.apply(players_group_status_arr,pl_grp_status_arr_temp);
	
	//show popup to no of connnected players (playing game)
	for(var k=1; k<=players_name_arr.length; k++)
	{
		name = players_name_arr[k-1]; 
		if(name == loggeduser)
		{
			game_score = 0;
			amount_won = '--';

			$('#game_summary').append('<tr id="tr_cards'+(k)+'"><td style="text-align:center">'+name+'</td><td style="text-align:center" id="win'+(k)+'"></td><td class="declare-cards" style="text-align: center;"><div id="pl'+(k)+'cards1" class="decl-group1"></div><div id="pl'+(k)+'cards2" class="decl-group2"></div><div id="pl'+(k)+'cards3" class="decl-group3"></div><div id="pl'+(k)+'cards4" class="decl-group4"></div><div id="pl'+(k)+'cards5" class="decl-group5"></div><div id="pl'+(k)+'cards6" class="decl-group6"></div><div id="pl'+(k)+'cards7" class="decl-group7"></div></td><td style="text-align:center">'+game_score+'</td><td style="text-align:center">'+poolamount_won+'</td></tr>');

			if(players_group_status_arr[k-1] == false)
			{
				if(players_card_arr[k-1].length>0)
				{
					$.each(players_card_arr[k-1], function(n,m)
					{
						if(n=0)
							$('#pl'+(k)+'cards1').append('<img  src="' + m.card_path + '" />'); 
						else
							$('#pl'+(k)+'cards1').append('<img  src="' + m.card_path + '" />');  
					});
				}
			}
			else
			{
				temp_grps = [];
				temp_grps.push.apply(temp_grps,players_card_arr[k-1]);
				if(temp_grps.length>0)
				{
					for(var p=1; p<=temp_grps.length; p++)
					{
						if(temp_grps[p-1].length>0)
						{
							$.each(temp_grps[p-1], function(n,m)
							{
								if(n=0)
									$('#pl'+(k)+'cards'+p).append('<img  src="' + m.card_path + '" />'); 
								else
									$('#pl'+(k)+'cards'+p).append('<img  src="' + m.card_path + '" />'); 
							});
						}//if-pl-group-length not 0
					}
				}
			}
		}
		else
		{
			$('#game_summary').append('<tr id="tr_cards'+(k)+'"><td style="text-align:center">'+name+'</td><td style="text-align:center" id="win'+(k)+'"></td><td class="declare-cards" style="text-align: center;"><div id="pl'+(k)+'cards1" class="decl-group1"></div><div id="pl'+(k)+'cards2" class="decl-group2"></div><div id="pl'+(k)+'cards3" class="decl-group3"></div><div id="pl'+(k)+'cards4" class="decl-group4"></div><div id="pl'+(k)+'cards5" class="decl-group5"></div><div id="pl'+(k)+'cards6" class="decl-group6"></div><div id="pl'+(k)+'cards7" class="decl-group7"></div></td><td style="text-align:center"><img style="width: 42%;" src="buyin.gif" /></td><td style="text-align:center"><img style="width: 30%;" src="buyin.gif" /></td></tr>');
			$("#seq").text(" Valid ");

			$('#pl'+(k)+'cards'+1).append('<img  src="buyin.gif" />'); 
		}	
	}//for ends 
					
	///clear data after game ends 
	clear_player_data_after_declare();
	setMessage('<label id="lbl_popup" style="color:white">To see Popup details </label><label id="click_here_popup" style="color:blue;text-decoration:underline">Click here</label><br>');
						
	$("#click_here_popup").click(function()
	{
		$(".declare-table").show();
	});

	console.log("declared_data_six_pool end");
});///after player declared valid  game
////after  declared game -popup to all players
socket.on("declared_final_six", function(data) 
{

		console.log("\n declared  final data "+JSON.stringify(data));
		$(".declare-table").show();
		var card_arr1 = [],card_arr2 = [],card_arr3 = [],card_arr4 = [],card_arr5 = [],card_arr6 = [],card_arr7 = [];
		$('#game_summary').find('td').remove();
		$('#game_summary tr:gt(3)').remove();

		var restart_timer = 10;
		var name; 
		var game_score =0 , amount_won =0;
		var player_grouped = false;
		var index = -1;
		var players_name_arr = [];
		var players_card_arr = [];
		var players_group_status_arr = [];
		var players_score_arr = [];
		var players_amount_arr = [];
		var n=1;
		var pl_name_arr_temp = [];
		var pl_card_arr_temp = [];
		var pl_grp_status_arr_temp = [];
		var pl_score_arr_temp = [];
		var pl_amount_arr_temp = [];
		var temp_grps = [];
		
		players_name_arr.push.apply(players_name_arr,data.players);
		players_card_arr.push.apply(players_card_arr,data.players_cards);
		players_group_status_arr.push.apply(players_group_status_arr,data.group_status);
		players_score_arr.push.apply(players_score_arr,data.players_score);
		players_amount_arr.push.apply(players_amount_arr,data.players_amount);

		for(var  i = 0; i < players_name_arr.length;)
		{
			if(players_name_arr[i] != loggeduser)
			{
				pl_name_arr_temp.push(players_name_arr[i]);
				pl_card_arr_temp.push(players_card_arr[i]);
				pl_grp_status_arr_temp.push(players_group_status_arr[i]);
				pl_score_arr_temp.push(players_score_arr[i]);
				pl_amount_arr_temp.push(players_amount_arr[i]);

				index = i;
				if(index != -1)
				{
					players_name_arr.splice(index, 1);
					players_card_arr.splice(index, 1);
					players_group_status_arr.splice(index, 1);
					players_score_arr.splice(index, 1);
					players_amount_arr.splice(index, 1);
				}
			}
			else
			{
				i++
				break;
			}
		}
		players_name_arr.push.apply(players_name_arr,pl_name_arr_temp);
		players_card_arr.push.apply(players_card_arr,pl_card_arr_temp);
		players_group_status_arr.push.apply(players_group_status_arr,pl_grp_status_arr_temp);
		players_score_arr.push.apply(players_score_arr,pl_score_arr_temp);
		players_amount_arr.push.apply(players_amount_arr,pl_amount_arr_temp);

		//console.log("\n players_name_arr "+JSON.stringify(players_name_arr));
		//console.log("\n players_score_arr "+JSON.stringify(players_score_arr));

		for(var k=1; k<=players_name_arr.length; k++)
		{
			name = players_name_arr[k-1]; 
			//console.log("\n ....... displaying details of player "+name);
				game_score = players_score_arr[k-1];
				amount_won = players_amount_arr[k-1];
				if((players_score_arr[k-1]) != -1)
				{
					$('#game_summary').append('<tr id="tr_cards'+(k)+'"><td style="text-align:center">'+name+'</td><td style="text-align:center" id="win'+(k)+'"></td><td class="declare-cards"><div id="pl'+(k)+'cards1" class="decl-group1"></div><div id="pl'+(k)+'cards2" class="decl-group2"></div><div id="pl'+(k)+'cards3" class="decl-group3"></div><div id="pl'+(k)+'cards4" class="decl-group4"></div><div id="pl'+(k)+'cards5" class="decl-group5"></div><div id="pl'+(k)+'cards6" class="decl-group6"></div><div id="pl'+(k)+'cards7" class="decl-group7"></div></td><td style="text-align:center">'+game_score+'</td><td style="text-align:center">'+amount_won+'</td></tr>');

					if(name==data.winner)
					{
						$('#win'+(k)+'').append('<img style="width: 40%" src="winner-rummy.jpg"/>');
					}

					if(loggeduser==data.winner)
					{
						audio_player_winner.play();
						$("#seq").text(" Valid ");
					}
					else { $("#seq").text(" Wrong "); }

					if(players_group_status_arr[k-1] == false)
					{
						if(players_card_arr[k-1].length>0)
						{
							$.each(players_card_arr[k-1], function(n,m)
							{
								if(n=0)
									$('#pl'+(k)+'cards1').append('<img  src="' + m.card_path + '" />'); 
								else
									$('#pl'+(k)+'cards1').append('<img  src="' + m.card_path + '" />');  
							});
						}
						
					}
					else
					{
						temp_grps = [];
						temp_grps.push.apply(temp_grps,players_card_arr[k-1]);
						if(temp_grps.length>0)
						{
							for(var p=1; p<=temp_grps.length; p++)
							{
								if(temp_grps[p-1].length>0)
								{
									$.each(temp_grps[p-1], function(n,m)
									{
										if(n=0)
											$('#pl'+(k)+'cards'+p).append('<img  src="' + m.card_path + '" />'); 
										else
											$('#pl'+(k)+'cards'+p).append('<img  src="' + m.card_path + '" />'); 
									});
								}//if-pl-group-length not 0
							}
						}
					}
				}
				else
				{
					$('#game_summary').append('<tr id="tr_cards'+(k)+'"><td style="text-align:center">'+name+'</td><td style="text-align:center" id="win'+(k)+'"></td><td class="declare-cards"><div id="pl'+(k)+'cards1" class="decl-group1"></div><div id="pl'+(k)+'cards2" class="decl-group2"></div><div id="pl'+(k)+'cards3" class="decl-group3"></div><div id="pl'+(k)+'cards4" class="decl-group4"></div><div id="pl'+(k)+'cards5" class="decl-group5"></div><div id="pl'+(k)+'cards6" class="decl-group6"></div><div id="pl'+(k)+'cards7" class="decl-group7"></div></td><td style="text-align:center"><img style="width: 42%;" src="buyin.gif" /></td><td style="text-align:center"><img style="width: 42%;" src="buyin.gif" /></td></tr>');

							$('#pl'+(k)+'cards'+1).append('<img  src="buyin.gif" />');
				}
				if(k==players_name_arr.length)
				{
						$('#game_summary').append('<tr class="joker" style="text-align:center" id="tr_joker" style="display:none"><th>Joker</th><th><img id="side_joker" ></th><th></th><th></th><th></th></tr><tr style="text-align:center" id="tr_msg" style="display:none"><th colspan="5" style="text-align:center; padding:2% 0%"><span style="color:white" id="restart_game_timer"></span></th></tr>');
											
						var joker_card_src = $("#joker_card").attr("src");	
						$("#side_joker").attr('src', joker_card_src); 
				}
		}//for ends 
					
		///clear data after game ends 
		clear_data_if_disconnected_player();//clear data of player if disconnected
		clear_player_data_after_declare();
		hide_all_players_turn_details();
		hide_all_add_here_buttons();
		$('#div_msg').show();
		declare = 2;
});////after  declared game -popup to all players
socket.on("declared_final_six_pool", function(data) 
{
		console.log("\n declared  final data "+JSON.stringify(data));
		$(".declare-table").show();
		var card_arr1 = [],card_arr2 = [],card_arr3 = [],card_arr4 = [],card_arr5 = [],card_arr6 = [],card_arr7 = [];
		$('#game_summary').find('td').remove();
		$('#game_summary tr:gt(3)').remove();

		var restart_timer = 10;
		var name; 
		var game_score =0 , amount_won =0;
		var player_grouped = false;
		var index = -1;
		var players_name_arr = [];
		var players_card_arr = [];
		var players_group_status_arr = [];
		var players_score_arr = [];
		var players_amount_arr = [];
		var players_poolamount_arr = [];
		var n=1;
		var pl_name_arr_temp = [];
		var pl_card_arr_temp = [];
		var pl_grp_status_arr_temp = [];
		var pl_score_arr_temp = [];
		var pl_amount_arr_temp = [];
		var pl_poolamount_arr_temp = [];
		var temp_grps = [];
		
		players_name_arr.push.apply(players_name_arr,data.players);
		players_card_arr.push.apply(players_card_arr,data.players_cards);
		players_group_status_arr.push.apply(players_group_status_arr,data.group_status);
		players_score_arr.push.apply(players_score_arr,data.players_score);
		players_amount_arr.push.apply(players_amount_arr,data.players_amount);
		players_poolamount_arr.push.apply(players_poolamount_arr,data.players_poolamount);
		for(var  i = 0; i < players_name_arr.length;)
		{
			if(players_name_arr[i] != loggeduser)
			{
				pl_name_arr_temp.push(players_name_arr[i]);
				pl_card_arr_temp.push(players_card_arr[i]);
				pl_grp_status_arr_temp.push(players_group_status_arr[i]);
				pl_score_arr_temp.push(players_score_arr[i]);
				pl_amount_arr_temp.push(players_amount_arr[i]);
				pl_poolamount_arr_temp.push(players_poolamount_arr[i]);
				index = i;
				if(index != -1)
				{
					players_name_arr.splice(index, 1);
					players_card_arr.splice(index, 1);
					players_group_status_arr.splice(index, 1);
					players_score_arr.splice(index, 1);
					players_amount_arr.splice(index, 1);
					players_poolamount_arr.splice(index, 1);
				}
			}
			else
			{
				i++
				break;
			}
		}
		players_name_arr.push.apply(players_name_arr,pl_name_arr_temp);
		players_card_arr.push.apply(players_card_arr,pl_card_arr_temp);
		players_group_status_arr.push.apply(players_group_status_arr,pl_grp_status_arr_temp);
		players_score_arr.push.apply(players_score_arr,pl_score_arr_temp);
		players_amount_arr.push.apply(players_amount_arr,pl_amount_arr_temp);
		players_poolamount_arr.push.apply(players_poolamount_arr,pl_poolamount_arr_temp);
		//console.log("\n players_name_arr "+JSON.stringify(players_name_arr));
		//console.log("\n players_score_arr "+JSON.stringify(players_score_arr));

		for(var k=1; k<=players_name_arr.length; k++)
		{
			name = players_name_arr[k-1]; 
			//console.log("\n ....... displaying details of player "+name);
				game_score = players_score_arr[k-1];
				amount_won = players_amount_arr[k-1];
				if((players_score_arr[k-1]) != -1)
				{
					$('#game_summary').append('<tr id="tr_cards'+(k)+'"><td style="text-align:center">'+name+'</td><td style="text-align:center" id="win'+(k)+'"></td><td class="declare-cards"><div id="pl'+(k)+'cards1" class="decl-group1"></div><div id="pl'+(k)+'cards2" class="decl-group2"></div><div id="pl'+(k)+'cards3" class="decl-group3"></div><div id="pl'+(k)+'cards4" class="decl-group4"></div><div id="pl'+(k)+'cards5" class="decl-group5"></div><div id="pl'+(k)+'cards6" class="decl-group6"></div><div id="pl'+(k)+'cards7" class="decl-group7"></div></td><td style="text-align:center">'+game_score+'</td><td style="text-align:center">'+amount_won+'</td></tr>');

					if(name==data.winner)
					{
						$('#win'+(k)+'').append('<img style="width: 40%" src="winner-rummy.jpg"/>');
					}

					if(loggeduser==data.winner)
					{
						audio_player_winner.play();
						$("#seq").text(" Valid ");
					}
					else { $("#seq").text(" Wrong "); }

					if(players_group_status_arr[k-1] == false)
					{
						if(players_card_arr[k-1].length>0)
						{
							$.each(players_card_arr[k-1], function(n,m)
							{
								if(n=0)
									$('#pl'+(k)+'cards1').append('<img  src="' + m.card_path + '" />'); 
								else
									$('#pl'+(k)+'cards1').append('<img  src="' + m.card_path + '" />');  
							});
						}
						
					}
					else
					{
						temp_grps = [];
						temp_grps.push.apply(temp_grps,players_card_arr[k-1]);
						if(temp_grps.length>0)
						{
							for(var p=1; p<=temp_grps.length; p++)
							{
								if(temp_grps[p-1].length>0)
								{
									$.each(temp_grps[p-1], function(n,m)
									{
										if(n=0)
											$('#pl'+(k)+'cards'+p).append('<img  src="' + m.card_path + '" />'); 
										else
											$('#pl'+(k)+'cards'+p).append('<img  src="' + m.card_path + '" />'); 
									});
								}//if-pl-group-length not 0
							}
						}
					}
				}
				else
				{
					$('#game_summary').append('<tr id="tr_cards'+(k)+'"><td style="text-align:center">'+name+'</td><td style="text-align:center" id="win'+(k)+'"></td><td class="declare-cards"><div id="pl'+(k)+'cards1" class="decl-group1"></div><div id="pl'+(k)+'cards2" class="decl-group2"></div><div id="pl'+(k)+'cards3" class="decl-group3"></div><div id="pl'+(k)+'cards4" class="decl-group4"></div><div id="pl'+(k)+'cards5" class="decl-group5"></div><div id="pl'+(k)+'cards6" class="decl-group6"></div><div id="pl'+(k)+'cards7" class="decl-group7"></div></td><td style="text-align:center"><img style="width: 42%;" src="buyin.gif" /></td><td style="text-align:center"><img style="width: 42%;" src="buyin.gif" /></td></tr>');

							$('#pl'+(k)+'cards'+1).append('<img  src="buyin.gif" />');
				}
				if(k==players_name_arr.length)
				{
						$('#game_summary').append('<tr class="joker" style="text-align:center" id="tr_joker" style="display:none"><th>Joker</th><th><img id="side_joker" ></th><th></th><th></th><th></th></tr><tr style="text-align:center" id="tr_msg" style="display:none"><th colspan="5" style="text-align:center; padding:2% 0%"><span style="color:white" id="restart_game_timer"></span></th></tr>');
											
						var joker_card_src = $("#joker_card").attr("src");	
						$("#side_joker").attr('src', joker_card_src); 
				}
		}//for ends 
					
		///clear data after game ends 
		clear_data_if_disconnected_player();//clear data of player if disconnected
		clear_player_data_after_declare();
		hide_all_players_turn_details();
		hide_all_add_here_buttons();
		$('#div_msg').show();
		declare = 2;
});////after  declared game -popup to all players
/*******************  Declare game ends *************/

/*******************  Clear / disable all buttons **************/
// function clear_player_data_after_declare(player_status)
// {
// 	if(player_status == true)
// 	{

// 	}
// }
/*******************  Clear / disable all buttons **************/

/*********** clear player details after game ends ********/
///clear data of  player
	function clear_player_data_after_declare()
	{
		$("#div_msg").empty();
		$("#images").empty();
		$("#msg").empty();
		$("#msg").hide();
		$("#open_deck").hide();
		$("#card_group1").empty();
		$("#card_group2").empty();
		$("#card_group3").empty();
		$("#card_group4").empty();
		$("#card_group5").empty();
		$("#card_group6").empty();
		$("#card_group7").empty();
		$("#discareded_open_cards").empty();
		$("#open_card").hide();
		$("#closed_cards").hide();
		$("#joker_card").hide();
		$("#open_card").attr('src','');  
		$("#closed_cards").attr('src', "");  
		$("#sort_cards").hide();
		$("#drop_game").hide();
		$("#finish_card").hide();
		$('#finish_card').attr("disabled", 'disabled');
		$('#drop_game').attr("disabled", 'disabled');
		open_card_src = '';
		closed_card_src = '';
		picked_card_value = '';
		$("#declare").hide();
		$("#discard_card").hide();
		$("#finish_game").hide();
		$("#group_cards").hide();
		$('#declare').attr("disabled", 'disabled');	
		$('#discard_card').attr("disabled", 'disabled');			
		$('#finish_game').attr("disabled", 'disabled');	
		random_group_roundno = 0;
		check_join_count = 10;
		selected_card_count=0;
		is_open_close_picked = 0;
		click_count = 0;
		activity_msg_count = 3;
		player_turn = false;
		discard_click = false ;
		next_turn = false ;
		remove_obj = null;
		ttt = false;
		initial_group = false;
		is_grouped_temp = false;
		initial_group_temp = false;
		is_sorted = false;
		is_grouped = false;
		open_data = '';
		close_data='';
		open_obj = "";
		user_assigned_cards = [];
		temp_closed_cards_arr = [];
		temp_closed_cards_arr1 = [];
		closed_card_src_temp = '';
		selected_card_arr = [];
		selected_card_arr1 = [];
		selected_group_card_arr = [];
		vars = {};
		grp1 = [];grp2 = [];grp3 = [];grp4 = [];
		grp5 = [];grp6 = [];grp7 = [];
		add_card_obj = "";
		is_declared = false ;
		is_other_declared = false ;
		parent_group_id = 0;
		selected_group_id = 0;
		selected_card_id = 0;
		discarded_open_arr = [];
		
		//clear_data_if_disconnected_player();
		for(var  i = 1; i < 7; i++)
		{
			$("#player_"+(i)+"_disconnect").hide();
			$("#player_"+(i)+"_dealer").hide();
		}
		console.log("Block on clear_player_data_after_declare");
	}//// clear_player_data_after_declare() ends 

function clear_data_if_disconnected_player()
{
	//alert("---");
	for(var  i = 1; i < 7; i++)
	{
		if(($("#player_"+(i)+"_status").text()) == "Disconnected")
		{
			$("#player_"+(i)+"_name").text("");
			$("#player_"+(i)+"_amount").text("");
			$("#player_"+(i)+"_details").hide();
			$("#player_"+(i)+"_sit").css('display','block');
			$("#player_"+(i)+"_male_player").css('display','none');
			$("#player_"+(i)+"_female_player").css('display','none');

		}
	}
}//clear_data_if_disconnected_player() ends 


socket.on('game_no_enough', function(playername, table_id){
	if(tableid == table_id && loggeduser == playername){
		alert("You have not enough points to continue");
		window.close();
	}
});
/*********** clear player details after game ends ********/

/***************************   Game Finished    *******************/
			
socket.on('game_finished_six', function(data)
{
	if(data.user==loggeduser)
	{
		if(tableid==data.group)
		{
		    //if(table_round_id == data.round_id)
			{
				bWaiting_Join = false;
				
				hide_all_players_turn_details();
				console.log("Player Join Table: when finished game\n");
				if(game_type == 'Pool Rummy') {
					socket.emit('player_join_table_pool', loggeduser,btnclicked,tableid,random_group_roundno, data.joined,data.player_amount,data.player_poolamount,player_gender,browser_type, os_type,user_id,true); 
				} else
					socket.emit('player_join_table', loggeduser,btnclicked,tableid,random_group_roundno, data.joined,data.player_amount,player_gender,browser_type, os_type,user_id,true); 
			}			
		}
	}
});
/***************************   Game Finished    *******************/

/*********** If Game has re-started again **************/
socket.on('update_amount_six', function(tableid_listening,name_array,amount_array)
{
	if(checkPlayerExistInGame(loggeduser,name_array))//if logged player playing game again 
	{
		if(tableid==tableid_listening)
		{
			for(var i = 0; i < name_array.length; i++) 
			{
				if(name_array[i] == loggeduser)
				{
					player_amount = amount_array[i];
				}
				for(var j = 0; j < name_array.length; j++) 
				{
					if(($("#player_"+(i+1)+"_name").text()) == name_array[j])
					{
						$("#player_"+(i+1)+"_amount").text(amount_array[j]);
					}
				}
			}
		}
	}
});
socket.on('update_amount_six_pool', function(tableid_listening,name_array,amount_array,poolamount_array)
{
	if(checkPlayerExistInGame(loggeduser,name_array))//if logged player playing game again 
	{
		if(tableid==tableid_listening)
		{
			for(var i = 0; i < name_array.length; i++) 
			{
				if(name_array[i] == loggeduser)
				{
					player_amount = amount_array[i];
					player_poolamount = poolamount_array[i];
				}
				for(var j = 0; j < name_array.length; j++) 
				{
					if(($("#player_"+(i+1)+"_name").text()) == name_array[j])
					{
						$("#player_"+(i+1)+"_amount").text(amount_array[j]);
						$("#player_"+(i+1)+"_poolamount").text(poolamount_array[j]);
					}
				}
			}
		}
	}
});

function checkPlayerExistInGame(currentPlayer,player_name_array_server)
{
	var found = false;
	for(var i = 0; i < player_name_array_server.length; i++) 
	{
		if(player_name_array_server[i] == currentPlayer)
		{
			found = true;
			break;
		}
	}
	return found;
}//checkPlayerExistInGame ends 

/*********** If Game has re-started again **************/

/*********-----------------  Player Disconnect start -----------------************/
socket.on('player_disconnected_six', function(playername,tableid_recvd)
			   {
					if($('.declare-table').is(':visible'))
					{
						// $(".declare-table").hide();
					}
			   		if(tableid==tableid_recvd)
					{
						for(var  i = 1; i < 7; i++)
						{
							if(($("#player_"+(i)+"_name").text()) == playername)
							{
								// $("#player_"+(i)+"_male_player").css('display','none');
								// $("#player_"+(i)+"_female_player").css('display','none'); 
								$("#player_"+(i)+"_disconnect").css('display','block'); 
								$("#player_"+(i)+"_status").text("Disconnected");
							}
						}//for ends 
					}
			   });

/*********-----------------  Player Disconnect ends -----------------************/

/************.......... REFRESH START ..............*********/
	$('#refresh').click(function() 
		{
			//alert(activity_timer_status+"--joined_table--"+joined_table);
		 	is_refreshed = true;
	
			//clear_player_data_after_declare();

			setTimeout( function() {
				location.reload();
			}, 100 );
		});

socket.on('player_reconnected_six', function(tableid_recvd,pl_names,player_sit_arr,players_amount,players_gender, players_playing)
	{
		if($('.declare-table').is(':visible'))
		{
			$(".declare-table").hide();
		}
		if(tableid==tableid_recvd)
		{
			var player_name_array = [];var player_sit_array = [];
			var player_amount_array = [];var player_gender_array = [];
			var player_name_array_temp = [];var player_sit_array_temp = [];
			var player_amount_array_temp = [];var player_gender_array_temp = [];
			var player_playing_array = [];var player_playing_array_temp = [];
			var index = -1;
			player_name_array.push.apply(player_name_array,pl_names);
			player_sit_array.push.apply(player_sit_array,player_sit_arr);
			player_amount_array.push.apply(player_amount_array,players_amount);
			player_gender_array.push.apply(player_gender_array,players_gender);
			player_playing_array.push.apply(player_playing_array,players_playing);
			for(var  i = 0; i < player_name_array.length;)
			{
				if(player_name_array[i] != loggeduser)
				{
					player_name_array_temp.push(player_name_array[i]);
					player_sit_array_temp.push(player_sit_array[i]);
					player_amount_array_temp.push(player_amount_array[i]);
					player_gender_array_temp.push(player_gender_array[i]);
					player_playing_array_temp.push(player_playing_array[i]);

					index = i;
					if(index != -1)
					{
						player_name_array.splice(index, 1);
						player_sit_array.splice(index, 1);
						player_amount_array.splice(index, 1);
						player_gender_array.splice(index, 1);
						player_playing_array.splice(index, 1);
					}
				}
				else
				{
					i++
					break;
				}
			}//for

			player_name_array.push.apply(player_name_array,player_name_array_temp);
			player_sit_array.push.apply(player_sit_array,player_sit_array_temp);
			player_amount_array.push.apply(player_amount_array,player_amount_array_temp);
			player_gender_array.push.apply(player_gender_array,player_gender_array_temp);
			player_playing_array.push.apply(player_playing_array,player_playing_array_temp);
			btnclicked = player_sit_array[0];

			hide_all_players_details();
			
			console.log("display players : player_reconnected_six\n");
			console.log("player_reconnected_six  player_sit_array:" + JSON.stringify(player_sit_array) + " \n");
			for(var  i = 0; i < player_name_array.length; i++)
			{
				$("#player_"+(i+1)+"_name").text(player_name_array[i]);
				$("#player_"+(i+1)+"_amount").text(player_amount_array[i]);
				if(player_gender_array[i] == 'Male')
				{ 
					$("#player_"+(i+1)+"_male_player").css('display','block');
					$("#player_"+(i+1)+"_female_player").css('display','none');					
				}
				else 
				{ 
					$("#player_"+(i+1)+"_male_player").css('display','none');
					$("#player_"+(i+1)+"_female_player").css('display','block'); 
				} 
				$("#player_"+(i+1)+"_details").show();

				if( player_playing_array[i] == false ) {
					$("#player_"+ (i+1)+"_disconnect").css('display','block'); 
					$("#player_"+ (i+1)+"_status").text("Waiting");
					console.log("WWWWWWWWWWWWWWWW5530");
				}
			}
		}//same-table-id
    });
	
	socket.on('player_reconnected_six_pool', function(tableid_recvd,pl_names,player_sit_arr,players_amount,players_poolamount,players_gender,players_playing)
	{
		if($('.declare-table').is(':visible'))
		{
			$(".declare-table").hide();
		}
		if(tableid==tableid_recvd)
		{
			var player_name_array = [];var player_sit_array = [];
			var player_amount_array = [];var player_gender_array = [];
			var player_poolamount_array = [];
			var player_name_array_temp = [];var player_sit_array_temp = [];
			var player_amount_array_temp = [];var player_gender_array_temp = [];
			var player_poolamount_array_temp = [];
			var player_playing_array = [];var player_playing_array_temp = [];
			var index = -1;

			player_name_array.push.apply(player_name_array,pl_names);
			player_sit_array.push.apply(player_sit_array,player_sit_arr);
			player_amount_array.push.apply(player_amount_array,players_amount);
			player_poolamount_array.push.apply(player_poolamount_array,players_poolamount);
			player_gender_array.push.apply(player_gender_array,players_gender);
			player_playing_array.push.apply(player_playing_array,players_playing);
			btnclicked = player_sit_array[0];

			for(var  i = 0; i < player_name_array.length;)
			{
				if(player_name_array[i] != loggeduser)
				{
					player_name_array_temp.push(player_name_array[i]);
					player_sit_array_temp.push(player_sit_array[i]);
					player_amount_array_temp.push(player_amount_array[i]);
					player_poolamount_array_temp.push(player_poolamount_array[i]);
					player_gender_array_temp.push(player_gender_array[i]);
					player_playing_array_temp.push(player_playing_array[i]);

					index = i;
					if(index != -1)
					{
						player_name_array.splice(index, 1);
						player_sit_array.splice(index, 1);
						player_amount_array.splice(index, 1);
						player_poolamount_array.splice(index, 1);
						player_gender_array.splice(index, 1);
						player_playing_array.splice(index, 1);
					}
				}
				else
				{
					i++
					break;
				}
			}//for

			player_name_array.push.apply(player_name_array,player_name_array_temp);
			player_sit_array.push.apply(player_sit_array,player_sit_array_temp);
			player_amount_array.push.apply(player_amount_array,player_amount_array_temp);
			player_poolamount_array.push.apply(player_poolamount_array,player_poolamount_array_temp);
			player_gender_array.push.apply(player_gender_array,player_gender_array_temp);
			player_playing_array.push.apply(player_playing_array,player_playing_array_temp);
			btnclicked = player_sit_array[0];
			hide_all_players_details();
			for(var  i = 0; i < player_name_array.length; i++)
			{
				$("#player_"+(i+1)+"_name").text(player_name_array[i]);
				$("#player_"+(i+1)+"_amount").text(player_amount_array[i]);
				$("#player_"+(i+1)+"_poolamount").text(player_poolamount_array[i]);
				if(player_gender_array[i] == 'Male')
				{ 
					$("#player_"+(i+1)+"_male_player").css('display','block');
					$("#player_"+(i+1)+"_female_player").css('display','none');					
				}
				else 
				{ 
					$("#player_"+(i+1)+"_male_player").css('display','none');
					$("#player_"+(i+1)+"_female_player").css('display','block'); 
				} 
				$("#player_"+(i+1)+"_details").show();
				
				if( player_playing_array[i] == false ) {
					$("#player_"+ (i+1)+"_disconnect").css('display','block'); 
					$("#player_"+ (i+1)+"_status").text("Waiting");
					console.log("WWWWWWWWWWWWWWWW5618");
				}
			}
		}//same-table-id
    });
 socket.on('other_player_reconnected_six', function(playername,tableid_recvd,pl_amount,pl_gender)
	{
		//alert(playername+"--"+tableid_recvd+"--"+pl_amount+"--"+pl_gender);
		if(tableid==tableid_recvd)
		{
			console.log("display players : other_player_reconnected_six\n");
			for(var  i = 1; i < 7; i++)
			{
				if(($("#player_"+(i)+"_name").text()) == playername)
				{
					$("#player_"+(i)+"_disconnect").hide();
					$("#player_"+(i)+"_name").text(playername);
					$("#player_"+(i)+"_amount").text(pl_amount);
					$("#player_"+(i)+"_details").show();
					$("#player_"+(i)+"_sit").css('display','none');
					
					if(pl_gender == 'Male')
					{ $("#player_"+(i)+"_male_player").css('display','block'); }
					else { $("#player_"+(i)+"_female_player").css('display','block'); }
				}
			}
		}
	});
	socket.on('other_player_reconnected_six_pool', function(playername,tableid_recvd,pl_amount,pl_poolamount,pl_gender)
	{
		//alert(playername+"--"+tableid_recvd+"--"+pl_amount+"--"+pl_gender);
		if(tableid==tableid_recvd)
		{
			console.log("display players : other_player_reconnected_six_pool\n");
			for(var  i = 1; i < 7; i++)
			{
				if(($("#player_"+(i)+"_name").text()) == playername)
				{
					$("#player_"+(i)+"_disconnect").hide();
					$("#player_"+(i)+"_name").text(playername);
					$("#player_"+(i)+"_amount").text(pl_amount);
					$("#player_"+(i)+"_poolamount").text(pl_poolamount);
					$("#player_"+(i)+"_details").show();
					$("#player_"+(i)+"_sit").css('display','none');

					console.log("BLOCK on other_player_reconnected_six");
					if(pl_gender == 'Male')
					{ $("#player_"+(i)+"_male_player").css('display','block'); }
					else { $("#player_"+(i)+"_female_player").css('display','block'); }
				}
			}
		}
	});
    /*** Show player data on refresh ***/
	socket.on("refresh_six", function(data) 
	{
		console.log("\n IN REFRESH EVENT  "+JSON.stringify(data));
		//console.log("\n finish data "+data.is_finish+"--obj-"+JSON.stringify(data.finish_obj));
		if(tableid == data.group_id)///check for same table
		{
			table_round_id = data.round_no;
			//joined_table= data.is_joined_table;
			joined_table= true;
			activity_timer_status = true;
				
			for(var  i = 1; i < 7; i++)
			{
				if(($("#player_"+(i+1)+"_name").text())==data.dealer)
				{$("#player_"+(i+1)+"_dealer").show();}
			}
				
			$("#open_deck").show();
			if(data.is_grouped == false)
			{
				user_assigned_cards.push.apply(user_assigned_cards, data.assigned_cards); 
				$('#images_parent').append( $('#images') );
				show_player_hand_cards(data.assigned_cards,data.sidejokername);
			}
			else if(data.is_grouped == true)				
			{ is_grouped = true; }
					
			$("#open_card").show();
			$("#closed_cards").show();
			$("#joker_card").show();
				
			$("#closed_cards").attr('src', "c3.jpg");  
			$("#joker_card").attr('src', data.sidejoker);  
				
			var temp = [];
			temp.push(data.open_data);
			//console.log("OPEN DATA recvd  "+JSON.stringify(temp));
						
			if(data.open_length == 1)
			{
				initial_open_card = data.open_data;
				open_data = '';
			}
			else
			{
				open_data = data.open_data;
			} 
			//console.log("\n %%%%%%%%%% open data path "+data.opencard+" id "+data.opencard_id+" obj "+JSON.stringify(data.open_data));
				  
			if(data.is_finish == true)				
			{ 
				is_finished = true; 
				if( !bLosted ) {
					$("#finish_card").show();
					$("#finish_card").attr('src', data.finish_obj.card_path); 
					hide_all_players_turn_details();				
							
					$("#declare").show();
					$("#msg").empty();
					$("#msg").css('display', "inline-block"); 
					$("#msg").html("Group your cards and Declare...!");
				}
			}
			if(data.open_data.length>0)
			{
				$("#open_card").attr('src', data.open_data[0].card_path);  
			}
			else
			{
				$("#open_card").attr('src', "closedimg.bmp");  
			}
			
			// if(data.close_cards.length>0)
			// {
			// 	temp_closed_cards_arr1[0]=data.close_cards[0];
			// 	closed_card_src_temp = data.close_cards[0].card_path;
			// 	closed_card_id_temp = data.close_cards[0].id;
			// }
			if(data.closedcards_path.length>0)
			{
				temp_closed_cards_arr1[0]=data.closedcards_path[0];
				closed_card_src_temp = data.closedcards_path[0].card_path;
				closed_card_id_temp = data.closedcards_path[0].id;
			}
			$("#discareded_open_cards").empty();		
			if(data.close_cards.length>0)
			{
				$.each(data.close_cards, function(k, v) 
					{
						$("#discareded_open_cards").append("<img width='10%' height='10%' src="+v.card_path+">");
					});
			}		
		} 
	}); 
/************.......... REFRESH ends  ..............*********/

/* ------------   Game leave / window close / refresh starts  -----------*/
		$("#leave_confirm").click(function()
		{
				if($.trim($("#div_msg").html())!=''){
					$("#div_msg").hide();
				}
		});
			
		$("#leave_group_cancel").click(function()
			{
				if($.trim($("#div_msg").html())!=''){
					$("#div_msg").show();
				}
		});
			
		var is_clicked = false;
		/////leaving group (manually clicked 'leave table' menu) ////
		$("#leave_group").click(function()
		{
				is_clicked = true;
				
			  if(!activity_timer_status)
			  {
				window.close();
			  }
			  else
				{	
					$('#leave_group').prop('disabled', true);
				}
				
		});

		$(window).unload(function()
			{

				//socket.emit("test",{left_user:loggeduser,is_refreshed:is_refreshed,is_clicked:is_clicked,activity_timer_status:activity_timer_status,joined_table:joined_table,player_amount:player_amount});
			});  

			socket.on("player_left_six_pl_game", function(data) 
			{
				//alert(data.game_restart);
		     console.log("--- in pl left ---"+socket.id);
			 console.log(" in player_left "+JSON.stringify(data));
			 var index = -1;

			 if(tableid==data.group)
			 {
			 	if($('.declare-table').is(':visible'))
					{
						var check_join_count = 3;
						var countdown1 = setInterval(function()
						{
							check_join_count--;
							if (check_join_count == 0)
								{
									clearInterval(countdown1);  
									$(".declare-table").hide();
									activity_timer_status=false;
								}
						}, 1000);
					}

				for(var  i = 0; i < 6; i++)
				{
					$("#player_"+(i+1)+"disconnect").hide();
				}
				is_finished = false ;
				 is_game_dropped = false;
				 console.log("\nANDY player_left_six_pl_game  declare:" + declare);
			 	declare = 0;
			 
			 	var count = 2; 

			 	setMessage(data.left_user+' has left the Game...!');
				// if(data.game_restart == true) {
				// console.log("\n player_name_array "+JSON.stringify(player_name_array));
				// 					console.log("\n player_sit_array "+JSON.stringify(player_sit_array));
				// 					console.log("\n player_amount_array "+JSON.stringify(player_amount_array));
				// 					console.log("\n player_gender_array "+JSON.stringify(player_gender_array));
				// 					for(var  j = 0; j < player_name_array.length;)
				// 					{
				// 						if(player_name_array[j] == data.left_user)
				// 						{
				// 							index = j;
				// 							if(index != -1)
				// 							{
				// 								player_name_array.splice(index, 1);
				// 								player_sit_array.splice(index, 1);
				// 								player_amount_array.splice(index, 1);
				// 								player_gender_array.splice(index, 1);
				// 							}
				// 						}
				// 						else
				// 						{
				// 							j++;
				// 							break;
				// 						}
				// 					}
				// 					console.log("\n after player_name_array "+JSON.stringify(player_name_array));
				// 					console.log("\n ----- player_sit_array "+JSON.stringify(player_sit_array));
				// 					console.log("\n ----- player_amount_array "+JSON.stringify(player_amount_array));
				// 					console.log("\n ----- player_gender_array "+JSON.stringify(player_gender_array));
				// 						}
				var countdown = setInterval(function(){
						  if (count == 0)
						   {
								  clearInterval(countdown);  
								if(data.joined_player == 1)
								{
									setMessage('<label style="color:white">Waiting for another Player to join Table!</label>');
								}
								else if(data.joined_player == 0)
								{
									emptyMessage();
								}
								/*
								if(data.game_restart == false) 
								{
									$("#player_"+(data.btn)+"_name").text("");
									$("#player_"+(data.btn)+"_amount").text("");
									$("#player_"+(data.btn)+"_details").hide();
									$("#player_"+(data.btn)+"_sit").css('display','block');
									$("#player_"+(data.btn)+"_loader").css('display','none');
									$("#player_"+(data.btn)+"_male_player").css('display','none');
									$("#player_"+(data.btn)+"_female_player").css('display','none');

								}
								else*/
								{
									for(var  i = 1; i < 7; i++)
									{
										if(($("#player_"+(i)+"_name").text()) == data.left_user)
										{
											$("#player_"+(i)+"_name").text("");
											$("#player_"+(i)+"_amount").text("");
											$("#player_"+(i)+"_details").hide();
											$("#player_"+(i)+"_sit").css('display','block');
											$("#player_"+(i)+"_loader").css('display','none');
											$("#player_"+(i)+"_male_player").css('display','none');
											$("#player_"+(i)+"_female_player").css('display','none');
											$("#player_"+(i)+"_disconnect").css('display','none');
										}
									}
									// console.log("\n player_name_array "+JSON.stringify(player_name_array));
									// console.log("\n player_sit_array "+JSON.stringify(player_sit_array));
									// console.log("\n player_amount_array "+JSON.stringify(player_amount_array));
									// console.log("\n player_gender_array "+JSON.stringify(player_gender_array));
									// for(var  j = 0; j < player_name_array.length;)
									// {
									// 	if(player_name_array[j] == data.left_user)
									// 	{
									// 		index = j;
									// 		if(index != -1)
									// 		{
									// 			player_name_array.splice(index, 1);
									// 			player_sit_array.splice(index, 1);
									// 			player_amount_array.splice(index, 1);
									// 			player_gender_array.splice(index, 1);
									// 		}
									// 	}
									// 	else
									// 	{
									// 		j++
									// 		break;
									// 	}
									// }
									// console.log("\n after player_name_array "+JSON.stringify(player_name_array));
									// console.log("\n ----- player_sit_array "+JSON.stringify(player_sit_array));
									// console.log("\n ----- player_amount_array "+JSON.stringify(player_amount_array));
									// console.log("\n ----- player_gender_array "+JSON.stringify(player_gender_array));
								}
							}
							count--;
						  }, 1000);
					}//if same table 
			});//player_left ends 

/* ------------   Game leave / window close / refresh end  -----------*/

		socket.on('show_sixgame_data', function(players_joined,player_sit_arr,tableid_listening,player_amount_arr,player_poolamount_arr,player_gender_arr,is_restart_game, players_playing)
			{
				
				console.log("\n show_sixgame_data IN check_if_joined_player sit array  "+JSON.stringify(player_sit_arr)+" amount array "+JSON.stringify(player_amount_arr)+" gender array "+JSON.stringify(player_gender_arr)+" players name array  "+JSON.stringify(players_joined));
				console.log("\n tableid "+tableid+" tableid_listening "+tableid_listening+"--is_restart_game--"+is_restart_game);

				if(tableid==tableid_listening)
				{
					is_finished = false;
					console.log("\nANDY show_sixgame_data  declare:" + declare);
					declare = 0;
					is_game_dropped=false;

					if(is_game_started == false)
					{
						for(var  i = 0; i < players_joined.length; i++)
						{
							if(loggeduser==players_joined[i])
							{  
								joined_table=true; 
								btnclicked = player_sit_arr[i];
								player_amount = player_amount_arr[i];
								player_gender = player_gender_arr[i];
							}
						}	
					} 
					if(is_restart_game == true){ is_game_started = true; }
					else { is_game_started = false; }

					if($('.declare-table').is(':visible'))
					{
						var check_join_count = 3;
						var countdown1 = setInterval(function(){
						check_join_count--;
						if (check_join_count == 0)
						{
							clearInterval(countdown1);  
							$(".declare-table").hide();
							activity_timer_status=false;
						}
					  }, 1000);
					}

					//ANDY if(is_game_started == false)
					{
						for(var  i = 1; i < 7; i++)
						{
							$("#player_"+(i)+"_name").text("");
							$("#player_"+(i)+"_amount").text("");
							$("#player_"+(i)+"_details").hide();
							$("#player_"+(i)+"_male_player").css('display','none');
							$("#player_"+(i)+"_female_player").css('display','none');
							$("#player_"+(i)+"_sit").show();
						}
						console.log("display players : show_sixgame_data\n");
						
						for(var  i = 0; i < players_joined.length; i++)
						{
							$("#player_"+(player_sit_arr[i])+"_loader").hide();
							$('#player_'+(player_sit_arr[i])+'_sit').css('display','none');
							$("#player_"+(player_sit_arr[i])+"_name").text(players_joined[i]);
							$("#player_"+(player_sit_arr[i])+"_amount").text(player_amount_arr[i]);
							$("#player_"+(player_sit_arr[i])+"_poolamount").text(player_poolamount_arr[i]);
							$("#player_"+(player_sit_arr[i])+"_details").show();

							console.log("\n " + player_gender_arr[i]);
							if(player_gender_arr[i] == 'Male')
							{ 
								$("#player_"+(player_sit_arr[i])+"_male_player").css('display','block');
								$("#player_"+(player_sit_arr[i])+"_female_player").css('display','none');					
							}
							else 
							{ 
								$("#player_"+(player_sit_arr[i])+"_male_player").css('display','none');
								$("#player_"+(player_sit_arr[i])+"_female_player").css('display','block'); 
							} 
							if($.trim($("#div_msg").html())=='' && players_joined.length ==1)
							{
								console.log("\ div_msg is empty ");
								setMessage('<label style="color:white">Wait Till Game End!</label>');
							}
						
						}//for ends 
					}
				}
			});

			// Drag And Drop
			$("#card_group1, #card_group2, #card_group3, #card_group4, #card_group5, #card_group6, #card_group7").dragsort({ 
				dragSelector: "div",
				dragBetween: true,
				dragStart: dragStart,
				dragEnd: saveOrder });
			
			$("#images").dragsort({ dragSelector: "div", dragBetween: true });

			function getGroupIdFromTag( tagId ) {
				for(i = 1; i <= 7; i++) {
					if(tagId == ("card_group" + i))
						return i;
				}
				return 0;
			}	

			function dragStart() {
				dragcards=true;
				var groupId = getGroupIdFromTag($(this).parent().attr('id'));
				if( groupId == 0 )
					return;
					
				parent_group_id = groupId;
				selected_card_id = $(this).children().attr('id');
				var sort_groups = [sort_grp1, sort_grp2, sort_grp3, sort_grp4, sort_grp5, sort_grp6, sort_grp7 ];
				for(var  i = 0; i < sort_groups[groupId - 1].length; i++)
				{
					if(sort_groups[groupId - 1][i].id == selected_card_id)
					{
						open_obj = sort_groups[groupId - 1][i];
						break;
					}
				}

				add_card_obj=open_obj;
				console.log("\n add_card_obj================================"+JSON.stringify( add_card_obj));
				console.log("\n add_card_obj======================== "+ add_card_obj);
			}
			function saveOrder() {	
				var groupId = getGroupIdFromTag($(this).parent().attr('id'));
				selected_card_id = $(this).children().attr('id');
				if( groupId == 0 )
					return;
				//if( groupId == parent_group_id )
				//	return;
				
			 //var position=0;
				$i=0;
				$('#card_group'+groupId).children('div').each(function(idx, val){
					   //alert(val);
					   if($(this).children('img').attr('id') == selected_card_id)
					   {
						 
						   //alert($i);
					      add_here_drop( groupId,$i );
					   }
					   $i++;
					})
				//add_here( groupId );
			};
			$("#closed_cards").dragsort({ dragSelector: "div", dragBetween: true});

		});//function ends 
	</script>		
	<script src="pop-up_six.js"></script>
</html>
