function hidePopup()
{
    $('.popup > .backdrop').hide();
    $('.popup').hide();
}

$(function(){
    $('body').on('click', 'a[data-popup]', function(event){
        event.preventDefault();

        var first = true;
        var clickedContext = $(this);
        var popupContent = '<div class="popup"><div class="content"><iframe></iframe></div></div>';
        var backdropContent = '<div class="backdrop"></div>';

        var url = clickedContext.attr('href');
        if (url.indexOf('?') === -1) {
            url += '?layout=popup';
        } else {
            url += '&layout=popup';
        }

        showLoader();

        //assumption that only 1 popup will be shown
        if ($('.popup').length > 0) {
            var popup = $('.popup');
            var iframe = popup.find('iframe');
            popup.show();
        } else {
            var popup = $(popupContent);
            var iframe = popup.find('iframe');
            popup.append(backdropContent);
            $('body').append(popup);
        }

        var content = popup.find('.content');
        content.css('width', '0');
        content.css('height', '0');
        var backdrop = popup.find('.backdrop');

        iframe.on('load', function(event) {
            show(popup, clickedContext);
        });

        iframe.attr('src', url);

        function show(popup, clickedContext) {
            var content = popup.find('.content');
            var backdrop = popup.find('.backdrop');
            if (first) {
                first = false;
                hideLoader();
            }
            backdrop.show();

            content.removeClass(function (index, className) {
                return (className.match (/(^|\s)content-\S+/g) || []).join(' ');
            });

            switch ($(clickedContext).data('popup')) {
                case 'right':
                    content.addClass('content-right');
                    content.css('height', '100%');
                    content.animate({width: '600px'}, 500);
                    break;
                case 'center':
                    content.addClass('content-center');
                    content.animate({
                        width: '90%',
                        height: '90%'
                    }, 500);
                    break;
            }
            document.body.style.overflow = "hidden";
        }

        var closePopup = function() {
            document.body.style.overflow = "visible";
            content.animate({width: '0'}, 1).promise().done(function () {
                hidePopup();
            });
        };

        backdrop.on('click', closePopup);

        content.on('click', function(event){
            event.stopPropagation();
        })
    });
});