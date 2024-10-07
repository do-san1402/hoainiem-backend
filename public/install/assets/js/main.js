$(document).ready(function () {
    ("use strict");
    $("#install-composer").click(function () {
        $("#install-composer").attr("disabled", true);
        $("#install-composer").html("Installing...");
        $("#previous-btn").attr("disabled", true);
        axios
            .post("./", {
                action: "composer install",
            })
            .then((res) => {
                if (res.data.status) {
                    document.getElementById("status").innerHTML =
                        "<div class='alert alert-success'>" +
                        res.data.message +
                        "</div>";
                    $("#install-composer").html("Installed");
                    countdown(5, "./?a=env_requirement");
                } else {
                    document.getElementById("status").innerHTML =
                        "<div class='alert alert-danger'>" +
                        res.data.message +
                        "</div>";
                    $("#install-composer").html("Install Composer");
                    countdown(5, "./?a=env_requirement");
                }
            })
            .catch((err) => {
                document.getElementById("status").innerHTML =
                    "<div class='alert alert-danger'>" +
                    err.data.message +
                    "</div>";
            });
    });

    /**
     * Create .env file
     *
     */
    $("#create-env").click(function () {
        $("#create-env").attr("disabled", true);
        $("#create-env").html("Creating...");
        $("#previous-btn").attr("disabled", true);
        axios
            .post("./", {
                action: "create .env file",
            })
            .then((res) => {
                if (res.data.status) {
                    document.getElementById("status").innerHTML =
                        "<div class='alert alert-success'>" +
                        res.data.message +
                        "</div>";
                    $("#create-env").html("Crated");
                    countdown(5, "./?a=db_configuration");
                } else {
                    document.getElementById("status").innerHTML =
                        "<div class='alert alert-danger'>" +
                        res.data.message +
                        "</div>";
                    $("#create-env").html("Create .env file");
                    countdown(5, "./?a=env_requirement");
                }
            })
            .catch((err) => {
                document.getElementById("status").innerHTML =
                    "<div class='alert alert-danger'>" +
                    err.data.message +
                    "</div>";
            });
    });

    /**
     * DB config
     */
    $("#db-config").on("submit", function (e) {
        e.preventDefault();
        var form = $(this);
        $("#db-config-btn").attr("disabled", true);
        $("#db-config-btn").html("Connecting...");
        $("#previous-btn").attr("disabled", true);
        var data = form.serialize();

        axios
            .post("./", data)
            .then((res) => {
                if (res.data.status) {
                    document.getElementById("status").innerHTML =
                        "<div class='alert alert-success'>" +
                        res.data.message +
                        "</div>";
                    $("#db-config-btn").html("Connected");
                    countdown(5, "./?a=admin_configuration");
                } else {
                    document.getElementById("status").innerHTML =
                        "<div class='alert alert-danger'>" +
                        res.data.message +
                        "</div>";
                    $("#db-config-btn").html("Failed");
                    countdown(5, "./?a=db_configuration");
                }
            })
            .catch((err) => {
                $("#db-config-btn").attr("disabled", false);
                $("#db-config-btn").html("Connect");
                $("#previous-btn").attr("disabled", false);
                document.getElementById("status").innerHTML =
                    "<div class='alert alert-danger'>" +
                    err.data.message +
                    "</div>";
            });
    });
    /**
     *  Admin Config
     */
    $("#admin-config").on("submit", function (e) {
        e.preventDefault();
        var form = $(this);
        $("#admin-config-btn").attr("disabled", true);
        $("#admin-config-btn").html("Connecting...");
        $("#previous-btn").attr("disabled", true);
        var data = form.serialize();

        axios
            .post("./", data)
            .then((res) => {
                if (res.data.status) {
                    document.getElementById("status").innerHTML =
                        "<div class='alert alert-success'>" +
                        res.data.message +
                        "</div>";
                    $("#admin-config-btn").html("Created");
                    countdown(5, "./");
                } else {
                    document.getElementById("status").innerHTML =
                        "<div class='alert alert-danger'>" +
                        res.data.message +
                        "</div>";
                    $("#admin-config-btn").html("Failed");
                    countdown(5, "./?a=admin_configuration");
                }
            })
            .catch((err) => {
                $("#admin-config-btn").attr("disabled", false);
                $("#admin-config-btn").html("Connect");
                $("#previous-btn").attr("disabled", false);
                document.getElementById("status").innerHTML =
                    "<div class='alert alert-danger'>" +
                    err.data.message +
                    "</div>";
            });
    });
});

function countdown(count = 10, $url = "./") {
    $("#timer").html(
        "<div class='alert alert-info'>Your page is automatic reload after <strong  id='countdown'></strong></div>"
    );
    var timer = setInterval(function () {
        count--;
        if (count == 0) {
            clearInterval(timer);
            window.location.href = $url;
        } else {
            $("#countdown").text(count);
        }
    }, 1000);
}
