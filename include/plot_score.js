
$.get("./session.php?getSession", function(data) {
    var json_data_joueur = $.parseJSON(data);
    var joueur_id = json_data_joueur["joueur_id"];
    if (joueur_id && joueur_id != null) {
        $.get("./get_historique_score_joueur.php?joueur_id="+joueur_id, function(data) {
            var json_data_scores = $.parseJSON(data);
            var dt = json_data_scores['dt'];
            var points = json_data_scores['points'];

            var trace1 = {
              x: dt,
              y: points,
              type: 'scatter'
            };

            var data = [trace1];

            var layout = {
            title: false,
            showlegend: false,
              xaxis: {
              },
              yaxis: {
              },
              margin: {
                  t:0,
                  b:0,
                  l:0,
                  r:0,
                  pad:0
              }
            };

            Plotly.newPlot('tester', data, layout, {displayModeBar: false, responsive: true});
        });
    }
});
