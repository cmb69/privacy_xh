<form id="privacy" name="privacy" action="" method="post">
    <?php echo $this->message()?>
    <input type="checkbox" id="privacy_agree" name="privacy_agree" />
    <label for="privacy_agree"><?php echo $this->text('checkbox')?></label>
    <input type="submit" class="submit" name="privacy_submit"
           value="<?php echo $this->text('button')?>" />
</form>
<script type="text/javascript">/* <![CDATA[ */
    if (typeof navigator.cookieEnabled != "undefined" && !navigator.cookieEnabled) {
        document.forms.privacy.style.display = "none";
    }
/* ]]> */</script>
