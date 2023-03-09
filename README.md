# Palo-Alto-Chromebook-Identity
This is a chrome extension that will grab the ip of the chrome book and the signed in user, it will then post this to a webserver hosting php. From there the php will post the ip and username to a palo alot firewall api so that it can log the identity to match with traffic.

First you will need a webserver with php already confifured and running. I have this set to run on IIS with php version 8.0 I cannot gauarntee if it will work on other versions but I assume it will.

Make sure you have a url that can hit the php.index file so like https://mytesturl.com/index.php

in the index.php file go to line 29 and put in the url of your plao alto firewall such as https://10.10.10.10/api/?type=user-id
then on line 30 enter in the palo alto api key. Palo alto has documentation on how to get the api key. 
thats it for the index.php file.

Next open your background.js file and go to line 17 and enter in the url that points to the php file such as https://mytesturl.com/index.php

open the mainfest.json file and change the Logo.png to whatever picture you want to use for your chrome extension this on line 13
then on line 20 change that to another picture you want to use, the one on line 20 is your bigger logo, the one on line 13 is the samller icon.

make sure you have the popup.html, manifest.json, background.js and the 2 logo files you want to use all in one folder, do not include the php file in that folder.
Then zip the folder up and you can upload it to chrome webstore developer dashboard, and once its improved you must force the app to be pushed to a chromebook otherwise the api calls will not work. that is is, you should start seeing log.log file get generated on the webserver folder where the php file is and you should start seeing identities getting mapped in the palo alto firewall.

NOTES

this is a chrome extensoin and is using api calls that will only work in a managed chromebook environment. This means you have to have the ability to force push this app to chromebookes, that is the only way it will work. If you try and just install this extension manually to test for example it will not pull the ip or username.
