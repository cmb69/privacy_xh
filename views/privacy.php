<?php

namespace Privacy;

/**
 * @var View $this
 * @var string $message
 */

?>

<form id="privacy" name="privacy" method="post">
    <?=$this->escape($message)?>
    <p class="privacy_buttons">
        <button type="submit" class="submit" name="privacy_agree" value="no"><?=$this->text('label_decline')?></button>
        <button type="submit" class="submit" name="privacy_agree" value="yes"><?=$this->text('label_allow')?></button>
    </p>
</form>
<script>
    if (typeof navigator.cookieEnabled != "undefined" && !navigator.cookieEnabled) {
        document.forms.privacy.style.display = "none";
    }
</script>
