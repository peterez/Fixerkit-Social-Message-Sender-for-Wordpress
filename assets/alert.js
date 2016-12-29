function isUrlValid(url) {
    return /^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(url);
}

function sendM() {

        element = document.getElementById('fixerkit_form');
        ret = validate(element);

       if(ret ==undefined) {
           sendData();
       } else {
           return false;
       }
}


function sendData(){
      var key = $('.forJs .key').html();
      var wrong = $('.forJs .wrong').html();
      var success = $('.forJs .success').html();
        $.ajax({
            cache:false,
            type:"POST",
            url:"http://fixerkit.com/developer/social/send?access_token="+key,
            data : $('#fixerkit_form').serialize(),
            error:function(){ apprise(wrong); },
            success:function(data){
                if(data=="ok") {
                    apprise(success);
                } else {
                    apprise(data);
                }

            }
        });

    }


    function deleteData(id) {
      var key = $('.forJs .key').html();
      var wrong = $('.forJs .wrong').html();
      var success = $('.forJs .success').html();
        $.ajax({
            cache:false,
            type:"GET",
            url:"http://fixerkit.com/developer/social/delete/"+id+"?access_token="+key,
            error:function(){ apprise(wrong); },
            success:function(data){
                if(data=="ok") {
                    apprise(success);
                    $('.li_'+id+' .bgRed').remove();
                    $('.li_'+id).attr("style","background:#ccc");
                } else {
                    apprise(data);
                }

            }
        });
    }


function validate(targetForm) {

    var EMAIL = "^[a-zA-Z0-9_-]+(\.([a-zA-Z0-9_-])+)*@[a-zA-Z0-9_-]+[.][a-zA-Z0-9_-]+([.][a-zA-Z0-9_-]+)*$"
    var URL = "http://"
    var DOMAIN =  /^[a-z0-9-\.]+\.[a-z]{2,4}/;

    for (var i = 0; i < targetForm.elements.length; i++) {
        if(targetForm.elements[i].getAttribute("strValue") != null) {
            var message = targetForm.elements[i].getAttribute("message");
            var strBound = targetForm.elements[i].getAttribute("strBound");
            var strVal = targetForm.elements[i].getAttribute("strValue");

            if(eval('document.' + strBound + '.type') == 'select-one') {
                var sIndex = eval('document.' + strBound + '.selectedIndex');
                var strBoundVal = eval('document.' + strBound + '[' + sIndex + '].value');
            }
            if(strVal == strBoundVal){
                if(targetForm.elements[i].value == '') {
                    apprise(message);
                    targetForm.elements[i].focus();
                    return false;
                }
            }

        }



        if(targetForm.elements[i].getAttribute("uyari")) {

            var message = targetForm.elements[i].getAttribute("message");

            if(targetForm.elements[i].type == 'checkbox') {
                if(!targetForm.elements[i].checked) {
                    apprise(message);
                    targetForm.elements[i].focus();
                    return false;
                }
            }
            else if(targetForm.elements[i].type == 'text' ||
                targetForm.elements[i].type == 'password' || targetForm.elements[i].type == 'file') {
                if(targetForm.elements[i].value == '') {
                    apprise(message);
                    targetForm.elements[i].focus();
                    return false;
                }

                if(targetForm.elements[i].getAttribute("regex") != null) {
                    var UserRegEx = targetForm.elements[i].getAttribute("regex");
                    var InputValue = targetForm.elements[i].value;

                    if(UserRegEx == 'EMAIL') {
                        var re = new RegExp(EMAIL);
                        if(!InputValue.match(re)) {
                            apprise(message);
                            targetForm.elements[i].focus();
                            return false;
                        }
                    }
                    else if(UserRegEx == 'URL') {
                        var re = new RegExp(URL);
                        if(!InputValue.match(re)) {
                            apprise(message);
                            targetForm.elements[i].focus();
                            return false;
                        }
                    }  else if(UserRegEx == 'DOMAIN') {
                        var re = new RegExp(DOMAIN);
                        if(!InputValue.match(re)) {
                            apprise(message);
                            targetForm.elements[i].focus();
                            return false;
                        }
                   }
                    else {
                        var re = new RegExp(UserRegEx);
                        if(!InputValue.match(re)) {
                            apprise(message);
                            targetForm.elements[i].focus();
                            return false;
                        }
                    }
                }
            }
            else if(targetForm.elements[i].type == 'select-one') {
                if(targetForm.elements[i].value == '') {
                    apprise(message);
                    targetForm.elements[i].focus();
                    return false;
                }
            }
            else if(targetForm.elements[i].type == 'textarea') {
                if(targetForm.elements[i].value == '') {
                    apprise(message);
                    targetForm.elements[i].focus();
                    return false;
                }
            }
            else if(targetForm.elements[i].type == 'radio') {
                var isSelected = false;
                var j = 0;
                while(targetForm.elements[i+j].type == 'radio' &&
                    targetForm.elements[i].name == targetForm.elements[i+j].name) {
                    if(targetForm.elements[i+j].checked) {
                        isSelected = true;
                    }
                    j++;

                }

                j = 0;

                while(targetForm.elements[i-j].type == 'radio' &&
                    targetForm.elements[i].name == targetForm.elements[i-j].name) {
                    if(targetForm.elements[i-j].checked) {
                        isSelected = true;
                    }

                    if(i-j <= 0) {
                        break;
                    }

                    j++;
                }

                if(!isSelected) {
                    apprise(message);
                    targetForm.elements[i].focus();
                    return false;
                }
            }
            else {
                return true;
            }
        }
    }
}