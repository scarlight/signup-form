var cs = jQuery.noConflict();

cs(document).ready(function(){

    var
        contact_form = cs("#contact-form"),
        responce = cs("#responce"),
        contact_submit = contact_form.find("#submit"),
        contact_reset = contact_form.find("#reset"),
        form_processor = contact_form.attr("action");

    contact_form.attr("action", "#");

    //anything inside captcha-ajax gets cleared on page load
    function showRecaptcha(element) {
        Recaptcha.create("GET_THE_PUBLIC_KEY_HERE >> HTTPS://WWW.GOOGLE.COM/RECAPTCHA/ADMIN/CREATE", element, {
            theme: "white"
        });
    }showRecaptcha("captcha-test");

    function lock_form(){
        contact_submit.attr("disabled","disabled");
        contact_form.find("label").addClass("processing");
    }

    function unlock_form(){
        contact_submit.removeAttr("disabled");
        contact_form.find("label").removeClass("processing");
    }

    function clear_error_msg(){
        responce.find("p").removeClass("error").text("");
        contact_form.find("label.error").remove();
    }

      //when dataType is not JSON
//    function showResponse(responseText, statusText, xhr, $form) {
//        if(statusText === "success"){
//            var delayResponce = setTimeout(function(){
//                unlock_form();
//                contact_form.slideUp({
//                    duration:1000,
//                    easing:"easeOutQuad",
//                    complete:function(){
//                        responce.fadeOut(0).append(responseText).fadeIn(1000);
//                        clearTimeout(delayResponce);
//                    }
//                });
//            }, 2000);
//        }
//        else{
//            responce.append("<p>Sorry, an error occured. Please try again later.<p>");
//        }
//    }

    function showResponse(data) {
        unlock_form();
        clear_error_msg();

        if(typeof data.success == "string"){
             contact_form.slideUp({
                duration:700,
                easing:"easeOutQuad",
                complete:function(){
                    responce.find("p").removeClass("error").fadeOut(0).append(data.success).fadeIn(1000);
                }
            });
        }
        else{
            //typicaly need to deserialize any string representation of JSON first to be javascript object to use .each
            //EG: cs.parseJSON({k:v}); in "data" parameter below, however "data" has already been deserialized
            //k=key; v=value; k now will be listed out via loop instead of me have to specify the key literally
            cs.each(data, function(k, v) {
                if(typeof v == "object"){
                    cs.each(v, function(nk, nv) {
                        if(nk == "fieldvalue"){
                            //works only for input type with textfield & not select,radio,password,checkbox and so on
                            contact_form.find("#"+k).val(nv);
                        }
                        else{
                            //apply error label
                            contact_form.find("#"+k).parent().append("<label class=\'error\'>"+nv+" </label>");

                            if(k == "captcha-test"){
                                Recaptcha.reload();
                                //validation check to get out jumpy focus due to captcha reload
                                contact_form.find("#recaptcha_response_field").on("focusin focusout", function(){
                                    cs(this).val("").off("focusin focusout").trigger("blur").on("focusout", function(){
                                        cs(this).parents("#"+k).siblings("label.error").remove();
                                    });;
                                });
                            }
                            else{
                                contact_form.find("#"+k).on("focusin", function(){
                                    cs(this).siblings("label.error").remove();
                                });
                            }


                        }
                        if(nk == "bad-form" || nk == "bad-submit"){
                            if(responce.find("p.error").length > 0){
                                responce.find("p").append(nv);
                            }
                            else{
                                responce.find("p").addClass("error").append(nv);
                            }
                        }
                    });
                }
            });
        }
    }

    var form1 = contact_form.validate({
        debug:false,

         //follow name attribute in form
        rules:{
            name:{
                required:true,
                minlength:3
            },
            phone:{
                required:true,
                digits:true,
                maxlength:12
            },
            email:{
                required:true,
                email:true
            },
            message:{
                required:true,
                maxlength:300
            },
            recaptcha_response_field:{
                required:true
            }
        },
        messages:{
            name:{
                required:"Please enter a name",
                minlength:"Name minimum 3 letters."
            },
            phone:{
                required:"Please enter a contact number.",
                digits:"Only digits allowed.",
                maxlength:"Phone number incorrect length"
            },
            email:{
                required:"Please provide an email.",
                email:"Please provide a valid email"
            },
            message:{
                required:"Please provide your feedback.",
                maxlength:"Message exceeds 300 character"
            },
            recaptcha_response_field:{
                required:"Please enter captcha."
            }
        },
        errorPlacement: function(error, element) {
            error.prependTo( element.parent() )
        },
        submitHandler: function(form){
            lock_form();

            var options = {
                success: showResponse,
                url: form_processor,
                type: "post",
                dataType: "json",
                clearForm: true,
                resetForm: true
            };

            cs(form).ajaxSubmit(options);
        }
    });

    contact_reset.click(function(){
        form1.resetForm();
        clear_error_msg();
        unlock_form();
    });

    cs(window).load(function(){
        // code goes here when window has finish loading

    });

});