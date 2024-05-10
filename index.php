<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="">
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.1/css/all.min.css"
        integrity="sha512-gMjQeDaELJ0ryCI+FtItusU9MkAifCZcGq789FrzkiM49D8lbDhoaUaIX4ASU187wofMNlgBJ4ckbrXM9sE6Pg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link href="https://cdn.www.gov.co/layout/v4/all.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="migracion_temp\images\favicon.png" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="migracion_temp\css\styles.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <link rel="stylesheet" href="estilos_login\estilos.css">
</head>

<body>
    <header class="bg-blue py-2">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-sm-2 col-3 he_logo d-flex justify-content-start">
                    <a href="https://www.gov.co/">
                        <img src="migracion_temp\images\logo\logo_gov.png" alt="LogoGov" class="py-1" />
                    </a>
                </div>
            </div>
        </div>
    </header>

    <div class="login-container">
        <form class="login-form" method="POST" action="evaluar_usuario.php">
            <div class="logo-container">
                <img src="migracion_temp\images\migracion_logo.png" alt="Logo">
            </div>
            <h2>Biometrias</h2>
            <div class="input-group">
                <label for="documento">Número de Documento:</label>
                <input type="text" id="documento" name="documento" placeholder="Ingrese nro de documento" required>
            </div>
            <div class="input-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" placeholder="Ingrese contraseña" required>
            </div>
            <a class="text-reg" link href="crear_usuario.php"> <p >¿No está registrado? REGÍSTRESE</p> </a> </br>
            <a class="text-reg" link href="recuperar_contraseña.php"> <p >¿Olvidó la contraseña?</p> </a>
            <button type="submit">Iniciar Sesión</button>
        </form>
    </div>
    <footer ng-include="::main.htmlRoutes.footer">
        <div class="footer-down">
            <div class="footer-topSpace"></div>
            <div class="container container--foot p-5">
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="footer__colTit">MIGRACIÓN COLOMBIA</div>
                        <p ng-if="::main.footer.address">
                            Dirección: Sede administrativa, Calle 24A No 59-42 Edificio Argos Torre 3
                        </p>
                        <p ng-if="::main.footer.operationHours">
                            Horario de atención: En la sede administrativa no hay atención al público.
                        </p>
                        <p ng-if="::main.footer.phone">
                            Teléfono Conmutador: +57 (601) 611 6170
                        </p>
                        <p ng-if="::main.footer.freeCareLine">
                            Línea de atención gratuita: 01 8000 128 662</p>
                        <p ng-if="::main.footer.antiCorruptionLine">
                            Línea anticorrupción: +57 (601) 611 6177
                        </p>
                        <p ng-if="::main.footer.email">
                            Correo institucional: autoridades.administrativas@migracioncolombia.gov.co
                        </p>
                        <p ng-if="::main.footer.emailNotification">
                            Correo de notificaciones judiciales: noti.judiciales@migracioncolombia.gov.co
                        </p>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="d-flex flex-row-reverse">
                            <div class="d-inline p-2 text-white">
                                <div class="footer-col footer-col__logo">
                                    <div class="footer-wLogo">
                                        <img class="footer-logo logo-one" loading="lazy"
                                            ng-if="main.firstLogo &amp;&amp; main.amountLogo === '2'"
                                            ng-src="migracion_temp\images\logo\2463_logogobierno300x300_200x200.png"
                                            alt="MIGRACIÓN COLOMBIA"
                                            src="migracion_temp\images\logo\2463_logogobierno300x300_200x200.png">

                                        <div class="vertical-line"></div>
                                        <img class="footer-logo logo-two" loading="lazy"
                                            ng-if="main.lastLogo &amp;&amp; main.amountLogo === '2'"
                                            ng-src="images/logo/2464_logomigracion300x400_200x200.png"
                                            alt="MIGRACIÓN COLOMBIA"
                                            src="migracion_temp\images\logo\2464_logomigracion300x400_200x200.png">
                                    </div>
                                    <div class="wrapFrame"><iframe src="https://horalegalnueva.inm.gov.co/inm/"
                                            width="510" height="100" align="right" frameborder="0"
                                            style="margin: 1% -84px; overflow-x: hidden"></iframe></div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="footer-wrapSocial">
                        <div class="col-6">
                            <div class="mb-2">
                                <a title="Dirígete a nuestra página de @Migración Colombia"
                                    ng-repeat="ordenRed in main.socialNetworks.ordenRedes track by $index"
                                    ng-if="$index < 4" target="_blank" ng-href="https://web.facebook.com/MigracionCol/"
                                    class="footer-socialBtn" tabindex="212"
                                    href="https://web.facebook.com/MigracionCol/">
                                    <span class="footer-icon" title="Facebook">
                                        <i class="fab fa-facebook-f"></i>
                                    </span>
                                    <text ng-if="ordenRed.alias">@Migración Colombia</text>
                                </a>
                            </div>
                            <div class="mb-2">
                                <a title="Dirígete a nuestra página de @MigracionCol"
                                    ng-repeat="ordenRed in main.socialNetworks.ordenRedes track by $index"
                                    ng-if="$index < 4" target="_blank" ng-href="https://twitter.com/migracioncol"
                                    class="footer-socialBtn" tabindex="212" href="https://twitter.com/migracioncol">
                                    <span class="footer-icon" title="Twitter">
                                        <i class="fab fa-twitter"></i>
                                    </span>
                                    <text ng-if="ordenRed.alias">@MigracionCol</text>
                                </a>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-2">
                                <a title="Dirígete a nuestra página de @migracioncol"
                                    ng-repeat="ordenRed in main.socialNetworks.ordenRedesDos track by $index"
                                    ng-if="$index < 4" target="_blank" ng-href="https://www.youtube.com/migracioncol"
                                    class="footer-socialBtn" tabindex="212"
                                    href="https://www.youtube.com/migracioncol"><span title="Youtube">
                                        <i class="fab fa-youtube"></i>
                                    </span>
                                    <text ng-if="ordenRed.alias">@migracioncol</text>
                                </a>
                            </div>
                            <div class="mb-2">
                                <a title="Dirígete a nuestra página de @migracioncol"
                                    ng-repeat="ordenRed in main.socialNetworks.ordenRedesDos track by $index"
                                    ng-if="$index < 4" target="_blank" ng-href="https://www.instagram.com/migracioncol/"
                                    class="footer-socialBtn" tabindex="212"
                                    href="https://www.instagram.com/migracioncol/">
                                    <span title="Instagram">
                                        <i class="fab fa-instagram"></i>
                                    </span>
                                    <text ng-if="ordenRed.alias">@migracioncol</text>
                                </a>
                            </div>

                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-12 mt-3">
                        <div ng-repeat="subsidiary in main.footer.subsidiaries track by $index" ng-if="$index < 3"
                            class="footer-wrapCol footer-wrapCol--subsidiaries">
                            <div class="footer-col">
                                <div class="footer__colTit" ng-bind="::subsidiary.name">
                                    Sede Administrativa - Bogotá
                                </div>
                                <p>Direccion: Calle 24A No 59-42 Edificio Argos Torre 3</p>
                                <p>Horario de atención: En esta sede no hay atención al público</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 mt-3">
                        <div class="footer-col">
                            <div class="footer__colTit--fix"></div>
                            <p>Email:autoridades.administrativas@migracioncolombia.gov.co</p>
                            <p>Teléfonos: +57 (601) 611 6170</p>
                        </div>
                    </div>
                    <div class="col-12 mt-3">
                        <div class="footer-infoCol"><!----><a ng-repeat="options_link in main.footerConfig"
                                class="footer__link" href="/politicas" tabindex="212">Políticas</a><!----><a
                                ng-repeat="options_link in main.footerConfig" class="footer__link" href="/transparencia"
                                tabindex="212">Transparencia</a><!----><a ng-repeat="options_link in main.footerConfig"
                                class="footer__link" href="/mapa-del-sitio" tabindex="212">Mapa del sitio</a><!----><a
                                ng-repeat="options_link in main.footerConfig" class="footer__link" href="/estadisticas"
                                tabindex="212">Estadísticas</a><!----></div>
                    </div>
                </div>
            </div>
            <div class="container container--default d-flex justify-content-end"><a class="footer-credit text-white"
                    target="_blank" href="https://home.micolombiadigital.gov.co/territorial/" tabindex="212">Creado
                    Ministerio TIC <img src="migracion_temp\images\colombia.png" alt="Bandera Colombia" class="logo-colflat"></a>
            </div>
        </div>
        <div class="content bg-footer">
            <div class="container py-2">
                <div class="row d-flex align-items-center">
                    <div class="col-12">
                        <div class="pt-middle">
                            <div class="d-inline logo_co">
                                <a href="https://www.colombia.co" class="no-bullets">
                                    <img src="migracion_temp\images\logo_co_footer.png" alt="logo co"
                                        class=" vr-separtor-gray-right pe-4">
                                </a>
                            </div>
                            <div class="d-inline logo">
                                <a href="https://www.gov.co" class="no-bullets ps-2">
                                    <img src="migracion_temp\images\logo\logo_gov.png" alt="logo">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <div id="accesibilidad-menu" class="accesibilidad-menu">
        <ul class="accesibilidad-items">
            <li>
                <a id="high_contrast" href="#" class="icon-contrast" title="Cambiar niveles de contraste">
                    <img src="migracion_temp\images\ico\channels-616_icon_contrast.svg" alt="Botón contraste" class="img-fluid">
                    <span> Contraste </span>
                </a>
            </li>
            <li>
                <a id="a_less" href="#" class="icon-a-less" title="Reducir el tamaño del texto">
                    <img src="migracion_temp\images\ico\channels-616_icon_less_size.svg" alt="Botón Reducir el tamaño del texto"
                        class="img-fluid">
                    <span> Reducir letra </span>
                </a>
            </li>
            <li>
                <a id="a_more" href="#" class="icon-a-more" title="Aumentar el tamaño del texto">
                    <img src="migracion_temp\images\ico\channels-616_icon_more_size.svg" alt="Botón Aumentar tamaño del texto"
                        class="img-fluid">
                    <span> Aumentar letra </span>
                </a>
            </li>
        </ul>
    </div>
    <script src="migracion_temp\js\accesibilidad.js"></script>



    <!-- Scripts -->
    <script src="https://cdn.www.gov.co/layout/v4/script.js"></script>
</body>

</html>