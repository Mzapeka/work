/**
 * Created by Администратор on 08.11.15.
 */
$(document).ready(function(){
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
    //узнаем идентификатор диллера из атрибута data- кнопки редактирования строки
    var id = $(this).data('iddill');
    var row = $('#' + id);
    //формируем объект со старыми данными
    var dillInfo = new Object();
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
    //вставляем в таблицу текстовые инпуты со старыми данными
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
        //Обработчик кнопки отмены редактирования
    row.find('.exitbutton').click(function(){
/*        editFilds.each(function(){
            if ($(this).attr('class') == 'nameDil'){
                $(this).empty().text(dillInfo.firstName + ' ' + dillInfo.lastName);
            }
            else {
                $(this).empty().text(dillInfo[$(this).attr('class')]);
            }
        })
        row.find('.exitbutton, .okbutton').remove();
        row.find('.deleteDill, .editDill').show();*/
        viewDillerInfo(editFilds,dillInfo,row);
    })

    function viewDillerInfo(filds, info, activrow){
        filds.each(function(){
            if ($(this).attr('class') == 'nameDil'){
                $(this).empty().text(info.firstName + ' ' + info.lastName);
            }
            else {
                $(this).empty().text(info[$(this).attr('class')]);
            }
        })
        activrow.find('.exitbutton, .okbutton').remove();
        activrow.find('.deleteDill, .editDill').show();
    }

    row.find('.okbutton').click(function(){
        //создаем объект из новых данных
        var newDillInfo = new Object();
        editFilds.each(function(){
            if ($(this).attr('class') == 'nameDil'){
                newDillInfo['firstName'] = $(this).find(':first-child').val();
                newDillInfo['lastName'] = $(this).find(':last-child').val();
            }
            else {
                newDillInfo[$(this).attr('class')] = $(this).find(':text').val();
            }
        })
        newDillInfo.idDiller = id;
        //отправляем объект на сервер
        $.post(
            'http://kts540.in.ua/admin/dillerUpdate',
            {'dillerInfo': newDillInfo},
            function result(data){
                if (data == 'success'){
                    viewDillerInfo(editFilds,newDillInfo,row);
                }
                else {
                    viewDillerInfo(editFilds,dillInfo,row);
                    alert('Информацию неудалось записать');
                }
            }
        )
            .error(function(){
                viewDillerInfo(editFilds,dillInfo,row);
                alert('Ошибка соединения. Данные не переданы');
            })
    })
}

/*
 for (var key in dillInfo) {
 alert(key+':'+dillInfo[key])
 }
 */

});
