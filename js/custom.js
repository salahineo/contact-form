// Client Side Validation
$(function () {
  // Error Variable
  let nameError;

  // Validate Name
  $('[name=name]').on('blur', function () {
    if ($(this).val().length < 3) {
      nameError = true;
    } else {
      nameError = false;
    }
  });

  // Validate Form Before Submit
  $('.contact-form').submit(function (e) {
    if (nameError === true) {
      $('.error-name').fadeIn();
      e.preventDefault();
    } else {
      $('.error-name').fadeOut();
    }
  });
});
