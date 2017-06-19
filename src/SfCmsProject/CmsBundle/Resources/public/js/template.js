$(function () {
    // On cache tous les gifs
    $("#loadingViewTemplatePage").hide();

    function iconeTemplateOn() {
        $('.formAjoutTemplate').on('click', function () {
            if ($('#iconeTemplate').hasClass('fa fa-chevron-circle-right')) {
                $('#iconeTemplate').removeClass('fa fa-chevron-circle-right').addClass('fa fa-chevron-circle-down');
            }
            else {
                $('#iconeTemplate').removeClass('fa fa-chevron-circle-down').addClass('fa fa-chevron-circle-right');
            }
        });
    }

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
                iconeTemplateOn();
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
                    iconeTemplateOn();
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
            var pathLoad = $(this).data('path');
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

                }
            });
        });
    }
});
