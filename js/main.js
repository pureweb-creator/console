$(document).ready(function () {

  $('.burger').on('click', function () {
    $('.sidemenu, .page-overlay').toggleClass('active');
  });

  if( $('form').is('#getCurrencyForm') ){
    $('#loadCurrency').on('click', function(){
      $.ajax({
        url: 'ajax/load_currency.php',
        method: 'POST',
        cache: false, 
        dataType: 'html',
        data: {
          test: 'test'
        },
        beforeSend: function(){
          $('#loadCurrency').html("Загрузка");          
        },
        success: function(data){
          $('.account-table--currency-more .account-table__body').html(data);
          $('.account-table--currency-more .account-table__header').css({
            'display': 'table-header-group',
            'margin-bottom': '10px'
          });

          $('#loadCurrency').html("Загрузить больше");          
        },
        error: function(){
          $('#loadCurrency').html("Ошибка!");
        }
      });
    });
  }

  // Tabs
  if( $('li').is('.tabs') ){
    $('ul.tabs__captions').each(function(i) {
      var storage = localStorage.getItem('tab' + i);
      if (storage) {
        $(this).find('li').removeClass('active').eq(storage).addClass('active')
        .closest('li.tabs').find('ul.tabs__content').removeClass('active').eq(storage).addClass('active');
      }
    });
   
    $('ul.tabs__captions').on('click', 'li:not(.active)', function() {
      $(this)
      .addClass('active').siblings().removeClass('active')
      .closest('li.tabs').find('ul.tabs__content').removeClass('active').eq($(this).index()).addClass('active');
      var ulIndex = $('ul.tabs__captions').index($(this).parents('ul.tabs__captions'));
      localStorage.removeItem('tab' + ulIndex);
      localStorage.setItem('tab' + ulIndex, $(this).index());
    });

    var tabIndex = window.location.hash.replace('#tab','')-1;
    if (tabIndex != -1) $('ul.tabs__captions li').eq(tabIndex).click();
  }

  // Statement Chart
  if( $('div').is('#chart') ){
    var 
      balance = $('.statement_balance').text().split(" ").reverse();

    var balance_array = [];
    for (var i = 1; i < balance.length; i++)
      balance_array.push(balance[i]);

    var options = {
      chart: {
        type: 'area'
      },
      fill: {
        type: 'gradient',
        gradient: {
          type: "vertical",
          shadeIntensity: 0.5,
          gradientToColors: ['#70E6E5', '#FFFFFF'], // optional, if not defined - uses the shades of same color in series
          inverseColors: true,
          opacityFrom: 1,
          opacityTo: 0,
          stops: [0, 100],
          colorStops: []
        }
      },
      legend: {
        show: false
      },
      grid: {
        borderColor: '#fafafa'
      },
      stroke: {
        width: 2,
        colors: ["#39AACC"],
      },
      markers: {
        size: 0,
        colors: ["#1999FB"],
        strokeColor: "#fff",
        strokeWidth: 3
      },
      dataLabels: {
        enabled: false
      },
      series: [{
        name: 'sales',
        data: balance_array
      }],
      xaxis: {
        categories: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31],
      }
    }
    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
  }

  // Material ripple click effect
  var links = document.querySelectorAll('.ripple-effect');
  for (var i = 0, len = links.length; i < len; i++) {
    links[i].addEventListener('click', function(e) {
      var targetEl = e.target;
      var inkEl = targetEl.querySelector('.ink');

      if (inkEl) {
        inkEl.classList.remove('animate');
      }
      else {
        inkEl = document.createElement('span');
        inkEl.classList.add('ink');
        inkEl.style.width = inkEl.style.height = Math.max(targetEl.offsetWidth, targetEl.offsetHeight) + 'px';
        targetEl.appendChild(inkEl);
      }

      inkEl.style.left = (e.offsetX - inkEl.offsetWidth / 2) + 'px';
      inkEl.style.top = (e.offsetY - inkEl.offsetHeight / 2) + 'px';

      inkEl.classList.add('animate');
    }, false);
  }
});
