
/**
*检查用户名

*/

String.prototype.Trim = function() { 
return this.replace(/(^\s*)|(\s*$)/g, ""); }
//---------------------------------------------------------------------------
/**
*检查标题是否为空
*
*/
function check_title(){
 var title;

 title = document.getElementById('title').value;
 title = title.Trim();
 if (title == "") {
  document.getElementById('title_error').innerHTML = "请输入标题";
  } else {
	document.getElementById('title_error').innerHTML = "";
  }
}
/**
*检查课程类型值
*等于0时 标示这个推荐是推荐一个课程
*这时 courseid 就是必填的
*等1时 就是一个普通的图文推荐  这时 courseid不填  url 字段为必填
*/
//---------------------------------------------------------------------------
function check_recommends(){
 var type;
 var url;
 var courseid;
 
 type  		= document.getElementById('type').value;
 courseid  	= document.getElementById('courseid').value;
 url  		= document.getElementById('url').value;
 type 		= type.Trim();

 if (type == 0 && courseid == "") {
	document.getElementById('courseid_error').innerHTML = "请输入课程ID";
  } else {
	document.getElementById('courseid_error').innerHTML = ""
  } 
  
  if (type == 1 && url == "") {
	document.getElementById('url_error').innerHTML = "请输入内容链接";
  } else {
	document.getElementById('url_error').innerHTML = ""
  }  
 }

//---------------------------------------------------------------------------
function regist(){
 var title_error		=document.getElementById('title_error').innerHTML;
 var courseid_error		=document.getElementById('courseid_error').innerHTML;
 var url_error			=document.getElementById('url_error').innerHTML;
 var type 				= document.getElementById('type').value;
 var title				=document.getElementById('title').value;   
 var courseid			=document.getElementById('courseid').value;   
 var url				=document.getElementById('url').value;  
 //判断错误信息全部为空并且文本框全部不为空
 
 if(type == 0){
	if ((title_error == "" && courseid_error == "")&&(title != "" && courseid != "")) {
  
	} else {
		alert ("推荐信息填写错误，请仔细检查更正后再提交");
		return false;
	}
 } else {

	if ((title_error == "" && url_error == "")&&(title != "" && url != "")) {
  
	} else {
		alert ("推荐信息填写错误，请仔细检查更正后再提交");
		return false;
	}
 }
 
 }       