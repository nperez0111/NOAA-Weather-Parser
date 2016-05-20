<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NOAA Weather ForeCast</title>
    <link rel="stylesheet" type="text/css" href="main.css">
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
    <script src="main.js"></script>
</body>

</html>