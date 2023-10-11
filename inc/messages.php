<?php
if(isset($message) and !empty($message)) {
  echo <<<ENDA
  <div class='alert alert-success alert-dismissible fade in' role='alert'>
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span>
    </button>
    <strong>Great!</strong> $message.
  </div>
ENDA;
}
if(isset($error_message) and !empty($error_message)) {
  echo <<<ENDB
  <div class='alert alert-danger alert-dismissible fade in' role='alert'>
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span>
    </button>
    <strong>Oh No!</strong> $error_message
  </div>
ENDB;
}
if(isset($warning) and !empty($warning)) {
  echo <<<ENDC
  <div class='alert alert-warning alert-dismissible fade in' role='alert'>
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span>
    </button>
    <strong>Something's wrong!</strong> $warning
  </div>
ENDC;
}

if(isset($notice) and !empty($notice)) {
  echo <<<ENDD
  <div class="alert alert-info alert-dismissible fade in" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
    </button>
    <strong>Holy guacamole!</strong> $notice
  </div>
ENDD;
}
?>
