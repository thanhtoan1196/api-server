// Example using HTTP POST operation

"use strict";
var page = require('webpage').create(),
	system = require('system'),
    server = 'http://m4ufree.com/ajax_new.php',
    data;

	data = 'm4u=' + system.args[1];
if (system.args.length === 1) {
    console.log('Usage: loadspeed.js <some URL>');
    phantom.exit(1);
} else {
	page.open(server, 'post', data, function (status) {
    if (status !== 'success') {
        console.log('Unable to post!');
    } else {
        var title = 'undefined';
        title = page.evaluate(function() {
            // return document.documentElement.innerHTML;
            return document.getElementsByTagName("iframe")[0].getAttribute("src");
        });
        if (!isEmpty(title)) {
            var data = '[ {"file": "view.php?v=CxcXExBZTEwQFwwRAgQGTQQMDAQPBgITChBNAAwOTAYWEQwTBk4UBhAXUlNNAhMTEBMMF00ADA5MCwwATCACEwZNJQYCEU1SWlVRTVRRUxNNIQ8WMQIaTStRVVdNIiIgTjEiMSEkTQ4TVw==","type": "mp4", "label": "Link was died"}]';
            console.log(data);
        } else {
    		title = page.evaluate(function() {
    			// return document.documentElement.innerHTML;
    			return document.getElementsByTagName("script")[5].innerHTML;
    		});
            // title = 'undefined';
            if (isEmpty(title)) {
                console.log('undefined');
            } else if (title.indexOf("undefined") >= 0) {
                console.log(title);
            } else {
        		var content = title.split("\n");
                console.log(content[3].replace("view.php", "http://m4ufree.com/view.php"));
            }
        }
    }
    phantom.exit();
});
}

function isEmpty(value){
  return (value == null || value.length === 0);
}

