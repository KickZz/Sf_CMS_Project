
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
    $('#article').on('shown.bs.collapse', function () {
        $('#iconeArticle').removeClass('fa fa-chevron-circle-right').addClass('fa fa-chevron-circle-down');
    });
    $('#article').on('hidden.bs.collapse', function () {
        $('#iconeArticle').removeClass('fa fa-chevron-circle-down').addClass('fa fa-chevron-circle-right');
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
                }
            });
        });
    }
    // Enregistre les changement dans la BDD
    function editPageValid() {
        $('.editPageFormValid').on('submit', function (e) {
            e.preventDefault();

            var name = $('#sfcmsproject_cmsbundle_page_name').val();
            var description = $('#sfcmsproject_cmsbundle_page_description').val();
            var content = $('#sfcmsproject_cmsbundle_page_content').val();
            var contentPost = $('#sfcmsproject_cmsbundle_page_contentPost').val();
            var isHome = $('#sfcmsproject_cmsbundle_page_isHome').val();
            $("#loadingTemplateListPage").show();

            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: {
                    name: name,
                    description: description,
                    content: content,
                    contentPost: contentPost,
                    isHome: isHome
                },
                success: function (response) {
                    $("#loadingTemplateListPage").hide();
                    $("#templateLoad").html(response);
                    init();
                }
            });
        });
    }
    // Enregistre l'ajout de page en BDD
    function addPageValid() {
        $('.addPageFormValid').on('submit', function (e) {
            e.preventDefault();
            var name = $('#sfcmsproject_cmsbundle_addpage_name').val();
            var description = $('#sfcmsproject_cmsbundle_addpage_description').val();
            var content = $('#sfcmsproject_cmsbundle_addpage_content').val();
            var contentPost = $('#sfcmsproject_cmsbundle_addpage_contentPost').val();
            var isHome = $('#sfcmsproject_cmsbundle_addpage_isHome').val();
            $("#loadingTemplateAjouterPage").show();

            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: {
                    name: name,
                    description: description,
                    content: content,
                    contentPost: contentPost,
                    isHome: isHome
                },
                success: function (response) {
                    $("#loadingTemplateAjouterPage").hide();
                    $("#templateLoad").html(response);
                    init();
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
                }
            });

        });

    }
});
