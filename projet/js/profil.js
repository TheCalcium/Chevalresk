const reg = new RegExp(String.raw`^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$`);
$(document).ready(function () {


    let arrow = false;
    //cahcher elem password du form
    $(".form-row").each(function () {
        if ($(this).attr('id') == 'hiddenZone') {
            $(this).hide();
        }
    });

    $("#modPw").on("click", function (e) {
        if (arrow == false) {
            $("#modPw").attr('name', 'chevron-down-outline');
            $(".form-row").each(function () {
                if ($(this).attr('id') == 'hiddenZone') {
                    $(this).show();
                }
            });
            //cacher zone de mdp dans le form
            arrow = true;
        } else {
            $("#modPw").attr('name', 'chevron-forward-outline');

            $(".form-row").each(function () {
                if ($(this).attr('id') == 'hiddenZone') {
                    $(this).hide();
                }
            }); //cacher zone de mdp dans le form

            arrow = false;
        }

    });
    let alreadySubmit = false;

    $("form").on("submit", function (e) {
        if (!alreadySubmit) {
            if ($("#modPw").attr('name') == 'chevron-down-outline') {
                e.preventDefault();
                let oldPw = $("#oldmdp").val();
                let email2 = $("#email").val();
                let erreur = false;

                function verifInformation(data) {

                    if ((data * 1) == 0) {
                        $("#erreur").text("Ancien mot de passe incorrect");
                        erreur = true;
                    }
                    if ($("#mdp").val() != $("#mdpConfirm").val()) {

                        $("#erreur").text("Mot de passe de confirmation différent du nouveau mot de passe");
                        erreur = true;
                    }
                    if ($("#mdp").val() == "") {
                        $("#erreur").text("Aucun mot de passe saisi");
                        erreur = true;
                    }
                    if (reg.test($("[name='email']").val()) == false) {
                        $("#erreur").text("L'email est incorrect");
                        erreur = true;
                    }
                    $.post("actionModifierProfil.php", { action: "verifEmail", email: email2 }, function (data) {
                        verifEmail(data);
                    });

                }
                function verifEmail(data) {
                    if ((data * 1) == 0) {
                        $("#erreur").text("Adresse courriel déjà utilisée");
                        erreur = true;
                    }

                    if (erreur == false) {
                        //alert("submit");
                        alreadySubmit = true;
                        $("form").submit();
                    } else {
                        document.getElementById("erreur").scrollIntoView();
                    }
                }
                $.post("actionModifierProfil.php", { action: "verifPw", pw: oldPw }, function (data) {
                    verifInformation(data);
                });
            }
            else {
                e.preventDefault();
                let email2 = $("#email").val();
                function verifEmail2(data) {

                    if ((data * 1) == 0) {
                        $("#erreur").text("Adresse courriel déjà utilisée");
                        erreur = true;
                    }
                    if (erreur == false) {
                        $(".form-row").each(function () {
                            if ($(this).attr('id') == 'hiddenZone') {
                                $(this).remove();
                            }
                        });
                        alreadySubmit = true;
                        $("form").submit();
                    } else {
                        document.getElementById("erreur").scrollIntoView();
                    }
                }

                let erreur = false;
                if (reg.test($("[name='email']").val()) == false) {
                    $("#erreur").text("L'email est incorrect");
                    erreur = true;
                }
                $.post("actionModifierProfil.php", { action: "verifEmail", email: email2 }, function (data) {
                    verifEmail2(data);
                });
                
                // verif apres post
            }
        }
    });
});
