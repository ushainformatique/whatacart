<h1><?= $handler->htmlEncode($name) ?></h1>
<h2><?= nl2br($handler->htmlEncode($message)) ?></h2>
<p>
    The above error occurred while the Web server was processing your request.
</p>
<p>
    Please contact us if you think this is a server error. Thank you.
</p>
<div class="version">
    <?= date('Y-m-d H:i:s', time()) ?>
</div>