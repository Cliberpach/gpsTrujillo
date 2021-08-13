<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>GPS Tracker</title>
    @if(verificarempresaloginicon())

  <link rel="icon" href="{{Storage::url(empresacolor()->ruta_logo_icon)}}" />
  @else
  <link rel="icon" href="{{asset('img/e.png')}}" />
  @endif
    <!-- Scripts -->
    <link href="{{asset('Inspinia/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('Inspinia/font-awesome/css/font-awesome.css')}}" rel="stylesheet">
    <link href="{{asset('Inspinia/css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('Inspinia/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <!-- Toastr style -->
    <link href="{{asset('Inspinia/css/plugins/toastr/toastr.min.css')}}" rel="stylesheet">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Styles -->
</head>
<body>

                        @guest
                            @if (Route::has('register'))
                                @yield('content')
                            @endif
                        @endguest
</body>
<script src="{{asset('Inspinia/js/jquery-3.1.1.min.js')}}"></script>
<script src="{{asset('Inspinia/js/popper.min.js')}}"></script>
<script src="{{asset('Inspinia/js/bootstrap.js')}}"></script>
<!-- Toastr script -->
<script src="{{asset('Inspinia/js/plugins/toastr/toastr.min.js')}}"></script>
<script>
    @if(verificarempresa())
        keyframesRule('{{ asset("/") }}css/style.css','{{empresacolor()->color}}')
        getSetStyleRule('{{ asset("/") }}css/style.css','.select2-container--default .select2-results__option--highlighted[aria-selected]','background-color: {{empresacolor()->color}};color: white;');
        getSetStyleRule('{{ asset("/") }}css/style.css','.panel-primary','border-color:{{empresacolor()->color}}');
        getSetStyleRule('{{ asset("/") }}css/style.css','.wizard > .steps .done a, .wizard > .steps .done a:hover, .wizard > .steps .done a:active','background: rgb(168 176 174);;color: rgb(255, 255, 255);');
        getSetStyleRule('{{ asset("/") }}Inspinia/email_templates/style.css','.btn-primary','text-decoration: none;color: #FFF;background-color: {{empresacolor()->color}}!important;border: solid {{empresacolor()->color}}!important;border-width: 5px 10px;line-height: 2;font-weight: bold;text-align: center;cursor: pointer;display: inline-block;border-radius: 5px;text-transform: capitalize;')
       getSetStyleRule('{{ asset("/") }}css/style.css', '.btn-primary', 'color: #fff;background-color: {{empresacolor()->color}}!important;border-color: {{empresacolor()->color}}!important;')
       getSetStyleRule('{{ asset("/") }}css/style.css', '.nav > li.active', 'border-left: 4px solid {{empresacolor()->color}};background: #293846;')
       getSetStyleRule('{{ asset("/") }}css/style.css', '.ldio-6fqlsp2qlpd div', 'position: absolute;width: 40px;height: 40px;background: {{empresacolor()->color}}!important;animation: ldio-6fqlsp2qlpd 1s linear infinite;')
       getSetStyleRule('{{ asset("/") }}Inspinia/css/style.css', '.pace .pace-progress', 'background: {{empresacolor()->color}};position: fixed;z-index: 2040;top: 0;right: 100%;width: 100%;height: 2px;')
       getSetStyleRule('{{ asset("/") }}Inspinia/css/style.css', '.panel-primary > .panel-heading','background-color: {{empresacolor()->color}}!important;border-color:{{empresacolor()->color}}!important;');
       getSetStyleRule('{{ asset("/") }}Inspinia/css/style.css', '.page-item.active .page-link', 'background-color: {{empresacolor()->color}};border-color: {{empresacolor()->color}};')
       getSetStyleRule('{{ asset("/") }}Inspinia/css/style.css', '.btn-primary', 'background-color: {{empresacolor()->color}};!important')
       getSetStyleRule('{{ asset("/") }}Inspinia/css/style.css', '.btn-primary.disabled, .btn-primary:disabled', 'background-color: {{empresacolor()->color}}!important;border-color: {{empresacolor()->color}}!important;')
       getSetStyleRule('{{ asset("/") }}Inspinia/css/style.css', '.btn-primary', 'border-color: {{empresacolor()->color}};!important')
       getSetStyleRule('{{ asset("/") }}Inspinia/css/style.css', '.btn-primary:hover,.btn-primary:focus,.btn-primary.focus', 'background-color: {{empresacolor()->color}}!important;border-color: {{empresacolor()->color}}!important;')
       getSetStyleRule('{{ asset("/") }}Inspinia/css/plugins/steps/jquery.steps.css', '.wizard > .actions a, .wizard > .actions a:hover, .wizard > .actions a:active', 'background: {{empresacolor()->color}};')
       getSetStyleRule('{{ asset("/") }}Inspinia/css/plugins/steps/jquery.steps.css', '.wizard > .steps .current a, .wizard > .steps .current a:hover, .wizard > .steps .current a:active', 'background: {{empresacolor()->color}};')
       @endif
       function getSetStyleRule(sheetName, selector, rule) {
                var stylesheet = document.querySelector("link[href=\"" + sheetName + "\"]");
                if( stylesheet ){
                    var rulelist=stylesheet.sheet.cssRules;
                        stylesheet = stylesheet.sheet;
                    var arreglo=[];
                        arreglo.push(rulelist);
                    for (var i=0; i < arreglo.length; i++) {
                               if(arreglo[i].selector_text===selector)
                               {
                                stylesheet.deleteRule(i);
                               }
                        }
                    //
                   stylesheet.insertRule(selector + '{ ' + rule + '}', stylesheet.cssRules.length);
                }
                return stylesheet
            }
    function keyframesRule(sheetName,color) {
                var stylesheet = document.querySelector("link[href=\"" + sheetName + "\"]");
                if( stylesheet ){
                    var rulelist=stylesheet.sheet.cssRules;
                    stylesheet = stylesheet.sheet;
                    var arreglo=[];
                    arreglo.push(rulelist);
                      var nuevovalor=color.substring((color.length)-2,color.length);
                      var valoranterior=color.substring(0,color.length-2);
                      var nuevo=(valoranterior+"0.6)");
                       arreglo[0][16].deleteRule('0%');
                       arreglo[0][16].appendRule('0% { background: '+nuevo+'; }');
                       arreglo[0][16].deleteRule('12.5%');
                       arreglo[0][16].appendRule('12.5% { background: '+nuevo+'; }');
                       arreglo[0][16].deleteRule('12.625%');
                       arreglo[0][16].appendRule('12.625% { background: '+color+'; }');
                       arreglo[0][16].deleteRule('100%');
                       arreglo[0][16].appendRule('100% { background: '+color+'; }');
                    //
                }
                return stylesheet
        }
     @auth
            window.location = "{{ route('home')  }}";
     @endauth
    window.addEventListener("load",function(){
        $('.loader-spinner').hide();
        $("#content-system").css("display", "");
    })
</script>
<!-- Propio scripts -->
<script src="{{ asset('Inspinia/js/scripts.js') }}"></script>
</html>
