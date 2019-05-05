//Load the image before, so it can be shown on onWindowUnload
var loaderImage = $('<img class="spinner" src="/img/spinner.svg"/>');
function showLoader(target)
{
    var target = target || 'body';
    var backdrop = $('<div class="backdrop"></div>');
    var loader = $('<div class="loader"></div>');

    if (target === 'body') {
        backdrop.css('position', 'fixed');
    }

    backdrop.html(loaderImage);
    loader.html(backdrop);

    $(target).append(loader);
}

function hideLoader(target)
{
    var target = target || 'body';
    $(target).find('> .loader').remove();
}