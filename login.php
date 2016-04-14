<?php
$_lang="es";
$_modulo="logueo";

$_start_session = MensajesDto::ObtenerMensaje($_lang, $_modulo, "start_session");

$_user = MensajesDto::ObtenerMensaje($_lang, $_modulo, "user");
$_pass = MensajesDto::ObtenerMensaje($_lang, $_modulo, "pass");
$_boton = MensajesDto::ObtenerMensaje($_lang, $_modulo, "boton");

$_help = MensajesDto::ObtenerMensaje($_lang, $_modulo, "help");
$_new_user = MensajesDto::ObtenerMensaje($_lang, $_modulo, "new_user");
$_ayudaLogin = MensajesDto::ObtenerMensaje($_lang, $_modulo, "ayudaLogin");
$_title_new_user = MensajesDto::ObtenerMensaje($_lang, $_modulo, "title_new_user");
$_license_number = MensajesDto::ObtenerMensaje($_lang, $_modulo, "license_number");
$_invalid_license_number = MensajesDto::ObtenerMensaje($_lang, $_modulo, "invalid_license_number");

$_enter = MensajesDto::ObtenerMensaje($_lang, $_modulo, "enter");
$_acept = MensajesDto::ObtenerMensaje($_lang, $_modulo, "acept");
$_cancel = MensajesDto::ObtenerMensaje($_lang, $_modulo, "cancel");
$_exit = MensajesDto::ObtenerMensaje($_lang, $_modulo, "exit");

$_title_help = MensajesDto::ObtenerMensaje($_lang, $_modulo, "help_login");

$_registro_docente = MensajesDto::ObtenerMensaje($_lang, $_modulo, "registro_docente");
$_registro_alumno = MensajesDto::ObtenerMensaje($_lang, $_modulo, "registro_alumno");
$_registro_acudiente_1 = MensajesDto::ObtenerMensaje($_lang, $_modulo, "registro_acudiente_1");
$_registro_acudiente_2 = MensajesDto::ObtenerMensaje($_lang, $_modulo, "registro_acudiente_2");
$_user = MensajesDto::ObtenerMensaje($_lang, $_modulo, "user");
$_password = MensajesDto::ObtenerMensaje($_lang, $_modulo, "password");
$_confirm_password = MensajesDto::ObtenerMensaje($_lang, $_modulo, "confirm_password");
$_password_warning = MensajesDto::ObtenerMensaje($_lang, $_modulo, "password_warning");
$_validate_license_warning = MensajesDto::ObtenerMensaje($_lang, $_modulo, "validate_license_warning");
$_verify = MensajesDto::ObtenerMensaje($_lang, $_modulo, "verify");
$_email = MensajesDto::ObtenerMensaje($_lang, $_modulo, "email");
$_nombres = MensajesDto::ObtenerMensaje($_lang, $_modulo, "nombres");
$_apellidos = MensajesDto::ObtenerMensaje($_lang, $_modulo, "apellidos");
$_fecha_de_nacimiento = MensajesDto::ObtenerMensaje($_lang, $_modulo, "fecha_de_nacimiento");
$_sexo = MensajesDto::ObtenerMensaje($_lang, $_modulo, "sexo");
$_male = MensajesDto::ObtenerMensaje($_lang, $_modulo, "male");
$_female = MensajesDto::ObtenerMensaje($_lang, $_modulo, "female");
$_direccion = MensajesDto::ObtenerMensaje($_lang, $_modulo, "direccion");
$_pais = MensajesDto::ObtenerMensaje($_lang, $_modulo, "pais");
$_departamento = MensajesDto::ObtenerMensaje($_lang, $_modulo, "departamento");
$_selec_pais = MensajesDto::ObtenerMensaje($_lang, $_modulo, "selec_pais");	
$_ciudad = MensajesDto::ObtenerMensaje($_lang, $_modulo, "ciudad");
$_telefono = MensajesDto::ObtenerMensaje($_lang, $_modulo, "telefono");
$_area = MensajesDto::ObtenerMensaje($_lang, $_modulo, "area");
$_nivel = MensajesDto::ObtenerMensaje($_lang, $_modulo, "nivel");

$_estudiante = MensajesDto::ObtenerMensaje($_lang, $_modulo, "estudiante");
$_acudiente_1 = MensajesDto::ObtenerMensaje($_lang, $_modulo, "acudiente_1");
$_acudiente_2 = MensajesDto::ObtenerMensaje($_lang, $_modulo, "acudiente_2");

$_estudiante_already = MensajesDto::ObtenerMensaje($_lang, $_modulo, "estudiante_already");
$_acudiente_1_already = MensajesDto::ObtenerMensaje($_lang, $_modulo, "acudiente_1_already");
$_acudiente_2_already = MensajesDto::ObtenerMensaje($_lang, $_modulo, "acudiente_2_already");

$_success_title = MensajesDto::ObtenerMensaje($_lang, $_modulo, "success_title");
$_success_message = MensajesDto::ObtenerMensaje($_lang, $_modulo, "success_message");

$_mensaje_validacion = MensajesDto::ObtenerMensaje($_lang, $_modulo, "mensaje_validacion");

