$(document).on('click','.popup_selector',function (event) {
    event.preventDefault();
    var updateID = $(this).attr('data-inputid'); // Btn id clicked
    var elfinderUrl = '/elfinder/popup/';

    // trigger the reveal modal with elfinder inside
    var triggerUrl = elfinderUrl + updateID;
    $.colorbox({
        href: triggerUrl,
        fastIframe: true,
        iframe: true,
        width: '70%',
        height: '100%',
        innerHeight: 500,
        initialHeight: 500,
        photo:false,

    });

});
console.log('555');
// function to update the file selected by elfinder
function processSelectedFile(filePath, requestingField) {
    $('#' + requestingField).val('/storage/photos/'+filePath).trigger('change');
    $('#' + requestingField)[0].dispatchEvent(new Event('change', { 'bubbles': true }));
}
