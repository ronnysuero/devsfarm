
function validatePassword()
{
    var password1 = $('#user_password').val();
    var password2 = $('#user_confirm_password').val();

    if(password1 != password2)
    {
      $('#error').text('Both passwords must match');
      $('#error_div').show();
      return false;
    }
    else
      return true;
}
