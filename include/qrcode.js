function openQRCamera(node) {
    var reader = new FileReader();
    reader.onload = function() {
        node.value = "";
        qrcode.callback = function(qrcode) {
            if(qrcode instanceof Error) {
                $('#modalText').html("Aucun code trouvé sur la photo. Réessayez");
                $('#exampleModal').modal();
            } else {
                $.get("./session.php?getSession", function(data) {
                    var json_data_joueur = $.parseJSON(data);
                    var joueurId = json_data_joueur["joueur_id"];
                    var associationId = json_data_joueur["association_id"];
                    if (joueurId && joueurId != null && associationId && associationId != null) {
                        data = { totem_code: qrcode, joueur_id: joueurId, association_id: associationId };
                        $.post("./create_scan.php", data).done(function (receive) {
                            console.log(receive);
                            $('#modalText').html(receive);
                            $('#exampleModal').modal();
                        });
                        $('#nom').val(qrcode);
                        $('#bouton_valider_scan').prop('disabled',false);
                    }
                });
            }
        };
        qrcode.decode(reader.result);
    };
    reader.readAsDataURL(node.files[0]);
}
