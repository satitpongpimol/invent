function login_validate(){
	var txtuser = document.forms["frmLogin"]["txtusername"];
	// var txtpass = document.forms["frmLogin"]["txtpassword"];
	if(txtuser.value == ''){
		txtuser.focus();
		return false;
	}
	/*else if(txtpass.value == ''){
		txtpass.focus();
		return false;
	}*/
	return true;
}
function Login_setfocus(){
	var txtuser = document.forms["frmLogin"]["txtusername"];
	txtuser.focus();
}
function form_setfocus(form_name,index){
	var frm = document.forms[form_name];
	var txt = frm.elements;
	for(i=0;i<index;i++){
		txt[index].setAttribute("readonly","readonly");
	}
	txt[index].focus();
}
function validate_empty(frm){
    var txt = frm.elements[0];
    if(txt.value == ''){
        txt.focus();
        return false;
    }
    return true;
}