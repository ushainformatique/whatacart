<?php
/* @var $exception \yii\web\HttpException|\Exception */
/* @var $handler \yii\web\ErrorHandler */
if ($exception instanceof \yii\web\HttpException) {
    $code = $exception->statusCode;
} else {
    $code = $exception->getCode();
}
$name = $handler->getExceptionName($exception);
if ($name === null) {
    $name = 'Error';
}
if ($code) {
    $name .= " (#$code)";
}



if ($exception instanceof \yii\base\UserException) {
    $message = $exception->getMessage();
} else {
    $message = 'An internal server error occurred.';
}

$this->title = $handler->htmlEncode($name);
?>
<br/><br/>
<div class="alert alert-danger">
    <h3><?= nl2br($handler->htmlEncode($message)) ?></h3>
    <p>
        The above error occurred while the Web server was processing your request.
    </p>
    <p>
        Please contact us if you think this is a server error. Thank you.
    </p>
</div>