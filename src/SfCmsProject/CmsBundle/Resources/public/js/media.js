$(function () {
    // On cache tous les gifs
    $("#loadingMediaStorage").hide();
    $("#loadingAddMedia").hide();
    $("#removeMediaSuccess").hide();
    $("#addMediaSuccess").hide();

    $('#media').on('shown.bs.collapse', function () {
        $('#iconeMedia').removeClass('fa fa-chevron-circle-right').addClass('fa fa-chevron-circle-down');
    });
    $('#media').on('hidden.bs.collapse', function () {
        $('#iconeMedia').removeClass('fa fa-chevron-circle-down').addClass('fa fa-chevron-circle-right');
    });

    // Charge le template de bibliothèque de media
    $('.mediaStorage').on('click', function (e) {
        e.preventDefault();
        $("#loadingMediaStorage").show();

        $.ajax({
            type: "POST",
            url: $(this).attr('href'),
            success: function (response) {
                $("#loadingMediaStorage").hide();
                $("#templateLoad").html(response);
                supMediaValid();
            }
        });
    });
    // charge le formulaire d'ajout de media
    $('.addMedia').on('click', function (e) {
        e.preventDefault();
        $("#loadingAddMedia").show();

        $.ajax({
            type: "POST",
            url: $(this).attr('href'),
            success: function (response) {
                $("#loadingAddMedia").hide();
                $("#templateLoad").html(response);
                dropzone();
            }
        });
    });
    function dropzone() {


        //je récupère l'action où sera traité l'upload en PHP
        var _actionToDropZone = $("#form_snippet_image").attr('action');

        //je définis ma zone de drop grâce à l'ID de ma div
        Dropzone.autoDiscover = false;
        var myDropzone = new Dropzone("#form_snippet_image", {url: _actionToDropZone});
        // on affiche l'encart d'information de succes
        myDropzone.on("success", function () {
            $("#addMediaSuccess").fadeIn(1000);
            $("#addMediaSuccess").fadeOut(1000);
        });
    }
    // Supprime le media de la BDD
    function supMediaValid() {
        $('.supTemplate').on('click', function (e) {
            e.preventDefault();
            var pathSup = $(this).data('path');
            var id = $(this).data('id');
            $("#loadingMediaStorage").show();
            $.ajax({
                type: "POST",
                url: pathSup,
                data: {
                    id: id
                },
                success: function (response) {
                    $("#loadingMediaStorage").hide();
                    $("#templateLoad").html(response);
                    supMediaValid();
                    $("#removeMediaSuccess").fadeIn(1000);
                    $("#removeMediaSuccess").fadeOut(1000);

                }
            });
        });
    }
});
