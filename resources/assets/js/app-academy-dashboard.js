document.addEventListener('DOMContentLoaded', function () {
  var options = {
    series: [
      {
        data: courseData.map(course => course.progress)
      }
    ],
    chart: {
      type: 'bar',
      height: 350,
      toolbar: {
        show: false
      }
    },
    plotOptions: {
      bar: {
        borderRadius: 4,
        horizontal: true
      }
    },
    dataLabels: {
      enabled: true,
      formatter: function (val) {
        return val + '%';
      },
      style: {
        fontSize: '12px',
        colors: ['#304758']
      }
    },
    xaxis: {
      categories: courseData.map(course => course.title),
      labels: {
        formatter: function (val) {
          return val + '%';
        }
      }
    },
    colors: ['#696cff', '#03c3ec', '#ff3e1d', '#71dd37', '#8592a3', '#ffab00']
  };

  var chart = new ApexCharts(document.querySelector('#horizontalBarChart'), options);
  chart.render();
});
