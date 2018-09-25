<?php
	// 只用于验证 经过index.php过滤后的代码是否可以弹窗
	//验证不能使用index 会出现不断验证第归死循环
	if(isset($_POST['id'])){
		echo '<h3>您搜索的是排名第<a id="search"></a>的漏洞：</h3>';
        echo '<script>'."\n";
        echo 'var s=\''.$_POST['id'].'\';'."\n";
        echo 'document.getElementById(\'search\').innerHTML = s;';
        echo '</script>'."\n";
	}
?>
