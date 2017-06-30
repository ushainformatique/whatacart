//Utility functions related to application
/**
 * Renders ajax validation errors.
 * @param {Json Object} data
 * @param {String} modelClassName
 * @param {String} errorCssClass
 * @param {String} successCssClass
 * @param {String} formId
 * @param {String} inputContainerSelector
 * @returns {undefined}
 */
$.fn.renderAjaxErrors = function(data, modelClassName, errorCssClass, successCssClass, formId, inputContainerSelector)
{
    $.each(data, function(index, errorMsgObj){
        $.each(errorMsgObj, function(k,v)
        {
            if(modelClassName !== '')
            {
                index   = modelClassName + '-' + index;
            }
            $('#' + index).closest(inputContainerSelector).find('.help-block').html(v);
            //Input container selector would mostly be .form-group
            var container = $('#' + formId).find('#'+index).closest(inputContainerSelector);
            $(container).removeClass(errorCssClass);
            $(container).removeClass(successCssClass);
            $(container).addClass(errorCssClass);
        });
    });
}

/**
 * Attach loader and disable button.
 * @param {Json Object} form
 * @returns {void}
 */
function attachButtonLoader(form)
{
    var button = form.find('button[type=submit]');
    button.parent().addClass('button-loader');
    button.addClass('disabled');
}

/**
 * Remove loader and disable button.
 * @param {Json Object} form
 * @returns {void}
 */
function removeButtonLoader(form)
{
    var button = form.find('button[type=submit]');
    button.parent().removeClass('button-loader');
    button.removeClass('disabled');
}

$.fn.attachLoader = function(context)
{
    $(context).addClass('loader');
}

$.fn.removeLoader = function(context)
{
    $(context).removeClass('loader');
}

// tooltips on hover
$('[data-toggle=\'tooltip\']').tooltip({container: 'body'});