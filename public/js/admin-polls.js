(function($){
    $(function(){

        $('.add-answer').on('click', function (e) {
            var count = $('#answers-container > .row').length;
            e.preventDefault();

            count = count+1;
            var answerInput =
                    '<div class="row">'+
                        '<div class="input-field col s9 m9 l9">'+
                            '<input id="answers" name="answers[]" type="text" class="answers validate">'+
                            '<label for="answers">Ответ - '+count+'</label>'+
                        '</div>'+
                        '<div class="col s3 m3 l3 left-align">'+
                            '<a class="btn-floating btn-medium waves-effect waves-light red delete-answer" href="#"><i class="material-icons">delete</i></a>'+
                        '</div>'+
                    '</div>';
            $(answerInput).hide().appendTo('#answers-container').fadeIn('3000');

            $('.delete-answer').on('click', function (e) {
                e.preventDefault();

                $(this).parent().parent().remove();
            });
        });

        $('.delete-poll-btn').on('click', function (e) {
            e.preventDefault();

            var pollId = $(this).attr('id');

            $.ajax({
                url : '/admin/polls/delete',
                method : 'POST',
                data : {'pollId' : pollId},
                dataType: "json",
                success : function(response){
                    if(response.result == true){
                        Materialize.toast('Опрос успешно удален', 4000, 'top');
                        setTimeout(function(){
                            location.href = location;
                        }, 1000);

                    } else {
                        Materialize.toast(response.result, 4000, 'top');
                    }
                }
            });
        });

        $('.delete-answer').on('click', function (e) {
            e.preventDefault();

            $(this).parent().parent().remove();
        });



    });
})(jQuery);

function initPollStatisticsChart(statistics)
{
    var statsObject = JSON.parse(statistics);

    var chartLabels = Object.keys(statsObject);

    var chartValues = Object.keys(statsObject).map(function(key) {
        return statsObject[key];
    });

    var ctx = document.getElementById("statistics-chart");

    var chartCanvas = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: chartLabels,
            datasets: [{
                label: ' голосов',
                data: chartValues,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            legend: {
                display: false,
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
        }
    });
}