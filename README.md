# Palo-Alto-Chromebook-Identity
Introduction:

This is a professional-grade Chrome extension designed to help IT professionals manage identity in a managed Chromebook environment. The extension collects the IP address of a Chromebook and the signed-in user and then posts it to a webserver hosting PHP. After that, the PHP will post the IP and username to a Palo Alto firewall API to log the identity and match it with traffic.

Installation:

To use this chrome extension, you need a webserver with PHP already configured and running. This extension is designed to work on IIS with PHP version 8.0, but it should work on other versions as well. Make sure you have a URL that can hit the PHP.index file such as https://mytesturl.com/index.php

Configuration:

In the index.php file, go to line 29 and enter the URL of your Palo Alto firewall, such as https://10.10.10.10/api/?type=user-id. Then, on line 30, enter your Palo Alto API key. You can find the documentation for obtaining the API key here: https://docs.paloaltonetworks.com/pan-os/9-1/pan-os-panorama-api/get-started-with-the-pan-os-xml-api/get-your-api-key. You can also obtain it directly from the browser if you are comfortable with that. That is all you need to do for the index.php file.

Next, open your background.js file and go to line 17. Enter the URL that points to the PHP file such as https://mytesturl.com/index.php.

Then, open the manifest.json file and change Logo.png to whatever picture you want to use for your Chrome extension on line 13. On line 20, change it to another picture you want to use; the one on line 20 is your bigger logo, and the one on line 13 is the smaller icon.

Make sure you have the popup.html, manifest.json, background.js, and the two logo files you want to use in one folder. Do not include the PHP file in that folder. Then, zip the folder and upload it to Chrome Webstore developer dashboard. Once it's approved, you must force the app to be pushed to a Chromebook; otherwise, the API calls will not work. That is all. You should start seeing the log.log file getting generated in the webserver folder where the PHP file is, and identities should start getting mapped in the Palo Alto firewall.

Notes:

This is a Chrome extension that uses API calls that only work in a managed Chromebook environment. This means you must have the ability to force push this app to Chromebooks; otherwise, it will not work. If you try to install this extension manually to test, for example, it will not pull the IP or username.

Credits:

This extension was created by Zimwick (https://github.com/zimwick), an IT professional with extensive experience in managing identity in a Chromebook environment. Zimwick created this extension to address a common need in the IT industry and has generously made it available on GitHub for others to use and modify.

License:

This extension is licensed under the MIT License (https://opensource.org/licenses/MIT), which allows anyone to use, modify, and distribute the extension as long as they include the original copyright notice and disclaimer.
