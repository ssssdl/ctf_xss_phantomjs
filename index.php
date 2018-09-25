<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    	<title>owasp漏洞排行</title>
</head>
<body>
	<div align="center">
	<h1>owasp 2017年安全漏洞 top_10</h1>
	<hr>
	<form action="" method="post">
		排名:
		<input type="text" name="id" value="1">
		<input type="submit" value="搜索">
	</form>
	<br>
<?php
    error_reporting(0);
	//接收参数
    function waf_xss($msg){
			$black_str = "/(script|[<]|[>])/i";
			$msg = preg_replace($black_str,"",$msg);
			if(preg_match($black_str, $msg)){
				$msg = Injection($msg);
				return $msg;
			}
			return $msg;
		}
	if(isset($_POST['id'])){
		$_key =  $_POST['id'];
	}else{
		$_key =  "1";
	}
	//迷惑+提示
	$_key =  preg_replace('/(and|order|or|union|select|sleep|substr|by|where|from)/i', "", $_key);//不涉及注入  单次过滤
	switch($_key){
		case "1":
			$_title = 'Injection';
			$_content = 'Injection flaws, such as SQL, NoSQL, OS, and LDAP injection, occur when untrusted data is sent to an interpreter as part of a command or query. The attacker‘s hostile data can trick the interpreter into executing unintended commands or accessing data without proper authorization.';
			break;
		case "2":
			$_title = 'Broken Authentication';
			$_content = 'Application functions related to authentication and session management are often implemented incorrectly, allowing attackers to compromise passwords, keys, or session tokens, or to exploit other implementation flaws to assume other users‘ identities temporarily or permanently.';
			break;
		case "3":
			$_title = 'Sensitive Data Exposure';
			$_content = 'Many web applications and APIs do not properly protect sensitive data, such as financial, healthcare, and PII. Attackers may steal or modify such weakly protected data to conduct credit card fraud, identity theft, or other crimes. Sensitive data may be compromised without extra protection, such as encryption at rest or in transit, and requires special precautions when exchanged with the browser.';
			break;
		case "4":
			$_title = 'XML External Entities (XXE)';
			$_content = 'Many older or poorly configured XML processors evaluate external entity references within XML documents. External entities can be used to disclose internal files using the file URI handler, internal file shares, internal port scanning, remote code execution, and denial of service attacks.';
			break;
		case "5":
			$_title = 'Broken Access Control';
			$_content = 'Restrictions on what authenticated users are allowed to do are often not properly enforced. Attackers can exploit these flaws to access unauthorized functionality and/or data, such as access other users‘ accounts, view sensitive files, modify other users’ data, change access rights, etc.';
			break;
		case "6":
			$_title = 'Security Misconfiguration';
			$_content = 'Security misconfiguration is the most commonly seen issue. This is commonly a result of insecure default configurations, incomplete or ad hoc configurations, open cloud storage, misconfigured HTTP headers, and verbose error messages containing sensitive information. Not only must all operating systems, frameworks, libraries, and applications be securely configured, but they must be patched/upgraded in a timely fashion.';
			break;
		case "7":
			$_title = 'Cross-Site Scripting (XSS)';//这里可以加一些提示  alert key 标为红色
			$_content = 'XSS fl<font color="red">a</font>ws occur whenever an app<font color="red">l</font>ication includ<font color="red">e</font>s unt<font color="red">r</font>usted da<font color="red">t</font>a in a new web page without proper validation or escaping, or updates an existing web page with user-supplied data using a browser API that can create HTML or JavaScript. XSS allows attac<font color="red">k</font>ers to <font color="red">e</font>xecute scripts in the victim‘s browser which can hijack <font color="red">y</font>our sessions, deface web sites, or redirect the user to malicious sites.';
			break;
		case "8":
			$_title = 'Insecure Deserialization';
			$_content = 'Insecure deserialization often leads to remote code execution. Even if deserialization flaws do not result in remote code execution, they can be used to perform attacks, including replay attacks, injection attacks, and privilege escalation attacks.';
			break;
		case "9":
			$_title = 'Using Components with Known Vulnerabilities';
			$_content = 'Components, such as libraries, frameworks, and other software modules, run with the same privileges as the application. If a vulnerable component is exploited, such an attack can facilitate serious data loss or server takeover. Applications and APIs using components with known vulnerabilities may undermine application defenses and enable various attacks and impacts.';
			break;
		case "10":
			$_title = 'Insufficient Logging&Monitoring';
			$_content = 'Insufficient logging and monitoring, coupled with missing or ineffective integration with incident response, allows attackers to further attack systems, maintain persistence, pivot to more systems, and tamper, extract, or destroy data. Most breach studies show time to detect a breach is over 200 days, typically detected by external parties rather than internal processes or monitoring.';
			break;
		default:
			//匹配alert没有的话输出查找的漏洞不存在 过滤 输入到phantomjs判断是否可以弹窗
			if(preg_match('/alert/i', $_key)){
				//过滤$_key
				//$_key = preg_replace('/(script|iframe|img|src|onerror|var|onmouseover|javascript|onsubmit|confirm)/i', "", $_key);//最简单 过滤一次关键字script等关键字直接重写就可以绕过
                $_key = waf_xss($_key);
                $_url = 'http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER["SERVER_PORT"].'/owasp/verification.php';
                //echo $_url;
				exec('phantomjs --output-encoding=utf8 verification.js '.base64_encode(iconv('utf-8','gbk',$_key)).' '.base64_encode(iconv('utf-8','gbk',$_url)),$output_main);//base64加密防命令执行
				if(count($output_main)){
					if($output_main[0]==="key"){
						$_title = 'you are right!! Come on';
						$_content = 'flag{G0_gEt_morE_f1AG!}';
					}else{
						$_title = 'Cross-Site Scripting (XSS)<!--差一点细心-->';
						$_content = 'XSS fl<font color="red">a</font>ws occur whenever an app<font color="red">l</font>ication includ<font color="red">e</font>s unt<font color="red">r</font>usted da<font color="red">t</font>a in a new web page without proper validation or escaping, or updates an existing web page with user-supplied data using a browser API that can create HTML or JavaScript. XSS allows attac<font color="red">k</font>ers to <font color="red">e</font>xecute scripts in the victim‘s browser which can hijack <font color="red">y</font>our sessions, deface web sites, or redirect the user to malicious sites.';
					}
				}else{//有alert 但没绕过
					$_title = 'Cross-Site Scripting (XSS)';
					$_content = 'XSS fl<font color="red">a</font>ws occur whenever an app<font color="red">l</font>ication includ<font color="red">e</font>s unt<font color="red">r</font>usted da<font color="red">t</font>a in a new web page without proper validation or escaping, or updates an existing web page with user-supplied data using a browser API that can create HTML or JavaScript. XSS allows attac<font color="red">k</font>ers to <font color="red">e</font>xecute scripts in the victim‘s browser which can hijack <font color="red">y</font>our sessions, deface web sites, or redirect the user to malicious sites.';
				}
			}else{
				$_title = 'Not Found';
				$_content = 'The requested content was not found on this server.';
			}
			break;
	}
	echo '<h3>您搜索的是排名第<a id="search"></a>的漏洞：</h3>';
	echo '<table border="1" width="400"><tr><th>'.$_title.'</th></tr>';
	echo '<tr><td>'.$_content.'</td></tr></table>';
    echo '<script>'."\n";
    echo 'var s=\''.$_key.'\';'."\n";
    echo 'document.getElementById(\'search\').innerHTML = s;';
    echo '</script>'."\n";

?>
	<br>
	<br>
	&copy; DLNUCTF 2018.
	<a href="http://R-web.github.io/" title="R-Web网络安全团队">R-Web网络安全团队</a>
	</div>
</body>
</html>
