<?php 
	


	 $to = "importsaeb@gmail.com";

	
	
	$subject = "Recebimento de Email";
	
$message =  "Contato via Site Lenigraf<br><br>"; 
$message .= utf8_decode ("Nome: ".$_POST['nome']."<br><br>");
$message .= utf8_decode ("E-mail: ".$_POST['email']."<br><br>");
$message .= utf8_decode ("Telefone: ".$_POST['telefone']."<br><br>");
$message .= utf8_decode ("Mensagem: ".$_POST['mensagem']."<br><br>");



$headers= "MIME-Version: 1.1\r\n";
$headers.= "content-type: text/html; charset=uft-8\r\n";
$headers.= "From:Site Lenigraf";



mail($to,$subject,$message,$headers);


?>






<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Contato | Contato</title>

<meta HTTP-EQUIV="REFRESH" CONTENT="3; URL=../index.html">



<style type="text/css">
body {
	background-repeat: repeat;
	background-image: url(../imagens/bg.jpg);
}

#containner {
	width: 980px;
	margin-right: auto;
	margin-left: auto;
}
#imagem {
	float: left;
	height: 150px;
	width: 975px;
	background-image: url(../imagens/fundo_msg.fw.png);
}
#imagem img {
	margin-left: 400px;
}
#iframe {
	width: 590px;
	margin-right: auto;
	margin-left: auto;
}
#imagem h1 {
	color: #000;
	font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
	font-size: 20px;
	text-align: center;
	float: left;
	margin-left: 80px;
	margin-top: 25px;
}
#imagem h2 {
	float: left;
	width: 980px;
	margin-left: 180px;
	color: #7EB325;
}
#imagem h3 {
	width: 400px;
	color: #0033CC;
	margin-right: auto;
	margin-left: 430px;
}
#imagem h3 a {
	color: #0066FF;
	text-decoration: none;
}
#imagem p {
	text-align: center;
}
#logotipo {
	float: left;
	margin-left: 0px;
	margin-top: 10px;
}
#like iframe {
	float: right;
	width: 100px;
	margin-top: -45px;
	margin-right: 150px;
}
</style>

</head>

<body>
<div id="containner">


<div id="imagem"><br />
  <h1>Obrigado <?php echo "$nome"; ?> por entrar em contato conosco , Em breve retornaremos o contato ! </h1>
  <h3> <a href="../index.html"> VOLTAR </a></h3>
  <div id="like"> 
   
  
  
  

</div>

</div>
</body>
</html>