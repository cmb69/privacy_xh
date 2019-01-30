<form id="privacy" name="privacy" method="post">
    <?=$this->message()?>
    <p>
        <button type="submit" class="submit" name="privacy_agree" value="yes"><?=$this->text('label_allow')?></button>
        <button type="submit" class="submit" name="privacy_agree" value="no"><?=$this->text('label_decline')?></button>
    </p>
</form>
<script type="text/javascript">/* <![CDATA[ */
    if (typeof navigator.cookieEnabled != "undefined" && !navigator.cookieEnabled) {
        document.forms.privacy.style.display = "none";
    }
/* ]]> */</script>