$_support_message = MensajesDto::ObtenerMensaje($_lang, $_modulo, "support_message");

$_identificacion = MensajesDto::ObtenerMensaje($_lang, $_modulo, "identificacion");

$_numerico = MensajesDto::ObtenerMensaje($_lang, $_modulo, "numerico");

$_ejemplo = MensajesDto::ObtenerMensaje($_lang, $_modulo, "ejemplo");


if(isset($_SESSION["usuarioCreado"]) && $_SESSION["usuarioCreado"] != ""){
	
	MensajesDto::MostrarMensaje($_lang, $_modulo, $_SESSION["usuarioCreado"]);
	unset($_SESSION['usuarioCreado']);

}

if(isset($_SESSION["ss_usuario_activo"]) && $_SESSION["ss_usuario_activo"] == "ok"){
	
	MensajesDto::MostrarMensaje($_lang, $_modulo, 'session_activa_complete');
	unset($_SESSION['ss_usuario_activo']);

}


// paises
$array_listado_paises = array();
$array_paises = array();
$paisDto = new PaisesDto();
$resP = $paisDto->PaisLst("",$array_listado_paises);

if (is_array($array_listado_paises)) {
	foreach ($array_listado_paises as $paises) {
		$paisSelect .= '<option value="'.$paises->getId().'">'.$paises->getNombre().'</option>';
	}
}

?>
<div class="page-signin">
    <div class="signin-body scroll-page">
        <div class="container">
            <div class="form-container">

                <form class="form-horizontal" action="../Logica/loginC.php" method="post">
                    <fieldset>
                        <div class="form-group">
                            <h2 class="pg-title-body margin-bottom-20"><?php echo $_start_session; ?></h2>
                        </div>
                        <div class="cubo"></div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="icon-user"></span>
                                </span>
                                <input type="text"
                                       class="form-control"
                                       placeholder="<?php echo $_user; ?>" id="usuario" name="usuario" 
                                       >
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="glyphicon icon-key2"></span>
                                </span>
                                <input type="password"
                                       class="form-control"
                                       placeholder="<?php echo $_pass; ?>" id="contrasena" name="contrasena"
                                       >
                            </div>
                        </div>
                        <div class="form-group">
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary btn-block" value="<?php echo $_boton; ?>" />
                        </div>
                    </fieldset>
                </form>

                <section>
                    <p class="text-center"><a href="recuperar.php"><?php echo $_help; ?></a></p>
                    <p class="text-center text-muted">
                                <a href="javascript:;" data-backdrop="static" data-toggle="modal" data-target="#ayudaLogin" ng-click="open()"><?php echo $_ayudaLogin; ?></a>
                    </p>
                    <p class="text-center text-muted text-small">
                                <a href="javascript:;" data-backdrop="static" data-toggle="modal" data-target="#register_new" class="btn btn-block btn-green" ng-click="open()"><?php echo $_new_user; ?></a>
                    </p>
                </section>
                
            </div>
        </div>
    </div>

</div>

<div class="modal fade" id="ayudaLogin" tabindex="-1" role="dialog" aria-labelledby="help_login" aria-hidden="true">
	<div class="modal-dialog modal-lg">
	    <div class="modal-content">
	    	<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h2 class="pg-title-body margin-bottom-20"><?php echo $_ayudaLogin; ?></h2>
			</div>
			<div class="modal-body">
				<iframe src="AyudaLogin/inicio-de-sesion.html" width="100%" height="500px" frameborder="0" allowfullscreen="allowfullscreen"></iframe>
			</div>

		</div>
	</div>
</div>





