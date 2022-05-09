window._ = require('lodash');


try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    let dir = $('html').attr('dir');
    if (dir == 'rtl') {
        require('bootstrap-v4-rtl');

    } else {
        require('bootstrap');
    }
} catch (e) {}

window.toastr = require('toastr')
// require('jquery-ui/ui/widgets/sortable') ;


