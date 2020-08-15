$(document).ready(function() {
    $('#dtReport').DataTable();

    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);
});

$(window).resize(function() {
    drawChart();
});

function drawChart() {
    $.ajax({
      url: "./admin/gettingJsonVisitorPageView",
      method: "GET",
      success: function(analytic) {
          var data = google.visualization.arrayToDataTable(analytic);
          var options = {
            title: 'Viewer Web Page',
            curveType: 'function',
            legend: { position: 'bottom' }
          };
          var chart = new google.visualization.LineChart(document.getElementById('linechart'));
          chart.draw(data, options);
      }, fail: function(data) {
          console.log('need to maintanance!');
      }
    })
}
