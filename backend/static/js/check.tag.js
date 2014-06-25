String.prototype.Trim = function() { 
return this.replace(/(^\s*)|(\s*$)/g, ""); }
/*
 *检查标签是否为空
 */
 function check_tag_name(){
 var tag_name;
 tag_name = document.getElementById('tag_name').value;
 tag_name = tag_name.Trim();
 if (tag_name == "") {
  document.getElementById('tag_name_error').innerHTML = "请输入标签名称";
  } else {
	document.getElementById('tag_name_error').innerHTML = "";
  }  
 }
 function check_tag(){
 var tag;
 tag = document.getElementById('tag').value;
 tag = tag.Trim();
 if (tag == "") {
  document.getElementById('tag_error').innerHTML = "请输入标签标示";
  } else {
  document.getElementById('tag_error').innerHTML = "";
  }
 }
 //----------------------------------------------------------------------------------------------------------------
 function regist(){
 var tag_name_error		=document.getElementById('tag_name_error').innerHTML;
 var tag_error			=document.getElementById('tag_error').innerHTML;
 var tag_name			=document.getElementById('tag_name').value;   
 var tag				=document.getElementById('tag').value;   
 //判断错误信息全部为空并且文本框全部不为空
 if ((tag_name_error == "" && tag_error == "")&&(tag_name != "" && tag != "")) {
  
  } else {
   alert ("推荐信息填写错误，请仔细检查更正后再提交");
   return false;
   }
 }    