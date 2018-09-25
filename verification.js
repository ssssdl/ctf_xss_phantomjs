var webPage = require('webpage');
var page = webPage.create();
var postBody = 'id=1';
var url = 'http://127.0.0.1/verification.php'
var system = require('system');
if (system.args.length === 1) {
    //console.log('Try to pass some args when invoking this script!');
    phantom.exit();
} else {
    system.args.forEach(function (arg, i) {
	    if(i === 1){
            postBody = 'id='+ atob(arg);
	    }
        if(i ===2 ){
            url = atob(arg);
        }
    });
}

page.open(url,'POST',postBody,function(status) {
	//console.log('Status: ' + status);//获取加载消息
	//console.log(page.content);//获取页面内容
	//page.render('aa.png');//获取屏幕截图
	phantom.exit();
	});
page.onAlert = function(msg) {//获取alert弹窗消息
	console.log(msg);
};
