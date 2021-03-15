module.exports = {
  init: function (app, webSection) {
    if (webSection != 'terms') {
      return;
    }

    app.toggleYesInput.init('#benefit_deadline', '#enable_benefits', app, this);
    app.toggleYesInput.initRadio('#price_exact_value', 'input[name=price_auto]', '#price_auto_0', app, this);
  },
};
