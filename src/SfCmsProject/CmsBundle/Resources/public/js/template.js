$(function () {
    // On cache tous les gifs
    $("#loadingViewTemplatePage").hide();


    // Charge le template de vue des template de page
    $('.viewTemplatePage').on('click', function (e) {
        e.preventDefault();
        $("#loadingViewTemplatePage").show();

        $.ajax({
            type: "POST",
            url: $(this).attr('href'),
            success: function (response) {
                $("#loadingViewTemplatePage").hide();
                $("#templateLoad").html(response);
                addTemplateValid();
                loadViewTemplate();
                editTemplateValid();


            }
        });
    });

    // Enregistre l'ajout de template en BDD
    function addTemplateValid() {
        $('.addTemplateFormValid').on('submit', function (e) {
            e.preventDefault();
            var name = $('#sfcmsproject_cmsbundle_addtemplate_name').val();
            var content = $('#sfcmsproject_cmsbundle_addtemplate_content').val();
            var csrf = $('#csrfTemplatePage').val();
            $("#loadingViewTemplatePage").show();

            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: {
                    name: name,
                    content: content,
                    csrf: csrf
                },
                success: function (response) {
                    $("#loadingViewTemplatePage").hide();
                    $("#templateLoad").html(response);
                    addTemplateValid();
                    loadViewTemplate();
                    $("#addTemplatePageSuccess").fadeIn(1000);
                    $("#addTemplatePageSuccess").fadeOut(1000);

                }
            });
        });
    }
    // Enregistre l'edition de template en BDD
    function editTemplateValid() {
        $('.editTemplateFormValid').on('submit', function (e) {
            e.preventDefault();
            var name = $('#sfcmsproject_cmsbundle_edittemplate_name').val();
            var content = $('#sfcmsproject_cmsbundle_edittemplate_content').val();
            var csrf = $('#csrfEditTemplatePage').val();
            $("#loadingViewTemplatePage").show();

            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: {
                    name: name,
                    supName : presentName,
                    content: content,
                    csrf: csrf
                },
                success: function (response) {
                    $("#loadingViewTemplatePage").hide();
                    presentName = response;
                    loadViewEditTemplate();
                    loadViewListTemplatePage();
                    $("#editTemplatePageSuccess").fadeIn(1000);
                    $("#editTemplatePageSuccess").fadeOut(1000);


                }
            });
        });
    }
    // Va chercher la vue du template en BDD
    function loadViewTemplate() {
        $('.btnLoadViewTemplate').on('click', function (e) {
            e.preventDefault();
            var name = $(this).data('name');
            presentName = $(this).data('name');
            thisPathLoad = $(this).data('path');
            thisPathReloadList = $(this).data('reload');
            pathFormEdit = $(this).data('edit');
            $("#loadViewTemplate").html("");
            loadDataFormEdit();
            $("#loadingViewTemplatePage").show();

            $.ajax({
                type: "POST",
                url: thisPathLoad,
                data: {
                    name: name
                },
                success: function (response) {
                    $("#loadingViewTemplatePage").hide();
                    $("#loadViewTemplate").html(response);
                },
                error:function (request, status, error) {
                    $("#loadViewTemplatePage").html("Une erreur s'est produite, vérifiez l'ensemble de vos variables");
                }
            });
        });
    }
    // Va chercher la vue du template en BDD après un edit
    function loadViewEditTemplate() {
            $("#loadingViewTemplatePage").show();

            $.ajax({
                type: "POST",
                url: thisPathLoad,
                data: {
                    name: presentName
                },
                success: function (response) {
                    $("#loadingViewTemplatePage").hide();
                    loadDataFormEdit();
                    $("#loadViewTemplate").html(response);
                }
            });
    }
    // Supprime le template de la BDD
    function supTemplateValid() {
        $('.supTemplate').on('click', function (e) {
            e.preventDefault();
            var pathLoad = $(this).data('path');
            var csrf = $('#csrfSupTemplatePage').val();
            $("#loadingViewTemplatePage").show();
            $.ajax({
                type: "POST",
                url: pathLoad,
                data: {
                    name: presentName,
                    csrf: csrf
                },
                success: function (response) {
                    $("#loadingViewTemplatePage").hide();
                    $("#templateLoad").html(response);
                    addTemplateValid();
                    loadViewTemplate();
                    editTemplateValid();
                    $("#removeTemplatePageSuccess").fadeIn(1000);
                    $("#removeTemplatePageSuccess").fadeOut(1000);

                }
            });
        });
    }
    // Hydrate le formulaire d'édition
    function loadDataFormEdit() {
        $.ajax({
            type: "POST",
            url: pathFormEdit,
            data: {
                presentName: presentName
            },
            success: function (response) {
                $("#templateFormEdit").html(response);
                editTemplateValid();
                supTemplateValid();
            }
        });
    }
     // Actualise la liste des noms de template de page
    function loadViewListTemplatePage() {
        $("#loadingViewTemplatePage").show();

        $.ajax({
            type: "POST",
            url: thisPathReloadList,
            success: function (response) {
                $("#loadingViewTemplatePage").hide();
                $("#listNameTemplate").html(response);
                loadViewTemplate();
            }
        });
    }
});
