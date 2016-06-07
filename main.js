var locs,
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
Ractive.DEBUG = false;

function applyHTML( resp, i ) {
    return ( "<div class='loc'><div><h1>" + titles[ i ] + "</h1></div>" + resp + "</div>" );
}

function loadData() {
    Promise.all( selected.map( function ( cur, i ) {
        return $.get( "getDay.php?loc=" + possibles[ cur ][ 1 ] );
    } ) ).then( function ( resp ) {
        var allDays = resp.map( applyHTML ).reduce( function ( a, b ) {
            return a + b;
        }, "" );
        $( '#hook' ).append( allDays );
    } );;
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

}
$( document ).ready( function () {
    //http://www.nws.noaa.gov/om/marine/atlantic.htm
    applyLocalStorage();
    loadData();
    ract = new Ractive( {
        el: "#settings",
        template: "#template",
        data: function () {

            return {
                darkMode: false,
                location: titles.slice( 0 ),
                poss: possibles.slice( 0 ),
                selectd: possibles.map( function ( cur, i ) {
                    return ( selected.indexOf( i ) > -1 );
                } )
            };
        },
        oninit: function () {
            this.observe( "location", function ( newVal ) {
                if ( !localStorage ) {
                    return;
                }
                localStorage.setItem( 'titles', JSON.stringify( newVal ) );
            } );

            this.observe( "darkMode", function ( newVal, oldVal ) {
                if ( !( oldVal == undefined ) ) {
                    if ( newVal ) {
                        $( 'body' ).addClass( "dark" );
                    } else {
                        $( 'body' ).removeClass( 'dark' );
                    }
                    if ( !localStorage ) {
                        return;
                    }
                    localStorage.setItem( 'darkMode', JSON.stringify( newVal ) );
                }
            } );

            this.observe( "selectd", function ( newVal, oldVal ) {
                if ( !localStorage || !oldVal ) {
                    return;
                }
                var arr = possibles.map( function ( cur, i ) {
                    return newVal[ i ] ? i : undefined;
                } ).filter( function ( cur ) {
                    return cur !== undefined;
                } );
                selected = arr;
                if ( !localStorage ) {
                    return;
                }
                localStorage.setItem( 'selected', JSON.stringify( arr ) );
            } );

            if ( localStorage ) {
                var darkSetting = JSON.parse( localStorage.getItem( 'darkMode' ) );
                if ( darkSetting && darkSetting !== null ) {
                    this.set( "darkMode", false );
                    this.set( "darkMode", darkSetting );
                }

            }

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
