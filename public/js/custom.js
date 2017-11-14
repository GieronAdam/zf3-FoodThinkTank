// tinymce.init({
//     selector: '#post-content',
//     height: 300,
//
//     theme: 'inlite',
//     plugins: 'print preview fullpage powerpaste searchreplace autolink directionality advcode visualblocks visualchars fullscreen image template link media codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount tinymcespellchecker a11ychecker imagetools mediaembed  linkchecker contextmenu colorpicker textpattern help',
//     toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat ' ,
//     image_advtab: true,
//     visualblocks_default_state: true,
//     templates: [
//         { title: 'zdjęcie - content', content:
//         '<div class="row">'+
//         '<div class="float-left" style="width: 30%; min-height: 30px; ">' +
//         'test'+
//         '</div><div class="float-right" style="width: 70%; min-height: 30px;">' +
//         'test' +
//         '</div></div>'
//         },
//         { title: 'Test template 2', content: 'Test 2' }
//     ],
//     content_css: [
//         '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
//         '//www.tinymce.com/css/codepen.min.css'
//     ]
// });

$('.mce-notification-inner').remove();
$('.mce-notification-warning').css('display','none');

var template =
                '' +
                '' +
                '' +
                '' +
                '' +
                '' +
                '' +
                '' +
                '' +
                '' + '';



tinymce.init({
    selector: "#post-content",
    height: 500,
    plugins: [
        "advlist autolink autosave link image lists charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
        "table contextmenu directionality emoticons template textcolor paste fullpage textcolor colorpicker textpattern"
    ],

    toolbar1: "newdocument fullpage | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | styleselect formatselect fontselect fontsizeselect",
    toolbar2: "cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media code | insertdatetime preview | forecolor backcolor",
    toolbar3: "table | hr removeformat | subscript superscript | charmap emoticons | print fullscreen | ltr rtl | visualchars visualblocks nonbreaking template pagebreak restoredraft",
    content_css: [
        '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
        '//www.tinymce.com/css/codepen.min.css'],

    menubar: false,
    toolbar_items_size: 'small',

    style_formats: [{
        title: 'Bold text',
        inline: 'b'
    }, {
        title: 'Red text',
        inline: 'span',
        styles: {
            color: '#ff0000'
        }
    }, {
        title: 'Red header',
        block: 'h1',
        styles: {
            color: '#ff0000'
        }
    }, {
        title: 'Example 1',
        inline: 'span',
        classes: 'example1'
    }, {
        title: 'Example 2',
        inline: 'span',
        classes: 'example2'
    }, {
        title: 'Table styles'
    }, {
        title: 'Table row 1',
        selector: 'tr',
        classes: 'tablerow1'
    }],

    templates: [{
        title: 'Test template 1',
        content: 'Test 1'
    }, {
        title: 'Test template 2',
        content: 'Test 2'
    }],

    init_instance_callback: function () {
        window.setTimeout(function() {
            $("#div").show();
        }, 1000);
    }
});
