<form id="privacy" name="privacy" action="" method="post">
    <?=$this->message()?>
    <input type="checkbox" id="privacy_agree" name="privacy_agree" />
    <label for="privacy_agree"><?=$this->text('checkbox')?></label>
    <input type="submit" class="submit" name="privacy_submit"
           value="<?=$this->text('button')?>" />
</form>
<script type="text/javascript">/* <![CDATA[ */
    if (typeof navigator.cookieEnabled != "undefined" && !navigator.cookieEnabled) {
        document.forms.privacy.style.display = "none";
    }
/* ]]> */</script>
