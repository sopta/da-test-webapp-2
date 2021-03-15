///////////////
// Libraries //
///////////////
global.$ = global.jQuery = require('jquery');
global.toastr = require('toastr');
require('../../../node_modules/flatpickr/dist/flatpickr.js');
require('flatpickr/dist/l10n/cs.js');

// Used some methods
global.Util = require('bootstrap/js/dist/util');
require('bootstrap/js/dist/collapse');
require('bootstrap/js/dist/dropdown');
require('bootstrap/js/dist/modal');
require('bootstrap/js/dist/tooltip');
require('bootstrap/js/dist/tab');

require('bootstrap-select');
require('bootstrap-select/dist/js/i18n/defaults-cs_CZ');

/////////////////
// Application //
/////////////////

global.CzechitasApp = require('./partials/app');
global.CzechitasApp.modules['order'] = require('./partials/order');
global.CzechitasApp.modules['student'] = require('./partials/student');
global.CzechitasApp.modules['term'] = require('./partials/term');

CzechitasApp.init();
