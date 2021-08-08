require('./create');
require('./edit');

document.addEventListener('DOMContentLoaded', function() {

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
});