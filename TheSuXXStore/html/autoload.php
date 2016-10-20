<?php
// @codingStandardsIgnoreFile
// @codeCoverageIgnoreStart
// this is an autogenerated file - do not edit
spl_autoload_register(
    function($class) {
        static $classes = null;
        if ($classes === null) {
            $classes = array(
                'email' => '/ValueObjects/Email.php',
                'invalidemailexception' => '/Exceptions/InvalidEmailException.php',
                'pdofactory' => '/Factories/PDOFactory.php',
                'suxxauthenticationformcommand' => '/Commands/AuthenticationFormCommand.php',
                'suxxauthenticator' => '/Classes/Authenticator.php',
                'suxxcommentcontroller' => '/Controllers/CommentController.php',
                'suxxcommentformcommand' => '/Commands/CommentFormCommand.php',
                'suxxcommenttabledatagateway' => '/Gateways/CommentTableDataGateway.php',
                'suxxcontroller' => '/Controllers/ControllerInterface.php',
                'suxxerrorcontroller' => '/Controllers/ErrorController.php',
                'suxxerrorview' => '/Views/errorview.php',
                'suxxfactory' => '/Factories/Factory.php',
                'suxxhomecontroller' => '/Controllers/HomeController.php',
                'suxxlogincontroller' => '/Controllers/LoginController.php',
                'suxxlogoutcontroller' => '/Controllers/LogoutController.php',
                'suxxproductcontroller' => '/Controllers/ProductController.php',
                'suxxproducttabledatagateway' => '/Gateways/ProductTableDataGateway.php',
                'suxxregistercontroller' => '/Controllers/RegisterController.php',
                'suxxregistrationformcommand' => '/Commands/RegistrationFormCommand.php',
                'suxxregistrator' => '/Classes/Registrator.php',
                'suxxrequest' => '/Classes/Request.php',
                'suxxresponse' => '/Classes/Response.php',
                'suxxresponseexception' => '/Exceptions/ResponseException.php',
                'suxxrouter' => '/Classes/Router.php',
                'suxxstaticview' => '/Views/staticview.php',
                'suxxusertabledatagateway' => '/Gateways/UserTableDataGateway.php',
                'suxxviewinterface' => '/Views/viewinterface.php'
            );
        }
        $cn = strtolower($class);
        if (isset($classes[$cn])) {
            require __DIR__ . $classes[$cn];
        }
    }
);
// @codeCoverageIgnoreEnd
