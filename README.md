NOAA-Weather-Parser
================================

What it does
------------

This set of php files parses down each NOAA Location and returns cleaner HTML output of the weather at that location. This uses more semantic tags and classes to hook onto so it may be skinnable.

What it is
----------

This is a project I made to make it easier to read the oceanagraphic test forecast provided by NOAA. So this project uses PHP to parse the text file into HTML which is then loaded into the shell to populate the forecast of each specified location in South Florida. This can easily be expanded to include other locations. For reference to the source material, see this.

Also the dark mode is pretty rad at night.

Technical Aspects
-----------------

`getDay.php` parses a single day off of the url `http://weather.noaa.gov/cgi-bin/fmtbltn.pl?file=forecasts/marine/coastal/am/LOCATION.txt` where `LOCATION` is a valid NOAA Location. As specified in [here](http://www.nws.noaa.gov/om/marine/atlantic.htm).

Such as `http://weather.noaa.gov/cgi-bin/fmtbltn.pl?file=forecasts/marine/coastal/am/amz670.txt`

The returned HTML will have split the file and parsed it giving it semantic markup and hooks for CSS to be applied. 

My Implemenation
----------------

`index.html` uses RactiveJS as a templating library to handle the settings view and stores any settings into localstorage. It loads each day and appends the resultant HTML Fragment to the page and is slightly styled with CSS.
