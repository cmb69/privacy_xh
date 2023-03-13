<?php

use Privacy\Infra\View;

/**
 * @var View $this
 * @var string $version
 * @var list<array{class:string,key:string,arg:string,state:string}> $checks
 */

?>

<h1>Privacy <?=$this->escape($version)?></h1>
<h2><?=$this->text('syscheck_title')?></h2>
<?php foreach ($checks as $check):?>
<p class="<?=$this->escape($check['class'])?>"><?=$this->text($check['key'], $check['arg'])?><?=$this->text($check['state'])?></p>
<?php endforeach?>
