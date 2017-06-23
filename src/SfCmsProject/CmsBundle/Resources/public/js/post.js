$(function () {
    // On cache tous les gifs
    $("#loadingTemplateAjouterPost").hide();
    $("#loadingTemplateListPost").hide();

    $('#article').on('shown.bs.collapse', function () {
        $('#iconeArticle').removeClass('fa fa-chevron-circle-right').addClass('fa fa-chevron-circle-down');
    });
    $('#article').on('hidden.bs.collapse', function () {
        $('#iconeArticle').removeClass('fa fa-chevron-circle-down').addClass('fa fa-chevron-circle-right');
    });

    function init() {
        editPost();
        suppressionPost();

    }
    function initTinyMCECustom() {
        tinymce.remove();
        tinymce.init({
            selector:'.tinymce',
            branding: false,
            height : 400,
            language_url: '../fr_FR.js',
            language : 'fr_FR',
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | fontsizeselect | fontselect",
            fontsize_formats: '8pt 11pt 10pt 12pt 14pt 18pt 24pt 36pt',
            font_format:'Andale Mono=andale mono,times;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;Georgia=georgia,palatino;Helvetica=helvetica;Impact=impact,chicago;Symbol=symbol;Tahoma=tahoma,arial,helvetica,sans-serif;Terminal=terminal,monaco;Times New Roman=times new roman,times;Trebuchet MS=trebuchet ms,geneva;Verdana=verdana,geneva;Webdings=webdings;Wingdings=wingdings,zapf dingbats'

        });
    }

    // Charge le template du formulaire de création de post
    $('.ajoutPost').on('click', function (e) {
        e.preventDefault();
        $("#loadingTemplateAjouterPost").show();

        $.ajax({
            type: "POST",
            url: $(this).attr('href'),
            success: function (response) {
                $("#loadingTemplateAjouterPost").hide();
                $("#templateLoad").html(response);
                initTinyMCECustom();
                addPostValid();

            }
        });
    });

    // Charge le template de la liste des posts
    $('.listPost').on('click', function (e) {
        e.preventDefault();
        $("#loadingTemplateListPost").show();

        $.ajax({
            type: "POST",
            url: $(this).attr('href'),
            success: function (response) {
                $("#loadingTemplateListPost").hide();
                $("#templateLoad").html(response);
                init();
            }
        });
    });

    // Enregistre l'ajout de post en BDD
    function addPostValid() {
        $('.addPostFormValid').on('submit', function (e) {
            e.preventDefault();
            tinyMCE.triggerSave(true, true);
            var name = $('#sfcmsproject_cmsbundle_addpost_name').val();
            var content = $('#sfcmsproject_cmsbundle_addpost_content').val();
            $("#loadingTemplateAjouterPost").show();

            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: {
                    name: name,
                    content: content
                },
                success: function (response) {
                    $("#loadingTemplateAjouterPost").hide();
                    $("#templateLoad").html(response);
                    init();
                }
            });
        });
    }

    // Charge le template d'édition de post
    function editPost() {
        $('.editPostForm').on('click', function (e) {
            e.preventDefault();
            $("#loadingTemplateListPost").show();

            $.ajax({
                type: "POST",
                url: $(this).attr('href'),
                success: function (response) {
                    $("#loadingTemplateListPost").hide();
                    $("#templateLoad").html(response);
                    editPostValid();
                    initTinyMCECustom();

                }
            });
        });
    }
    // Enregistre les changements dans la BDD
    function editPostValid() {
        $('.editPostFormValid').on('submit', function (e) {
            e.preventDefault();
            tinyMCE.triggerSave(true, true);
            var name = $('#sfcmsproject_cmsbundle_post_name').val();
            var content = $('#sfcmsproject_cmsbundle_post_content').val();
            $("#loadingTemplateListPost").show();

            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: {
                    name: name,
                    content: content
                },
                success: function (response) {
                    $("#loadingTemplateListPost").hide();
                    $("#templateLoad").html(response);
                    init();
                }
            });
        });
    }

    // Supprime le post de la BDD
    function suppressionPost() {



        $('.suppressionPost').on('submit', function (e) {

            e.preventDefault();
            var idPost = $(this).data("post");
            var csrf = $('#csrf'+ idPost).val();
            $("#loadingTemplateListPost").show();



            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: {
                    csrf: csrf
                },
                success: function (response) {
                    $("#loadingTemplateListPost").hide();
                    $("#templateLoad").html(response);
                    init();
                }
            });

        });

    }
});