const { data } = require("jquery");
$(function() {
        const typeCategory = [
            { "category": "Tổng quát" },
            { "category": 'Triết học' },
            { "category": 'Tôn giáo' },
            { "category": 'Khoa học xã hội' },
            { "category": 'Ngôn ngữ' },
            { "category": 'Toán học và khoa học tự nhiên' },
            { "category": 'Kỹ thuật' },
            { "category": 'Nghệ thuật' },
            { "category": 'Văn học' },
            { "category": 'Địa lý lịch sử' },
        ];
        let myChart;
        let dtt = [];
        let typedata;
        let typeofbooks = $('#typeofbook');
        typeofbooks.change(function() {
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
                        if ($('#typeofbook').val() == 'category') {
                            dtt = [...typeCategory];
                        } else dtt = res;
                        if (res.length != 0) typedata = Object.keys((res[0]))[0];
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
            if (dtt.length == 0) {
                document.querySelector('.dashboard-money-content-search-listsearch-list').innerHTML = '<li>please choose type to search</li>';
            } else {

                if ($(this).val() == '') document.querySelector('.dashboard-money-content-search-listsearch-list').innerHTML = '<li>type some thing</li>';
                else {
                    let rsSearch = dtt.reduce((arr, value) => {

                        return arr.concat(value[typedata].toLowerCase().search($(this).val().toLocaleLowerCase()) != -1 ? `<li>${value[typedata]}</li>` : undefined).filter(x => x != undefined);
                    }, []);
                    if (rsSearch.length == 0) document.querySelector('.dashboard-money-content-search-listsearch-list').innerHTML = '<li>the result is not exist</li>';
                    else document.querySelector('.dashboard-money-content-search-listsearch-list').innerHTML = Array.from(new Set(rsSearch)).join('');
                }
            }
            $('.dashboard-money-content-search-listsearch-list li').on('click', function() {
                $('#searchinput').val($(this).text());

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
                        value: $(this).text(),
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
            setTimeout(() => {
                document.querySelector('.dashboard-money-content-search-listsearch').style.display = 'none';
            }, 200)
        })
        $('#searchinput').on('focusin', function() {

                if ($('#typeofbook').val() != 0 && $(this).val() != '') document.querySelector('.dashboard-money-content-search-listsearch').style.display = 'block';

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
                    const nameBook = res.reduce((arr, value) => {
                        return arr.concat(value.nameBook);
                    }, [])

                    const valueY = res.reduce((arr, value) => {
                        return arr.concat(value.total);
                    }, [])
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
                error: function(jqXHR, textStatus, errorThrown) {}
            })
            //DASHBOARD MONTH
        let dateStart = $("input[name='fromdate']").val();
        let dataEnd = $("input[name='todate']").val();
        $.ajax({
                type: 'POST',
                url: '/ajax/datefromto',
                data: {
                    type: 'month',
                    valuefrom: dateStart,
                    valueto: dataEnd,
                },
                success: function(res) {
                    let dataChart = new Array;
                    let arrLabels = new Array;
                    for (var i = 0; i < res.countDay; i++) {
                        var date = new Date(dateStart);
                        var check = 0;
                        date.setDate(date.getDate() + i);
                        if (i == 0) {
                            arrLabels.push(dateStart)
                        } else if (i == res.countDay - 1) {
                            arrLabels.push(dataEnd)
                        } else {
                            arrLabels.push(' ')
                        }
                        res.data.map((value) => {
                            var dateRes = new Date(value.date);
                            if (dateRes.getTime() === date.getTime()) {
                                dataChart.push(value.total);
                                check = 1;
                            }
                        });
                        if (check == 0) {
                            dataChart.push(0);
                        }
                    }
                    let ctx = document.getElementById('myChart')
                    myChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: arrLabels,
                            datasets: [{
                                label: 'Số đơn',
                                data: dataChart,
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
            let dateto = $(this).prev().val();
            let dataform = $(this).prev().prev().prev().val();
            if (dateto == "" || dataform == "") alert('nhap de ??');
            else {
                $.ajax({
                    type: 'POST',
                    url: '/ajax/datefromto',
                    data: {
                        valueto: dateto,
                        valuefrom: dataform,
                        type: type2,
                    },
                    success: function(res) {
                        let dataChart = new Array;
                        myChart.data.labels = new Array;
                        myChart.data.datasets[0].data = new Array;
                        for (var i = 0; i <= res.countDay; i++) {
                            var date = new Date(dataform);
                            var check = 0;
                            date.setDate(date.getDate() + i);
                            if (i == 0) {
                                myChart.data.labels.push(dataform)
                            } else if (i == res.countDay) {
                                myChart.data.labels.push(dateto)
                            } else {
                                myChart.data.labels.push(' ')
                            }
                            res.data.map((value) => {
                                var dateRes = new Date(value.date);
                                if (dateRes.getTime() === date.getTime()) {
                                    myChart.data.datasets[0].data.push(value.total);
                                    check = 1;
                                }
                            });
                            if (check == 0) {
                                myChart.data.datasets[0].data.push(0);
                            }
                        }
                        myChart.update();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {}
                })
            }
        })
    })
    //function ma hoa tien
const intBindStringMoney = (e) => {
    let arr = [];
    while (e > 0) {
        let test = e % 1000;
        arr.unshift("." + test.toString());
        e = Math.floor(e / 1000);
    }
    return arr.join('').substr(1, arr.join('').length);
}