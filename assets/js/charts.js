$(function () {
    if (document.getElementById('totalChart')) {
        var ctx = document.getElementById('totalChart').getContext('2d');

        var currentEngagements = $('canvas').data('currentengagements');
        var logins = $('canvas').data('logins');
        let months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        let currentMonth = new Date().getMonth();
        Chart.defaults.font.size = 20;
        var options = new Chart(
            ctx, {
                type: 'line',
                data: {
                    labels: months.slice(currentMonth - 12).concat(months.slice(0, currentMonth)),
                    datasets: [{
                        label: 'Curently engaged employees',
                        data: currentEngagements,
                        backgroundColor: [
                            'rgba(255, 255, 255, 0.2)',
                        ],
                        borderColor: [
                            'rgba(125, 217, 175, 1)',
                        ],
                        pointBorderColor: [
                            'rgba(125, 217, 175, 1)',
                            'rgba(125, 217, 175, 1)',
                        ],
                        borderWidth: 5
                    },
                        {
                            label: 'Logins',
                            data: logins,
                            backgroundColor: [
                                'rgba(255, 255, 255, 0.2)',
                            ],
                            borderColor: [
                                'rgba(211, 211, 211, 1)',
                            ],
                            pointBorderColor: [
                                'rgba(211, 211, 211, 1)',
                            ],
                            borderWidth: 5
                        }],
                },
                options: {
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            min: 0,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            labels: {
                                font: {
                                    size: 20,
                                }
                            },
                            legend: {
                                labels: {
                                    size: 20,
                                    color: 'rgba(211, 211, 211, 1)',
                                }
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    },
                }
            }
        );
    }

});


