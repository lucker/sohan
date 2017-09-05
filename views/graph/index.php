<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  </head>
  <body>
  <h1>График выигрыша/затрат пользователя</h1>
  <!-- ставка дата -->
  <!-- выйграшь дата -->
      <script type="text/javascript">
     google.charts.load('current', {packages: ['corechart', 'line'],'language': 'ru'});
     google.charts.setOnLoadCallback(drawCurveTypes);

function drawCurveTypes() {
      var data = new google.visualization.DataTable();
      data.addColumn('datetime', 'X');
      data.addColumn('number', 'Затраты');
      data.addColumn('number', 'Выигрыш');

      data.addRows([
	  <? for($i=0;$i<count($ar);$i++){ 
	  echo "[new Date('".$ar[$i]['date']."'),".$ar[$i]['money'].",".$ar[$i]['win']."],";
	  }?>
      ]);

      var options = {
        hAxis: {
          title: 'Время'
        },
        vAxis: {
          title: 'Ставки'
        },
        series: {
          1: {curveType: 'function'}
        }
      };

      var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
      chart.draw(data, options);
    }
    </script>
     <div id="chart_div"></div>
  </body>
</html>