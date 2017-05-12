
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

    $('.ajoutPage').on('click', function (e) {
            e.preventDefault();
            $("#loadingTemplateAjouterPage").show();

            $.ajax({
                url: $(this).attr('href'),
                success: function (response) {
                    $("#loadingTemplateAjouterPage").hide();
                    $("#templateLoad").html(response);
                }
            });
        });
    $('.listPage').on('click', function (e) {
        e.preventDefault();
        $("#loadingTemplateListPage").show();

        $.ajax({
            url: $(this).attr('href'),
            success: function (response) {
                $("#loadingTemplateListPage").hide();
                $("#templateLoad").html(response);
            }
        });
    });
});
