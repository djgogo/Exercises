<?php

namespace Address\Routers
{
    use Address\Factories\Factory;
    use Address\Http\Request;

    class GetRequestRouter implements RouterInterface
    {
        /** @var Factory */
        private $factory;

        public function __construct(Factory $factory)
        {
            $this->factory = $factory;
        }

        public function route(Request $request)
        {
            if (!$request->isGetRequest()) {
                return null;
            }

            $uri = $request->getRequestUri();
            $path = parse_url($uri, PHP_URL_PATH);

            switch ($path) {
                case '/':
                    return $this->factory->getHomeController();
                case '/address/addr':
//                    return $this->factory->getAddressController();
                case '/address/updateaddressview':
//                    return $this->factory->getUpdateAddressViewController();
                default:
                    return null;
            }
        }
    }
}
