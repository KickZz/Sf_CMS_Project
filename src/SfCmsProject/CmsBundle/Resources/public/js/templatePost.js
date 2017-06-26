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
            $("#loadingViewTemplatePost").show();

            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: {
                    name: name,
                    content: content
                },
                success: function (response) {
                    $("#loadingViewTemplatePost").hide();
                    $("#templateLoad").html(response);
                    addTemplatePostValid();
                    loadViewTemplatePost();

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

            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: {
                    name: name,
                    presentName : presentNamePost,
                    content: content
                },
                success: function (response) {
                    $("#loadingViewTemplatePost").hide();
                    $("#templateLoad").html(response);
                    addTemplatePostValid();
                    loadViewEditTemplatePost();


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
            pathFormEditPost = $(this).data('edit');
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
                    loadDataFormEditPost();

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
                $("#loadViewTemplatePost").html(response);
                loadDataFormEditPost();
                loadViewTemplatePost();

            }
        });
    }
    // Supprime le template de la BDD
    function supTemplatePostValid() {
        $('.supTemplatePost').on('click', function (e) {
            e.preventDefault();
            var pathLoad = $(this).data('path');
            $("#loadingViewTemplatePost").show();
            $.ajax({
                type: "POST",
                url: pathLoad,
                data: {
                    name: presentNamePost
                },
                success: function (response) {
                    $("#loadingViewTemplatePost").hide();
                    $("#templateLoad").html(response);
                    addTemplatePostValid();
                    loadViewTemplatePost();
                    editTemplatePostValid();

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
});