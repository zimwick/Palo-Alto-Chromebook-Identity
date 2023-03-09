function sendPayload() {
  chrome.enterprise.networkingAttributes.getNetworkDetails(function(details) {
    let ipAddress = details.ipv4;

    chrome.identity.getProfileUserInfo(function(userInfo) {
      let username = userInfo.email;
		
		//making sure device has an ip and username before sending payload
      if (ipAddress && username) {
        var payload = {
          'ips': ipAddress,
          'username': username
        };

        // Make the API call
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'https://<webserverhere>/index.php');
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.send(JSON.stringify(payload));
      }
    });
  });
}

chrome.runtime.getPlatformInfo(function(info) {
  if (info.os === "cros") {
    // If it's a Chromebook, run the sendPayload function
    sendPayload();

    // Refresh and send the payload every 10 minutes
    setInterval(function() {
      sendPayload();
    }, 10 * 60 * 1000); // 10 minutes in milliseconds
  }
});
