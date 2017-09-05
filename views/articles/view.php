<?php
     if (!defined('_SAPE_USER')){
        define('_SAPE_USER', 'e6a2fa9c1dec018a735c153eef932c60');
     }
     require_once(realpath($_SERVER['DOCUMENT_ROOT'].'/'._SAPE_USER.'/sape.php'));
     $sape = new SAPE_client();
?>
<div class="container">
<h1><?= $article->title; ?></h1>
<?= $article->text; ?>
<? echo $sape->return_links($n); ?>
</div>