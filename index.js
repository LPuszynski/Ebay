   $(document).ready(function () {
            var nombre = 1;
            $("#next").click(function () {

                nombre = nombre + 1;
                var nbrsrc = "cigares" + nombre + ".jpg";
                $("#cigare").attr("src", nbrsrc);
                if (nombre == 4) {
                    nombre = 0;
                }
            });
            $("#previous").click(function () {

                nombre = nombre - 1;
                if (nombre == 0) {
                    nombre = 4;
                }
                var nbrsrc = "cigares" + nombre + ".jpg";
                $("#cigare").attr("src", nbrsrc);
                if (nombre == 1) {
                    nombre = 4;
                }
            });
            $("div").ready(function auto() {
                setTimeout(function () {
                    nombre = nombre + 1;
                    var nbrsrc = "cigares" + nombre + ".jpg";
                    $("#cigare").attr("src", nbrsrc);
                    if (nombre == 4) {
                        nombre = 1;
                    }
                    auto();
                }, 7500);
            });

        });