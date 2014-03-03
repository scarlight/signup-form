var cs = jQuery.noConflict();

cs(document).ready(function(){

    var doc = document.documentElement;
    doc.setAttribute('data-useragent', navigator.userAgent);

    var COMPANYNAME_form = {

        config: {
            form: "#COMPANYNAME-contactform #contactform",
            responce: "#responce",
            submit_btn: "#submit",
            reset_btn: "#reset",
            form_action_url: "",
            validate_obj: "",
            recaptcha: "true",
            recaptcha_color: "white"
        },

        //anything inside captcha-ajax gets cleared on page load
        showRecaptcha: function(element){
            Recaptcha.create("GET_THE_PUBLIC_KEY_HERE >> HTTPS://WWW.GOOGLE.COM/RECAPTCHA/ADMIN/CREATE", element, {
                theme: this.config.recaptcha_color
            });
        },

        showResponse: function(data){
            this.unlock_form();
            this.clear_error_msg();

            if(typeof data.success == "string"){
                 cs(this.config.form).slideUp({
                    duration:700,
                    easing:"easeOutQuad",
                    complete:function(){
                        cs(this.config.responce).find("p").removeClass("error").fadeOut(0).append(data.success).fadeIn(1000);
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
                                cs(this.config.form).find("#"+k).val(nv);
                            }
                            else{
                                //apply error label
                                cs(this.config.form).find("#"+k).parent().append("<label class=\'error\'>"+nv+" </label>");

                                if(k == "captcha-test"){
                                    Recaptcha.reload();
                                    //validation check to get out jumpy focus due to captcha reload
                                    cs(this.config.form).find("#recaptcha_response_field").on("focusin focusout", function(){
                                        cs(this).val("").off("focusin focusout").trigger("blur").on("focusout", function(){
                                            cs(this).parents("#"+k).siblings("label.error").remove();
                                        });;
                                    });
                                }
                                else{
                                    cs(this.config.form).find("#"+k).on("focusin", function(){
                                        cs(this).siblings("label.error").remove();
                                    });
                                }


                            }
                            if(nk == "bad-form" || nk == "bad-submit"){
                                if(cs(this.config.responce).find("p.error").length > 0){
                                    cs(this.config.responce).find("p").append(nv);
                                }
                                else{
                                    cs(this.config.responce).find("p").addClass("error").append(nv);
                                }
                            }
                        });
                    }
                });
            }
        },

        validate_form: function(){
            this.config.validate_obj = cs(this.config.form).validate({
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
                        required:"Please enter a name.",
                        minlength:"Name minimum 3 letters."
                    },
                    phone:{
                        required:"Please enter a contact number.",
                        digits:"Only digits allowed.",
                        maxlength:"Phone number incorrect length."
                    },
                    email:{
                        required:"Please provide an email.",
                        email:"Please provide a valid email."
                    },
                    message:{
                        required:"Please provide your feedback.",
                        maxlength:"Message exceeds 300 character."
                    },
                    recaptcha_response_field:{
                        required:"Please enter captcha."
                    }
                },
                errorPlacement: function(error, element) {
                    error.prependTo( element.parent() )
                },
                submitHandler: function(form){
                    COMPANYNAME_form.lock_form();
                    var options = {
                        success: showResponse,
                        url: COMPANYNAME_form.config.form_action_url,
                        type: "post",
                        dataType: "json",
                        clearForm: true,
                        resetForm: true
                    };
                    cs(form).ajaxSubmit(options);
                }
            });
        },

        lock_form: function(){
            cs(this.config.submit_btn).attr("disabled","disabled");
            cs(this.config.form).find("label").addClass("processing");
        },

        unlock_form: function(){
            cs(this.config.submit_btn).removeAttr("disabled");
            cs(this.config.form).find("label").removeClass("processing");
        },

        reset_form: function(){
            this.config.validate_obj.resetForm();// validates own reset function
            this.clear_error_msg();
            this.unlock_form();
        },

        clear_error_msg: function(){
            cs(this.config.responce).find("p").removeClass("error").text("");
            cs(this.config.form).find("label.error").remove();
        },

        init: function(){
            if(cs(this.config.form).length > 0){

                this.config.form_action_url = cs(this.config.form).attr("action");
                cs(this.config.form).attr("action", "#");

                if(this.config.recaptcha){
                    this.showRecaptcha("captcha-test");
                }

                this.validate_form();

                cs(this.config.reset_btn).click(function(){
                   COMPANYNAME_form.reset_form();
                });

            }
        }
    }

    COMPANYNAME_form.init();

    cs(window).load(function(){

        // code goes here when window has finish loading

    });

});