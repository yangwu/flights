<?PHP
//引入PHPMailer的核心文件 使用require_once包含避免出现PHPMailer类重复定义的警告
include_once dirname ( '__FILE__' ) . '/PHPMailerAutoload.php';
include_once dirname ( '__FILE__' ) . '/db/DBHelper.php';

class mailHelper{
	
	
	function sendMail($sendAddress,$sendSubject,$sendBody){
		//示例化PHPMailer核心类
		$mail = new \PHPMailer();
		
		//是否启用smtp的debug进行调试 开发环境建议开启 生产环境注释掉即可 默认关闭debug调试模式
		//$mail->SMTPDebug = 1;
		
		//使用smtp鉴权方式发送邮件，当然你可以选择pop方式 sendmail方式等 本文不做详解
		//可以参考http://phpmailer.github.io/PHPMailer/当中的详细介绍
		$mail->isSMTP();
		//smtp需要鉴权 这个必须是true
		$mail->SMTPAuth=true;
		//链接qq域名邮箱的服务器地址
		$mail->Host = 'smtp.qq.com';
		//设置使用ssl加密方式登录鉴权
		$mail->SMTPSecure = 'ssl';
		//设置ssl连接smtp服务器的远程服务器端口号 可选465或587
		$mail->Port = 465;
		//设置smtp的helo消息头 这个可有可无 内容任意
		//$mail->Helo = 'Hello smtp.qq.com Server';
		//设置发件人的主机域 可有可无 默认为localhost 内容任意，建议使用你的域名
		$mail->Hostname = 'wishconsole.com';
		//设置发送的邮件的编码 可选GB2312 我喜欢utf-8 据说utf8在某些客户端收信下会乱码
		$mail->CharSet = 'UTF-8';
		//设置发件人姓名（昵称） 任意内容，显示在收件人邮件的发件人邮箱地址前的发件人姓名
		$mail->FromName = 'wishconsole administrator';
		//smtp登录的账号 这里填入字符串格式的qq号即可
		$mail->Username ='409326210';
		//smtp登录的密码 这里填入“独立密码” 若为设置“独立密码”则填入登录qq的密码 建议设置“独立密码”
		$mail->Password = 'jetxgtzqqdincbda';
		//设置发件人邮箱地址 这里填入上述提到的“发件人邮箱”
		$mail->From = 'admin@wishconsole.com';
		//邮件正文是否为html编码 注意此处是一个方法 不再是属性 true或false
		$mail->isHTML(true);
		//设置收件人邮箱地址 该方法有两个参数 第一个参数为收件人邮箱地址 第二参数为给该地址设置的昵称 不同的邮箱系统会自动进行处理变动 这里第二个参数的意义不大
		$mail->addAddress($sendAddress,$sendAddress);
		//添加多个收件人 则多次调用方法即可
		//$mail->addAddress('hongliang5301@163.com','WishConsole');
		//添加该邮件的主题
		$mail->Subject = $sendSubject;
		//添加邮件正文 上方将isHTML设置成了true，则可以是完整的html字符串 如：使用file_get_contents函数读取本地的html文件
		$mail->Body = $sendBody;
		//为该邮件添加附件 该方法也有两个参数 第一个参数为附件存放的目录（相对目录、或绝对目录均可） 第二参数为在邮件附件中该附件的名称
		//$mail->addAttachment('./d.jpg','mm.jpg');
		//同样该方法可以多次调用 上传多个附件
		//$mail->addAttachment('./Jlib-1.1.0.js','Jlib.js');
		
		
		//发送命令 返回布尔值
		//PS：经过测试，要是收件人不存在，若不出现错误依然返回true 也就是说在发送之前 自己需要些方法实现检测该邮箱是否真实有效
		return $mail->send();
	}
	
	function sendMailResetPsd($sendAddress){
		$dbhelper = new DBHelper();
		$userResult = $dbhelper->queryUser("", $sendAddress);
		$userArray = mysql_fetch_array ( $userResult );
		
		if($userArray == null || $userArray['id'] == null){
			header ( "Location:./reset.php?errorMsg=不存在此邮箱，请重新输入" );
			exit ();
		}
		
		$token = uniqid().strtotime ( date ( 'Y-m-d  H:i:s' ) );
		$dbhelper->removeResetToken($userArray['id']);
		$dbhelper->insertResetToken($userArray['id'], $token);
		$url = "https://www.wishconsole.com/flights/reset.php?t=".$token;
		
		
		$subject = '重置密码';
		//添加邮件正文 上方将isHTML设置成了true，则可以是完整的html字符串 如：使用file_get_contents函数读取本地的html文件
		$body = "尊敬的会员，您好：<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;请点击下面的链接，在新开的页面中重新设置您的密码：<br/><a href='".$url."'>".$url."</a><br/>如果有任何问题， 可以直接回复该邮箱地址请求技术支持。";
		
		return $this->sendMail($sendAddress, $subject, $body);
	}
	
	function sendMailActiveAccount($address,$username) {
		$subject = "欢迎来到Wish管理助手-更有效率的Wish商户实用工具";
		$body = "<br/>尊敬的会员".$username.",您好：<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;欢迎使用Wish管理助手，我们目前开放了产品上传功能，后续其他更多功能也会逐步开放。如果您在使用过程中有什么疑问，可参考帮助文档。<br/>也欢迎您能提供宝贵的意见和建议，可直接与我们联系，邮箱地址：admin@wishconsole.com.";
		return $this->sendMail($address, $subject, $body);
	}
}
?>