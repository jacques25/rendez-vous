<?php

namespace App;

final class UserEvents
{
  /**
   * @Event("App\)
   */
  const REGISTRATION_INITIALIZE = 'user.registration.initialize';

  const REGISTRATION_SUCCESS = 'user.registration.success';

  const REGISTRATION_FAILURE = 'user.registration.failure';

  const REGISTRATION_COMPLETED = 'user.registration.completed';

  const REGISTRATION_CONFIRM = 'user.registration.confirm';

  const REGISTRATION_CONFIRMED = 'user.registration.confirmed';

  const RESETTING_SEND_EMAIL_INITIALIZE = 'user.resetting.send_email.initialize';

  const RESETTING_SEND_EMAIL_CONFIRM = 'user.resetting.send_email.confirm';

  const RESETTING_SEND_EMAIL_COMPLETED = 'user.resetting.send_email.completed';
}
