<?php $this->beginPage() ?>
<head>
 <meta charset="utf-8">
    <title><?= $this->title ?></title>
    <? $this->head() ?>
 <!-- <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0"> -->
    <meta name="interkassa-verification" content="3e597c8b7f97a63d1c6e235999aa9b5c" />
 <script src="//ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
 <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
 <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
 <script src="//netdna.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
 <meta name="yandex-verification" content="ba4f9ea8aa48c4ba" />
 <!-- <script src="/ckeditor/ckeditor.js"></script> -->
 <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
 <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.js"></script>
</head>
<body>
<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter41696884 = new Ya.Metrika({
                    id:41696884,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/41696884" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-84802838-1', 'auto');
  ga('send', 'pageview');

</script>

  <!-- menu -->
<nav class="navbar navbar-inverse">
  <div class="container-fluid navbar-collapse">
    <div class="navbar-header">
		<a class="navbar-brand" href="/">sohan.xyz</a>
    </div>

     
      
	 <? if(Yii::$app->user->isGuest){ ?>
	 <ul class="nav navbar-nav navbar-right">
		<li><a href="/site/registration"> <span class="glyphicon glyphicon-user"></span> Регистрация</a></li>
		<li><a href="/site/login"><span class="glyphicon glyphicon-log-in"></span> Вход</a></li>
     </ul>
	 <? }else{ ?>
	 <ul class="nav navbar-nav navbar-right">
		<li>
           <a data-toggle="dropdown" href="#"> <span class="glyphicon glyphicon-chevron-down"></span> <?= $this->params['user']->name ?></a>
           <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
            <li><a href="/prognoz/index"> Сделать ставку </a></li>
	        <li><a href="/prognoz/p"> Добавить прогноз </a></li>
		    <li><a href="/money/index"> Пополнить счет </a></li>
           </ul>
		</li>
		 <li><a href="/site/logout"><span class="glyphicon glyphicon-log-out"></span> Выход</a></li>
     </ul>
     
	 <? } ?>
  </div>
</nav>
<!-- menu -->
  <?= $content ?>
<!-- Top100 (Kraken) Counter -->
<script>
    (function (w, d, c) {
    (w[c] = w[c] || []).push(function() {
        var options = {
            project: 4458699
        };
        try {
            w.top100Counter = new top100(options);
        } catch(e) { }
    });
    var n = d.getElementsByTagName("script")[0],
    s = d.createElement("script"),
    f = function () { n.parentNode.insertBefore(s, n); };
    s.type = "text/javascript";
    s.async = true;
    s.src =
    (d.location.protocol == "https:" ? "https:" : "http:") +
    "//st.top100.ru/top100/top100.js";

    if (w.opera == "[object Opera]") {
    d.addEventListener("DOMContentLoaded", f, false);
} else { f(); }
})(window, document, "_top100q");
</script>
<noscript><img src="//counter.rambler.ru/top100.cnt?pid=4458699"></noscript>
<!-- END Top100 (Kraken) Counter -->
</body>
<?php $this->endPage() ?>