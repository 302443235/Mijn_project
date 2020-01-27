/*
function clickbutton(){
   var text = document.getElementById("myInput").value;



}*/

$(document).ready(function($) {

        $('a[data-toggle=modal], button[data-toggle=modal]').click(function () {

            var data_id = '';
            var data_name = '';


            if (typeof $(this).data('name') !== 'undefined') {

                data_name = $(this).data('name');
                document.getElementById("modaltitle").innerHTML = data_name;


            }

            if (typeof $(this).data('id') !== 'undefined') {

                data_id = $(this).data('id');

            }
            //document.getElementById("modalbody").innerText =  ;
            $.post('gegevens_patient.php', {postname: data_id},
                function(data){
                    document.getElementById("modalbody").innerHTML = data;


                });
        })

    $("#myInput").on("keyup", function() {

        var input = document.getElementById("myInput");
        var upper = input.value.toUpperCase();

        var getTable = document.getElementById("patientOverview");

        var getTr = getTable.getElementsByTagName("tr");
        for(var i = 0; i < getTr.length; i++) {
            // a = li[i].getElementsByTagName("a")[0];
            var txt = getTr[i].innerText;

            if (txt.toUpperCase().indexOf(upper) > -1) {
                getTr[i].style.display = "";

            } else {
                getTr[i].style.display = "none";
            }
        }


    });
});

