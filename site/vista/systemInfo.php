<?php
function messageClass($messageType)
{
    $type = substr($messageType, 7);
    return strtolower($type . "-message");
}

function systemInfo($messageType)
{
    session_start();
    if (isset($_SESSION[$messageType])) {
        $messageClass = messageClass($messageType);
?>
        <div class="<?php echo $messageClass; ?>"><?php echo $_SESSION[$messageType]; ?></div>
<?php

        unset($_SESSION[$messageType]);
    }
}
