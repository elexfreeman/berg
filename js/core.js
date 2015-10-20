/**
 * Created by elex on 15-Oct-15.
 */
function Search()
{

    var city_start=$("#city_start option:selected").val();
    var city=$("#city option:selected").val();
    var date_start=$("#date_start").val();
    var date_stop=$("#date_stop").val();
    var ship=$("#ship option:selected").val();
    $(".search-resul").html("Поиск...");
    $.get(
        "ajax.html",
        {
            //log1:1,
            action: "Search",
            city_start: city_start,
            city: city,
            date_start: date_start,
            date_stop: date_stop,
            ship: ship,
        },
        function (data) {
          //  console.info(data);
            $(".search-resul").html(data);


        }, "html"
    ); //$.get  END
}