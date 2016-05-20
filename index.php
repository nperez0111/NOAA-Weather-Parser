<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NOAA Weather ForeCast</title>
    <style>
        * {
            box-sizing: border-box;
        }
        
        .top {
            border-top: 1px solid black;
            border-bottom: 1px solid black;
        }
        
        h1 {
            border-bottom: 1px solid #CCC;
            text-align: center;
            font-size: 180%;
        }
        
        p {
            color: #333;
        }
        
        body h2 {
            text-align: center;
        }
        
        h2 {
            font-family: Candara, Calibri, Segoe, "Segoe UI", Optima, Arial, sans-serif;
        }
        
        .today {
            text-decoration: underline;
            font-size: 160%;
            margin-left: 20px;
            color: black;
            text-align: left;
        }
        
        .alert {
            color: red;
            text-decoration: underline;
            font: 600;
        }
        
        .loc {
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
            max-width: 960px;
            margin: 5em auto;
        }
        
        p {
            max-width: 95%;
            margin: 25px auto;
            font-family: Cambria, Georgia, serif;
            font-size: 100%;
            text-transform: lowercase;
        }

        p::first-letter { 
            text-transform: uppercase;
        }
        
        #toSettings {
            font: bold 1.1em Arial;
            text-decoration: none;
            background-color: #0088CC;
            color: #EEE;
            padding: 4px 12px;
            border: 1px solid #CCCCCC;
            border-radius: 3px;
            float: right;
        }
        
        .hidden {
            display: none;
        }
        
        .center {
            text-align: center;
        }
        
        ul {
            list-style: none;
            padding:0;
            margin:0;
        }
        
        li {
            width: 100%;
            margin: 20px auto;
            padding:0 20px;
        }
        
        li input[type='text'] {
            width: 50%;
            padding: 2px 5px;
            box-sizing: border-box;
        }
        label{display:inline-block;width:50%;margin-top:16px;}
    </style>
</head>

