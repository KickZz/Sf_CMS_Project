$(function () {
    $("#loadingTemplateMenu").hide();

    function init() {
        sortableUpdateOrder();
        sortableUpdateOrderPageWithoutMenu();
        initLinkMenu();
        classUpdate();
        sortableUpdateOrderSubMenu();
    }
    // Charge le template de la création de menu
    $('.menu').on('click', function (e) {
        e.preventDefault();
        $("#loadingTemplateMenu").show();

        $.ajax({
            type: "POST",
            url: $(this).attr('href'),
            success: function (response) {
                $("#loadingTemplateMenu").hide();
                $("#templateLoad").html(response);
                init();
            }
        });
    });

    // Initialise les liens situé dans les listes de création de menu
    function initLinkMenu () {


        $('.linkList').on('click', function () {


            var pageId = ($(this).data('page'));
            var classPage = ("#page" + pageId);
            var iconePage = ("#iconePage" + pageId);

            $(classPage).on('shown.bs.collapse', function () {
                $(iconePage).removeClass('fa fa-plus-circle').addClass('fa fa-minus-circle');
            });
            $(classPage).on('hidden.bs.collapse', function () {
                $(iconePage).removeClass('fa fa-minus-circle').addClass('fa fa-plus-circle');
            });
        });

    }

    function classUpdate(){
        // Envoi la requête de modification de la class de l'icone de la page
        $('.classFormIcon').on('submit', function (e) {
            e.preventDefault();
            var pageId = $(this).data('page');
            var classCss = $('#classCss'+ pageId).val();
            var csrf = $('#csrf'+ pageId).val();

            $.ajax({
                url: $(this).attr('action'),
                type: "POST",
                data: {
                    classCss: classCss,
                    csrf: csrf
                },
                success: function (response) {
                    $("#templateClass" + pageId).html(response);
                    $('#classCss'+ pageId).val('');
                    $("#templateIcon" + pageId).attr("class", response);

                }
            });
        });
    }
    // Met à jour l'ordre du menu
    function sortableUpdateOrder() {

        $( ".listMenu" ).sortable({

            containment: "#containerListMenu",
            connectWith : '.listPageWithoutMenu, .listSubMenu',
            revert : true,
            cursor : 'move',
            placeholder: "ui-state-highlight",
            forcePlaceholderSize : true,
            dropOnEmpty : true,
            opacity : 1,
            start: function(event, ui) {
                $(ui.placeholder).css({"border": "1px dashed grey"});
                $(ui.placeholder).css({"background-color": "rgba(180,181,181,0.75)"});
                $(ui.placeholder).css({"margin-top": "5px"});
            },
            update : function() {
                var serial = $(this).sortable('serialize');
                if (serial) {
                    $("#loadingTemplateMenu").show();
                    $.ajax({
                        type: "POST",
                        url: $(this).data("update"),
                        data: serial,
                        success: function () {
                            initLinkMenu();
                            $("#loadingTemplateMenu").hide();
                            $("#saveMenu").fadeIn(1000);
                            $("#saveMenu").fadeOut(1000);
                        }
                    });
                }
            }
        });

        $( ".listMenu" ).disableSelection();
    }

    // Met à jour l'ordre de la liste des pages restantes
    function sortableUpdateOrderPageWithoutMenu() {
        $( ".listPageWithoutMenu" ).sortable({

            containment: "#containerListMenu",
            connectWith : '.listMenu, .listSubMenu',
            revert: true,
            cursor: 'move',
            placeholder: "ui-state-highlight",
            forcePlaceholderSize : true,
            dropOnEmpty: true,
            opacity: 1,
            start: function(event, ui) {
                $(ui.placeholder).css({"border": "1px dashed grey"});
                $(ui.placeholder).css({"background-color": "rgba(180,181,181,0.75)"});
                $(ui.placeholder).css({"margin-top": "5px"});
            },
            update : function() {
                var serial = $(this).sortable('serialize');
                if (serial) {
                    $("#loadingTemplateMenu").show();
                    $.ajax({
                        type: "POST",
                        url: $(this).data("update"),
                        data: serial,
                        success: function () {
                            initLinkMenu();
                            $("#loadingTemplateMenu").hide();
                        }
                    });
                }
            }
        });

        $( ".listPageWithoutMenu" ).disableSelection();
    }

    // Met à jour l'ordre des sous menu
    function sortableUpdateOrderSubMenu() {

        $( ".listSubMenu" ).sortable({

            containment: "#containerListMenu",
            connectWith : '.listPageWithoutMenu, .listMenu, .listSubMenu',
            revert : true,
            cursor : 'move',
            placeholder: "ui-state-highlight",
            forcePlaceholderSize : true,
            dropOnEmpty : true,
            opacity : 1,
            appendTo: "body",
            helper: "clone",
            start: function(event, ui){
                $(ui.helper).css({"list-style":"none"});
                $(ui.placeholder).css({"border": "1px dashed grey"});
                $(ui.placeholder).css({"background-color": "rgba(180,181,181,0.75)"});
                $(ui.placeholder).css({"margin-top": "5px"});
            },
            update : function() {
                var serial = $(this).sortable('serialize');

                    $("#loadingTemplateMenu").show();
                    $.ajax({
                        type: "POST",
                        url: $(this).data("update"),
                        data: serial,
                        success: function () {
                            refreshCount();
                            initLinkMenu();
                            $("#loadingTemplateMenu").hide();
                            $("#saveMenu").fadeIn(1000);
                            $("#saveMenu").fadeOut(1000);
                        }
                    });

            }
        });

        $( ".listSubMenu" ).disableSelection();
    }
    // Met à jour le nombre de sous page
    function refreshCount(){
        var name = "templateCountSubMenu";
        var classElem = document.getElementsByClassName(name);
        $(classElem).each(function(){
            var pageId = $(this).data('page');
            $.ajax({
                type: "POST",
                url: $(this).data("path"),
                success: function (response) {

                    $('#templateCount' + pageId).html(response);
                }
            });
        });
    }
});
