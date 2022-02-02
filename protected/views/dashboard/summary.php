<div>
  <div class="container-fluid xyz  col-lg-8">
    <div class="hedder">
      <h1>Vehicle Overview</h1>
    </div>
    <div class="table-content">
      <?php
      $q = "SELECT
              ma_vehicle_category.Category_Name,
              Count(ma_vehicle_registry.Vehicle_No) as count1
              FROM
              ma_vehicle_registry
              INNER JOIN ma_vehicle_category ON ma_vehicle_registry.Vehicle_Category_ID = ma_vehicle_category.Vehicle_Category_ID
              INNER JOIN vehicle_transfer ON ma_vehicle_registry.Vehicle_No = vehicle_transfer.Vehicle_No
              INNER JOIN ma_vehicle_status ON ma_vehicle_registry.Vehicle_Status_ID = ma_vehicle_status.Vehicle_Status_ID
              WHERE
              vehicle_transfer.To_Date < CURDATE() AND
              ma_vehicle_registry.Vehicle_Status_ID = 1
              GROUP BY
              ma_vehicle_category.Category_Name";
      $arr = Yii::app()->db->createCommand($q)->queryAll();
      $tbl =  "<table class='table table-striped'><thead><tr><th scope= 'col'>Catogory</th><th scope= 'col'>Allocated</th><th scope= 'col'>Idle</th><th scope= 'col'>Accident</th></tr></thead>";
      foreach ($arr as $val) {
        $tbl .= "<tr><th scope='row'>" . $val['Category_Name'] . "</th><td>" . $val['count1'] . "</td><td></td><td></td></tr>";
        //$tbl .= "<tr><td>$No</td><td>" . $val['Material_ID'] . "</td><td>" . $val['Material_Name'] . "</td><td style = 'text-align: center'>" . $val['Unit_Code'] . "</td><td style = 'text-align: center'>" . $val ['Qty'] . "</td><td></td></tr>";
      }
      $tbl .= "</table>";
      echo $tbl;
      ?>
    </div>
  </div>
  <div class="chart_container col-lg-4">
    <?php $this->renderPartial('//dashboard/charts', array()); ?>
  </div>

  <script>
    $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
    });
    $("#menu-toggle-2").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled-2");
      $('#menu ul').hide();
    });

    function initMenu() {
      $('#menu ul').hide();
      $('#menu ul').children('.current').parent().show();
      //$('#menu ul:first').show();
      $('#menu li a').click(
        function() {
          var checkElement = $(this).next();
          if ((checkElement.is('ul')) && (checkElement.is(':visible'))) {
            return false;
          }
          if ((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
            $('#menu ul:visible').slideUp('normal');
            checkElement.slideDown('normal');
            return false;
          }
        }
      );
    }
    $(document).ready(function() {
      initMenu();
    });
  </script>
</div>
<div class="col-xs-3" style="width: 100%; float: left; padding-top:100px">
  <?php $this->renderPartial('//dashboard/_index_bk', array()); ?>
</div>