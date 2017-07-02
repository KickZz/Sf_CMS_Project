$(function () {
    // On cache tous les gifs
    $("#loadingViewTemplatePost").hide();


    // Charge le template de vue des template de post
    $('.viewTemplatePost').on('click', function (e) {
        e.preventDefault();
        $("#loadingViewTemplatePost").show();

        $.ajax({
            type: "POST",
            url: $(this).attr('href'),
            success: function (response) {
                $("#loadingViewTemplatePost").hide();
                $("#templateLoad").html(response);
                addTemplatePostValid();
                loadViewTemplatePost();
                editTemplatePostValid();


            }
        });
    });

    // Enregistre l'ajout de template en BDD
    function addTemplatePostValid() {
        $('.addTemplatePostFormValid').on('submit', function (e) {
            e.preventDefault();
            var name = $('#sfcmsproject_cmsbundle_addtemplate_post_name').val();
            var content = $('#sfcmsproject_cmsbundle_addtemplate_post_content').val();
            var csrf = $('#csrfTemplatePost').val();
            $("#loadingViewTemplatePost").show();

            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: {
                    name: name,
                    content: content,
                    csrf: csrf
                },
                success: function (response) {
                    $("#loadingViewTemplatePost").hide();
                    $("#templateLoad").html(response);
                    addTemplatePostValid();
                    loadViewTemplatePost();
                    $("#addTemplatePostSuccess").fadeIn(1000);
                    $("#addTemplatePostSuccess").fadeOut(1000);

                }
            });
        });
    }
    // Enregistre l'edition de template en BDD
    function editTemplatePostValid() {
        $('.editTemplatePostFormValid').on('submit', function (e) {
            e.preventDefault();
            var name = $('#sfcmsproject_cmsbundle_edittemplate_post_name').val();
            var content = $('#sfcmsproject_cmsbundle_edittemplate_post_content').val();
            $("#loadingViewTemplatePost").show();
            var csrf = $('#csrfEditTemplatePost').val();

            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: {
                    name: name,
                    supName : presentNamePost,
                    content: content,
                    csrf: csrf
                },
                success: function (response) {
                    $("#loadingViewTemplatePost").hide();
                    loadViewEditTemplatePost();
                    presentNamePost = response;
                    loadViewEditTemplatePost();
                    loadViewListTemplatePost();
                    $("#editTemplatePostSuccess").fadeIn(1000);
                    $("#editTemplatePostSuccess").fadeOut(1000);


                }
            });
        });
    }
    // Va chercher la vue du template en BDD
    function loadViewTemplatePost() {
        $('.btnLoadViewTemplatePost').on('click', function (e) {
            e.preventDefault();
            var name = $(this).data('name');
            presentNamePost = $(this).data('name');
            thisPathLoadPost = $(this).data('path');
            thisPathReloadListPost = $(this).data('reload');
            pathFormEditPost = $(this).data('edit');
            loadDataFormEditPost();
            $("#loadingViewTemplatePost").show();

            $.ajax({
                type: "POST",
                url: thisPathLoadPost,
                data: {
                    name: name
                },
                success: function (response) {
                    $("#loadingViewTemplatePost").hide();
                    $("#loadViewTemplatePost").html(response);
                },
                error:function (request, status, error) {
                    $("#loadViewTemplatePost").html("Une erreur s'est produite, vérifiez l'ensemble de vos variables");
                }
            });
        });
    }
    // Va chercher la vue du template en BDD après un edit
    function loadViewEditTemplatePost() {
        $("#loadingViewTemplatePost").show();

        $.ajax({
            type: "POST",
            url: thisPathLoadPost,
            data: {
                name: presentNamePost
            },
            success: function (response) {
                $("#loadingViewTemplatePost").hide();
                loadDataFormEditPost();
                $("#loadViewTemplatePost").html(response);


            }
        });
    }
    // Supprime le template de la BDD
    function supTemplatePostValid() {
        $('.supTemplatePost').on('click', function (e) {
            e.preventDefault();
            var pathLoad = $(this).data('path');
            var csrf = $('#csrfSupTemplatePost').val();
            $("#loadingViewTemplatePost").show();
            $.ajax({
                type: "POST",
                url: pathLoad,
                data: {
                    name: presentNamePost,
                    csrf: csrf
                },
                success: function (response) {
                    $("#loadingViewTemplatePost").hide();
                    $("#templateLoad").html(response);
                    addTemplatePostValid();
                    loadViewTemplatePost();
                    editTemplatePostValid();
                    $("#removeTemplatePostSuccess").fadeIn(1000);
                    $("#removeTemplatePostSuccess").fadeOut(1000);

                }
            });
        });
    }
    // Hydrate le formulaire d'édition
    function loadDataFormEditPost() {
        $.ajax({
            type: "POST",
            url: pathFormEditPost,
            data: {
                presentName: presentNamePost
            },
            success: function (response) {
                $("#templateFormEditPost").html(response);
                editTemplatePostValid();
                supTemplatePostValid()


            }
        });
    }
    // Actualise la liste des noms de template de post
    function loadViewListTemplatePost() {
        $("#loadingViewTemplatePost").show();

        $.ajax({
            type: "POST",
            url: thisPathReloadListPost,
            success: function (response) {
                $("#loadingViewTemplatePost").hide();
                $("#listNameTemplate").html(response);
                loadViewTemplatePost();
            }
        });
    }
});