<?php

class Page_compraController extends Page_mainController
{
  public function indexAction()
  {
    $this->setLayout("blanco");

    // echo Session::getInstance()->get("user");
  }
  public function confirmarAction()
  {
    // Obtiene el contenido de la sección 2 para la vista
    $this->_view->contenido = $this->template->getContentseccion("2");

    // Instancia los modelos necesarios
    $itemsModel = new Administracion_Model_DbTable_Listarcompras();
    $productoModel = new Administracion_Model_DbTable_Productos();

    // Obtiene la información del usuario
    $usuarioInfo = $this->getUsuario();

    // Sanitiza y asigna los parámetros de la solicitud
    $cedula = $this->_getSanitizedParam('cedula');
    $cuotas = $this->_getSanitizedParam('cuotas');
    $cuota = $this->_getSanitizedParam('cuota');
    $valor = $this->_getSanitizedParam('valor');
    $nombre = Session::getInstance()->get("username");
    $nombreDestinatario = $this->_getSanitizedParam('destinatario');
    $direccion = $this->_getSanitizedParam('direccion');
    $ciudad = $this->_getSanitizedParam('ciudad-destino');
    $telefono = $this->_getSanitizedParam('telefono');
    $documento = $this->_getSanitizedParam('documento-destinatario');
    $barrio = $this->_getSanitizedParam('barrio');
    $celular = $this->_getSanitizedParam('celular');

    // Verifica que todos los datos necesarios estén presentes
    if ($barrio && $direccion && $ciudad && $telefono && $documento && $celular && $nombre) {
      // Actualiza los datos del carrito
      $itemsModel->updateCarrito($cedula, $nombre, $direccion, $ciudad, $telefono, $documento, $barrio, $celular, $cuotas);
    }

    // Recupera los productos en el carrito que no han sido validados aún
    $productosEnCarrito = $itemsModel->getList("validacion = '0' AND cedula='$cedula'", "");

    // Asigna los datos a las variables de la vista
    $this->_view->cedula = $cedula;
    $this->_view->cuotas = $cuotas;
    $this->_view->cuota = $cuota;
    $this->_view->valor = $valor;
    $this->_view->nombre = $nombre;
    $this->_view->nombreDestinatario = $nombreDestinatario;
    $this->_view->direccion = $direccion;
    $this->_view->ciudad = $ciudad;
    $this->_view->telefono = $telefono;
    $this->_view->documento = $documento;
    $this->_view->barrio = $barrio;
    $this->_view->celular = $celular;
    $this->_view->usuarioInfo = $usuarioInfo;
    $this->_view->list_ciudades = $this->getCiudaddocumento();
  }


