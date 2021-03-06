<?php

namespace Address\Controllers
{

    use Address\Exceptions\AddressTableGatewayException;
    use Address\Gateways\AddressTableDataGateway;
    use Address\Http\Request;
    use Address\Http\Response;
    use Address\Http\Session;

    class DeleteAddressController implements ControllerInterface
    {
        /** @var AddressTableDataGateway  */
        private $addressDataGateway;

        /** @var Session */
        private $session;

        public function __construct(Session $session, AddressTableDataGateway $addressDataGateway)
        {
            $this->addressDataGateway = $addressDataGateway;
            $this->session = $session;
        }

        public function execute(Request $request, Response $response)
        {
            if ($this->session->isLoggedIn() && $request->isLoggedIn()) {
                try {
                    $this->addressDataGateway->delete($request->getValue('id'));
                    $this->session->setValue('message', 'Datensatz wurde gelöscht');
                } catch (AddressTableGatewayException $e) {
                    $this->session->setValue('warning', 'Löschen des Datensatzes fehlgeschlagen!');
                }
            } else {
                $this->session->setValue('warning', 'Um Adressen zu löschen müssen Sie sich anmelden.');
            }

            $response->setAddresses(...$this->addressDataGateway->getAllAddresses());
            $response->setRedirect('/');
        }
    }
}
