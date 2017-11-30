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
        var title = page.evaluate(function() {
            // return document.documentElement.innerHTML;
            return document.getElementsByTagName("iframe")[0].getAttribute("src");
        });
	    console.log(title);
    }
    phantom.exit();
});
}

