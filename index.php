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
    <script src="main.js"></script>
</body>

</html>