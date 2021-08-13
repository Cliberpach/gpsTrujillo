function cambioColor(url, color) {
    keyframesRule(url + "css/style.css", color);
    getSetStyleRule(
        url + "css/style.css",
        ".select2-container--default .select2-results__option--highlighted[aria-selected]",
        "background-color: " + color + ";color: white;"
    );
    getSetStyleRule(
        url + "Inspinia/css/style.css",
        ".bg-primary",
        "background-color: " + color + "!important;color: white;"
    );
    getSetStyleRule(
        url + "css/style.css",
        ".panel-primary",
        "border-color:" + color + ""
    );
    getSetStyleRule(
        url + "css/style.css",
        ".wizard > .steps .done a, .wizard > .steps .done a:hover, .wizard > .steps .done a:active",
        "background: rgb(168 176 174);;color: rgb(255, 255, 255);"
    );
    getSetStyleRule(
        url + "Inspinia/email_templates/style.css",
        ".btn-primary",
        "text-decoration: none;color: #FFF;background-color: " +
            color +
            "!important;border: solid " +
            color +
            "!important;border-width: 5px 10px;line-height: 2;font-weight: bold;text-align: center;cursor: pointer;display: inline-block;border-radius: 5px;text-transform: capitalize;"
    );
    getSetStyleRule(
        url + "css/style.css",
        ".btn-primary",
        "color: #fff;background-color: " +
            color +
            "!important;border-color: " +
            color +
            "!important;"
    );
    getSetStyleRule(
        url + "css/style.css",
        ".nav > li.active",
        "border-left: 4px solid " + color + ";background: #293846;"
    );
    getSetStyleRule(
        url + "css/style.css",
        ".ldio-6fqlsp2qlpd div",
        "position: absolute;width: 40px;height: 40px;background: " +
            color +
            "!important;animation: ldio-6fqlsp2qlpd 1s linear infinite;"
    );
    getSetStyleRule(
        url + "Inspinia/css/style.css",
        ".pace .pace-progress",
        "background: " +
            color +
            ";position: fixed;z-index: 2040;top: 0;right: 100%;width: 100%;height: 2px;"
    );
    getSetStyleRule(
        url + "Inspinia/css/style.css",
        ".panel-primary > .panel-heading",
        "background-color: " +
            color +
            "!important;border-color:" +
            color +
            "!important;"
    );
    getSetStyleRule(
        url + "Inspinia/css/style.css",
        ".page-item.active .page-link",
        "background-color: " + color + ";border-color: " + color + ";"
    );
    getSetStyleRule(
        url + "Inspinia/css/style.css",
        ".btn-primary",
        "background-color: " + color + ";!important"
    );
    getSetStyleRule(
        url + "Inspinia/css/style.css",
        ".btn-primary.disabled, .btn-primary:disabled",
        "background-color: " +
            color +
            "!important;border-color: " +
            color +
            "!important;"
    );
    getSetStyleRule(
        url + "Inspinia/css/style.css",
        ".btn-primary",
        "border-color: " + color + ";!important"
    );
    getSetStyleRule(
        url + "Inspinia/css/style.css",
        ".btn-primary:hover,.btn-primary:focus,.btn-primary.focus",
        "background-color: " +
            color +
            "!important;border-color: " +
            color +
            "!important;"
    );
    getSetStyleRule(
        url + "Inspinia/css/plugins/steps/jquery.steps.css",
        ".wizard > .actions a, .wizard > .actions a:hover, .wizard > .actions a:active",
        "background: " + color + ";"
    );
    getSetStyleRule(
        url + "Inspinia/css/plugins/steps/jquery.steps.css",
        ".wizard > .steps .current a, .wizard > .steps .current a:hover, .wizard > .steps .current a:active",
        "background: " + color + ";"
    );
}

function getSetStyleRule(sheetName, selector, rule) {
    var stylesheet = document.querySelector('link[href="' + sheetName + '"]');
    if (stylesheet) {
        var rulelist = stylesheet.sheet.cssRules;
        stylesheet = stylesheet.sheet;
        var arreglo = [];
        arreglo.push(rulelist);
        for (var i = 0; i < arreglo.length; i++) {
            if (arreglo[i].selector_text === selector) {
                stylesheet.deleteRule(i);
            }
        }
        //
        stylesheet.insertRule(
            selector + "{ " + rule + "}",
            stylesheet.cssRules.length
        );
    }
    return stylesheet;
}
function keyframesRule(sheetName, color) {
    var stylesheet = document.querySelector('link[href="' + sheetName + '"]');
    if (stylesheet) {
        var rulelist = stylesheet.sheet.cssRules;
        stylesheet = stylesheet.sheet;
        var arreglo = [];
        arreglo.push(rulelist);
        var nuevovalor = color.substring(color.length - 2, color.length);
        var valoranterior = color.substring(0, color.length - 2);
        var nuevo = valoranterior + "0.6)";
        arreglo[0][16].deleteRule("0%");
        arreglo[0][16].appendRule("0% { background: " + nuevo + "; }");
        arreglo[0][16].deleteRule("12.5%");
        arreglo[0][16].appendRule("12.5% { background: " + nuevo + "; }");
        arreglo[0][16].deleteRule("12.625%");
        arreglo[0][16].appendRule("12.625% { background: " + color + "; }");
        arreglo[0][16].deleteRule("100%");
        arreglo[0][16].appendRule("100% { background: " + color + "; }");
        //
    }
    return stylesheet;
}
