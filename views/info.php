<?php

use Privacy\Infra\View;

/**
 * @var View $this
 * @var string $version
 * @var array<stdClass> $checks
 */

?>

<h1>Privacy <?=$this->escape($version)?></h1>
<h2><?=$this->text('syscheck_title')?></h2>
<?php foreach ($checks as $check):?>
<p class="xh_<?=$this->escape($check->state)?>"><?=$this->text('syscheck_message', $check->label, $check->stateLabel)?></p>
<?php endforeach?>
