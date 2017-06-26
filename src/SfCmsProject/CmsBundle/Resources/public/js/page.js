
$(function () {
    // On cache tous les gifs
    $("#loadingTemplateAjouterPage").hide();
    $("#loadingTemplateListPage").hide();


    $('#page').on('shown.bs.collapse', function () {
        $('#iconePage').removeClass('fa fa-chevron-circle-right').addClass('fa fa-chevron-circle-down');
    });
    $('#page').on('hidden.bs.collapse', function () {
        $('#iconePage').removeClass('fa fa-chevron-circle-down').addClass('fa fa-chevron-circle-right');
    });
    $('#reglage').on('shown.bs.collapse', function () {
        $('#iconeReglage').removeClass('fa fa-chevron-circle-right').addClass('fa fa-chevron-circle-down');
    });
    $('#reglage').on('hidden.bs.collapse', function () {
        $('#iconeReglage').removeClass('fa fa-chevron-circle-down').addClass('fa fa-chevron-circle-right');
    });
    $('#personnalisation').on('shown.bs.collapse', function () {
        $('#iconePersonnalisation').removeClass('fa fa-chevron-circle-right').addClass('fa fa-chevron-circle-down');
    });
    $('#personnalisation').on('hidden.bs.collapse', function () {
        $('#iconePersonnalisation').removeClass('fa fa-chevron-circle-down').addClass('fa fa-chevron-circle-right');
    });


    function init() {
        editPage();
        suppressionPage();

    }
    function initTinyMCECustom() {
        tinymce.remove();
        tinymce.init({
            selector:'.tinymce',
            branding: false,
            height : 400,
            language_url: '../fr_FR.js',
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | fontsizeselect | fontselect",
            fontsize_formats: '8pt 11pt 10pt 12pt 14pt 18pt 24pt 36pt',
            font_format:'Andale Mono=andale mono,times;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;Georgia=georgia,palatino;Helvetica=helvetica;Impact=impact,chicago;Symbol=symbol;Tahoma=tahoma,arial,helvetica,sans-serif;Terminal=terminal,monaco;Times New Roman=times new roman,times;Trebuchet MS=trebuchet ms,geneva;Verdana=verdana,geneva;Webdings=webdings;Wingdings=wingdings,zapf dingbats'

        });
    }

    // Charge le template du formulaire de création de page
    $('.ajoutPage').on('click', function (e) {
        e.preventDefault();
        $("#loadingTemplateAjouterPage").show();

        $.ajax({
            type: "POST",
            url: $(this).attr('href'),
            success: function (response) {
                $("#loadingTemplateAjouterPage").hide();
                $("#templateLoad").html(response);
                initTinyMCECustom();
                addPageValid();

            }
        });
    });
    // Charge le template de la liste des pages
    $('.listPage').on('click', function (e) {
        e.preventDefault();
        $("#loadingTemplateListPage").show();

        $.ajax({
            type: "POST",
            url: $(this).attr('href'),
            success: function (response) {
                $("#loadingTemplateListPage").hide();
                $("#templateLoad").html(response);
                init();
            }
        });
    });

    // Charge le template d'édition de page
    function editPage() {
        $('.editPageForm').on('click', function (e) {
            e.preventDefault();
            $("#loadingTemplateListPage").show();

            $.ajax({
                type: "POST",
                url: $(this).attr('href'),
                success: function (response) {
                    $("#loadingTemplateListPage").hide();
                    $("#templateLoad").html(response);
                    editPageValid();
                    initTinyMCECustom();

                }
            });
        });
    }
    // Enregistre les changement dans la BDD
    function editPageValid() {
        $('.editPageFormValid').on('submit', function (e) {
            e.preventDefault();
            tinyMCE.triggerSave(true, true);
            var name = $('#sfcmsproject_cmsbundle_page_name').val();
            var description = $('#sfcmsproject_cmsbundle_page_description').val();
            var content = $('#sfcmsproject_cmsbundle_page_content').val();
            var isHome = $('#sfcmsproject_cmsbundle_page_isHome').val();
            $("#loadingTemplateListPage").show();

            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: {
                    name: name,
                    description: description,
                    content: content,
                    isHome: isHome
                },
                success: function (response) {
                    $("#loadingTemplateListPage").hide();
                    $("#templateLoad").html(response);
                    init();
                    $("#editPageSuccess").fadeIn(1000);
                    $("#editPageSuccess").fadeOut(1000);
                }
            });
        });
    }
    // Enregistre l'ajout de page en BDD
    function addPageValid() {
        $('.addPageFormValid').on('submit', function (e) {
            e.preventDefault();
            tinyMCE.triggerSave(true, true);
            var name = $('#sfcmsproject_cmsbundle_addpage_name').val();
            var description = $('#sfcmsproject_cmsbundle_addpage_description').val();
            var content = $('#sfcmsproject_cmsbundle_addpage_content').val();
            var isHome = $('#sfcmsproject_cmsbundle_addpage_isHome').val();
            $("#loadingTemplateAjouterPage").show();

            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: {
                    name: name,
                    description: description,
                    content: content,
                    isHome: isHome
                },
                success: function (response) {
                    $("#loadingTemplateAjouterPage").hide();
                    $("#templateLoad").html(response);
                    init();
                    $("#addPageSuccess").fadeIn(1000);
                    $("#addPageSuccess").fadeOut(1000);
                }
            });
        });
    }

    // Supprime la page de la BDD
    function suppressionPage() {



        $('.suppressionPage').on('submit', function (e) {

            e.preventDefault();
            var idPage = $(this).data("page");
            var csrf = $('#csrf'+ idPage).val();
            $("#loadingTemplateListPage").show();



            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: {
                    csrf: csrf
                },
                success: function (response) {
                    $("#loadingTemplateListPage").hide();
                    $("#templateLoad").html(response);
                    init();
                    $("#supPageSuccess").fadeIn(1000);
                    $("#supPageSuccess").fadeOut(1000);
                }
            });

        });

    }
});