  public function confirmarcarritoAction()
  {
    $this->setLayout("blanco");
    // Sanitiza y asigna los parámetros de la solicitud
    $cedula = $this->_getSanitizedParam('id');
    $cuotas = $this->_getSanitizedParam('cuotas');
    $cuota = $this->_getSanitizedParam('cuota');
    $valor = $this->_getSanitizedParam('valor');

    // Instancia los modelos necesarios
    $itemsModel = new Administracion_Model_DbTable_Listarcompras();
    $productoModel = new Administracion_Model_DbTable_Productos();
    $productosEnCarrito = $itemsModel->getList("cedula = '$cedula' AND enviado IS NULL AND validacion='0'", "");

    $ultimaCompra = $itemsModel->getList(" validacion = '1'", "orden DESC")[0];

    $orden = $ultimaCompra->orden + 1;
    $fecha = date("Y-m-d H:i:s");
    if ($cedula && count($productosEnCarrito) >= 1 && $productosEnCarrito[0]->nombre != '') {
      $itemsModel->updateCarritoConfirmacion($cedula, $orden, $fecha);
    }


    if (!$productosEnCarrito   && $productosEnCarrito[0]->nombre == '') {
      header('Location: /page/informacioenvio');
    }



    // Instancia los modelos necesarios
    $itemsModel = new Administracion_Model_DbTable_Listarcompras();
    $productoModel = new Administracion_Model_DbTable_Productos();
    $usuariosModel = new Administracion_Model_DbTable_Usuariostienda();

    $productosEnCarrito = $itemsModel->getList("cedula = '$cedula' AND validacion = '1' AND orden='$orden'", " id ASC ");

    $enviado = $productosEnCarrito[0]->enviado;
    $nombres = '';
    $precios = '';
    $cantidades = '';
    $mensajeProductos = '';
    foreach ($productosEnCarrito as $itemCarrito) {
      $productoId = $itemCarrito->producto;
      $producto = $productoModel->getById($productoId);


      if ($producto->nombre != '') {
        /*  $mensajeProductos .= "
			<tr>
				<td>" . $producto->nombre . "</td>
				<td><div align='right'>$ " . (number_format($itemCarrito->valor, 0)) . "</div></td>
				<td><div align='center'>" . $itemCarrito->cantidad . "</div></td>
				<td><div align='right'>$ " . (number_format($itemCarrito->valor * $itemCarrito->cantidad, 0)) . "</div></td>
			</tr>"; */
        $mensajeProductos .= "

      <tr style='padding-top:10px;padding-bottom:10px; display:grid;'>
      <td class='esd-structure es-p20' align='left' esd-custom-block-id='1105821' esdev-config='h1'>

        <table cellpadding='0' cellspacing='0' class='es-left' align='left'>
          <tbody>
            <tr>
              <td width='270' class='es-m-p20b esd-container-frame' align='left'>
                <table cellpadding='0' cellspacing='0' width='100%'>
                  <tbody>
                    <tr>
                      <td align='center' class='esd-block-image' style='font-size: 0px;'><img class='adapt-img p_image' src='https://tienda.foebbva.com/imagenes/" . $producto->imagen . "' alt='Imagen del producto " . $producto->nombre . " style='display: block;' width='270'></td>
                    </tr>
                  </tbody>
                </table>
              </td>
            </tr>
          </tbody>
        </table>

        <table cellpadding='0' cellspacing='0' class='es-right' align='right'>
          <tbody>
            <tr>
              <td width='270' align='left' class='esd-container-frame'>
                <table cellpadding='0' cellspacing='0' width='100%'>
                  <tbody>
                    <tr>
                      <td align='left' class='esd-block-text'>
                        <h3 class='p_name'>" . $producto->nombre . "</h3>
                      </td>
                    </tr>

                    <tr>
                      <td align='left' class='esd-block-text es-p10t es-p15b'>
                        <h2 style='color: #3a599b;margin-bottom:5px;margin-top:5px; font-size: 20px;' class='p_price'>$ " . (number_format($itemCarrito->valor, 0)) . "</h2>
                      </td>
                    </tr>
                    <tr>
                      <td align='left' class='esd-block-text es-p10t'>
                        <p class='p_description' style='color: #3a599b;margin-bottom:5px;margin-top:5px; font-size: 20px;'>Cantidad: " . $itemCarrito->cantidad . "</p>
                      </td>
                    </tr>
                    <tr>
                      <td align='left' class='esd-block-text es-p10t es-p15b'>
                        <h2 style='color: #3a599b;margin-bottom:5px;margin-top:5px; font-size: 25px;' class='p_price'>$ " . (number_format($itemCarrito->valor * $itemCarrito->cantidad, 0)) . "</h2>
                      </td>
                    </tr>

                  </tbody>
                </table>
              </td>
            </tr>
          </tbody>
        </table>

      </td>
    </tr>
    ";
      } //if

    }

    $usuario = $usuariosModel->getList("usuario = '$cedula'", "")[0];
    $cupo_actual = $usuario->cupo_actual;
    $cupo_actual = $cupo_actual - $valor;

    if ($enviado != 1) {
      $usuariosModel->editField($usuario->id, "cupo_actual", $cupo_actual);
      $itemsModel->updateByOrden($orden);
    }

    $nombre = $usuario->nombre;
    $usuario = $usuario->usuario;
    $correo = $usuario->correo;
    $ciudad = $usuario->ciudad_documento;
    $ciudad2 = $usuario->ciudad_residencia;
    $id = $usuario->id;

    if ($nombre == "") {
      $nombre =  Session::getInstance()->get("username");
    }
    if ($correo == "") {
      $correo =  Session::getInstance()->get("email");
    }
    if ($usuario == "") {
      $usuario =  Session::getInstance()->get("user");
    }

    $datos = [
      'nombre' => $nombre,
      'correo' => $correo,
      'ciudad' => $ciudad,
      'ciudad2' => $ciudad2,
      'usuario' => $usuario,
      'valor' => $_GET['valor'],
      'cuotas' => $_GET['cuotas'],
      'id' => $id,
      'nombres' => $nombres,
      'precios' => $precios,
      'cantidades' => $cantidades,
      'orden' => $orden,
      'cedula' => $cedula,
      'f' => microtime(),
      'hash' => md5("OMEGA_" . $orden)
    ];


    $pagare  = $this->consultarPagare($cedula);
    if ($pagare != "") {
      $itemsModel->updateItemByPagare($pagare, $orden);
    }

    /* $mensaje = "<strong>Compra No. " . $orden . "V</strong><br />
    <table style=\"border:1px solid #000000;\" border=\"1\" cellspacing=\"0\" cellpadding=\"3\" >
      <tr>
        <td><strong>Producto</strong></td>
        <td><strong>Precio</strong></td>
        <td><strong>Cantidad</strong></td>
        <td><strong>Subtotal</strong></td>
      </tr>";
 */
    $mensaje = "
	<table class='es-wrapper' width='100%' cellspacing='0' cellpadding='0'>
		<tbody>
			<tr>
				<td class='esd-email-paddings' valign='top'>

					<table class='es-content' cellspacing='0' cellpadding='0' align='center'>
						<tbody>
							<tr>
								<td class='esd-stripe' align='center' esd-custom-block-id='1105818'>
									<table class='es-content-body' width='600' cellspacing='0' cellpadding='0' bgcolor='#FFF' align='center' style='background-color: #FFF;'>
										<tbody>
											<tr>
												<td class='esd-structure es-p30t es-p20b es-p20r es-p20l' align='left'>
													<table cellpadding='0' cellspacing='0' width='100%'>
														<tbody>
															<tr>
																<td width='560' class='esd-container-frame' align='center' valign='top'>
																	<table cellpadding='0' cellspacing='0' width='100%'>
																		<tbody>
																			<tr>
																				<td align='center' class='esd-block-text' style='background-color:#3a599b;color:#FFF'>
																					<h2 style='margin-top:10px;margin-bottom:10px;'>¡Gracias por tu compra!</h2>
																				</td>
																			</tr>
																		</tbody>
																	</table>
																</td>
															</tr>
														</tbody>
													</table>
												</td>
											</tr>
											<tr>
												<td class='esd-structure es-p35t es-p35b es-p20r es-p20l'>

													<table cellpadding='0' cellspacing='0' class='es-right' align='center'>
														<tbody>
															<tr>
																<td width='100%' align='center' class='esd-container-frame es-m-p20b'>
																	<table cellpadding='0' cellspacing='0' width='100%'>
																		<tbody>
																			<tr>
																				<td align='center' class='esd-block-image' style='font-size: 0px;'><img class='adapt-img' src='https://www.foebbva.com/skins/page/images/header/logo.png' alt='Logo del FOE' style='display: block;' width='292' title='Logo del FOE'></td>
																			</tr>
																		</tbody>
																	</table>
																</td>
															</tr>
														</tbody>
													</table>

												</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
					<table cellpadding='0' cellspacing='0' class='es-content' align='center'>
						<tbody>
							<tr>
								<td class='esd-stripe' align='center' esd-custom-block-id='1105819'>
									<table bgcolor='#ffffff' class='es-content-body' align='center' cellpadding='0' cellspacing='0' width='600'>
										<tbody>
											<tr>
												<td class='esd-structure es-p30t es-p20b es-p20r es-p20l' align='left'>
													<table cellpadding='0' cellspacing='0' width='100%'>
														<tbody>
															<tr>
																<td width='560' class='esd-container-frame' align='center' valign='top'>
																	<table cellpadding='0' cellspacing='0' width='100%'>
																		<tbody>
																			<tr>
																				<td align='center' class='esd-block-text' style='background-color:#80c341;color:#FFF'>
																					<h3 style='margin-top:5px;margin-bottom:5px;'>Compra No. " . $orden . "V</h3>
																				</td>
																			</tr>
																		</tbody>
																	</table>
																</td>
															</tr>
														</tbody>
													</table>
												</td>
											</tr>
  
  ";

    $mensaje .= $mensajeProductos;

    /*     $mensaje .= "	
	<tr>
		<td></td>
		<td></td>
		<td><strong>TOTAL</strong></td>
		<td><div align='right'><strong>$ " . (number_format($valor, 0)) . "</strong></div></td>
	</tr>

</table>
<br /><br />"; */
    $mensaje .= "	
<tr style='padding-top:10px;padding-bottom:10px; display:grid;'>
												<td class='esd-structure es-p20' align='left' esd-custom-block-id='1105821' esdev-config='h1'>

													<table cellpadding='0' cellspacing='0' class='es-left' align='left'>
														<tbody>
															<tr>
																<td width='270' class='es-m-p20b esd-container-frame' align='left'>
																	<table cellpadding='0' cellspacing='0' width='100%'>
																		<tbody>
																			<tr>
																				<td align='center' class='esd-block-image' style='font-size: 0px;'></td>
																			</tr>
																		</tbody>
																	</table>
																</td>
															</tr>
														</tbody>
													</table>

													<table cellpadding='0' cellspacing='0' class='es-right' align='right'>
														<tbody>
															<tr>
																<td width='270' align='left' class='esd-container-frame'>
																	<table cellpadding='0' cellspacing='0' width='100%'>
																		<tbody>
																			<tr>
																				<td align='left' class='esd-block-text'>
																					<h3 style='color: #3a599b;margin-bottom:5px;margin-top:5px;' class='p_name'>Total</h3>
																				</td>
																			</tr>



																			<tr>
																				<td align='left' class='esd-block-text es-p10t es-p15b'>
																					<h2 style='color: #3a599b;margin-bottom:5px;margin-top:5px; font-size: 25px;' class='p_price'>$ " . (number_format($valor, 0)) . "</h2>
																				</td>
																			</tr>

																		</tbody>
																	</table>
																</td>
															</tr>
														</tbody>
													</table>

												</td>
											</tr>
                      </tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
          <table cellpadding='0' cellspacing='0' class='es-footer' align='center'>
						<tbody>
							<tr>
								<td class='esd-stripe' align='center' esd-custom-block-id='1105822'>
									<table class='es-footer-body' width='600' cellspacing='0' cellpadding='0' bgcolor='#ffffff' align='center'>
										<tbody>

											<tr>
												<td class='esd-structure es-p30b es-p20r es-p20l' align='left'>

													<table cellpadding='0' cellspacing='0' class='es-left' align='left'>
														<tbody>
															<tr>
																<td width='100%' class='es-m-p20b esd-container-frame' align='left'>
																	<table cellpadding='0' cellspacing='0' width='100%'>
																		<tbody>
																			<tr>
																				<td align='left' class='esd-block-text es-m-txt-c'>
																					<p align='justify' class='textoNegro'>Yo <span style='text-decoration:underline;'>" . $nombre . "</span> identificado (a) con cedula de ciudadanía número <span style='text-decoration:underline;'>" . $usuario . "</span> de " . $ciudad . "<span style='text-decoration:underline;'></span>, autorizo al pagador de la empresa donde laboro y que determina mi vinculo de asociación con el Fondo de Empleados BBVA, a a descontar por n&oacute;mina o d&eacute;bito autom&aacute;tico el valor de <span style='text-decoration:underline;'>$ " . (number_format($valor, 0)) . "</span> en ( <span style='text-decoration:underline;'>" . $cuotas . "</span> ) cuotas mensuales. En caso de mí desvinculación laboral, autorizo descontar de mi liquidación final de prestaciones sociales y demás beneficios que me liquiden a mi favor.
																						Así mismo en caso de no presentarse el descuento en mi desprendible de nómina autorizo descontar el saldo de mi cuenta de nómina registrada en el FOE. En el caso de asociados independientes se cargara en su próxima cuenta de cobro.</p>
																				</td>
																			</tr>
																		</tbody>
																	</table>
																</td>
															</tr>";



    //     $bono = "<div style=\"border:1px solid #000000; padding:5px;\"><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
    //   <tr>
    //     <td><table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
    //       <tr>
    //         <td><img src=\"https://tienda.foebbva.com/corte/logo60.png\" height=\"77\" /></td>
    //         <td class=\"textoNegro\"><div align=\"center\"><strong>DOCUMENTO AUTORIZACI&Oacute;N DE DESCUENTO No. " . $orden . "V</strong></div></td>
    //       </tr>
    //     </table></td>
    //   </tr>\r\n
    //   <tr>
    //     <td></td>
    //   </tr>\r\n
    //   <tr>
    //     <td><p align=\"justify\" class=\"textoNegro\">Yo <span style=\"text-decoration:underline;\">" . $nombre . "</span> identificado (a) con cedula de ciudadan&iacute;a n&uacute;mero <span style=\"text-decoration:underline;\">" . $usuario . "</span> de <span style=\"text-decoration:underline;\">" . $ciudad . "</span>, autorizo al pagador de la empresa donde laboro y que determina mi vinculo de asociaci&oacute;n con el Fondo de Empleados BBVA, a descontar por n&oacute;mina o d&eacute;bito autom&aacute;tico el valor de <span style=\"text-decoration:underline;\">$ " . (number_format($valor, 0)) . "</span> en ( <span style=\"text-decoration:underline;\">" . $cuotas . "</span> ) cuotas mensuales. En caso de m&iacute; desvinculaci&oacute;n laboral, autorizo descontar de mi liquidaci&oacute;n final de prestaciones sociales y dem&aacute;s beneficios que me liquiden a mi favor.\r\n As&iacute; mismo en caso de no presentarse el descuento en mi desprendible de n&oacute;mina autorizo descontar el saldo de mi cuenta de n&oacute;mina registrada en el FOE. En el caso de asociados independientes se cargara en su pr&oacute;xima cuenta de cobro.</p>
    //     </td>
    //   </tr>
    // </table></div>";

    // $mensaje .= $bono;

    $boton_azul = "background:#01508A; color:#FFF; font-size:12px; padding:5px 12px; text-decoration:none; max-width:200px; border-bottom:1px solid #FFFFFF; border-radius:4px;";

    $pagareMensaje = "<br /><br /><br />
<a href=\"https://tienda.foebbva.com/pdf.php?orden=" . $orden . "\" style='" . $boton_azul . "'>IMPRIMIR PAGAR&Eacute; Y CARTA DE INSTRUCCIONES</a>
";
    $boton_azul = "
<tr>
																<td width='100%' class='es-m-p20b esd-container-frame' align='left'>
																	<table cellpadding='0' cellspacing='0' width='100%'>
																		<tbody>
																			<tr>
																				<td align='left' class='esd-block-text es-m-txt-c'>
																					<br>
																					<a href='https://tienda.foebbva.com/pdf.php?orden=" . $orden . "' style='" . $boton_azul . "'>IMPRIMIR PAGAR&Eacute; Y CARTA DE INSTRUCCIONES</a>
																				</td>
																			</tr>
																		</tbody>
																	</table>
																</td>
															</tr>";


    $mensaje .= $pagareMensaje;

    if ($pagare != '') {
      // $mensaje = $mensaje . "<br /><br />¿Tiene Pagare Firmado? <strong>Si. tiene firmado el pagare No. " . $pagare . "</strong>";
      $mensaje = $mensaje . "
      <tr>
      <td width='100%' class='es-m-p20b esd-container-frame' align='left'>
        <table cellpadding='0' cellspacing='0' width='100%'>
          <tbody>
            <tr>
              <td align='left' class='esd-block-text es-m-txt-c'>
                <br>
               

                ¿Tiene Pagare Firmado?: <strong>Si. tiene firmado el pagare No. " . $pagare . "</strong>


              </td>
            </tr>
          </tbody>
        </table>
      </td>
    </tr>";
    } else {
      // $mensaje = $mensaje . "<br /><br />Tiene Pagare Firmado?: <strong>El asociado no tiene pagare firmado.</strong>";
      $mensaje = $mensaje . "
      <tr>
      <td width='100%' class='es-m-p20b esd-container-frame' align='left'>
        <table cellpadding='0' cellspacing='0' width='100%'>
          <tbody>
            <tr>
              <td align='left' class='esd-block-text es-m-txt-c'>
                <br>
             

                ¿Tiene Pagare Firmado?: <strong>El asociado no tiene pagare firmado.</strong>


              </td>
            </tr>
          </tbody>
        </table>
      </td>
    </tr>";
    }
    $mensaje .= "</tbody>
    </table>

  </td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>

</td>
</tr>
</tbody>
</table>
</div>";

    $asunto = " COMPRA " . $orden . "V TIENDA VIRTUAL FOEBBVA";

    // Muestra el mensaje
    // echo $mensaje;
    $emailModel = new Core_Model_Mail();
    $emailModel->getMail()->Subject = $asunto;
    $emailModel->getMail()->msgHTML($mensaje);
    $emailModel->getMail()->AltBody = $mensaje;

    if ($correo != "") {
      // $emailModel->getMail()->addAddress($correo, "Notificaciones FOE");
      // $data["mailTo"] = "" . $correo;
      $emailModel->getMail()->addAddress("desarrollo8@omegawebsystems.com", "Notificaciones FOE");
      $data["mailTo"] = "desarrollo8@omegawebsystems.com";
    }
    //$emailModel->getMail()->addBCC("tiendavirtualfoe@foebbva.com", "Notificaciones FOE");
    // $emailModel->getMail()->addBCC("solicitudcreditosfoe@foebbva.com", "Notificaciones FOE");
    $emailModel->getMail()->addBCC("soporteomega@omegawebsystems.com", "Notificaciones FOE");
    // $emailModel->getMail()->addBCC("desarrollo8@omegawebsystems.com", "Notificaciones FOE");


    $infopageModel = new Page_Model_DbTable_Informacion();

    $informacion = $infopageModel->getById(1);
    $correosCopia = $informacion->info_pagina_correos_contacto;



    //ENVIO API
    $token = $this->conectar2();
    $data["mailCc"] = "tiendavirtualfoe@foebbva.com";
    $data["subject"] = "" . $asunto;
    $data["certimail"] = "CNC";
    $data["richContent"] = "" . $mensaje;
    //$data["mailTo"] = "solicitudcreditosfoe@foebbva.com";
    $data["bcc"] = $correosCopia;
    //print_r($data);
    $result = $this->enviar($data, $token);
    if ($result == "-1" or $result == "" or $result == NULL) {

      if ($emailModel->sed()) {
        header("location: /page/informacioenvio/?res=1&orden=$orden");
        exit();  // Agregado exit para asegurar que se detenga la ejecución después del redireccionamiento

      } else {
        Session::getInstance()->set("error_guardar", "Lo sentimos, ocurrió un error al enviar la confirmación");
        header("location: /page/informacioenvio/?res=2&orden=$orden");
        exit();  // Agregado exit para asegurar que se detenga la ejecución después del redireccionamiento

      }
    }
    header("location: /page/informacioenvio/?res=1&orden=$orden");
  }





