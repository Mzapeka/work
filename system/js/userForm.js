/**
 * Created by Администратор on 09.11.15.
 */
$(document).ready(function(){

    var formOk;
    $("#sendForm").click(function(){
        window.formOk = true;
        $("#regForm input:text, #em").each(function(indx, element){
            /*var inputElement = $(element);
             var inputDiv = inputElement.parent();*/
            var checkInput = new CheckInput($(element), $(element).parent());
            checkInput.checkWrong();
            checkInput.checkSpan();
        });
        if (!window.formOk){
            return false;
        };
    });

    function CheckInput(inputElement, inputDiv, formOk){
        this.checkWrong = function(){
            if (inputElement.val() != '' & checkEmail() & checkPhone()) {
                inputDiv.removeClass().addClass("form-group has-success has-feedback");
                window.formOk = window.formOk & true;
            }
            else {
                inputDiv.removeClass().addClass("form-group has-error has-feedback");
                window.formOk = window.formOk & false;
            }
        };

        this.checkSpan = function(){
            if (inputDiv.find("span").length){
                if (inputDiv.hasClass('has-error')){
                    inputDiv.find('span').removeClass().addClass('glyphicon glyphicon-remove form-control-feedback');
                }
                else {
                    inputDiv.find('span').removeClass().addClass('glyphicon glyphicon-ok form-control-feedback');
                }
            }
            else {
                if (inputDiv.hasClass('has-error')){
                    inputDiv.append('<span class="glyphicon glyphicon-remove form-control-feedback"></span>');
                }
                else {
                    inputDiv.append('<span class="glyphicon glyphicon-ok form-control-feedback"></span>');
                }
            };
        };

        function checkEmail(){
            if (inputElement.attr('type') == "email"){
                if (!/[0-9a-z_]+@[0-9a-z_^\.]+\.[a-z]{2,3}/i.test(inputElement.val())){
                    inputElement.tooltip({ //устанавливаем маркер на незаполненом поле
                        animation: true,
                        title : "Введите корректный адрес электронной почты",
                        placement : 'left'
                    }).tooltip('show');
                    return false;
                };
            };
            return true;
        };
        function checkPhone(){
            if (inputDiv.find("#phone1").length){
                if (!/^\+380[0-9]{9}$/i.test(inputElement.val())){
                    inputElement.tooltip({ //устанавливаем маркер на незаполненом поле
                        animation: true,
                        title : "Телефон должен быть в формате +380ххххххххх",
                        placement : 'left'
                    }).tooltip('show');
                    return false;
                };
            };
            return true;
        };
    };

});