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