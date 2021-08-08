require('./bootstrap');
require('./admin/layouts/index');
require('./upload');
require('./format.input');
require('./login_register');
require('./clicked_navbar');

var url = window.location.href;
if (url.indexOf('/admin') != -1) {
    if (url.indexOf('/book') != -1) {
        if (url.indexOf('/create') != -1) {
            $('#icon_managebook').addClass('hover');
            $('#page_managebook').addClass('activeHeight');
            $('#page_addbook').addClass('hover');
        } else if (url.indexOf('/edit') != -1) {
            $('#icon_managebook').addClass('hover');
            $('#page_managebook').addClass('activeHeight');
            $('#page_editbook').addClass('hover');
        } else {
            $('#icon_managebook').addClass('hover');
            $('#page_managebook').addClass('activeHeight');
            $('#page_listbook').addClass('hover');
        }
    } else if (url.indexOf('/user') != -1) {
        $('#page_manageuser').addClass('hover');
    } else if (url.indexOf('/contact') != -1) {
        $('#page_managecontact').addClass('hover');
    } else if (url.indexOf('/order') != -1) {
        $('#page_manageorder').addClass('hover');
    } else {
        $('#page_dashboard').addClass('hover');
    }
}