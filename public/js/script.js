/*
function clickbutton(){
   var text = document.getElementById("myInput").value;


    $.post('ha_select_patient.php', {postname: text},
        function(data){
            document.getElementById("patientList").innerHTML = data;

        });
}*/
$(document).ready(function($) {
    $(".table-row").click(function() {
        window.document.location = $(this).data("href");
    });
    $("#myInput").on("keyup", function() {
        console.warn('test');
        var value = $(this).val().toLowerCase();
        $("#myTable tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });

    });
});
function myFunction() {
    var input, filter, ul, li, a, i, txtValue;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();

    ul = document.getElementById("patientOverview");

    li = ul.getElementsByTagName("tr");
    for(i = 0; i < li.length; i++) {
        // a = li[i].getElementsByTagName("a")[0];
        txtValue = li[i].innerText;


        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";

        } else {
            li[i].style.display = "none";
        }
    }
}
