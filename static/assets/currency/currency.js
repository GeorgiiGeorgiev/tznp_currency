let settingsSection = jQuery('div.settingsSection');// родитиельский div настроек

let settingsToggle = jQuery('button.settingsToggle');// кнопка разаернуть\свернуть настройки

let settingsForm = jQuery('form#settingsForm');// форма настроек

let convertForm = jQuery('form#convertForm');// форма обменика

let convertResponse = jQuery('div.convertResponse');// ответ обменика

let convertResponseValue = convertResponse.find('input.responseValue');// значение ответа обменика

let convertResponseMessage = convertResponse.find('div.responseMessage');// сообщение при ошибке обменика

let convertResponseLoading = convertResponse.find('img.loading');// загрузка

let scrollUpButton = jQuery('span.scrollUp');// кнопка прокрутки страницы вверх

let historyResponse = jQuery('div.historyResponse');

jQuery(document).ready(function(){

    settingsSection.hide();

    convertResponseMessage.hide();

    convertResponseLoading.hide();

    historyResponse.hide();

});

// кнопка разаернуть\свернуть настройки
jQuery(settingsToggle).on('click',function(){

    settingsSection.toggle('slow');

});

// форма обменика
jQuery(convertForm).submit(function(e){

    e.preventDefault();

    convertResponseLoading.show('slow');

    convertResponseValue.val('');

    convertResponseMessage.html('').hide('slow');

    historyResponse.show('slow');

    jQuery.ajax({
        url: '/currency_api/conversation',
        type: 'GET',
        data: convertForm.serializeArray(),
        dataType: 'JSON',
        success:function(data)
        {
            console.log(data);

            if(data.success){

                convertResponse.removeClass(['alert-info','alert-danger']).addClass('alert-success');

                convertResponseValue.val(data.result);

                convertResponseLoading.hide('slow');

            }else{

                convertResponse.removeClass(['alert-info','alert-success']).addClass('alert-danger');

                convertResponseMessage.html(data.error).show('slow');

                convertResponseLoading.hide('slow');

            }

        }
    });

});

// форма настроек
jQuery(settingsForm).submit(function(e){

    e.preventDefault();

    if(confirm('Вы уверены?')){

        jQuery.ajax({
            url: '/settings/store',
            type: 'POST',
            data: settingsForm.serializeArray(),
            dataType: 'JSON',
            success:function(data)
            {
                console.log(data);

                if(data.success){

                    alert('Настройки успешно сохранены, страница будет перезагружена.');

                    location.reload();

                }else{

                    alert(data.error);

                }
            }
        });

    }

});

// кнопка прокрутки страницы вверх
jQuery(scrollUpButton).click(function(){

    jQuery('body,html').animate({scrollTop: 0}, 1200);

});