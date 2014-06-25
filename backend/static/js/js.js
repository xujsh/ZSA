$(document).ready(function() {
   $('#faq').find('dt').click(function() {
     $(this).next().slideToggle();
   });
}); 

function Pid(id,tag){
 if(!tag){
  return document.getElementById(id);
  }
 else{
  return document.getElementById(id).getElementsByTagName(tag);
  }
}
function tab_zzjs(id,hx,box,iClass,s,pr){
 var hxs=Pid(id,hx);
 var boxs=Pid(id,box);
 if(!iClass){
  boxsClass=boxs; 
 }
 else{ 
  var boxsClass = [];
  for(i=0;i<boxs.length;i++){
   if(boxs[i].className.match(/\btab\b/)){
    boxsClass.push(boxs[i]);
   }
  }
 }
 if(!pr){ 
  go_to(0); 
  yy();
 }
 else {
  go_to(pr);
  yy();
 }
 function yy(){
  for(var i=0;i<hxs.length;i++){
   hxs[i].temp=i;
   if(!s){
    s="onmouseover"; 
    hxs[i][s]=function(){
     go_to(this.temp);
    }
   }
   else{
    hxs[i][s]=function(){
     go_to(this.temp);
    }
   }
  }
 }
 function go_to(pr){
  for(var i=0;i<hxs.length;i++){
   if(!hxs[i].tmpClass){
    hxs[i].tmpClass=hxs[i].className+=" ";
    boxsClass[i].tmpClass=boxsClass[i].className+=" ";
   }
   if(pr==i){
    hxs[i].className+=" up"; 
    boxsClass[i].className+=" up"; 
   }
   else {
    hxs[i].className=hxs[i].tmpClass;
    boxsClass[i].className=boxsClass[i].tmpClass;
   }
  }
 }
}
tab_zzjs("tab_zzjs_1","h3","div","","onclick",2); tab_zzjs("tab_zzjs_2","h4","ol");tab_zzjs("tab_zzjs_3","h3","div","tab");

