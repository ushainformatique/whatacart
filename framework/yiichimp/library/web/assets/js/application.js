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
                console.log(index);
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

/**
 * Get alias for based on name on key press
 * @param string nameId
 * @param string aliasId
 * @returns void
 */
function getAlias(nameId, aliasId)
{
    var alias = $('#' + nameId).val().toLowerCase();
    alias = alias.replace(/[^A-Za-z0-9]/gi, '-');

    $('#' + aliasId).val(alias);
}

/**
 * Sidebar rendering
 * @returns void
 */
$(function() {
    /*------- Wrapping content inside .page-content ---*/

	$('.page-content').wrapInner('<div class="page-content-inner"></div>');

	/*------- Applying offcanvas class -----*/

	$(document).on('click', '.offcanvas', function () {
		$('body').toggleClass('offcanvas-active');
	});

	/*-------  Default navigation -----*/

	$('.navigation').find('li.active').parents('li').addClass('active');
	$('.navigation').find('li').not('.active').has('ul').children('ul').addClass('hidden-ul');
	$('.navigation').find('li').has('ul').children('a').parent('li').addClass('has-ul');


	$(document).on('click', '.sidebar-toggle', function (e) {
	    e.preventDefault();

	    $('body').toggleClass('sidebar-narrow');

	    if ($('body').hasClass('sidebar-narrow')) {
	        $('.navigation').children('li').children('ul').css('display', '');

		    $('.sidebar-content').hide().delay().queue(function(){
		        $(this).show().addClass('animated fadeIn').clearQueue();
		    });
	    }

	    else {
	        $('.navigation').children('li').children('ul').css('display', 'none');
	        $('.navigation').children('li.active').children('ul').css('display', 'block');

		    $('.sidebar-content').hide().delay().queue(function(){
		        $(this).show().addClass('animated fadeIn').clearQueue();
		    });
	    }
	});


	$('.navigation').find('li').has('ul').children('a').on('click', function (e) {
	    e.preventDefault();

	    if ($('body').hasClass('sidebar-narrow')) {
			$(this).parent('li > ul li').not('.disabled').toggleClass('active').children('ul').slideToggle(250);
			$(this).parent('li > ul li').not('.disabled').siblings().removeClass('active').children('ul').slideUp(250);
	    }

	    else {
			$(this).parent('li').not('.disabled').toggleClass('active').children('ul').slideToggle(250);
			$(this).parent('li').not('.disabled').siblings().removeClass('active').children('ul').slideUp(250);
	    }
	}); 
});