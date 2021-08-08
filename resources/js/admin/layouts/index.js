require('./default');
document.addEventListener('DOMContentLoaded', function() {
    //activeWith
    let a = document.querySelector('.navbar1')
    a.children[0].onclick = (e) => {

        const b = document.querySelector('.book').getAttribute('class');
        console.log(b);
        if (b.split(' ')[2] == undefined) {
            document.querySelector('.book').setAttribute('class', `${b} activeWidth`)
        } else {
            document.querySelector('.book').setAttribute('class', 'grid book')
        }
    }
    $('#page_managebook').click(() => {
        let leng = $('#page_managebook').attr('class').indexOf('activeHeight');
        if (leng != -1) $('#page_managebook').removeClass('activeHeight')
        else $('#page_managebook').addClass('activeHeight')
    })
});
