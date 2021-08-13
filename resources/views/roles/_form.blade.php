<div class="wrapper wrapper-content animated fadeIn">
    <form class="wizard-big" action="{{ $action }}" method="POST" id="form_registrar_role">
        @csrf
        <h1>Datos Del Rol</h1>
        <fieldset  style="position: relative;">
            <div class="card" style="width: 70rem;">
                <div class="card-header">
                    <br>
                </div>
                <div class="card-body">
           
               <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-9">
                    <div class="form-group row">       
                    <label class="required">Nombre</label>                     
                        <input type="text" class="form-control  {{ $errors->has('name') ? ' is-invalid' : '' }}" id="name" placeholder="Name" name="name" value="{{old('name')?old('name'):$role->name}}">
                        @if ($errors->has('name'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                       @endif
                    </div>
                    <div class="form-group row">     
                    <label class="required">Slug</label>
                    <input type="text" class="form-control  {{ $errors->has('slug') ? ' is-invalid' : '' }}" id="slug" placeholder="Slug" name="slug" value="{{old('slug')?old('slug'):$role->slug}}">
                    @if ($errors->has('slug'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('slug') }}</strong>
                    </span>
                   @endif
                  </div>

                  <div class="form-group row">     
                    <label class="required">Descripcion</label>
                    <input class="form-control  {{ $errors->has('description') ? ' is-invalid' : '' }}"  value="{{old('descripction')?old('descripction'):$role->description}}" placeholder="Description" name="description" id="description"> 

                 
                    @if ($errors->has('description'))
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('description') }}</strong>
                  </span>
                 @endif
                  </div>
                  <hr>
                  <h4>Acceso Total</h4>
                  <div class="form-control {{ $errors->has('full-access') ? ' is-invalid' : '' }}">
                    <div class="custom-control custom-radio custom-control-inline" >
                        <input type="radio" id="customRadioInline1" name="full-access" onclick="fullacceso()" class="custom-control-input" value="yes" {{ old('full-access') ? (old('full-access') == "yes" ? "checked" : "") : ($role['full-access'] == "yes" ? "checked" : "") }}>
                        <label class="custom-control-label" for="customRadioInline1">Si</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline" >
                        <input type="radio" id="customRadioInline2" name="full-access" onclick="nofullacceso()" class="custom-control-input" value="no" {{ old('full-access') ? (old('full-access') == "no" ? "checked" : "") : ($role['full-access'] == "no" ? "checked" : "") }}>
                        <label class="custom-control-label" for="customRadioInline2">NO</label>
                    </div>
                </div>
                  @if ($errors->has('full-access'))
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('full-access') }}</strong>
                  </span>
                 @endif
                  <hr>
                  @foreach ($permissions as $permission)
                      <div class="form-group row"> 
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input check" {{  ($role['full-access'] == "yes" ? "disabled" : "") }} id="permission_{{$permission->id}}" value="{{$permission->id}}" name="permission[]"
                        {{ old('permission') ? (is_array(old('permission')) && in_array($permission->id,old('permission')) ? 'checked':''
                        ):(is_array($permissions_role) && in_array($permission->id,$permissions_role) ? 'checked':''
                        )}}>
                        <label class="custom-control-label" for="permission_{{$permission->id}}">
                            {{$permission->id}}-{{$permission->name}}
                            <i>({{$permission->description}})</i>
                        </label>
                    </div>  
                    </div>
                  @endforeach
                    
                </div>
                 
                    
            </div>
            <div class="row">
                <div class="m-t-md col-lg-8">
                    <i class="fa fa-exclamation-circle leyenda-required"></i> <small class="leyenda-required">Los campos marcados con asterisco (*) son obligatorios.</small>
                </div>
            </div>
                </div>
              </div>
           
        </fieldset>
        @if (!empty($put))
            <input type="hidden" name="_method" value="PUT">
        @endif
    </form>
</div>
@push('styles')
    <link href="{{ asset('Inspinia/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">
    <link href="{{ asset('Inspinia/css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
    <link href="{{ asset('Inspinia/css/plugins/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet">
    <link href="{{ asset('Inspinia/css/plugins/select2/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('Inspinia/css/plugins/steps/jquery.steps.css') }}" rel="stylesheet">
    <style>
        .logo {
            width: 190px;
            height: 190px;
            border-radius: 10%;
            position: absolute;
        }
    </style>
@endpush
@push('scripts')
    <!-- iCheck -->
    <script src="{{ asset('Inspinia/js/plugins/iCheck/icheck.min.js') }}"></script>
    <!-- Data picker -->
    <script src="{{ asset('Inspinia/js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('Inspinia/js/plugins/select2/select2.full.min.js') }}"></script>
    <!-- Steps -->
    <script src="{{ asset('Inspinia/js/plugins/steps/jquery.steps.min.js') }}"></script>
    <script>

    

         $("#form_registrar_role").steps({
            bodyTag: "fieldset",
            transitionEffect: "fade",
            labels: {
                current: "actual paso:",
                pagination: "Paginación",
                finish: "Finalizar",
                next: "Siguiente",
                previous: "Anterior",
                loading: "Cargando ..."
            },
            onStepChanging: function (event, currentIndex, newIndex)
            {
                // Always allow going backward even if the current step contains invalid fields!
            
                return true;
            },
            onStepChanged: function (event, currentIndex, priorIndex)
            {
            },
            onFinishing: function (event, currentIndex)
            {
                var form = $(this);
                // Start validation; Prevent form submission if false
                return true;
            },
            onFinished: function (event, currentIndex)
            {
               
                 var form = $(this);
                // Submit form input
                 form.submit();
      
            }
        });
        function fullacceso()
        {
             $(".check").removeAttr('checked');
            $(".check").attr('disabled',true);
           
        }
        function nofullacceso()
        {
            $(".check").removeAttr('disabled');
        }
     
    </script>
@endpush