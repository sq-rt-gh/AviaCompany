function GetFlights(e) {
    e.preventDefault();

    $.ajax({
        url: "/php/flights.php",
        type: "GET",
        data: {
            from: $("[name=from]").val(),
            to: $("[name=dest]").val(),
            date: $("[name=date]").val()
        },
        success: (data) => {
            if (data == '[]') {
                $("#flights-table").html("<h1>Билеты не найдены.</h1>")
            }
            else {
                flights = JSON.parse(data);
                $("#flights-table").html("");

                flights.forEach(row => {
                    let s = `<tr class=\"tr\">
                                <td>
                                    <div class=\"plane-info\">
                                        <img src=\"pics/${row.img}\" alt=\"No image\">
                                        <p>${row.model}</p>
                                    </div>
                                </td>
                                <td>
                                    <div class=\"city-info\">
                                        <h3>${row.from}</h3>
                                        <p>${row.departure}</p>
                                    </div>
                                </td>
                                <td><p>&#8658;</p></td>
                                <td>
                                    <div class=\"city-info\">
                                        <h3>${row.destination}</h3>
                                        <p>${row.arrival}</p>
                                    </div>
                                </td>
                                <td>
                                    <form action=\"./php/buy.php\" method=\"post\">
                                    <input type=\"hidden\" name=\"flight_id\" value=\"${row.id}\">
                                    <input type=\"submit\" class='buy-btn' value=\"Купить\">
                                    </form>
                                </td>
                            </tr><tr class=\"empty\"></tr>`;
                            $("#flights-table").append(s);
                });
            }
        }
    });
}

function GetCities() {
    $.ajax({
        url: "/php/cities.php",
        type: "GET",
        data: { },
        success: (data) => {
            console.log(data)
            cities = JSON.parse(data);
            $("[name=from]").html("<option selected value=''>Откуда</option>");
            $("[name=dest]").html("<option selected value=''>Куда</option>");

            cities.from.forEach(city => {
                $("[name=from]").append(`<option value='${city}'>${city}</option>`);
            });
            cities.to.forEach(city => {
                $("[name=dest]").append(`<option value='${city}'>${city}</option>`);
            });
        }
    });
}