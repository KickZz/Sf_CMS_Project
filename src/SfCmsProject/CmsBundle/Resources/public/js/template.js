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
            $("#loadingViewTemplatePage").show();

            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: {
                    name: name,
                    content: content
                },
                success: function (response) {
                    $("#loadingViewTemplatePage").hide();
                    $("#templateLoad").html(response);
                    addTemplateValid();
                    loadViewTemplate();

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
            $("#loadingViewTemplatePage").show();

            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: {
                    name: name,
                    presentName : presentName,
                    content: content
                },
                success: function (response) {
                    $("#loadingViewTemplatePage").hide();
                    $("#templateLoad").html(response);
                    addTemplateValid();
                    loadViewTemplate();


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
            var pathLoad = $(this).data('path');
            pathFormEdit = $(this).data('edit');
            $("#loadingViewTemplatePage").show();

            $.ajax({
                type: "POST",
                url: pathLoad,
                data: {
                    name: name
                },
                success: function (response) {
                    $("#loadingViewTemplatePage").hide();
                    $("#loadViewTemplate").html(response);
                    loadDataFormEdit();

                }
            });
        });
    }
    // Va chercher la vue du template en BDD
    function supTemplateValid() {
        $('.supTemplate').on('click', function (e) {
            e.preventDefault();
            var pathLoad = $(this).data('path');
            $("#loadingViewTemplatePage").show();
            $.ajax({
                type: "POST",
                url: pathLoad,
                data: {
                    name: presentName
                },
                success: function (response) {
                    $("#loadingViewTemplatePage").hide();
                    $("#templateLoad").html(response);
                    addTemplateValid();
                    loadViewTemplate();
                    editTemplateValid();

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
                supTemplateValid()


            }
        });
    }
});