  /**
   * Genera los valores del campo ciudad_documento.
   *
   * @return array cadena con los valores del campo ciudad_documento.
   */
  private function getCiudaddocumento()
  {
    $modelData = new Administracion_Model_DbTable_Dependciudad();
    $data = $modelData->getList();
    $array = array();
    foreach ($data as $key => $value) {
      $array[$value->codigo] = $value->nombre;
    }
    return $array;
  }

  public function consultarPagare($cedula)
  {

    $hash = md5("OMEGA_" . date("Y-m-d"));
    $context = stream_context_create([
      "ssl" => [
        "verify_peer" => false,
        "verify_peer_name" => false,
      ],
    ]);
    $res = file_get_contents("https://creditos.foebbva.com/page/login/consultarpagare/?hash=" . $hash . "&cedula=" . $cedula, false, $context);
    $res = json_decode($res);
    return ($res->numero_pagare);
  }

  function conectar2()
  {


    $url = "http://notify-it.com/notify/services/checkAccount?u=comercial@foebbva.notify-it.com&p=9864912c-77e8-4a0b-aed0-e009489aca2d";

    $data = array();

    $ch = curl_init($url);
    # Setup request to send json via POST.
    $payload = json_encode($data);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    # Return response instead of printing.
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    # Send request.
    $result = curl_exec($ch);
    curl_close($ch);
    # Print response.
    //echo "<pre>$result</pre>";

    return $result;
  }



  function enviar($data, $token)
  {


    $url = "http://notify-it.com/notify/services/sendImmediateEmailNotification?login=comercial@foebbva.notify-it.com&password=9864912c-77e8-4a0b-aed0-e009489aca2d";

    $authorization = "Authorization: Bearer " . $token; // Prepare the authorisation token

    $ch = curl_init($url);
    # Setup request to send json via POST.
    $payload = json_encode($data);

    //echo $payload;

    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', $authorization));
    # Return response instead of printing.
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    # Send request.
    $result = curl_exec($ch);
    //echo 'Curl error: ' . curl_error($ch).'<br>';
    curl_close($ch);
    # Print response.
    //echo "<pre>$result</pre>";

    return $result;
  }
}
