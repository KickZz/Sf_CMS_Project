
$(function () {
    $("#loadingTemplateAjouterPage").hide();
    $("#loadingTemplateListPage").hide();
    $('#page').on('shown.bs.collapse', function () {
        $('#iconePage').removeClass('fa-chevron-right').addClass('fa-chevron-down');
    });
    $('#page').on('hidden.bs.collapse', function () {
        $('#iconePage').removeClass('fa-chevron-down').addClass('fa-chevron-right');
    });
    $('#article').on('shown.bs.collapse', function () {
        $('#iconeArticle').removeClass('fa-chevron-right').addClass('fa-chevron-down');
    });
    $('#article').on('hidden.bs.collapse', function () {
        $('#iconeArticle').removeClass('fa-chevron-down').addClass('fa-chevron-right');
    });
    $('#reglage').on('shown.bs.collapse', function () {
        $('#iconeReglage').removeClass('fa-chevron-right').addClass('fa-chevron-down');
    });
    $('#reglage').on('hidden.bs.collapse', function () {
        $('#iconeReglage').removeClass('fa-chevron-down').addClass('fa-chevron-right');
    });

    function init() {
        editPage();
        suppressionPage();

    }

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
