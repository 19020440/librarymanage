const { data } = require("jquery");
$(function() {

  const typeCategory = [
    {"category": "Tổng quát"},
    {"category":'Triết học'},
    {"category": 'Tôn giáo'},
    {"category":  'Khoa học xã hội'},
    {"category":  'Ngôn ngữ'},
    {"category": 'Toán học và khoa học tự nhiên'},
    {"category": 'Kỹ thuật'},
    {"category": 'Nghệ thuật'},
    {"category": 'Văn học'},
    {"category": 'Địa lý lịch sử'},
  ];
    let myChart;
      let dtt = [];
      let typedata;
      let typeofbooks = $('#typeofbook');
      typeofbooks.change (function(){
        $.ajaxSetup({
          beforeSend: function(xhr, type) {
              if (!type.crossDomain) {
                  xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
                }
            },
        });
        $.ajax({
          type: 'POST',
          url: '/ajax/search',
          data: {
            [$(this).attr('name')]: $(this).val(),
          },
          success: function(res) {
            if($('#typeofbook').val() == 'category') {
              dtt = [...typeCategory];
            } else dtt = res;
            if(res.length != 0) typedata = Object.keys((res[0]))[0];
            // console.log(res);
          },
          error: function(jqXHR, textStatus, errorThrown) {

          }
        })
        document.querySelector('.dashboard-money-content-search-listsearch-list').innerHTML = '';
        $('#searchinput').val('');
        document.querySelector('.dashboard-money-content-search-listsearch ').style.display = 'none';
      })
    //type book
    $('#searchinput').on('keyup', function() {
      document.querySelector('.dashboard-money-content-search-listsearch ').style.display = 'block';
        if(dtt.length == 0){
          document.querySelector('.dashboard-money-content-search-listsearch-list').innerHTML = '<li>please choose type to search</li>';
        } else {

            if($(this).val() == '') document.querySelector('.dashboard-money-content-search-listsearch-list').innerHTML = '<li>type some thing</li>';
            else {
            let rsSearch = dtt.reduce((arr, value) => {
              
              return arr.concat( value[typedata].toLocaleLowerCase().search($(this).val().toLocaleLowerCase()) != -1 ? `<li>${value[typedata]}</li>` : undefined).filter(x => x!= undefined);
            },[]);
            if(rsSearch.length == 0) document.querySelector('.dashboard-money-content-search-listsearch-list').innerHTML = '<li>the result is not exist</li>';
            else  document.querySelector('.dashboard-money-content-search-listsearch-list').innerHTML = Array.from(new Set(rsSearch)).join('');
            }
        }
        $('.dashboard-money-content-search-listsearch-list li').on('click', function() {
            $('#searchinput').val($(this).text());
            // document.querySelector('.dashboard-money-content-search-listsearch').style.display = 'none';

          $.ajaxSetup({
            beforeSend: function(xhr, type) {
                if (!type.crossDomain) {
                    xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
                  }
              },
          });
          $.ajax({
            type: 'POST',
            url: '/ajax/totalMoney',
            data: {
            value:  $(this).text(),
            type: $('#typeofbook').val(),
            },
            success: function(res) {
              ($('.dashboard-money-content-total').children().children()[1]).innerHTML = intBindStringMoney((res[0])['total'])
            },
            error: function(jqXHR, textStatus, errorThrown) {
      
            }
          })
        
        })
    })
    $('#searchinput').on('focusout', function() {
      setTimeout(()=> {
        document.querySelector('.dashboard-money-content-search-listsearch').style.display = 'none';
      },200)
    })
    $('#searchinput').on('focusin', function() {
    
      if($('#typeofbook').val() != 0 && $(this).val() != '') document.querySelector('.dashboard-money-content-search-listsearch').style.display = 'block';
      
    })
    //dashboard
    $.ajaxSetup({
      beforeSend: function(xhr, type) {
          if (!type.crossDomain) {
              xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
            }
        },
    });
    $.ajax({
      type: 'GET',
      url: '/ajax/dashboardData',
      success: function(res) {
        const nameBook = res.reduce((arr,value) => {
          return arr.concat(value.nameBook);
        },[])

        const valueY = res.reduce((arr,value) => {
          return arr.concat(value.total);
        },[])
        let ctx1 = document.getElementById('mayChart1');
        let myChart1 = new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: nameBook,
            datasets: [{
                label: 'Sách phổ biến',
                data: valueY,
                backgroundColor: [
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(201, 203, 207, 0.2)'
                ],
                borderColor: [
                    'rgb(54, 162, 235)',
                    'rgb(153, 102, 255)',
                    'rgb(201, 203, 207)'
                ],
                borderWidth: 1,
            }],
            options: {
                scales: {
                  y: {
                    beginAtZero: true
                  }
                }
              },
        }
    })
      },
      error: function(jqXHR, textStatus, errorThrown) {
      }
    })
    //DASHBOARD MONTH
    $('input[type="month"]').prev().on('click', function() {
      if($(this).next().prop('disabled')){

          $(this).next().prop('disabled', false)
          $(this).next().next().prop('disabled', true)
      } else {
          $(this).next().prop('disabled', true)
          $(this).next().next().prop('disabled', false)
      }
    })

    $('#yearBoard').next().on('click',  function() {
      let datas;
      if($(this).prev().prop('disabled')){ datas = {
        type: 'month',
        year: $(this).prev().prev().val().split('-')[0],
        month: $(this).prev().prev().val().split('-')[1],
      }} else {
        datas = {
          type: 'year',
          year: $(this).prev().val(),
        }
      }
      $.ajax({
        type: 'POST',
        url: '/ajax/dashBoardOfMonth',
        data: datas,
        success: function(res) {
          let values;
          let indexs;
          if(datas.type == 'month') {
            values = new Array(4).fill(0);
            res.map((value) => {
              values[value.weeks-1] = value.total;
            })
            indexs = values.reduce((arr, value, index) => {
              return arr.concat('Tuần ' + (index+1).toString())
            },[])
          }
          else { 
            values = new Array(12).fill(0);
            res.map((value) => {
              values[value.months-1] = value.total;
            })
            indexs = values.reduce((arr, value, index) => {
              return arr.concat('Tháng ' + (index+1).toString())
            },[])
          }
          myChart.data.labels = indexs;
          myChart.data.datasets[0].data = values;
          myChart.update();
        },
        error: function(jqXHR, textStatus, errorThrown) {
        }
      })
      
    })
    let today = new Date().toISOString().slice(0, 10).split('-')
    $('input[type="month"]').prop('disabled', false)
    $('input[type="month"]').val(today[0] + '-' + today[1]);
    $('input[type="month"]').next().prop('disabled', true)
    $.ajax({
      type: 'POST',
      url: '/ajax/dashBoardOfMonth',
      data: {
        type: 'month',
        year: today[0],
        month: today[1], 
      },
      success: function(res) {
        let valueWeek = new Array(4).fill(0);
        res.map((value) => {
          valueWeek[value.weeks-1] = value.total;
        })
        let Weeks = valueWeek.reduce((arr, value, index) => {
              return arr.concat('Tuần ' + (index+1).toString())
            },[])    
        let ctx = document.getElementById('myChart')
        myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels:Weeks,
                datasets: [{
                    label: 'Visitpr Stats',
                    data: valueWeek,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1,
                    fill: true,
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
      },
      error: function(jqXHR, textStatus, errorThrown) {

      }
    })

//dashboras2
let type2 = 'month';
$('input[name="todate"]').next().on('click', function() {
  let data;
  if($(this).prev().val() == "" || $(this).prev().prev().prev().val() == "")  alert('nhap de ??');
  else {
    $.ajax({
      type: 'POST',
      url: '/ajax/datefromto',
      data: {
       valueto:  $(this).prev().val(),
       valuefrom:  $(this).prev().prev().prev().val(),
       type: type2,
      },
      success: function(res) {
       data = new Array(monthDiff($('input[name="todate"]').prev().prev().val(), $('input[name="todate"]').val())).fill(0);
       let timestarts = new Date($('input[name="todate"]').prev().prev().val());

       data = mahoa(timestarts.getFullYear() + '-' + (timestarts.getMonth()+1),monthDiff($('input[name="todate"]').prev().prev().val(), $('input[name="todate"]').val()));
       res.map((value) => {
         data[value.dates] = value.total;
       })
       myChart.data.labels = Object.keys(data);
       myChart.data.datasets[0].data = Object.values(data);
       myChart.update();
      },
      error: function(jqXHR, textStatus, errorThrown) {
      }
    })
    $('button#yearButton').parent().css('display','block');
  }
})
let stt=0;
let thuong = Math.floor(monthDiff($('input[name="todate"]').prev().prev().val(), $('input[name="todate"]').val())/14);
var dus = monthDiff($('input[name="todate"]').prev().prev().val(), $('input[name="todate"]').val());

$('button#yearButton').prev().prev().on('click', function() {
     let kc = khoangcach2ngay ($('input[name="todate"]').val(), ($('input[name="todate"]').prev().prev().val()));
     let thuong = Math.floor(kc/14);
     let du = kc % 14;
    if(thuong > 0) $(this).next().css('display', 'inline-block');
    $.ajax({
      type: 'POST',
      url: '/ajax/datefromto',
      data: {
      value:  thuong > 0 ? 14:(du-1),
      valuefrom:  $('input[name="fromdate"]').val(),
      type: 'day',
      },
      success: function(res) {
        let data = getTwoWeek($('input[name="fromdate"]').val(), thuong > 0 ? 13:(du-1))
          res.map((value) => {
            data[value.days] = value.total;
          })
         
        myChart.data.labels = Object.keys(data);
        myChart.data.datasets[0].data = Object.values(data);
        myChart.update();
      },
      error: function(jqXHR, textStatus, errorThrown) {
      }
    })
})
$('button#yearButton').prev().on('click', function() {

    stt++;
    let kc = khoangcach2ngay ($('input[name="todate"]').val(), getDays($('input[name="fromdate"]').val(), stt*14));
    if(kc < 0) return;
    let thuong = Math.floor(kc/14);
    let du = kc % 14;
     $(this).prev().prev().css('display', 'inline-block');
    $.ajax({
      type: 'POST',
      url: '/ajax/datefromto',
      data: {
      value:  thuong > 0 ? 14:(du-1),
      valuefrom:  getDays($('input[name="fromdate"]').val(), stt*14),
      type: 'day',
      },
      success: function(res) {
        let data = getTwoWeek(getDays($('input[name="fromdate"]').val(), stt*14), thuong > 0 ? 13:(du-1))
          res.map((value) => {
            data[value.days] = value.total;
          })
         
        myChart.data.labels = Object.keys(data);
        myChart.data.datasets[0].data = Object.values(data);
        myChart.update();
      },
      error: function(jqXHR, textStatus, errorThrown) {
      }
    })
})
$('button#yearButton').prev().prev().prev().on('click', function() {
  let dayonSet = getDays($('input[name="todate"]').prev().prev().val(), stt*14);
  let kc = khoangcach2ngay ($('input[name="todate"]').val(), getDays(dayonSet, -14));
    let thuong = Math.floor(kc/14);
    let du = kc % 14;
     $(this).prev().prev().css('display', 'inline-block');
    $.ajax({
      type: 'POST',
      url: '/ajax/datefromto',
      data: {
      value:  thuong > 0 ? 14:(du-1),
      valuefrom: getDays(dayonSet, -14),
      type: 'day',
      },
      success: function(res) {
        let data = getTwoWeek(getDays(dayonSet, -14), thuong > 0 ? 13:(du-1))
          res.map((value) => {
            data[value.days] = value.total;
          })
         
        myChart.data.labels = Object.keys(data);
        myChart.data.datasets[0].data = Object.values(data);
        myChart.update();
      },
      error: function(jqXHR, textStatus, errorThrown) {
      }
    })
    stt--;
    if(stt == 0) $(this).css('display', 'none');
})
})
//function ma hoa tien
const intBindStringMoney = (e) => {
  let arr = [];
  while(e > 0) {
      let test = e%1000;
       arr.unshift("." + test.toString());
      e=Math.floor(e/1000);
  }
  return arr.join('').substr(1,arr.join('').length);
}
//button onclick
$('button#btn2').on('click', function() {
  console.log(111111);
  $.ajaxSetup({
    beforeSend: function(xhr, type) {
        if (!type.crossDomain) {
            xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
          }
      },
  });
  $.ajax({
    type: 'POST',
    url: '/ajax/totalMoney',
    data: {
     value:  $('#searchinput').val(),
     type: $('#typeofbook').val(),
    },
    success: function(res) {
      console.log(intBindStringMoney((res[0])['total']));
      ($('.dashboard-money-content-total').children().children()[1]).innerHTML = intBindStringMoney((res[0])['total'])
    },
    error: function(jqXHR, textStatus, errorThrown) {
    }
  })
})
  function monthDiff(d1, d2) {
    let a1 = new Date(d1);
    let a2 = new Date(d2)
    var months;
    months = (a2.getFullYear() - a1.getFullYear()) * 12;
    months -= a1.getMonth();
    months += a2.getMonth();
    return months <= 0 ? 0 : months;
  }

  function addMonths(now) {
    let nows = new Date(now);
    var current;
    if (nows.getMonth() == 11) {
        current = new Date(nows.getFullYear() + 1, 0, 1);
    } else {
        current = new Date(nows.getFullYear(), nows.getMonth() + 1, 1);            
    }
    const rs = current.getFullYear() + '-' + (current.getMonth()+1);
    return rs;
}
function mahoa(rs, leng) {
    // let rs = '2021-7';
    let obj ={[rs]: 0,};
    for(let i=1; i<= leng; ++i) {
        rs = addMonths(rs);
        let a = {[rs]: 0,}
        obj = {...obj,...a};
    }
    return obj;
}
function getTwoWeek(day,leng){
  var a = new Date(day);
  let rs = {[a.getFullYear() + '-' + (a.getMonth()+1)+'-'+a.getDate()]: 0,}
  for(let i=1; i<= leng;++i) {
    var nextDay = new Date(a);
      nextDay.setDate(a.getDate() + i);
      
     let b = {[nextDay.getFullYear() + '-' + (nextDay.getMonth()+1) + '-'+nextDay.getDate()]: 0,};
     rs = {...rs,...b};
  }
  return rs;
}
function khoangcach2ngay(str1,str2) {
  return Math.floor(( Date.parse(str1) - Date.parse(str2) ) / 86400000) + 1;
}
function getDays(day, leng) {
  var a = new Date(day);
var nextDay = new Date(a);
nextDay.setDate(a.getDate() + leng)
return nextDay.getFullYear() + '-' + (nextDay.getMonth()+1) + '-'+nextDay.getDate()
}

