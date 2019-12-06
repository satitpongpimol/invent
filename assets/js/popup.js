function ShowPopup(wnd_id,html_string,close_timeout) {
    var el = document.getElementById(wnd_id);
    var width = window.innerWidth||document.documentElement.clientWidth||document.body.clientWidth;
    var height = window.innerHeight||document.documentElement.clientHeight||document.body.clientHeight;
    el.innerHTML = html_string ;
    el.style.visibility = "visible";
    if(close_timeout > 0){
        setTimeout(function(){closePopup(wnd_id);}, close_timeout);
    }
}
function closePopup(wnd_id){
    var el = document.getElementById(wnd_id);
    el.innerHTML = '';
    el.style.visibility = "hidden";
    document.forms[0].elements[0].focus();
}

function ajax_login(frm){
    var url = frm.action;
    var user = frm.elements[0];
    var pass = frm.elements[1];
    event.preventDefault ? event.preventDefault() : (event.returnValue = false);
    postAjax(url,'txtusername='+user.value+'&txtpassword='+pass.value,function(data){
        var json = JSON.parse(data);
        if(json !== 'undefined' || json !== ''){
            if(json.status == 'Y'){
                closePopup('Wndpopup');
            }else{
                show_ajax_message(json);
                frm.elements[0].value='';
                frm.elements[0].focus();
            }
        }
    });
    return false;
}

function show_ajax_message(data){
    if('undefined'===data || data === null){
        return;
    }
    var ajax_msg_div = document.getElementById('ajax_message');
    if(ajax_msg_div){
        ajax_msg_div.innerHTML = data.message;
    }
}