<body>
    <a href="http://weather.noaa.gov/cgi-bin/fmtbltn.pl?file=raw/fz/fzus52.kmfl.cwf.mfl.txt">Back To NOAA</a><a href="#" id="toSettings">Configure settings</a>
    <div id="hook"></div>
    <div id="settings" class="hidden">
        
    </div>
    <script id='template' type='text/ractive'>
        <div class="loc">
            <h1>Settings</h1>
            <p class="center">Disclaimer: all settings are stored onto only the current device. See admin for multiple device availability.</p>
            <h2>This is to change the labels used in naming of the areas.</h2>
            <ul id="Rename">
            {{#each location:i}}
                <li><label for='a{{i}}'><b>Actual Name:</b> {{poss[i][0]}}</label><input type='text' value='{{location[i]}}' id='a{{i}}' data-id='{{i}}'><label for='s{{i}}'>Display?</label><input type='checkbox' id='s{{i}}' checked='{{selectd[i]}}'></li>
                {{/each}}
            </ul>
        </div>
    </script>
    <script src="https://code.jquery.com/jquery-2.2.0.min.js"></script>
    <script src='http://cdn.ractivejs.org/latest/ractive.js'></script>
    <script type="text/javascript">var locs,
    titles,
    possibles = [
        [ "Coastal waters from Altamaha Sound, GA to Flagler Beach, FL out to 20 NM", "AMZ450" ],
        [ "Waters from Atlamaha Sound, GA to Fernandina Beach, FL extending 20 NM to 60 NM", "AMZ470" ],
        [ "Coastal waters from Fernandina Beach to St. Augustine, FL out 20 NM", "AMZ452" ],
        [ "Waters from Fernandina Beach to St. Augustine, FL extending 20 NM to 60 NM", "AMZ472" ],
        [ "Coastal waters from St. Augustine to Flager Beach, FL out 20 NM", "AMZ454" ],
        [ "Waters from St. Augustine to Flager Beach, FL extending 20 NM to 60 NM", "AMZ474" ],
        [ "Flagler Beach to Volusia-Brevard County Line 0-20NM ", "AMZ550" ],
        [ "Volusia-Brevard County Line to Sebastian Inlet 0-20NM ", "AMZ552" ],
        [ "Sebastian Inlet to Jupiter Inlet 0-20NM ", "AMZ555" ],
        [ "Flagler Beach to Volusia-Brevard County Line 20-60NM", "AMZ570" ],
        [ "Volusia-Brevard County Line to Sebastian Inlet 20-60NM", "AMZ572" ],
        [ "Sebastian Inlet to Jupiter Inlet 20-60NM", "AMZ575" ],
        [ "Lake Okeechobee, FL", "AMZ610" ],
        [ "Coastal waters from Jupiter Inlet to Deerfield Beach, FL out 20 NM", "AMZ650" ],
        [ "Waters from Jupiter Inlet to Deerfield Beach, FL extending 20 NM to 60 NM", "AMZ670" ],
        [ "Biscayne Bay, FL", "AMZ630" ],
        [ "Coastal waters from Deerfield Beach to Ocean Reef, FL out 20 NM", "AMZ651" ],
        [ "Waters from Deerfield Beach to Ocean Reef, FL extending 20 NM to 60 NM", "AMZ671" ],
        [ "Florida Bay including Blackwater and Buttonwood Sounds", "GMZ031" ],
        [ "Bayside and Gulfside from Craig Key to Halfmoon Shoal out to 5 fathoms", "GMZ032" ],
        [ "Gulf waters from East Cape Sable to Chokoloskee 20 to 60 nm out and beyond 5 fathoms", "GMZ033" ],
        [ "Gulf of Mexico including Dry Tortugas and Rebecca Shoal Channel", "GMZ034" ],
        [ "Hawk Channel from Ocean Reef to Craig Key out to the reef", "GMZ042" ],
        [ "Hawk Channel from Craig Key to west end of Seven Mile Bridge out to the reef", "GMZ043" ],
        [ "Hawk Channel from west end of Seven Mile Bridge to Halfmoon Shoal out to the reef", "GMZ044" ],
        [ "Straits of Florida from Ocean Reef to Craig Key out 20 nm", "GMZ052" ],
        [ "Straits of Florida from Craig Key to west end of Seven Mile Bridge out 20 nm", "GMZ053" ],
        [ "Straits of Florida from west end of Seven Mile Bridge to south of Halfmoon Shoal out 20 nm", "GMZ054" ],
        [ "Straits of Florida from Halfmoon Shoal to GMZ055 20 nm west of Dry Tortugas out 20 nm", "GMZ055" ],
        [ "Straits of Florida from Ocean Reef to Craig Key 20 to 60 nm out", "GMZ072" ],
        [ "Straits of Florida from Craig Key to west end of Seven Mile Bridge 20 to 60 nm out", "GMZ073" ],
        [ "Straits of Florida from west end of Seven Mile Bridge to south of Halfmoon Shoal 20 to 60 nm out", "GMZ074" ],
        [ "Straits of Florida from Halfmoon Shoal to 20 nm west of Dry Tortugas 20 to 60 nm out", "GMZ075" ]
    ],
    selected,
    ract;

function applyHTML( resp, i ) {
    var always = "<div class='loc'><div><h1>" + titles[ i ] + "</h1></div>";
    $( '#hook' ).append( always + resp + "</div>" );
}

function loadData() {
    selected.forEach( function ( cur, i ) {
        $.get( "getDay.php?loc=" + possibles[ cur ][ 1 ] ).then( function ( resp ) {
            applyHTML( resp, cur );
        } );
    } );
}

function applyLocalStorage() {
    if ( !localStorage ) {
        return;
    }
    var i = 0;
    titles = localStorage.getItem( 'titles' ) ? JSON.parse( localStorage.getItem( 'titles' ) ) : possibles.map( function ( cur ) {
        return cur[ 0 ];
    } );
    selected = localStorage.getItem( 'selected' ) ? JSON.parse( localStorage.getItem( 'selected' ) ) : possibles.map( function () {
        return i++;
    } );

};
$( document ).ready( function () {
    //http://www.nws.noaa.gov/om/marine/atlantic.htm
    applyLocalStorage();
    loadData();
    ract = new Ractive( {
        el: "#settings",
        template: "#template",
        data: function(){

            return {
                location: titles.slice( 0 ),
                poss: possibles.slice( 0 ),
                selectd: possibles.map(function( cur,i ) {
                    return ( selected.indexOf( i ) > -1 );
                })
            };
        },
        oninit: function () {
            this.observe( "location", function ( newVal, oldVal, obj ) {
                if ( !localStorage ) {
                    return;
                }
                localStorage.setItem( 'titles', JSON.stringify( newVal ) );
            } );
            this.observe( "selectd", function ( newVal, oldVal, obj ) {
                if ( !localStorage || !oldVal ) {
                    return;
                }
                var arr = possibles.map(function( cur,i) {
                    return newVal[ i ] ? i : undefined;
                }).filter(function(cur){
                    return cur!==undefined;
                });
                localStorage.setItem( 'selected', JSON.stringify( arr ) );
                selected=arr;
            } );
        }
    } );
    $( "#toSettings" ).click( function ( e ) {
        e.preventDefault();
        if ( $( "#settings" ).hasClass( "hidden" ) ) {
            $( "#settings" ).removeClass( "hidden" );
            $( "#hook" ).addClass( "hidden" );

        } else {
            $( '#hook' ).empty();
            loadData();
            $( "#hook" ).removeClass( "hidden" );
            $( "#settings" ).addClass( "hidden" );
        }
    } );
} );
    </script>
</body>

</html>