<div class="modal fade" id="register_new" tabindex="-1" role="dialog" aria-labelledby="register_new" aria-hidden="true">
	<div class="modal-dialog modal-lg">
	    <div class="modal-content">
			<form id="register_new_form" method="post" action="validarlicencia.php" class="form-horizontal ng-pristine ng-valid ng-valid-required" lang="es">
				<input type="hidden" name="colegio" id="colegio" />			
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h2 class="pg-title-body margin-bottom-20"><?php echo $_title_new_user; ?></h2>
				</div>
				<div class="modal-body" style="max-height: 350px; overflow-y: auto;">

					<div class="form-group">
						<div class="col-sm-12" style="text-align: right !important;">
					    	<span class="icon-info2" style="text-align:right !important;">&nbsp;<label style="font-family:tahoma;"><?php echo $_validate_license_warning; ?></label></span>
					    	<br />
					    	<br />
					    	<br />
						</div>
						<label class="col-sm-4" for="" style="width:15% !important;"><?php echo $_license_number; ?>:</label>
						<div class="col-sm-8 input-group-3">
							<input type="text" class="form-control" name="license_number" id="license_number" />&nbsp;&nbsp;<a href="#" class="btn btn-default"><?php echo $_verify; ?></a>
							<span class="glyphicon glyphicon-remove reg-error" style="display: none;"></span>
							<span class="help-block" style="display: none;"><?php echo $_invalid_license_number; ?></span>
							<span class="glyphicon glyphicon-ok reg-correcto" style="display: none; margin-left: 0px !important;"></span>
   							</br>
							<br/>
							<input type="hidden" name="register_docente" id="register_docente" value="false" />
							<input type="hidden" name="register_estudiante" id="register_estudiante" value="false" />
							<input type="hidden" name="register_tutor1" id="register_tutor1" value="false" />
							<input type="hidden" name="register_tutor2" id="register_tutor2" value="false" />
						</div>
						<br/>
						<br/>
						
						<div id="forma_docente" class="panel-body" style="display: none; float: left; width: 100%;">
							<h3 class="tit-modal" style="margin-top:69px;"><?php echo $_registro_docente; ?></h3>
							   	<div class="form-group group-registro">
					                <label class="col-sm-4 pos-reg-tit" for=""><?php echo $_user; ?>:</label>
					                    <div class="col-sm-8"><input type="text" id="dc_us" name="docente_user" class="form-control" pattern="[a-zA-Z_-.]*"></div>
					                </div>
					                <div class="form-group group-registro">
					                    <label class="col-sm-4 pos-reg-tit" for=""><?php echo $_password; ?>:</label>
					                    <div class="col-sm-8">
					                    	<input type="password" id="dc_pas" name="docente_password" class="form-control">
					                    </div>
					                </div>
					                <div class="form-group group-registro">
					                    <label class="col-sm-4 pos-reg-tit" for=""><?php echo $_confirm_password; ?>:</label>
					                    <div class="col-sm-8"><input type="password" id="dc_pas_conf" name="docente_passwordb" class="form-control"></div>
					                </div>
					                <div class="form-group group-registro">
					                    <label class="col-sm-4 pos-reg-tit" for=""><?php echo $_email; ?>:</label>
					                    <div class="col-sm-8"><input type="email" id="dc_ema" name="docente_email" class="form-control" ></div>
					                </div>
					                <div class="form-group group-registro">
					                    <label class="col-sm-4 pos-reg-tit" for=""><?php echo $_nombres; ?>:</label>
					                    <div class="col-sm-8"><input type="text" id="dc_nom" name="docente_nombres" class="form-control" title="<?php echo $_numerico ;?>" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ ']*"></div>
					                </div>
					                <div class="form-group group-registro">
					                    <label class="col-sm-4 pos-reg-tit" for=""><?php echo $_apellidos; ?>:</label>
					                    <div class="col-sm-8"><input type="text" id="dc_apell" name="docente_apellidos" class="form-control" title="<?php echo $_numerico ;?>" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ ']*"></div>
					                </div>


					                <div class="form-group group-registro">
					                    <label class="col-sm-4 pos-reg-tit" for=""><?php echo $_identificacion; ?>:</label>
					                    <div class="col-sm-8"><input type="text" id="dc_iden" name="docente_identificacion" class="form-control" placeholder="<?php echo $_ejemplo; ?>"></div>
					                </div>


					                <div class="form-group group-registro">
										<label class="col-sm-4 pos-reg-tit" for=""><?php echo $_pais; ?>:</label>
										<div class="col-sm-8 select-correo">
											<select onchange="cargarCiudad(this.value,'docente');" id="pais_docente" name="pais_docente" class="form-control">
												<option value="0"><?php echo $_selec_pais;?></option>
												<?php echo $paisSelect ;?>
											</select>
										</div>
									</div>
									<div class="form-group group-registro">
										<label class="col-sm-4 pos-reg-tit" for=""><?php echo $_departamento; ?>:</label>
										<div class="col-sm-8 select-correo">
											<select id="docente_departamentos" name="docente_departamento" class="form-control" onchange="cargarCiudadDepartamento(this.value,'docente');">
											</select>
										</div>
									</div>
									<div class="form-group group-registro">
										<label class="col-sm-4 pos-reg-tit" for=""><?php echo $_ciudad; ?>:</label>
										<div class="col-sm-8 select-correo">
											<select id="docente_ciudad" name="docente_ciudad" class="form-control">
											</select>
										</div>
									</div>
					                <div class="form-group group-registro">
					                    <label class="col-sm-4 pos-reg-tit" for=""><?php echo $_area; ?>:</label>
					                    <div class="col-sm-8 select-correo">
					                    	<select id="docente_area" name="docente_area" class="form-control">
					                    	</select>
					                    </div>
					                </div>
						</div>
						<div id="forma_alumno" class="panel-body" style="display: none; float: left; width: 100%;">
									<div class="table-responsive">
							            <table class="table table-striped table-bordered">
							                <thead>
							                    <tr>
							                        <th><?php echo $_estudiante; ?></th>
							                        <th><?php echo $_acudiente_1; ?></th>
							                        <th><?php echo $_acudiente_2; ?></th>
							                    </tr>
							                </thead>
							                <tbody>
							                    <tr>
							                        <td><span id="span_alumno"><?php echo $_estudiante_already; ?></span><a id="enlace_alumno" class="enlace-clicken1" href="javascript:;">Registrar</a></td>
							                        <td><span id="span_tutor1"><?php echo $_acudiente_1_already; ?></span><a id="enlace_tutor1" class="enlace-clicken1" href="javascript:;">Registrar</a></td>
							                        <td><span id="span_tutor2"><?php echo $_acudiente_2_already; ?></span><a id="enlace_tutor2" class="enlace-clicken1" href="javascript:;">Registrar</a></td>
							                    </tr>
							                </tbody>
							            </table>
							        </div>
									<br><br>
									
									<div id="div_estudiante" class="div_registros" style="display: none;">
										<h3 class="tit-modal"><?php echo $_registro_alumno; ?></h3>
										<div class="form-group group-registro">
											<label class="col-sm-4 pos-reg-tit" for=""><?php echo $_user; ?>:</label>
											<div class="col-sm-8"><input type="text" id="est_us" name="estudiante_user" class="form-control" pattern="[a-zA-Z_-.]*"></div>
										</div>
										<div class="form-group group-registro">
											<label class="col-sm-4 pos-reg-tit" for=""><?php echo $_password; ?>:</label>
											<div class="col-sm-8">
												<input type="password" id="est_pass" name="estudiante_password" class="form-control">
											</div>
										</div>
										<div class="form-group group-registro">
											<label class="col-sm-4 pos-reg-tit" for=""><?php echo $_confirm_password; ?>:</label>
											<div class="col-sm-8"><input type="password" id="est_pass_conf" name="estudiante_passwordb" class="form-control"></div>
										</div>
										<div class="form-group group-registro">
											<label class="col-sm-4 pos-reg-tit" for=""><?php echo $_email; ?>:</label>
											<div class="col-sm-8"><input type="email" id="est_ema" name="estudiante_email" class="form-control"></div>
										</div>
										<div class="form-group group-registro">
											<label class="col-sm-4 pos-reg-tit" for=""><?php echo $_nombres; ?>:</label>
											<div class="col-sm-8"><input type="text" id="est_nom" name="estudiante_nombres" class="form-control" title="<?php echo $_numerico ;?>" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ ']*"></div>
										</div>
										<div class="form-group group-registro">
											<label class="col-sm-4 pos-reg-tit" for=""><?php echo $_apellidos; ?>:</label>
											<div class="col-sm-8"><input type="text" id="est_apell" class="form-control"  name="estudiante_apellidos" title="<?php echo $_numerico ;?>" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ ']*"></div>
										</div>

										<div class="form-group group-registro">
						                    <label class="col-sm-4 pos-reg-tit" for=""><?php echo $_identificacion; ?>:</label>
						                    <div class="col-sm-8"><input type="text" id="est_iden" name="estudiante_identificacion" class="form-control" placeholder="<?php echo $_ejemplo; ?>"></div>
						                </div>
										
										<div class="form-group group-registro">
											<label class="col-sm-4 pos-reg-tit" for=""><?php echo $_pais; ?>:</label>
											<div class="col-sm-8 select-correo">
												<select onchange="cargarCiudad(this.value,'alumno');" id="pais_alumno" name="pais_alumno" class="form-control">
													<option value="0"><?php echo $_selec_pais;?></option>
													<?php echo $paisSelect ;?>
												</select>
											</div>
										</div>
										
										<div class="form-group group-registro">
											<label class="col-sm-4 pos-reg-tit" for=""><?php echo $_departamento; ?>:</label>
											<div class="col-sm-8 select-correo">
												<select id="estudiant_departamentos" name="estudiante_departamento" class="form-control" onchange="cargarCiudadDepartamento(this.value,'alumno');">
												</select>
											</div>
										</div>										

										<div class="form-group group-registro">
											<label class="col-sm-4 pos-reg-tit" for=""><?php echo $_ciudad; ?>:</label>
											<div class="col-sm-8 select-correo">
												<select id="estudiant_ciudad" name="estudiante_ciudad" class="form-control">
												</select>
											</div>
										</div>
										
										<div class="form-group group-registro">
											<label class="col-sm-4 pos-reg-tit" for=""><?php echo $_nivel; ?>:</label>
											<div class="col-sm-8 select-correo">
												<select title="Si elije un nivel / grado incorrecto, podrá verse afectado" id="nivel_alumno" name="estudiante_nivel" class="form-control">
												</select>
											<label style="font-weight:normal">Si elije un nivel / grado incorrecto, podrá verse afectado</label>
											</div>
										</div>
									</div>
									

									<div id="div_tutor1" class="div_registros" style="display: none;">
									
										<h3 class="tit-modal"><?php echo $_registro_acudiente_1; ?></h3>
										
										<div class="form-group group-registro">
											<label class="col-sm-4 pos-reg-tit" for=""><?php echo $_user; ?>:</label>
											<div class="col-sm-8"><input type="text" id="tut1_us" name="tutor1_user" class="form-control" pattern="[a-zA-Z_-.]*"></div>
										</div>
										<div class="form-group group-registro">
											<label class="col-sm-4 pos-reg-tit" for=""><?php echo $_password; ?>:</label>
											<div class="col-sm-8">
												<input type="password" id="tut1_pass" name="tutor1_password" class="form-control">
											</div>
										</div>
										<div class="form-group group-registro">
											<label class="col-sm-4 pos-reg-tit" for=""><?php echo $_confirm_password; ?>:</label>
											<div class="col-sm-8"><input type="password" id="tut1_pass_conf" class="form-control" name="tutor1_passwordb"></div>
										</div>
										<div class="form-group group-registro">
											<label class="col-sm-4 pos-reg-tit" for=""><?php echo $_email; ?>:</label>
											<div class="col-sm-8"><input type="email" id="tut1_ema" class="form-control" name="tutor1_email"></div>
										</div>
										<div class="form-group group-registro">
											<label class="col-sm-4 pos-reg-tit" for=""><?php echo $_nombres; ?>:</label>
											<div class="col-sm-8"><input type="text" id="tut1_nom" class="form-control" name="tutor1_nombres" title="<?php echo $_numerico ;?>" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ ']*"></div>
										</div>
										<div class="form-group group-registro">
											<label class="col-sm-4 pos-reg-tit" for=""><?php echo $_apellidos; ?>:</label>
											<div class="col-sm-8"><input type="text" id="tut1_apell" class="form-control" name="tutor1_apellidos" title="<?php echo $_numerico ;?>" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ ']*"></div>
										</div>
										<div class="form-group group-registro">
						                    <label class="col-sm-4 pos-reg-tit" for=""><?php echo $_identificacion; ?>:</label>
						                    <div class="col-sm-8"><input type="text" id="tut1_ident" name="tutor1_identificacion" class="form-control" placeholder="<?php echo $_ejemplo; ?>"></div>
						                </div>
										<div class="form-group group-registro">
											<label class="col-sm-4 pos-reg-tit" for=""><?php echo $_pais; ?>:</label>
											<div class="col-sm-8 select-correo">
												<select onchange="cargarCiudad(this.value,'tutor1');" id="pais_tutor1" name="pais_tutor1" class="form-control">
													<option value="0"><?php echo $_selec_pais;?></option>
													<?php echo $paisSelect ;?>
												</select>
											</div>
										</div>

										<div class="form-group group-registro">
											<label class="col-sm-4 pos-reg-tit" for=""><?php echo $_departamento; ?>:</label>
											<div class="col-sm-8 select-correo">
												<select id="tutor1_departamentos" name="tutor1_departamento" class="form-control" onchange="cargarCiudadDepartamento(this.value,'tutor1');">
												</select>
											</div>
										</div>	

										<div class="form-group group-registro">
											<label class="col-sm-4 pos-reg-tit" for=""><?php echo $_ciudad; ?>:</label>
											<div class="col-sm-8 select-correo">
												<select id="tutor1_ciudad" name="tutor1_ciudad" class="form-control">
												</select>
											</div>
										</div>
										
									</div>
									
									<div id="div_tutor2" class="div_registros" style="display: none;">
									
										<h3 class="tit-modal"><?php echo $_registro_acudiente_2; ?></h3>
										
										<div class="form-group group-registro">
											<label class="col-sm-4 pos-reg-tit" for=""><?php echo $_user; ?>:</label>
											<div class="col-sm-8"><input type="text" id="tut2_us" class="form-control" name="tutor2_user" pattern="[a-zA-Z_-.]*"></div>
										</div>
										<div class="form-group group-registro">
											<label class="col-sm-4 pos-reg-tit" for=""><?php echo $_password; ?>:</label>
											<div class="col-sm-8">
												<input type="password" id="tut2_pass" class="form-control" name="tutor2_password">
											</div>
										</div>
										<div class="form-group group-registro">
											<label class="col-sm-4 pos-reg-tit" for=""><?php echo $_confirm_password; ?>:</label>
											<div class="col-sm-8"><input type="password" id="tut2_pass_conf" class="form-control" name="tutor2_passwordb"></div>
										</div>
										<div class="form-group group-registro">
											<label class="col-sm-4 pos-reg-tit" for=""><?php echo $_email; ?>:</label>
											<div class="col-sm-8"><input type="email" id="tut2_ema" class="form-control" name="tutor2_email"></div>
										</div>
										<div class="form-group group-registro">
											<label class="col-sm-4 pos-reg-tit" for=""><?php echo $_nombres; ?>:</label>
											<div class="col-sm-8"><input type="text" id="tut2_nom" class="form-control" name="tutor2_nombres" title="<?php echo $_numerico ;?>" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ ']*"></div>
										</div>
										<div class="form-group group-registro">
											<label class="col-sm-4 pos-reg-tit" for=""><?php echo $_apellidos; ?>:</label>
											<div class="col-sm-8"><input type="text" id="tut2_apell" class="form-control" name="tutor2_apellidos" title="<?php echo $_numerico ;?>" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚüÜ ']*"></div>
										</div>
										<div class="form-group group-registro">
						                    <label class="col-sm-4 pos-reg-tit" for=""><?php echo $_identificacion; ?>:</label>
						                    <div class="col-sm-8"><input type="text" id="tut2_ident" name="tutor2_identificacion" class="form-control" placeholder="<?php echo $_ejemplo; ?>"></div>
						                </div>
										<div class="form-group group-registro">
											<label class="col-sm-4 pos-reg-tit" for=""><?php echo $_pais; ?>:</label>
											<div class="col-sm-8 select-correo">
												<select onchange="cargarCiudad(this.value,'tutor2');" id="pais_tutor2" name="pais_tutor2" class="form-control">
													<option value="0"><?php echo $_selec_pais;?></option>
													<?php echo $paisSelect ;?>
												</select>
											</div>
										</div>
										<div class="form-group group-registro">
											<label class="col-sm-4 pos-reg-tit" for=""><?php echo $_departamento; ?>:</label>
											<div class="col-sm-8 select-correo">
												<select id="tutor2_departamentos" name="tutor2_departamento" class="form-control" onchange="cargarCiudadDepartamento(this.value,'tutor2');">
												</select>
											</div>
										</div>
										
										<div class="form-group group-registro">
											<label class="col-sm-4 pos-reg-tit" for=""><?php echo $_ciudad; ?>:</label>
											<div class="col-sm-8 select-correo">
												<select id="tutor2_ciudad" name="tutor2_ciudad" class="form-control">
												</select>
											</div>
										</div>
						</div>
					</div>
				</div>
				<div class="modal-footer" style="margin-top: 50px;">
					<!-- div que carga los errores -->
					<div class="error" style="color:red; text-align: left !important;"></div>
					</br>
					<span><?php echo $_support_message; ?></span>
				  	<br />
				  	<br />
					<input type="submit" class="btn btn-primary" value="<?php echo $_acept; ?>" />
					<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $_cancel; ?></button>
				</div>
			</form>
		</div>
	</div>
