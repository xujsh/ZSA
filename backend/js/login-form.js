$(function(){
	$("#password").blur(function(){
		password=$("#password").val();
		if(password==''){
			alert('密码必填');
			$("#password").focus();
			return false;
		}
	});
	$("#repassword").blur(function(){
		repassword=$("#repassword").val();
		if(repassword==''){
			alert('填写确认密码');
			$("#repassword").focus();
			return false;
		}
		if(repassword!==password){
			alert('两次密码不一致');
			return false;
		}
	});
	
})
	
	function register(){
		var username	=$('#username').val();
		var password	=$('#password').val();
		var repassword	=$('#repassword').val();
		var email		=$('#email').val();
		if(username==""){
			alert('用户名不能为空');
			document.getElementById("links").href="javascript:void(0)";
			return false;
		}else if(password==''){
			alert('密码不能为空');
			document.getElementById("links").href="javascript:void(0)";
			return false;
		}else if(repassword==''){
			alert('确认密码');
			document.getElementById("links").href="javascript:void(0)";
			return false;
		}else if(email==''){
			alert('邮箱不能为空');
			document.getElementById("links").href="javascript:void(0)";
			return false;
		}else{
			document.getElementById("links").href="javascript:form1.submit();";
		}	
		
	}
	function sub(){
		var name	=$('#username').val();
		var password=$('#password').val();
		if(name==""){
			alert('用户名不能为空');
			document.getElementById("links").href="javascript:void(0)";
			return false;
		}else if(password==''){
			alert('密码不能为空');
			document.getElementById("links").href="javascript:void(0)";
			return false;
		}else{
			document.getElementById("links").href="javascript:form1.submit();";
		}	
	}