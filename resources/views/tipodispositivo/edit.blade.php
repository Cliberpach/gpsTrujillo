<div class="modal inmodal" id="modal_editar_tipodispositivo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <i class="fa fa-cogs modal-icon"></i>
                <h4 class="modal-title">Tipo Dispositivo</h4>
            </div>
            <div class="modal-body">
                <form role="form" action="{{route('tipodispositivo.update')}}" method="POST" id="editar_tabla_detalle" enctype="multipart/form-data">
                    {{ csrf_field() }} {{method_field('PUT')}}
                <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label class="required">Nombre</label> 
                        <select id="nombre_editar" name="nombre_editar" class="select2_form form-control {{ $errors->has('nombre_editar') ? ' is-invalid' : '' }}">
                                    <option></option>
                                    @foreach(nombretipodispositivos() as $nombre)
                                        <option value="{{ $nombre->simbolo }}" {{old('nombre_editar') == $nombre->simbolo ? "selected" : ""}}>{{$nombre->simbolo }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('nombre_editar'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong id="nombre_editar_error">{{ $errors->first('nombre_editar') }}</strong>
                                    </span>
                                @endif
                    </div>
                    <div class="form-group">
                        <label class="required">Activo</label>
                            <select id="activo_editar" name="activo_editar" class="select2_form form-control {{ $errors->has('activo_editar') ? ' is-invalid' : '' }}">
                                <option value="VIGENTE">VIGENTE</option>
                                    <option value="NO VIGENTE">NO VIGENTE</option>
                            </select>
                            @if ($errors->has('activo_editar'))
                                <span class="invalid-feedback" role="alert">
                                    <strong id="activo_editar_error">{{ $errors->first('activo_editar') }}</strong>
                                </span>
                            @endif
                    </div>
                    <div class="form-group">
                        <label class="required">Precio</label> 
                        <input type="text" class="form-control {{ $errors->has('precio_editar') ? ' is-invalid' : '' }}" name="precio_editar" id="precio_editar" value="{{old('precio_editar')}}" required  onkeyup="return mayus(this)">
                        @if ($errors->has('precio_editar'))
                        <span class="invalid-feedback" role="alert">
                            <strong id="precio_editar_error">{{ $errors->first('precio_editar') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label id="logo_label">Logo:</label>
                            <div class="custom-file">
                                <input id="logo" type="file" name="logo" onchange="seleccionarimageneditada()"
                                    class="custom-file-input {{ $errors->has('logo') ? ' is-invalid' : '' }}"
                                    accept="image/*" >
                                <label for="logo" id="logo_txt" name="logo_txt"
                                    class="custom-file-label selected {{ $errors->has('ruta') ? ' is-invalid' : '' }}"> Seleccionar</label>
                                @if ($errors->has('logo'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('logo') }}</strong>
                                </span>
                                @endif
                                <div class="invalid-feedback"><b><span id="error-logo_empresa"></span></b></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group  justify-content-center">
                        <div class="col-md-12">
                            <div class="row justify-content-end">
                                <a href="javascript:void(0);" id="limpiar_logo" onclick="limpiareditada()">
                                    <span class="badge badge-danger">x</span>
                                </a>
                            </div>
                            <div class="row justify-content-center">
                                <p>
                                    <img class="logo" src="{{asset('storage/empresas/logos/default.jpg')}}"
                                        alt="">
                                    <input id="url_logo" name="url_logo" type="hidden" value="">
                                </p>
                            </div>
                        </div>
                    </div>
            </div>
                    <div class="modal-footer">
                        <div class="col-md-6 text-left" style="color:#fcbc6c">
                            <i class="fa fa-exclamation-circle"></i> <small>Los campos marcados con asterisco (<label class="required"></label>) son obligatorios.</small>
                        </div>
                        <div class="col-md-6 text-right">
                            <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Guardar</button>
                            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
                        </div>
                    </div>
                </form>
        </div>
    </div>
</div>