</div>
<script>
	$(document).ready
	(
		function()
		{
			$('#license_number').blur
			(
				function()
				{
					$('#register_new span.reg-error').hide();
					$('#register_new span.reg-correcto').hide();
					$('#register_new span.help-block').hide();
					$('#forma_docente').hide();
					$('#forma_alumno').hide();
				
					dataserial = $('#register_new_form').serialize();
					urlform = $('#register_new_form').attr('action');
					$.ajax
					(
						{
							url: urlform,
							type: 'POST',
							data: dataserial
						}
					).done
					(
						function(data)
						{
							if(data==0)
							{
								$('#register_new span.reg-error').show();
								$('#register_new span.help-block').show();
							}
							else
							{
								data = JSON.parse(data);
								console.log(data);
								if(data.estado==0)
								{
									$('#register_new span.reg-error').show();
									$('#register_new span.help-block').show();
								}
								else
								{
									$('#colegio').val(data.colegio);
									if(data.rol==2)
									{
										if(!data.usuario)
										{
											$('#register_new span.reg-correcto').show();
											$('#register_docente').val(true);
											$('#docente_area').html(data.areas);
											$('#forma_docente').show();

											// eliminamos los campos required de estudiantes

											$("#est_us").removeAttr("required");
											$("#est_pass").removeAttr("required");
											$("#est_pass_conf").removeAttr("required");
											$("#est_ema").removeAttr("required");
											$("#est_nom").removeAttr("required");
											$("#est_apell").removeAttr("required");
											$("#est_iden").removeAttr("required");

											// eliminamos los campos required de tutor1

											$("#tut1_us").removeAttr("required");
											$("#tut1_pass").removeAttr("required");
											$("#tut1_pass_conf").removeAttr("required");
											$("#tut1_ema").removeAttr("required");
											$("#tut1_nom").removeAttr("required");
											$("#tut1_apell").removeAttr("required");
											$("#tut1_ident").removeAttr("required");

											// eliminamos los campos required de tutor2

											$("#tut2_us").removeAttr("required");
											$("#tut2_pass").removeAttr("required");
											$("#tut2_pass_conf").removeAttr("required");
											$("#tut2_ema").removeAttr("required");
											$("#tut2_nom").removeAttr("required");
											$("#tut2_apell").removeAttr("required");
											$("#tut2_ident").removeAttr("required");



											// se toma el id de los campos para agregarles el atributo required 

											var usua = document.querySelector('#dc_us');
											var pass = document.querySelector('#dc_pas');
											var pass_conf = document.querySelector('#dc_pas_conf');
											var emai = document.querySelector('#dc_ema');
											var nomb = document.querySelector('#dc_nom');
											var apell = document.querySelector('#dc_apell');
											var ident = document.querySelector('#dc_iden');
											
											usua.setAttribute("required", "true");
											pass.setAttribute("required", "true");
											pass_conf.setAttribute("required", "true");
											emai.setAttribute("required", "true");
											nomb.setAttribute("required", "true");
											apell.setAttribute("required", "true");
											ident.setAttribute("required", "true");
										}
										else
										{
											$('#register_new span.reg-error').show();
											$('#register_new span.help-block').show();
										}
									}
									else if(data.rol==3)
									{
											$('#register_new span.reg-correcto').show();
											$('#nivel_alumno').html(data.niveles);
											
											$('#span_alumno').show();
											$('#enlace_alumno').hide();
											
											$('#span_tutor1').show();
											$('#enlace_tutor1').hide();
											
											$('#span_tutor2').show();
											$('#enlace_tutor2').hide();
												
											if(!data.usuario)
											{
												//$('#register_estudiante').val(true);
												$('#span_alumno').hide();
												$('#enlace_alumno').show();
												
												$('#enlace_alumno').click
												(
													function(event)
													{
														event.preventDefault();
														$('#register_estudiante').val(true);
														$('.div_registros').hide();
														$('#div_estudiante').show();


														// eliminamos los campos required de docentes

														$("#dc_us").removeAttr("required");
														$("#dc_pas").removeAttr("required");
														$("#dc_pas_conf").removeAttr("required");
														$("#dc_ema").removeAttr("required");
														$("#dc_nom").removeAttr("required");
														$("#dc_apell").removeAttr("required");
														$("#dc_iden").removeAttr("required");

														// eliminamos los campos required de tutor1

														$("#tut1_us").removeAttr("required");
														$("#tut1_pass").removeAttr("required");
														$("#tut1_pass_conf").removeAttr("required");
														$("#tut1_ema").removeAttr("required");
														$("#tut1_nom").removeAttr("required");
														$("#tut1_apell").removeAttr("required");
														$("#tut1_ident").removeAttr("required");

														// eliminamos los campos required de tutor2

														$("#tut2_us").removeAttr("required");
														$("#tut2_pass").removeAttr("required");
														$("#tut2_pass_conf").removeAttr("required");
														$("#tut2_ema").removeAttr("required");
														$("#tut2_nom").removeAttr("required");
														$("#tut2_apell").removeAttr("required");
														$("#tut2_ident").removeAttr("required");


														// agregamos los campos required en estudiantes

														var est_usua = document.querySelector('#est_us');
														var est_pass = document.querySelector('#est_pass');
														var est_pass_conf = document.querySelector('#est_pass_conf');
														var est_emai = document.querySelector('#est_ema');
														var est_nomb = document.querySelector('#est_nom');
														var est_apell = document.querySelector('#est_apell');
														var est_ident = document.querySelector('#est_iden');
														
														est_usua.setAttribute("required", "true");
														est_pass.setAttribute("required", "true");
														est_pass_conf.setAttribute("required", "true");
														est_emai.setAttribute("required", "true");
														est_nomb.setAttribute("required", "true");
														est_apell.setAttribute("required", "true");
														est_ident.setAttribute("required", "true");



													}
												);
												
											}
											if(!data.tutor1)
											{
												//$('#register_tutor1').val(true);
												$('#span_tutor1').hide();
												$('#enlace_tutor1').show();
												
												$('#enlace_tutor1').click
												(
													function(event)
													{
														event.preventDefault();
														$('#register_tutor1').val(true);
														$('.div_registros').hide();
														$('#div_tutor1').show();


														
														// eliminamos los campos required de docentes

														$("#dc_us").removeAttr("required");
														$("#dc_pas").removeAttr("required");
														$("#dc_pas_conf").removeAttr("required");
														$("#dc_ema").removeAttr("required");
														$("#dc_nom").removeAttr("required");
														$("#dc_apell").removeAttr("required");
														$("#dc_iden").removeAttr("required");


														// eliminamos los campos required de estudiantes

														$("#est_us").removeAttr("required");
														$("#est_pass").removeAttr("required");
														$("#est_pass_conf").removeAttr("required");
														$("#est_ema").removeAttr("required");
														$("#est_nom").removeAttr("required");
														$("#est_apell").removeAttr("required");
														$("#est_iden").removeAttr("required");

														// eliminamos los campos required de tutor2

														$("#tut2_us").removeAttr("required");
														$("#tut2_pass").removeAttr("required");
														$("#tut2_pass_conf").removeAttr("required");
														$("#tut2_ema").removeAttr("required");
														$("#tut2_nom").removeAttr("required");
														$("#tut2_apell").removeAttr("required");
														$("#tut2_ident").removeAttr("required");


														//agregamos atributo required en tutor1

														var tut1_usua = document.querySelector('#tut1_us');
														var tut1_pass = document.querySelector('#tut1_pass');
														var tut1_pass_conf = document.querySelector('#tut1_pass_conf');
														var tut1_emai = document.querySelector('#tut1_ema');
														var tut1_nomb = document.querySelector('#tut1_nom');
														var tut1_apell = document.querySelector('#tut1_apell');
														var tut1_ident = document.querySelector('#tut1_ident');
														
														tut1_usua.setAttribute("required", "true");
														tut1_pass.setAttribute("required", "true");
														tut1_pass_conf.setAttribute("required", "true");
														tut1_emai.setAttribute("required", "true");
														tut1_nomb.setAttribute("required", "true");
														tut1_apell.setAttribute("required", "true");
														tut1_ident.setAttribute("required", "true");


													}
												);
											}
											if(!data.tutor2)
											{
												//$('#register_tutor2').val(true);
												$('#span_tutor2').hide();
												$('#enlace_tutor2').show();
												
												$('#enlace_tutor2').click
												(
													function(event)
													{
														event.preventDefault();
														$('#register_tutor2').val(true);
														$('.div_registros').hide();
														$('#div_tutor2').show();


														// eliminamos los campos required de docentes

														$("#dc_us").removeAttr("required");
														$("#dc_pas").removeAttr("required");
														$("#dc_pas_conf").removeAttr("required");
														$("#dc_ema").removeAttr("required");
														$("#dc_nom").removeAttr("required");
														$("#dc_apell").removeAttr("required");
														$("#dc_iden").removeAttr("required");


														// eliminamos los campos required de estudiantes

														$("#est_us").removeAttr("required");
														$("#est_pass").removeAttr("required");
														$("#est_pass_conf").removeAttr("required");
														$("#est_ema").removeAttr("required");
														$("#est_nom").removeAttr("required");
														$("#est_apell").removeAttr("required");
														$("#est_iden").removeAttr("required");

														// eliminamos los campos required de tutor1

														$("#tut1_us").removeAttr("required");
														$("#tut1_pass").removeAttr("required");
														$("#tut1_pass_conf").removeAttr("required");
														$("#tut1_ema").removeAttr("required");
														$("#tut1_nom").removeAttr("required");
														$("#tut1_apell").removeAttr("required");
														$("#tut1_ident").removeAttr("required");


														//agregamos atributo required en tutor2

														var tut2_usua = document.querySelector('#tut2_us');
														var tut2_pass = document.querySelector('#tut2_pass');
														var tut2_pass_conf = document.querySelector('#tut2_pass_conf');
														var tut2_emai = document.querySelector('#tut2_ema');
														var tut2_nomb = document.querySelector('#tut2_nom');
														var tut2_apell = document.querySelector('#tut2_apell');
														var tut2_ident = document.querySelector('#tut2_ident');
														
														tut2_usua.setAttribute("required", "true");
														tut2_pass.setAttribute("required", "true");
														tut2_pass_conf.setAttribute("required", "true");
														tut2_emai.setAttribute("required", "true");
														tut2_nomb.setAttribute("required", "true");
														tut2_apell.setAttribute("required", "true");
														tut2_ident.setAttribute("required", "true");

													}
												);
											}
											$('#forma_alumno').show();
											
									}
									else
									{
										$('#register_new span.reg-error').show();
										$('#register_new span.help-block').show();
									}
								}
							}
						}
					);
				}
			);
			
			$('#register_new_form').submit
			(
				function(event)
				{
					event.preventDefault();
					
					dataserial = $(this).serialize();
					
					$.ajax
					(
						{
							url: 'guardarlicencia.php',
							data: dataserial,
							type: 'POST'
						}
					).done
					(
						function(data)
						{
							//console.log(data);
							//data = JSON.parse(data);
							
							var mensaje = data.substring(0,1);


							//alert(data);

							if(!data){
								
								//console.log("if");

								$('#register_new').modal('hide');
								//$('#reg_exito').modal('show');

								var mensaje = "<?php echo $_mensaje_validacion;?>";
								
								$('.error').html(data);

							}else if(data){
								//console.log("else");
								//$('.error').html(data);
								var mensaje = "<?php echo $_mensaje_validacion;?>";
								
								$('.error').html(data);

							}
						}
					);
				}
			);
		}
	);
	
	function cargarCiudad(pais,tipo){
		
		var sinC = "sinColegio";


		// departamento

		var accion2 = "departamento";

		$.post("../Logica/AuxiliarCrearColegio.php", { accion: accion2, pais: pais, sinC:sinC}, function(data2){

			

			if(tipo == "alumno"){
				$("#estudiant_departamentos").html(data2);
			}else if(tipo == "tutor1"){
				$("#tutor1_departamentos").html(data2);
			}else if(tipo == "tutor2"){
				$("#tutor2_departamentos").html(data2);
			}else if(tipo == "docente"){
				$("#docente_departamentos").html(data2);
			}

		});

		// ---------------------------------------------------------------------------------------------------------

		var accion = "cargarCiudad";
		
		$.post("../Logica/AuxiliarCrearColegio.php", { accion: accion, pais: pais, sinC:sinC}, function(data){
			
			if(tipo == "alumno"){
				$("#estudiant_ciudad").html(data);
			}else if(tipo == "tutor1"){
				$("#tutor1_ciudad").html(data);
			}else if(tipo == "tutor2"){
				$("#tutor2_ciudad").html(data);
			}else if(tipo == "docente"){
				$("#docente_ciudad").html(data);
			}
		});
	}


	function cargarCiudadDepartamento(depart_pais,tipo){

		var accion = "ciudadPorDepartamento";
		var sinC = "sinColegio";
		var ids = depart_pais.split(',');
		var depart = ids["0"];
		var pais = ids["1"];


		$.post("../Logica/AuxiliarCrearColegio.php", { accion: accion, depart: depart, pais:pais, sinC:sinC}, function(data){

			if(tipo == "alumno"){
				$("#estudiant_ciudad").html(data);
			}else if(tipo == "tutor1"){
				$("#tutor1_ciudad").html(data);
			}else if(tipo == "tutor2"){
				$("#tutor2_ciudad").html(data);
			}else if(tipo == "docente"){
				$("#docente_ciudad").html(data);
			}

		});


	}
</script>

<div class="modal fade" id="reg_exito" tabindex="-1" role="dialog" aria-labelledby="reg_exito" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h2 class="pg-title-body margin-bottom-20"><?php echo $_success_title; ?></h2>
	  </div>
	  <div class="modal-body">
		<?php echo $_success_message; ?>
		<div style="height:15px;"></div>
	  </div>
	  <div class="modal-footer">
	  	<span><?php echo $_support_message; ?></span>
	  	<br />
	  	<br />
		<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $_exit; ?></button>
	  </div>
	</div>
  </div>
</div>
