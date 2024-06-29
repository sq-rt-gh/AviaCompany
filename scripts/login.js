let hidden = true;

function Reg(e) {
    e.preventDefault();
    $(".hide").attr("hidden", !hidden);
    if (hidden) {
        $("#msg").html("Регистрация");
        $("#reg").html("Войти");
        $("[type=submit]").val("Создать аккаунт");
    }
    else {
        $("#msg").html("Авторизация");
        $("#reg").html("Регистрация");        
        $("[type=submit]").val("Войти");
    }
    hidden = !hidden;
}

function Login(e) {
    e.preventDefault();
    $.ajax({
        url: "/php/login.php",
        type: "POST",
        data: {
            isLogin: hidden,
            login: $("#login").val(),
            pswd: $("#pswd").val(),
            pswd2: $("#pswd2").val(),
            name: $("#name").val()
        },
        success: (data) => {
            if (data=="ok") {
                window.location = "/profile.php";
            }
            else {
                $("#msg").html(data)
            }
        }
    });
}