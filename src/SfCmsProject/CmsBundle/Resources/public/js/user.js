$(function () {
    // On cache tous les gifs
    $("#loadingViewUser").hide();
    $("#loadingViewProfilUser").hide();

    function init() {
        editUser();
        suppressionUser();

    }
    // Charge le template de vue des template des utilisateurs
    $('.viewUser').on('click', function (e) {
        e.preventDefault();
        $("#loadingViewUser").show();

        $.ajax({
            type: "POST",
            url: $(this).attr('href'),
            success: function (response) {
                $("#loadingViewUser").hide();
                $("#templateLoad").html(response);
                init();
                addUserValid();
            }
        });
    });
    // Charge le template de vue d'edition de profil
    $('.viewProfilUser').on('click', function (e) {
        e.preventDefault();
        $("#loadingViewProfilUser").show();

        $.ajax({
            type: "POST",
            url: $(this).attr('href'),
            success: function (response) {
                $("#loadingViewProfilUser").hide();
                $("#templateLoad").html(response);
                editProfilUserValid();
            }
        });
    });
    // Enregistre les changement dans la BDD
    function editProfilUserValid() {
        $('.editProfilUserFormValid').on('submit', function (e) {
            e.preventDefault();
            var username = $('#sfcmsproject_cmsbundle_editprofiluser_username').val();
            var plainTextPassword = $('#sfcmsproject_cmsbundle_editprofiluser_plainTextPassword').val();
            var email = $('#sfcmsproject_cmsbundle_editprofiluser_email').val();
            var signature = $('#sfcmsproject_cmsbundle_editprofiluser_signature').val();
            var csrf = $('#csrfEditProfilUser').val();
            $("#loadingViewProfilUser").show();

            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: {
                    username: username,
                    plainTextPassword: plainTextPassword,
                    email: email,
                    csrf: csrf,
                    signature: signature
                },
                success: function (response) {
                    $("#loadingViewProfilUser").hide();
                    $("#templateLoad").html(response);
                    init();
                    addUserValid();
                    $("#editProfilUserSuccess").fadeIn(1000);
                    $("#editProfilUserSuccess").fadeOut(1000);
                }
            });
        });
    }


    // Enregistre l'ajout de l'utilisateur en BDD
    function addUserValid() {
        $('.addUserFormValid').on('submit', function (e) {
            e.preventDefault();

            var username = $('#sfcmsproject_cmsbundle_adduser_username').val();
            var plainTextPassword = $('#sfcmsproject_cmsbundle_adduser_plainTextPassword').val();
            var email = $('#sfcmsproject_cmsbundle_adduser_email').val();
            var signature = $('#sfcmsproject_cmsbundle_adduser_signature').val();
            var roles = $('#sfcmsproject_cmsbundle_adduser_roles').val();
            var csrf = $('#csrfAddUser').val();

            $("#loadingViewUser").show();

            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: {
                    username: username,
                    plainTextPassword: plainTextPassword,
                    email: email,
                    signature: signature,
                    csrf: csrf,
                    roles: roles
                },
                success: function (response) {
                    $("#loadingViewUser").hide();
                    $("#templateLoad").html(response);
                    addUserValid();
                    $("#addUserSuccess").fadeIn(1000);
                    $("#addUserSuccess").fadeOut(1000);

                }
            });
        });
    }
    // Charge le template d'édition d'utilisateur
    function editUser() {
        $('.editUserForm').on('click', function (e) {
            e.preventDefault();
            $("#loadingViewUser").show();

            $.ajax({
                type: "POST",
                url: $(this).attr('href'),
                success: function (response) {
                    $("#loadingViewUser").hide();
                    $("#templateLoad").html(response);
                    editUserValid();
                }
            });
        });
    }
    // Enregistre les changement dans la BDD
    function editUserValid() {
        $('.editUserFormValid').on('submit', function (e) {
            e.preventDefault();
            var roles = $('#sfcmsproject_cmsbundle_user_roles').val();
            var csrf = $('#csrfEditUser').val();
            $("#loadingViewUser").show();

            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: {
                    csrf: csrf,
                    roles: roles
                },
                success: function (response) {
                    $("#loadingViewUser").hide();
                    $("#templateLoad").html(response);
                    init();
                    $("#editUserSuccess").fadeIn(1000);
                    $("#editUserSuccess").fadeOut(1000);
                }
            });
        });
    }
    // Supprime l'utilisateur de la BDD
    function suppressionUser() {



        $('.suppressionUser').on('submit', function (e) {

            e.preventDefault();
            var idUser = $(this).data("user");
            var csrf = $('#csrf'+ idUser).val();
            $("#loadingViewUser").show();



            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: {
                    csrf: csrf
                },
                success: function (response) {
                    $("#loadingViewUser").hide();
                    $("#templateLoad").html(response);
                    init();
                    $("#supUserSuccess").fadeIn(1000);
                    $("#supUserSuccess").fadeOut(1000);
                }
            });

        });

    }

});
