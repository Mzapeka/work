/**
 * Created by Администратор on 08.11.15.
 */
$(document).ready(function(){
    /*проверка на правильность ввода при потере фокуса на текстовом поле*/
    /*  $("#regForm input:text, #em").each(function(indx, element){
     var inputElement = $(element);
     var inputDiv = inputElement.parent();
     inputElement.blur(function(){
     var checkInput = new CheckInput(inputElement, inputDiv);
     checkInput.checkWrong();
     checkInput.checkSpan();
     });
     });
     */

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
/*Управление модалью удаления дилера*/
$('#deleteDillModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Кнопка, що викликає модаль
    var idDill = button.data('iddill') // Витягування інфи з атрибутів data-*
    // Якщо необхідно, ви можете створювати тут AJAX-запит (а потім здійснювати оновлення в callback).
    // Оновлення вмісту модалі. Ми будемо використовувати тут jQuery, але ви можете використовувати бібліотеку data binding або інші методи.
    var companyName = $('#'+idDill).find('.compName').text();
    var modal = $(this)
    modal.find('.modal-body h4').text('Вы действительно хотите удалить дилера: ' + companyName);
    modal.find('#deleteDill').show();
    modal.find('#deleteDill').unbind('click');
    modal.find('#deleteDill').click(function(){
        $.post(
            'http://kts540.in.ua/admin/dillerDelete',
            {
                idDil : idDill
            },
            onAjaxSuccess
        );
    });
    // Здесь мы изменяем элементы формы в случае успешного удаления.
    function onAjaxSuccess(data){
        if (data == 'success'){
            modal.find('#deleteDill').hide();
            modal.find('.modal-body h4').text('Дилер ' + companyName + ' успешно удален из базы');
            $('#' + idDill).detach()
        }
        else {
            modal.find('#deleteDill').hide();
            modal.find('.modal-body h4').text('Дилера удалить не удалось: ' + data);
        }
    }


})


// Управление редактированием диллеров
$('.editDill').click(editDiller);

function editDiller(){
    var id = $(this).data('iddill');
    var dillInfo = new Object();
    var row = $('#' + id);
    var editFilds= row.find('.compName, .adress, .mail, .phone, .nameDil');
    editFilds.each(function(){
        if ($(this).attr('class') == 'nameDil'){
            var arr = $(this).text().split(/[\s]/);
            dillInfo.firstName = arr[0];
            dillInfo.lastName = arr[1];
        }
        else {
            dillInfo[$(this).attr('class')] = $(this).text();
        }
    });
    editFilds.each(function(){
        $(this).text('').append(function(){
            if ($(this).attr('class') == 'nameDil'){
                return '<input type="text" value="' + dillInfo.firstName + '"/>' +
                    '<input type="text" value="' + dillInfo.lastName + '"/>';
            }
            else {
                return '<input type="text" value="'+ dillInfo[$(this).attr('class')] + '"/>';
            }
        })
    })
    row.find('.deleteDill, .editDill').hide();
    row.find('.action').append(function(){
        return '<input type="button" class="btn btn-default btn-xs okbutton" value="Ok"/>'+
            '<input type="button" class="btn btn-default btn-xs exitbutton" value="Отмена"/>'
    })

    row.find('.exitbutton').click(function(){
        editFilds.each(function(){
            if ($(this).attr('class') == 'nameDil'){
                $(this).empty().text(dillInfo.firstName + ' ' + dillInfo.lastName);
            }
            else {
                $(this).empty().text(dillInfo[$(this).attr('class')]);
            }
        })
        row.find('.exitbutton, .okbutton').remove();
        row.find('.deleteDill, .editDill').show();
    })
}

/*
 for (var key in dillInfo) {
 alert(key+':'+dillInfo[key])
 }
 */



/*    $('#regForm').submit(function(){
 $('#regForm .form-group').each(function(indx){
 if ($(this).find("input:text").val() == '') {
 $(this).removeClass().addClass("form-group has-error has-feedback");
 if ($(this).find(span).hasClass("glyphicon-ok")){
 $(this).find(span).removeClass('glyphicon-ok').addClass('glyphicon-remove');
 }
 else {
 $(this).append('<span class="glyphicon glyphicon-remove form-control-feedback"></span>');
 }
 }
 else {
 $(this).removeClass().addClass("form-group has-success has-feedback");
 if ($(this).find(span).hasClass("glyphicon-remove")){
 $(this).find(span).removeClass('glyphicon-remove').addClass('glyphicon-ok');
 }
 else {
 $(this).append('<span class="glyphicon glyphicon-ok form-control-feedback"></span>');
 }
 }
 });
 $('#regForm .form-group').each(function(indx){
 if ($(this).hasClass('has-error')){
 return false;
 }
 });

 });*/
});
